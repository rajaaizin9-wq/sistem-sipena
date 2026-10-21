(function () {
    const canvas = document.getElementById('pdf-canvas');
    const pageNumberEl = document.getElementById('page-number');
    const pageCountEl = document.getElementById('page-count');
    const previousButton = document.getElementById('previous');
    const nextButton = document.getElementById('next');
    const zoomInButton = document.getElementById('zoom-in');
    const zoomOutButton = document.getElementById('zoom-out');
    const zoomResetButton = document.getElementById('zoom-reset');
    const zoomLevelEl = document.getElementById('zoom-level');
    const loadingOverlay = document.getElementById('loading-overlay');
    const loadingTextEl = loadingOverlay ? loadingOverlay.querySelector('span') : null;
    const shell = document.getElementById('viewer-shell');

    let pdfDoc = null;
    let currentPage = 1;
    let currentScale = 1.0;
    let userZoomMultiplier = 1.0;
    let isRendering = false;
    let pendingPageNumber = null;
    let currentRenderTask = null;

    const pdfUrl = window.__SCORM_PDF_URL__ || 'document.pdf';

    function showLoading(show, message) {
        if (!loadingOverlay) return;
        if (show) {
            if (message && loadingTextEl) {
                loadingTextEl.textContent = message;
            }
            loadingOverlay.classList.remove('hidden');
        } else {
            loadingOverlay.classList.add('hidden');
        }
    }

    function renderPage(pageNumber) {
        if (!pdfDoc || !canvas) return;

        if (isRendering) {
            pendingPageNumber = pageNumber;
            if (currentRenderTask) {
                currentRenderTask.cancel();
            }
            return;
        }

        isRendering = true;

        pdfDoc.getPage(pageNumber).then(function (page) {
            const baseViewport = page.getViewport({ scale: 1.0 });
            const availWidth = Math.max(260, (shell ? shell.clientWidth : window.innerWidth) - 24);
            const availHeight = Math.max(260, (shell ? shell.clientHeight : window.innerHeight) - 24);

            const scaleX = availWidth / baseViewport.width;
            const scaleY = availHeight / baseViewport.height;
            const fitScale = Math.min(scaleX, scaleY);
            currentScale = fitScale * userZoomMultiplier;

            // Handle HiDPI / Retina screens crisp resolution
            const dpr = window.devicePixelRatio || 1;
            const viewport = page.getViewport({ scale: currentScale });

            const cssWidth = Math.floor(viewport.width);
            const cssHeight = Math.floor(viewport.height);

            canvas.width = Math.floor(cssWidth * dpr);
            canvas.height = Math.floor(cssHeight * dpr);
            canvas.style.width = cssWidth + 'px';
            canvas.style.height = cssHeight + 'px';

            const context = canvas.getContext('2d');
            const outputScaleViewport = page.getViewport({ scale: currentScale * dpr });

            const renderContext = {
                canvasContext: context,
                viewport: outputScaleViewport
            };

            currentRenderTask = page.render(renderContext);
            return currentRenderTask.promise;
        }).then(function () {
            isRendering = false;
            currentRenderTask = null;

            if (pageNumberEl) pageNumberEl.textContent = String(pageNumber);
            if (previousButton) previousButton.disabled = pageNumber <= 1;
            if (nextButton) nextButton.disabled = pageNumber >= pdfDoc.numPages;

            if (zoomLevelEl) {
                zoomLevelEl.textContent = Math.round(userZoomMultiplier * 100) + '%';
            }

            // Pre-fetch next page for fast navigation
            if (pageNumber < pdfDoc.numPages) {
                pdfDoc.getPage(pageNumber + 1).catch(function () {});
            }

            if (pendingPageNumber !== null) {
                const nextNum = pendingPageNumber;
                pendingPageNumber = null;
                renderPage(nextNum);
            }
        }).catch(function (error) {
            if (error && error.name === 'RenderingCancelledException') {
                isRendering = false;
                if (pendingPageNumber !== null) {
                    const nextNum = pendingPageNumber;
                    pendingPageNumber = null;
                    renderPage(nextNum);
                }
                return;
            }
            isRendering = false;
        });
    }

    function init() {
        if (!window.pdfjsLib) {
            window.addEventListener('pdfjs:ready', init, { once: true });
            return;
        }

        window.pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
        showLoading(true, 'Menyiapkan modul PDF...');

        const loadingTask = window.pdfjsLib.getDocument({
            url: pdfUrl,
            disableAutoFetch: false,
            disableStream: false
        });

        loadingTask.onProgress = function (progressData) {
            if (progressData.total > 0) {
                const percent = Math.min(100, Math.round((progressData.loaded / progressData.total) * 100));
                showLoading(true, 'Memuat dokumen PDF (' + percent + '%)...');
            } else if (progressData.loaded > 0) {
                const loadedKb = Math.round(progressData.loaded / 1024);
                showLoading(true, 'Memuat dokumen PDF (' + loadedKb + ' KB)...');
            }
        };

        loadingTask.promise.then(function (doc) {
            pdfDoc = doc;
            currentPage = 1;
            if (pageCountEl) pageCountEl.textContent = String(pdfDoc.numPages || 1);
            renderPage(currentPage);
            showLoading(false);
        }).catch(function () {
            showLoading(false);
            if (canvas) {
                const context = canvas.getContext('2d');
                context.font = '14px sans-serif';
                context.fillText('Gagal memuat dokumen PDF.', 20, 40);
            }
        });
    }

    // Debounced Resize handling for Fullscreen and Mobile orientation changes
    let resizeTimer = null;
    function handleResize() {
        if (resizeTimer) clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            if (pdfDoc && !isRendering) {
                renderPage(currentPage);
            }
        }, 150);
    }

    if (window.ResizeObserver && shell) {
        const ro = new ResizeObserver(handleResize);
        ro.observe(shell);
    } else {
        window.addEventListener('resize', handleResize);
    }

    previousButton.addEventListener('click', function () {
        if (currentPage > 1) {
            currentPage -= 1;
            renderPage(currentPage);
        }
    });

    nextButton.addEventListener('click', function () {
        if (pdfDoc && currentPage < pdfDoc.numPages) {
            currentPage += 1;
            renderPage(currentPage);
        }
    });

    if (zoomInButton) {
        zoomInButton.addEventListener('click', function () {
            if (userZoomMultiplier < 3.0) {
                userZoomMultiplier = Math.min(3.0, userZoomMultiplier + 0.25);
                renderPage(currentPage);
            }
        });
    }

    if (zoomOutButton) {
        zoomOutButton.addEventListener('click', function () {
            if (userZoomMultiplier > 0.5) {
                userZoomMultiplier = Math.max(0.5, userZoomMultiplier - 0.25);
                renderPage(currentPage);
            }
        });
    }

    if (zoomResetButton) {
        zoomResetButton.addEventListener('click', function () {
            userZoomMultiplier = 1.0;
            renderPage(currentPage);
        });
    }

    init();
})();