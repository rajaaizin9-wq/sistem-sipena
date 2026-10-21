<?php

use App\Controllers\Home;
use CodeIgniter\Test\CIUnitTestCase;

final class HomePageSettingsTest extends CIUnitTestCase
{
    public function testHomePageUsesLandingPageSettings(): void
    {
        $path = WRITEPATH . 'landing_page_settings.json';
        $payload = [
            'hero_title' => 'Judul Uji',
            'hero_subtitle' => 'Subjudul uji',
            'hero_cta_label' => 'Mulai sekarang',
            'hero_cta_url' => '/uji',
            'secondary_cta_label' => 'Lihat detail',
            'secondary_cta_url' => '/detail',
            'about_title' => 'Tentang BNN',
            'about_body' => 'Isi tentang BNN',
            'services_title' => 'Layanan uji',
            'services_body' => 'Deskripsi layanan',
            'quick_links_title' => 'Akses uji',
            'quick_links_body' => 'Deskripsi akses',
        ];

        file_put_contents($path, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

        try {
            $controller = new Home();
            $html = (string) $controller->index();

            $this->assertStringContainsString('Judul Uji', $html);
            $this->assertStringContainsString('Layanan uji', $html);
            $this->assertStringContainsString('Akses uji', $html);
        } finally {
            if (is_file($path)) {
                unlink($path);
            }
        }
    }
}
