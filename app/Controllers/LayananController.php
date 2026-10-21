<?php

namespace App\Controllers;

use App\Models\LandingPageSettingsModel;

class LayananController extends BaseController
{
    public function __construct(private readonly LandingPageSettingsModel $settingsModel = new LandingPageSettingsModel()) {}

    public function index(): string
    {
        $settings = $this->settingsModel->getSettings();

        return view('layouts/public', [
            'title'   => 'Layanan | BNN Kota Tanjungpinang',
            'content' => view('page_layanan/index', [
                'settings' => $settings,
                'services' => [
                    ['title' => 'Alur SKHPN', 'description' => 'Surat Keterangan Hasil Pemeriksaan Narkotika', 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>'],
                    ['title' => 'Alur Rehabilitasi', 'description' => 'Layanan rehabilitasi penyalahguna narkotika', 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>'],
                    ['title' => 'Alur TAT', 'description' => 'Tim Asesmen Terpadu penanganan tersangka & terdakwa narkotika', 'icon' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>']
                ],
                'service_links' => [
                    'Alur SKHPN' => base_url('alur-skhpn'),
                    'Alur Rehabilitasi' => base_url('alur-rehabilitasi'),
                    'Alur TAT' => base_url('alur-tat'),
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
}
