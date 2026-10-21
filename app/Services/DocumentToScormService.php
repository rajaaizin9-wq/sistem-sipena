<?php

namespace App\Services;

use CodeIgniter\HTTP\Files\UploadedFile;
use RuntimeException;
use ZipArchive;

/** Converts a PDF document into a minimal, view-only SCORM 1.2 package. */
class DocumentToScormService
{
    private const ALLOWED_EXTENSIONS = ['pdf'];

    public function createPackage(UploadedFile $document, string $title = 'Document'): string
    {
        $tempPath = $document->getTempName();
        if ($document->hasMoved() || $tempPath === '' || ! is_file($tempPath)) {
            throw new RuntimeException('File dokumen tidak valid.');
        }

        $extension = strtolower($document->getExtension());
        if (! in_array($extension, self::ALLOWED_EXTENSIONS, true)) {
            throw new RuntimeException('Dokumen harus berformat PDF.');
        }

        $workDir = WRITEPATH . 'document-scorm/' . bin2hex(random_bytes(16));
        $this->ensureDirectory($workDir);

        try {
            $converter = $this->resolveConverter($extension);
            $pdfPath = $converter->convertToPdf($document, $workDir);
            $destinationPdfPath = $workDir . '/document.pdf';
            if (! copy($pdfPath, $destinationPdfPath)) {
                throw new RuntimeException('Gagal menyalin PDF ke paket SCORM.');
            }

            $packagePath = $workDir . '/document-scorm.zip';
            $zip = new ZipArchive();
            if ($zip->open($packagePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new RuntimeException('Gagal membuat paket SCORM.');
            }

            $zip->addFromString('imsmanifest.xml', $this->manifest($title));
            $zip->addFromString('index.html', $this->viewer($title));
            $zip->addFromString('assets/pdf.js', $this->pdfBootstrapScript());
            $zip->addFromString('assets/pdf.worker.js', $this->pdfWorkerScript());
            $zip->addFromString('assets/viewer.js', $this->viewerScript());
            $zip->addFromString('assets/viewer.css', $this->viewerStyles());
            $zip->addFile($destinationPdfPath, 'document.pdf');
            $zip->close();

            return $packagePath;
        } catch (\Throwable $e) {
            $this->removeDirectory($workDir);
            throw $e;
        }
    }

    private function resolveConverter(string $extension): DocumentConverterInterface
    {
        foreach ($this->getDocumentConverters() as $converter) {
            if ($converter->supports($extension)) {
                return $converter;
            }
        }

        throw new RuntimeException('Format dokumen tidak didukung. Hanya PDF saat ini.');
    }

    /** @return list<DocumentConverterInterface> */
    private function getDocumentConverters(): array
    {
        return [
            new PdfDocumentConverter(),
        ];
    }

    private function manifest(string $title): string
    {
        $safeTitle = htmlspecialchars($title !== '' ? $title : 'Document', ENT_XML1);

        return '<?xml version="1.0" encoding="UTF-8"?>' .
            '<manifest identifier="document-scorm" version="1.0" xmlns="http://www.imsproject.org/xsd/imscp_rootv1p1p2" xmlns:adlcp="http://www.adlnet.org/xsd/adlcp_rootv1p2">' .
            '<metadata><schema>ADL SCORM</schema><schemaversion>1.2</schemaversion></metadata>' .
            '<organizations default="document-org"><organization identifier="document-org"><title>' . $safeTitle . '</title><item identifier="document-item" identifierref="document-resource"><title>' . $safeTitle . '</title></item></organization></organizations>' .
            '<resources><resource identifier="document-resource" type="webcontent" adlcp:scormtype="sco" href="index.html"><file href="index.html"/><file href="imsmanifest.xml"/><file href="assets/pdf.js"/><file href="assets/pdf.worker.js"/><file href="assets/viewer.js"/><file href="assets/viewer.css"/><file href="document.pdf"/></resource></resources></manifest>';
    }

    private function viewer(string $title): string
    {
        $safeTitle = htmlspecialchars($title !== '' ? $title : 'Document', ENT_XML1);

        return <<<HTML
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{$safeTitle}</title>
    <link rel="stylesheet" href="assets/viewer.css">
</head>
<body>
    private function viewer(string $title): string
    {
        $safeTitle = htmlspecialchars($title !== '' ? $title : 'Document', ENT_XML1);

        return <<<HTML
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{$safeTitle}</title>
    <link rel="stylesheet" href="assets/viewer.css">
</head>
<body>
    <main class="viewer-shell" id="viewer-shell">
        <div id="loading-overlay" class="loading-overlay">
            <div class="spinner"></div>
            <span>Memuat modul PDF...</span>
        </div>
        <div class="canvas-container">
            <canvas id="pdf-canvas"></canvas>
        </div>
    </main>
    <nav class="toolbar">
        <div class="toolbar-group">
            <button id="previous" type="button" title="Halaman Sebelumnya (<-)">
                <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                <span class="btn-label">Sebelumnya</span>
            </button>
            <div class="page-indicator">
                <input type="number" id="page-input" class="page-input" value="1" min="1" aria-label="Nomor Halaman" title="Ketik nomor halaman lalu tekan Enter">
                <span class="page-total-sep">/</span>
                <span id="page-count">1</span>
            </div>
            <button id="next" type="button" title="Halaman Berikutnya (->)">
                <span class="btn-label">Berikutnya</span>
                <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
        <div class="toolbar-group zoom-group">
            <button id="zoom-out" type="button" title="Perkecil (-)">
                <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                </svg>
            </button>
            <span id="zoom-level" class="zoom-level">Fit</span>
            <button id="zoom-in" type="button" title="Perbesar (+)">
                <svg class="btn-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
            </button>
            <button id="zoom-reset" type="button" class="btn-reset" title="Ukur Pas">Reset</button>
        </div>
    </nav>
    <script>window.__SCORM_PDF_URL__ = 'document.pdf';</script>
    <script src="assets/pdf.js"></script>
    <script src="assets/viewer.js"></script>
</body>
</html>
HTML;
    }

    private function viewerStyles(): string
    {
        return <<<CSS
html, body {
    height: 100%;
    margin: 0;
    padding: 0;
    background: #0f172a;
    color: #0f172a;
    font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    -webkit-font-smoothing: antialiased;
}
body {
    display: flex;
    flex-direction: column;
    height: 100vh;
    overflow: hidden;
}
.viewer-shell {
    flex: 1;
    min-height: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    overflow: auto;
    padding: 12px;
    background: #334155;
    position: relative;
    -webkit-overflow-scrolling: touch;
}
.canvas-container {
    display: flex;
    justify-content: center;
    align-items: center;
    margin: auto;
    padding: 4px;
}
#pdf-canvas {
    display: block;
    border-radius: 6px;
    background: #ffffff;
    box-shadow: 0 12px 30px rgba(0, 0, 0, 0.35);
    image-rendering: -webkit-optimize-contrast;
    image-rendering: crisp-edges;
}

.loading-overlay {
    position: absolute;
    inset: 0;
    background: rgba(15, 23, 42, 0.75);
    backdrop-filter: blur(4px);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
    color: #ffffff;
    font-size: 13px;
    font-weight: 600;
    z-index: 20;
    transition: opacity 0.2s ease, visibility 0.2s ease;
}
.loading-overlay.hidden {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}
.spinner {
    width: 28px;
    height: 28px;
    border: 3px solid rgba(255, 255, 255, 0.2);
    border-top-color: #38bdf8;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}
@keyframes spin {
    to { transform: rotate(360deg); }
}
.toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    padding: 8px 14px;
    background: #0f172a;
    border-top: 1px solid #1e293b;
    box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.2);
    z-index: 10;
    flex-shrink: 0;
    flex-wrap: wrap;
}
.toolbar-group {
    display: flex;
    align-items: center;
    gap: 8px;
}
.toolbar button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    border: 0;
    border-radius: 8px;
    padding: 8px 14px;
    background: #0284c7;
    color: #ffffff;
    font-size: 13px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.15s ease;
    box-shadow: 0 2px 4px rgba(2, 132, 199, 0.2);
    user-select: none;
}
.toolbar button#previous {
    background: #334155;
    color: #f1f5f9;
    box-shadow: none;
}
.toolbar button#previous:hover:not(:disabled) {
    background: #475569;
}
.toolbar button:hover:not(:disabled) {
    background: #0369a1;
    transform: translateY(-1px);
}
.toolbar button:active:not(:disabled) {
    transform: scale(0.95);
}
.toolbar button:disabled {
    background: #1e293b;
    color: #475569;
    box-shadow: none;
    cursor: not-allowed;
    opacity: 0.5;
}
.toolbar button .btn-icon {
    width: 16px;
    height: 16px;
}
.toolbar button.btn-reset {
    background: #334155;
    color: #cbd5e1;
    padding: 6px 10px;
    font-size: 11px;
}
.toolbar button.btn-reset:hover:not(:disabled) {
    background: #475569;
    color: #ffffff;
}
.page-indicator {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    background: #1e293b;
    padding: 4px 8px;
    border-radius: 6px;
    font-size: 12px;
    font-weight: 700;
    color: #94a3b8;
}
.page-input {
    width: 34px;
    background: #0f172a;
    border: 1px solid #334155;
    color: #38bdf8;
    border-radius: 4px;
    text-align: center;
    font-size: 12px;
    font-weight: 700;
    padding: 2px 0;
    outline: none;
}
.page-input:focus {
    border-color: #38bdf8;
    background: #1e293b;
}
/* Hide input number arrows */
.page-input::-webkit-outer-spin-button,
.page-input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
.page-input[type=number] {
    -moz-appearance: textfield;
}
.zoom-level {
    font-size: 12px;
    font-weight: 700;
    color: #94a3b8;
    min-width: 40px;
    text-align: center;
}
@media (max-width: 640px) {
    .toolbar {
        padding: 6px 8px;
        gap: 6px;
    }
    .toolbar button {
        padding: 7px 10px;
        font-size: 12px;
    }
    .btn-label {
        display: inline;
        font-size: 11px;
    }
    .zoom-group {
        gap: 4px;
    }
}
CSS;
    }

    private function pdfBootstrapScript(): string
    {
        return <<<JS
(function () {
    const script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js';
    script.onload = function () {
        window.dispatchEvent(new Event('pdfjs:ready'));
    };
    document.head.appendChild(script);
})();
JS;
    }

    private function pdfWorkerScript(): string
    {
        return "// Placeholder worker asset for SCORM package compatibility.\n";
    }

    private function viewerScript(): string
    {
        return <<<JS
(function () {
    const canvas = document.getElementById('pdf-canvas');
    const pageInputEl = document.getElementById('page-input');
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

    function updateControlsState(pageNumber) {
        const isFirst = pageNumber <= 1;
        const isLast = pdfDoc ? pageNumber >= pdfDoc.numPages : true;

        if (previousButton) previousButton.disabled = isFirst;
        if (nextButton) nextButton.disabled = isLast;

        if (pageInputEl) {
            pageInputEl.value = pageNumber;
            pageInputEl.max = pdfDoc ? pdfDoc.numPages : 1;
        }

        if (zoomLevelEl) {
            zoomLevelEl.textContent = Math.round(userZoomMultiplier * 100) + '%';
        }
    }

    function renderPage(pageNumber) {
        if (!pdfDoc || !canvas) return Promise.resolve();

        if (isRendering) {
            pendingPageNumber = pageNumber;
            if (currentRenderTask) {
                currentRenderTask.cancel();
            }
            return Promise.resolve();
        }

        isRendering = true;

        return pdfDoc.getPage(pageNumber).then(function (page) {
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

            updateControlsState(pageNumber);

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
            return renderPage(currentPage);
        }).then(function () {
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

    function goPrev() {
        if (currentPage > 1) {
            currentPage -= 1;
            renderPage(currentPage);
        }
    }

    function goNext() {
        if (pdfDoc && currentPage < pdfDoc.numPages) {
            currentPage += 1;
            renderPage(currentPage);
        }
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

    if (previousButton) previousButton.addEventListener('click', goPrev);
    if (nextButton) nextButton.addEventListener('click', goNext);

    // Keyboard navigation (Arrow keys / Space / PageUp / PageDown)
    document.addEventListener('keydown', function (e) {
        if (['INPUT', 'TEXTAREA', 'SELECT'].includes(document.activeElement ? document.activeElement.tagName : '')) return;

        if (e.key === 'ArrowLeft' || e.key === 'PageUp') {
            e.preventDefault();
            goPrev();
        } else if (e.key === 'ArrowRight' || e.key === 'PageDown' || e.key === ' ') {
            e.preventDefault();
            goNext();
        }
    });

    // Touch Swipe gestures on Mobile
    let touchStartX = 0;
    let touchStartY = 0;
    if (shell) {
        shell.addEventListener('touchstart', function (e) {
            if (e.touches.length === 1) {
                touchStartX = e.touches[0].clientX;
                touchStartY = e.touches[0].clientY;
            }
        }, { passive: true });

        shell.addEventListener('touchend', function (e) {
            if (e.changedTouches.length === 1) {
                const deltaX = e.changedTouches[0].clientX - touchStartX;
                const deltaY = e.changedTouches[0].clientY - touchStartY;
                if (Math.abs(deltaX) > 45 && Math.abs(deltaX) > Math.abs(deltaY) * 1.4) {
                    if (deltaX < 0) {
                        goNext(); // Swipe left -> Next
                    } else if (deltaX > 0) {
                        goPrev(); // Swipe right -> Prev
                    }
                }
            }
        }, { passive: true });
    }

    // Direct Page Jump Input
    if (pageInputEl) {
        pageInputEl.addEventListener('change', function () {
            let targetPage = parseInt(pageInputEl.value, 10);
            if (isNaN(targetPage)) targetPage = currentPage;
            if (pdfDoc) {
                targetPage = Math.max(1, Math.min(pdfDoc.numPages, targetPage));
                currentPage = targetPage;
                renderPage(currentPage);
            }
        });
        pageInputEl.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                pageInputEl.blur();
            }
        });
    }

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
JS;
    }

    private function ensureDirectory(string $path): void
    {
        if (! is_dir($path) && ! mkdir($path, 0755, true) && ! is_dir($path)) {
            throw new RuntimeException('Gagal membuat direktori sementara.');
        }
    }

    private function removeDirectory(string $path): void
    {
        if (! is_dir($path)) {
            return;
        }

        $items = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS), \RecursiveIteratorIterator::CHILD_FIRST);
        foreach ($items as $item) {
            $item->isDir() ? @rmdir($item->getRealPath()) : @unlink($item->getRealPath());
        }

        @rmdir($path);
    }
}
