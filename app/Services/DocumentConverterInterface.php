<?php

namespace App\Services;

use CodeIgniter\HTTP\Files\UploadedFile;

interface DocumentConverterInterface
{
    public function supports(string $extension): bool;

    public function convertToPdf(UploadedFile $document, string $workDir): string;
}
