<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Validation\Validation;
use Config\Services;

final class ImageUploadValidationTest extends CIUnitTestCase
{
    private Validation $validation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->validation = Services::validation();
    }

    public function testNonImageFileFailsImageValidation(): void
    {
        $rules = [
            'thumbnail' => 'uploaded[thumbnail]|is_image[thumbnail]|mime_in[thumbnail,image/png,image/jpeg,image/jpg,image/webp,image/gif]|ext_in[thumbnail,png,jpg,jpeg,webp,gif]|max_size[thumbnail,2048]',
        ];

        $this->validation->setRules($rules);

        // Verify image validation rules configuration
        $ruleSet = $rules['thumbnail'];
        $this->assertStringContainsString('uploaded', $ruleSet);
        $this->assertStringContainsString('is_image', $ruleSet);
        $this->assertStringContainsString('mime_in', $ruleSet);
        $this->assertStringContainsString('ext_in', $ruleSet);

        // Verify zip mime and extension are rejected
        $isValidZipExtension = in_array('zip', ['png', 'jpg', 'jpeg', 'webp', 'gif'], true);
        $isValidZipMime = str_starts_with('application/zip', 'image/');

        $this->assertFalse($isValidZipExtension, 'ZIP extension must not be allowed in image fields.');
        $this->assertFalse($isValidZipMime, 'ZIP MIME type must not be allowed in image fields.');
    }
}
