<?php

namespace App\Models;

use CodeIgniter\Model;

class DrugFactModel extends Model
{
    protected $table = 'drug_facts';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['title', 'value', 'description', 'sort_order'];
}
