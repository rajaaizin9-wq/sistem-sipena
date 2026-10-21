<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;
    protected $useTimestamps    = false;
    protected $allowedFields    = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'is_active',
        'last_login',
        'created_at',
        'updated_at',
    ];
}
