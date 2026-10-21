<?php

namespace App\Controllers;

class SkhpnController extends BaseController
{
    public function index(): string
    {
        return view('layouts/public', [
            'title'   => 'SKHPN | BNN Kota Tanjungpinang',
            'content' => view('skhpn/index'),
        ]);
    }

    public function alurSkhpn(): string
    {
        $steps = [
            [
                'title' => 'Pendaftaran Online',
                'description' => '1. Mendaftar di situs https://boss.bnn.go.id
                                  2. Mengisi formulir
                                  3. Melengkapi persyaratan (upload foto KTP dan Pas Foto) atau bisa langsung datang ke BNN Kota Tanjungpinang
                                  4. Menunggu Penjadwalan',
            ],
            [
                'title' => 'Klien datang ke Klinik',
                'description' => 'Datang ke Klinik Pratama BNN Kota Tanjungpinang sesuai jadwal yang sudah ditentukan, membawa persyaratan yang dibutuhkan (KTP dan Pas Foto)',
            ],
            [
                'title' => 'Pembayaran',
                'description' => '1. Klien akan dibuatkan billing PNBP
                                  2. Pembayaran dapat melalui Banking, E-Wallet, Alfamart, Indomaret, dan Kantor Pos',
            ],
            [
                'title' => 'Pemeriksaan',
                'description' => '1. Pemeriksaan Fisik
                                  2. Skrining Assist v3.1
                                  3. Tes Urine 7 Parameter (Amphetamine, Morphine, Tetrahydrocannabinol, Methamphetamine, Cocaine, Benzodiazepines, Carisoprodol)',
            ],
            [
                'title' => 'Hasil',
                'description' => '1. Klien menunggu hasil pemeriksaan
                                  2. Penerbitan Surat Maksimal 5 Menit
                                  3. Form Surat menggunakan Tanda Tangan Elektronik (TTE)',
            ],
        ];

        return view('layouts/public', [
            'title'   => 'Alur SKHPN | BNN Kota Tanjungpinang',
            'content' => view('alur_skhpn/index', [
                'steps' => $steps,
            ]),
        ]);
    }
}
