<?php

namespace App\Controllers;

class TatController extends BaseController
{
    public function alurTat(): string
    {
        $steps = [
            [
                'title' => 'Permohonan Asesmen',
                'description' => 'TAT hanya dapat diminta oleh Penyidik, Jaksa Penuntut Umum, atau berdasarkan Penetapan Hakim — tidak bisa diajukan langsung oleh keluarga/tersangka.',
                'tables' => [
                    'headers' => ['Tahap Perkara', 'Pemohon', 'Batas Waktu'],
                    'rows' => [
                        ['Penyidikan', 'Penyidik (Polri/BNN)', 'Paling lama 3×24 jam sejak surat perintah penangkapan'],
                        ['Penuntutan', 'Jaksa Penuntut Umum', 'Selama proses penuntutan'],
                        ['Persidangan', 'Berdasarkan penetapan hakim', 'Selama persidangan berjalan'],
                    ]
                ],
                'documents' => [
                    'Surat permohonan asesmen (bermaterai)',
                    'Identitas tersangka/terdakwa',
                    'Laporan polisi / LKN',
                    'Surat perintah penyidikan, penangkapan, dan penahanan',
                    'Berita Acara Pemeriksaan (BAP)',
                    'Hasil uji laboratorium barang bukti narkotika',
                    'Hasil pemeriksaan urine / rambut dari fasilitas kesehatan pemerintah',
                    'Surat perintah penyitaan (jika ada barang bukti)'
                ],
            ],
            [
                'title' => 'Penerimaan & Disposisi di BNN',
                'description' => 'Petugas administrasi BNN menerima surat permohonan, mencatat di buku register, lalu mendisposisikannya kepada Kepala BNN setempat. Petugas TAT kemudian menindaklanjuti untuk menjadwalkan asesmen.',
            ],
            [
                'title' => 'Pelaksanaan Asesmen',
                'description' => 'Asesmen dilakukan oleh dua tim yang bekerja secara terpadu:',
                'teams' => [
                    [
                        'name' => 'Tim Medis (dokter, psikolog klinis, dan/atau psikiater)',
                        'points' => [
                            'Tes urine (7–8 parameter: MET, MOP, COC, AMP, BZO, THC, SOMA, K2)',
                            'Pemeriksaan fisik dan kesehatan awal',
                            'Wawancara klinis',
                            'Penilaian tingkat ketergantungan/kandungan narkotika',
                            'Analisis psikososial'
                        ]
                    ],
                    [
                        'name' => 'Tim Hukum (penyidik Polri/BNN, Jaksa, Kemenkumham/BAPAS)',
                        'points' => [
                            'Analisis peran tersangka: apakah korban penyalahguna, pecandu, atau pengedar',
                            'Penelusuran rekam jejak keterlibatan dalam jaringan peredaran gelap',
                            'Analisis barang bukti dan kaitannya dengan peredaran gelap narkotika'
                        ]
                    ]
                ],
            ],
            [
                'title' => 'Case Conference',
                'description' => 'Setelah pemeriksaan medis dan hukum selesai, dilakukan Case Conference — rapat gabungan Tim Medis dan Tim Hukum untuk membahas hasil secara terpadu dan menentukan rekomendasi.',
            ],
            [
                'title' => 'Hasil Rekomendasi TAT',
                'description' => 'Rekomendasi dapat berupa:',
                'recommendations' => [
                    ['status' => 'Pecandu Narkotika', 'rekomendasi' => 'Rehabilitasi (medis rawat inap, medis rawat jalan, atau sosial rawat inap)'],
                    ['status' => 'Korban Penyalahgunaan', 'rekomendasi' => 'Rehabilitasi (medis dan/atau sosial)'],
                    ['status' => 'Pengedar / Peredaran Gelap', 'rekomendasi' => 'Tidak direkomendasikan rehabilitasi → proses hukum pidana lanjut'],
                ],
            ],
            [
                'title' => 'Penyerahan Rekomendasi',
                'description' => 'Rekomendasi TAT diserahkan kepada Penyidik / JPU / Hakim (tergantung tahap perkara) dengan Berita Acara Penyerahan. Hasil ini kemudian:',
                'outcomes' => [
                    'Dilampirkan dalam berkas perkara',
                    'Diajukan sebagai bukti oleh JPU di persidangan',
                    'Menjadi dasar hakim dalam memutus (rehabilitasi atau pidana)'
                ],
            ]
        ];

        return view('layouts/public', [
            'title'   => 'Alur Tim Asesmen Terpadu (TAT) | BNN Kota Tanjungpinang',
            'content' => view('alur_tat/index', [
                'steps' => $steps,
            ]),
        ]);
    }
}
