<?php

namespace App\Controllers;

use App\Models\RehabilitasiRawatJalanRegistrationModel;

class RehabilitasiController extends BaseController
{
    public function __construct(
        private readonly RehabilitasiRawatJalanRegistrationModel $registrations = new RehabilitasiRawatJalanRegistrationModel()
    ) {}

    public function registrationForm(): string
    {
        return view('layouts/public', [
            'title'   => 'Pendaftaran Rehabilitasi Rawat Jalan | BNN Kota Tanjungpinang',
            'content' => view('rehabilitasi/registration_form', [
                'validationErrors' => session()->getFlashdata('validationErrors') ?? [],
            ]),
        ]);
    }

    public function alurRehabilitasi(): string
    {
        $steps = [
            [
                'title' => 'Pendaftaran',
                'description' => 'Masyarakat melakukan pendaftaran dan skrining awal untuk memperoleh layanan rehabilitasi.',
            ],
            [
                'title' => 'Asesmen Awal',
                'description' => 'Tim melakukan wawancara dan asesmen guna mengetahui kondisi serta kebutuhan rehabilitasi.',
            ],
            [
                'title' => 'Layanan Rawat Jalan',
                'description' => 'Perencanaan terapi dan intervensi psikososial dan medis.',
            ],
            [
                'title' => 'Asesmen Lanjutan dan Monitoring',
                'description' => 'Asesmen lanjutan dan monitoring dilakukan untuk menilai perkembangan klien selama proses rehabilitasi.',
            ],
            [
                'title' => 'Persiapan Pascarehabilitasi',
                'description' => 'Resume perawatan rekomendasi pasca rehabilitasi dan penilaian.',
            ],
            [
                'title' => 'Layanan Pascarehabilitasi',
                'description' => 'Pemantauan dan pendampingan.',
            ],
            [
                'title' => 'Terminasi Program',
                'description' => 'Intervensi dan surat keterangan selesai rehabilitasi.',
            ],
        ];

        return view('layouts/public', [
            'title'   => 'Alur Rehabilitasi | BNN Kota Tanjungpinang',
            'content' => view('alur_rehabilitasi/index', [
                'steps' => $steps,
            ]),
        ]);
    }

    public function register(): \CodeIgniter\HTTP\RedirectResponse
    {
        $rules = [
            'client_name'      => 'required|max_length[255]',
            'client_nik'       => 'required|max_length[50]',
            'gender'           => 'required|in_list[Laki-laki,Perempuan]',
            'birth_place'      => 'required|string|max_length[150]',
            'birth_date'       => 'required|valid_date[Y-m-d]',
            'client_age'       => 'required|integer|greater_than[0]|less_than[120]',
            'client_phone'     => 'required|string|max_length[20]',
            'client_address'   => 'required|string',
            'guardian_name'    => 'required|string|max_length[255]',
            'guardian_nik'     => 'permit_empty|string|max_length[50]',
            'guardian_phone'   => 'permit_empty|string|max_length[20]',
            'purpose'          => 'required|string|max_length[255]',
            'guardian_address' => 'required|string',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()
                ->with('error', 'Mohon periksa kembali data yang wajib diisi.')
                ->with('validationErrors', $this->validator->getErrors());
        }

        $data = $this->request->getPost([
            'client_name',
            'client_nik',
            'gender',
            'birth_place',
            'birth_date',
            'client_age',
            'client_phone',
            'client_address',
            'guardian_name',
            'guardian_nik',
            'guardian_phone',
            'purpose',
            'guardian_address',
        ]);

        try {
            if (! $this->registrations->insert($data)) {
                return redirect()->back()->withInput()->with('error', 'Pendaftaran belum dapat disimpan. Silakan coba kembali.');
            }
        } catch (\Throwable $e) {
            log_message('error', 'Gagal menyimpan pendaftaran rehabilitasi: {message}', ['message' => $e->getMessage()]);

            return redirect()->back()->withInput()->with('error', 'Pendaftaran belum dapat disimpan. Silakan coba kembali.');
        }

        return redirect()->to('/pendaftaran-rehabilitasi')->with('success', 'Pendaftaran rehabilitasi berhasil dikirim.');
    }
}
