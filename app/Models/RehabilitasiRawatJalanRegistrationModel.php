<?php

namespace App\Models;

use CodeIgniter\Model;

class RehabilitasiRawatJalanRegistrationModel extends Model
{
    protected $table = 'rehabilitasi_rawat_jalan_registrations';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = [
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
    ];
}
