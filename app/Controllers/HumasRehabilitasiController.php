<?php

namespace App\Controllers;

use App\Models\RehabilitasiRawatJalanRegistrationModel;

class HumasRehabilitasiController extends BaseController
{
    public function __construct(
        private readonly RehabilitasiRawatJalanRegistrationModel $registrations = new RehabilitasiRawatJalanRegistrationModel()
    ) {}

    public function kontenRehabilitasi(): string
    {
        $user = session()->get('auth_user');

        return view('dashboard/layout', [
            'user' => $user,
            'content' => view('dashboard/humas_rehabilitasi/konten_rehabilitasi', [
                'user' => $user,
            ]),
        ]);
    }

    public function registrasiRehabilitasi(): string
    {
        $user = session()->get('auth_user');

        if ($user === null || ($user['role'] ?? '') !== 'humas_rehabilitasi') {
            return redirect()->to('/dashboard');
        }

        $registrations = $this->registrations
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('dashboard/layout', [
            'user' => $user,
            'content' => view('dashboard/humas_rehabilitasi/registrasi_rehabilitasi', [
                'user' => $user,
                'registrations' => $registrations,
            ]),
        ]);
    }
}
