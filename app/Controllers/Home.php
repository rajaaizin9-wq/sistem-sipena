<?php

namespace App\Controllers;

use App\Models\LandingPageSettingsModel;
use App\Models\ArticleModel;
use App\Models\DrugFactModel;
use App\Models\ScormModuleModel;
use App\Models\AboutSectionModel;
use App\Models\MonthlyStatisticModel;

class Home extends BaseController
{
    public function __construct(
        private readonly LandingPageSettingsModel $settingsModel = new LandingPageSettingsModel(),
        private readonly ArticleModel $articleModel = new ArticleModel(),
        private readonly DrugFactModel $drugFactModel = new DrugFactModel(),
        private readonly ScormModuleModel $scormModuleModel = new ScormModuleModel(),
        private readonly AboutSectionModel $aboutSectionModel = new AboutSectionModel(),
        private readonly MonthlyStatisticModel $monthlyStatsModel = new MonthlyStatisticModel(),
    ) {}

    public function index(): string
    {
        $settings = $this->settingsModel->getSettings();
        helper('date');

        $availableYears = array_values(array_unique(array_map('intval', $this->monthlyStatsModel->getAvailableYears())));
        $selectedYear = (int) ($this->request->getGet('stat_year') ?: date('Y'));
        if (! in_array($selectedYear, $availableYears, true)) {
            $selectedYear = reset($availableYears) ?: (int) date('Y');
        }

        return view('layouts/public', [
            'title'   => 'BNN Kota Tanjungpinang',
            'content' => view('home/index', [
                'settings' => $settings,
                'articles' => $this->articleModel->where('status', 'published')->orderBy('created_at', 'DESC')->findAll(4),
                'readingModules' => $this->scormModuleModel->getPublishedModules(4),
                'drugFacts' => $this->drugFactModel->orderBy('sort_order', 'ASC')->orderBy('id', 'ASC')->findAll(4),
                'aboutSection' => $this->aboutSectionModel->orderBy('id', 'DESC')->first(),
                'monthlyData' => $this->monthlyStatsModel->getYearData($selectedYear),
                'availableYears' => $availableYears,
                'selectedYear' => $selectedYear,
                'services' => [
                    ['title' => 'Alur SKHPN', 'description' => 'Surat Keterangan Hasil Pemeriksaan Narkotika', 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>'],
                    ['title' => 'Alur Rehabilitasi', 'description' => 'Layanan rehabilitasi penyalahguna narkotika', 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>'],
                    ['title' => 'Ruang Belajar', 'description' => 'Modul edukasi interaktif tentang bahaya narkoba', 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>'],
                ],
                'service_links' => [
                    'Alur SKHPN' => '#kontak',
                    'Alur Rehabilitasi' => base_url('pendaftaran-rehabilitasi'),
                    'Ruang Belajar' => base_url('belajar'),
                ],
                'quick_links' => [
                    ['title' => 'Buku Tamu', 'url' => 'https://formfacade.com/sm/HNgUlmWf3'],
                    ['title' => 'Layanan SKHPN', 'url' => 'https://boss.bnn.go.id/layanan_skhpn/daftarskhpn'],
                    ['title' => 'Layanan Penyuluhan', 'url' => 'https://whatstarget.com/sm/9x9At5yJd'],
                    ['title' => 'Layanan Tes Urine', 'url' => 'https://formfacade.com/public/111201608809958731619/all/form/1FAIpQLSfUK9IbnuFsoEJsRGwscnaBIB_jfzDbpyTSqgABjMsY96SbyA'],
                    ['title' => 'Layanan Pendaftaran Rehabilitasi Rawat Jalan', 'url' => base_url('pendaftaran-rehabilitasi')],
                    ['title' => 'Pengaduan Masyarakat', 'url' => 'https://forms.gle/YHmRm6dUDupX6PWs6'],
                    ['title' => 'Kritik dan Saran', 'url' => 'https://docs.google.com/forms/d/e/1FAIpQLScpwb3ZhfKmIKP79orCM-vo5gt3uZbbltkuHzK65vkv8gvqlA/viewform'],
                    ['title' => 'Survei Kualitas Pelayanan', 'url' => 'https://docs.google.com/forms/d/e/1FAIpQLSdf-FOVz0WCybct2o2d-QEK84MuLgSceC5DbzVSHyyg9RVwpg/viewform?usp=sf_link'],
                    ['title' => 'Survei Indeks Persepsi Korupsi', 'url' => 'https://docs.google.com/forms/d/e/1FAIpQLSfPteSJFW_oFX2peEemd3bbf5t6eSx5Jplxie-fPaf_iChCXg/viewform?usp=sf_link'],
                ],
            ]),
        ]);
    }

    public function monthlyStatsApi(): \CodeIgniter\HTTP\ResponseInterface
    {
        $year = (int) ($this->request->getGet('year') ?: date('Y'));
        $monthlyData = array_values($this->monthlyStatsModel->getYearData($year));

        return $this->response->setJSON([
            'year' => $year,
            'data' => $monthlyData,
        ]);
    }
}
