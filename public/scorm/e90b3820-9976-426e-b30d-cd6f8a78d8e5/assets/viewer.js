(function () {
    const canvas = document.getElementById('pdf-canvas');
    const pageNumberEl = document.getElementById('page-number');
    const pageCountEl = document.getElementById('page-count');
    const previousButton = document.getElementById('previous');
    const nextButton = document.getElementById('next');

    let pdfDoc = null;
    let currentPage = 1;
    const pdfUrl = window.__SCORM_PDF_URL__ || 'document.pdf';

    function renderPage(pageNumber) {
        if (!pdfDoc || !canvas) {
            return;
        }

        pdfDoc.getPage(pageNumber).then(function (page) {
            const baseViewport = page.getViewport({ scale: 1 });
            const shell = document.querySelector('.viewer-shell');
            const availWidth = Math.max(280, (shell ? shell.clientWidth : window.innerWidth) - 24);
            const availHeight = Math.max(300, (shell ? shell.clientHeight : window.innerHeight) - 24);
            const scaleX = availWidth / baseViewport.width;
            const scaleY = availHeight / baseViewport.height;
            const scale = Math.min(scaleX, scaleY);

            const viewport = page.getViewport({ scale: scale });
            canvas.height = viewport.height;
            canvas.width = viewport.width;
            const context = canvas.getContext('2d');

            const renderContext = {
                canvasContext: context,
                viewport: viewport,
            };

            page.render(renderContext).promise.then(function () {
                pageNumberEl.textContent = String(pageNumber);
                previousButton.disabled = pageNumber <= 1;
                nextButton.disabled = pageNumber >= pdfDoc.numPages;
            });
        });
    }

    function updatePageCount() {
        if (!pdfDoc) {
            return;
        }

        pageCountEl.textContent = String(pdfDoc.numPages || 1);
        renderPage(currentPage);
    }

    function init() {
        if (!window.pdfjsLib) {
            window.addEventListener('pdfjs:ready', init, { once: true });
            return;
        }

        window.pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
        window.pdfjsLib.getDocument(pdfUrl).promise.then(function (doc) {
            pdfDoc = doc;
            currentPage = 1;
            updatePageCount();
        }).catch(function () {
            canvas.textContent = 'Gagal memuat PDF.';
        });
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

    init();
})();