(function () {
    const script = document.createElement('script');
    script.src = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js';
    script.onload = function () {
        window.dispatchEvent(new Event('pdfjs:ready'));
    };
    document.head.appendChild(script);
})();