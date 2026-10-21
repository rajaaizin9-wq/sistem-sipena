<?php

namespace App\Controllers;

use App\Services\AuthService;

class AuthController extends BaseController
{
    public function loginForm(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (session()->get('auth_user') !== null) {
            return redirect()->to('/dashboard');
        }

        return view('auth/login', [
            'error' => session()->getFlashdata('error'),
        ]);
    }

    public function login(): \CodeIgniter\HTTP\RedirectResponse
    {
        $username = trim((string) $this->request->getPost('username'));
        $password = (string) $this->request->getPost('password');

        if ($username === '' || $password === '') {
            return redirect()->back()->withInput()->with('error', 'Username dan password wajib diisi.');
        }

        $user = (new AuthService())->attempt($username, $password);

        if ($user === null) {
            return redirect()->back()->withInput()->with('error', 'Username atau password tidak valid.');
        }

        session()->regenerate(true);
        session()->set('auth_user', [
            'id'       => $user['id'],
            'name'     => $user['name'],
            'username' => $user['username'],
            'role'     => $user['role'],
        ]);

        return redirect()->to('/dashboard');
    }

    public function logout(): \CodeIgniter\HTTP\RedirectResponse
    {
        session()->destroy();

        return redirect()->to('/login');
    }
}
