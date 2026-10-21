<?php

use App\Services\DocumentToScormService;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\Test\CIUnitTestCase;

final class DocumentToScormServiceTest extends CIUnitTestCase
{
    public function testItBuildsAScormPackageWithEmbeddedPdfAndPdfViewerAssets(): void
    {
        $tempDir = WRITEPATH . 'tests';
        if (! is_dir($tempDir)) {
            mkdir($tempDir, 0777, true);
        }

        $tempPath = $tempDir . '/sample.pdf';
        file_put_contents($tempPath, "%PDF-1.4\n1 0 obj\n<< /Type /Catalog >>\nendobj\n");

        $uploadedFile = new UploadedFile(
            $tempPath,
            'sample.pdf',
            'application/pdf',
            filesize($tempPath),
            UPLOAD_ERR_OK
        );

        $service = new DocumentToScormService();
        $packagePath = $service->createPackage($uploadedFile, 'Dokumen Uji');

        $this->assertFileExists($packagePath);

        $zip = new ZipArchive();
        $this->assertTrue($zip->open($packagePath) === true);
        $this->assertNotFalse($zip->locateName('document.pdf'));
        $this->assertNotFalse($zip->locateName('imsmanifest.xml'));
        $this->assertNotFalse($zip->locateName('index.html'));
        $this->assertNotFalse($zip->locateName('assets/viewer.css'));
        $this->assertNotFalse($zip->locateName('assets/viewer.js'));
        $this->assertNotFalse($zip->locateName('assets/pdf.js'));
        $this->assertNotFalse($zip->locateName('assets/pdf.worker.js'));

        $indexHtml = $zip->getFromName('index.html');
        $this->assertStringContainsString('document.pdf', $indexHtml);
        $this->assertStringContainsString('assets/viewer.css', $indexHtml);
        $this->assertStringContainsString('assets/viewer.js', $indexHtml);

        $viewerJs = $zip->getFromName('assets/viewer.js');
        $this->assertStringContainsString('window.pdfjsLib', $viewerJs);

        $zip->close();
        @unlink($packagePath);
        @unlink($tempPath);
        if (is_dir(dirname($packagePath))) {
            @rmdir(dirname($packagePath));
        }
    }
}
