<?php

namespace App\Models;

use CodeIgniter\Model;

class AboutSectionModel extends Model
{
    protected $table = 'about_sections';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['title', 'description', 'link', 'image'];
}
