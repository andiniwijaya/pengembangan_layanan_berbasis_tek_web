/**
 * Modul Barcode WijayCart.
 * Fitur cetak dan unduh barcode produk di halaman admin.
 */

export function initBarcodeActions() {
    const printBtn = document.getElementById('barcode-print');
    const downloadBtn = document.getElementById('barcode-download');
    const svgEl = document.querySelector('#barcode-display svg');

    printBtn?.addEventListener('click', () => {
        const printWindow = window.open('', '_blank');
        printWindow.document.write(`
            <html><head><title>Cetak Barcode</title></head>
            <body style="display:flex;justify-content:center;align-items:center;height:100vh;margin:0;">
            ${document.getElementById('barcode-display').innerHTML}
            </body></html>
        `);
        printWindow.document.close();
        printWindow.print();
    });

    downloadBtn?.addEventListener('click', () => {
        if (!svgEl) return;
        const svgData = new XMLSerializer().serializeToString(svgEl);
        const blob = new Blob([svgData], { type: 'image/svg+xml' });
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url;
        a.download = `barcode-${downloadBtn.dataset.code || 'product'}.svg`;
        a.click();
        URL.revokeObjectURL(url);
    });
}
