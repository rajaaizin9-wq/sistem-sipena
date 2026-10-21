<?php

namespace App\Models;

use CodeIgniter\Model;

class LandingPageSettingsModel extends Model
{
    protected $table = 'landing_page_settings';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $allowedFields = [
        'hero_title',
        'hero_subtitle',
        'hero_cta_label',
        'hero_cta_url',
        'secondary_cta_label',
        'secondary_cta_url',
        'about_title',
        'about_body',
        'services_title',
        'services_body',
        'quick_links_title',
        'quick_links_body',
        'ikm_score',
        'ikm_year',
        'updated_at',
    ];

    public function defaultSettings(): array
    {
        return [
            'id' => 1,
            'hero_title' => 'Selamat Datang di BNN Kota Tanjungpinang',
            'hero_subtitle' => 'Bersama mewujudkan Indonesia bersih dari penyalahgunaan dan peredaran gelap narkoba.',
            'hero_cta_label' => 'Akses layanan',
            'hero_cta_url' => '#akses',
            'secondary_cta_label' => 'Ruang belajar',
            'secondary_cta_url' => '/belajar',
            'about_title' => 'Tentang BNN Kota Tanjungpinang',
            'about_body' => 'BNN Kota Tanjungpinang hadir untuk memberikan layanan informasi, edukasi, dan pencegahan narkoba secara terbuka dan mudah diakses.',
            'services_title' => 'Layanan utama',
            'services_body' => 'Fokus pada pelayanan yang membantu masyarakat mendapatkan informasi dan dukungan secara tepat.',
            'quick_links_title' => 'Layanan Gurindam',
            'quick_links_body' => 'Layanan Gurindam merupakan layanan publik digitalisasi oleh BNN Kota Tanjungpinang',
            'ikm_score' => '-',
            'ikm_year' => date('Y'),
        ];
    }

    public function getSettings(): array
    {
        $defaults = $this->defaultSettings();
        $json = $this->readJsonFallback([]);
        $base = array_merge($defaults, $json);

        try {
            $row = $this->find(1);
            if (is_array($row) && $row !== []) {
                $base = array_merge($base, array_filter($row, fn($val) => $val !== null));
            }
        } catch (\Throwable $e) {
            // Fallback below.
        }

        $ikmModel = new \App\Models\IkmModel();
        $ikmData  = $ikmModel->getIkm();
        $base['ikm_score'] = $ikmData['ikm_score'] ?? '-';
        $base['ikm_year']  = $ikmData['ikm_year'] ?? date('Y');

        return $base;
    }

    public function saveSettings(array $data): bool
    {
        if (array_key_exists('ikm_score', $data) || array_key_exists('ikm_year', $data)) {
            $ikmModel = new \App\Models\IkmModel();
            $ikmModel->saveIkm(
                (string) ($data['ikm_score'] ?? '-'),
                (string) ($data['ikm_year'] ?? date('Y'))
            );
        }

        $payload = $this->getSettings();
        $allowed = $this->defaultSettings();

        foreach ($data as $key => $value) {
            if (array_key_exists($key, $allowed)) {
                $payload[$key] = trim((string) $value);
            }
        }
        $payload['updated_at'] = date('Y-m-d H:i:s');

        // Always write to JSON fallback so data is never lost if DB table lacks new columns
        $this->writeJsonFallback($payload);

        try {
            if ($this->find(1) !== null) {
                $this->update(1, $payload);
            } else {
                $this->insert($payload);
            }
        } catch (\Throwable $e) {
            // DB column schema mismatch or error fallback handled by JSON
        }

        return true;
    }

    private function readJsonFallback(array $defaults): array
    {
        $path = WRITEPATH . 'landing_page_settings.json';
        if (! is_file($path)) {
            return $defaults;
        }

        $content = file_get_contents($path);
        if ($content === false) {
            return $defaults;
        }

        $decoded = json_decode($content, true);
        if (! is_array($decoded)) {
            return $defaults;
        }

        return array_merge($defaults, $decoded);
    }

    private function writeJsonFallback(array $payload): void
    {
        $path = WRITEPATH . 'landing_page_settings.json';
        file_put_contents($path, json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}
