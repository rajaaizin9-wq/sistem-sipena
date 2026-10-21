<?php

namespace App\Services;

use App\Models\UserModel;

class AuthService
{
    public function __construct(private readonly UserModel $users = new UserModel())
    {
    }

    public function attempt(string $username, string $password): ?array
    {
        $user = $this->users
            ->where('username', $username)
            ->where('is_active', 1)
            ->first();

        if ($user === null || ! password_verify($password, $user['password'])) {
            return null;
        }

        $this->users->update($user['id'], [
            'last_login' => date('Y-m-d H:i:s'),
        ]);

        unset($user['password']);

        return $user;
    }
}
