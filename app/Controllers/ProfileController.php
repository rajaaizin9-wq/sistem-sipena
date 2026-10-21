<?php

namespace App\Controllers;

use App\Models\UserModel;

class ProfileController extends BaseController
{
    public function __construct(private readonly UserModel $users = new UserModel()) {}

    public function index(): string
    {
        $user = session()->get('auth_user');
        $profile = $this->users->find((int) ($user['id'] ?? 0));

        return view('dashboard/layout', [
            'user' => $user,
            'content' => view('dashboard/profile', [
                'user' => $profile ?? $user,
            ]),
        ]);
    }

    public function update(): \CodeIgniter\HTTP\RedirectResponse
    {
        $user = session()->get('auth_user');
        $userId = (int) ($user['id'] ?? 0);

        if ($userId === 0) {
            return redirect()->to('/login');
        }

        $rules = [
            'name'  => 'required|string|max_length[100]',
            'email' => 'permit_empty|valid_email|max_length[150]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->to('/dashboard/profile')->with('error', 'Data profil tidak valid.');
        }

        $payload = [
            'name'  => trim((string) $this->request->getPost('name')),
            'email' => trim((string) $this->request->getPost('email')),
        ];

        $currentPassword = (string) $this->request->getPost('current_password');
        $newPassword     = (string) $this->request->getPost('new_password');
        $confirmPassword = (string) $this->request->getPost('confirm_password');

        if ($newPassword !== '' || $currentPassword !== '' || $confirmPassword !== '') {
            if ($currentPassword === '' || $newPassword === '' || $confirmPassword === '') {
                return redirect()->to('/dashboard/profile')->with('error', 'Lengkapi seluruh kolom password.');
            }

            if ($newPassword !== $confirmPassword) {
                return redirect()->to('/dashboard/profile')->with('error', 'Konfirmasi password tidak cocok.');
            }

            if (strlen($newPassword) < 6) {
                return redirect()->to('/dashboard/profile')->with('error', 'Password baru minimal 6 karakter.');
            }

            $record = $this->users->find($userId);
            if ($record === null || ! password_verify($currentPassword, $record['password'])) {
                return redirect()->to('/dashboard/profile')->with('error', 'Password saat ini salah.');
            }

            $payload['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        $this->users->update($userId, $payload);

        $updated = $this->users->find($userId);
        if ($updated !== null) {
            session()->set('auth_user', [
                'id'       => $updated['id'],
                'name'     => $updated['name'],
                'username' => $updated['username'],
                'role'     => $updated['role'],
            ]);
        }

        return redirect()->to('/dashboard/profile')->with('success', 'Profil berhasil diperbarui.');
    }
}