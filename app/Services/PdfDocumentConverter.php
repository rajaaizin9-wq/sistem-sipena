<?php

namespace App\Services;

use CodeIgniter\HTTP\Files\UploadedFile;
use RuntimeException;

class PdfDocumentConverter implements DocumentConverterInterface
{
    public function supports(string $extension): bool
    {
        return strtolower($extension) === 'pdf';
    }

    public function convertToPdf(UploadedFile $document, string $workDir): string
    {
        $sourcePath = $workDir . '/source.pdf';

        if (! copy($document->getTempName(), $sourcePath)) {
            throw new RuntimeException('Gagal menyalin dokumen PDF sementara.');
        }

        return $sourcePath;
    }
}
