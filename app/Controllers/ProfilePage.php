<?php

namespace App\Controllers;

class ProfilePage extends BaseController
{
    public function index(): string
    {
        return view('layouts/public', [
            'title' => 'Profil BNN Kota Tanjungpinang',
            'content' => view('profile_page/index'),
        ]);
    }
}
