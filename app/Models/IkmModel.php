<?php

namespace App\Models;

use CodeIgniter\Model;

class IkmModel extends Model
{
    protected $table            = 'ikm_settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useTimestamps    = true;
    protected $allowedFields    = ['ikm_score', 'ikm_year', 'created_at', 'updated_at'];

    public function getIkm(): array
    {
        try {
            $row = $this->find(1);
            if (is_array($row) && $row !== []) {
                return $row;
            }
        } catch (\Throwable $e) {
            // fallback
        }

        return [
            'id'        => 1,
            'ikm_score' => '-',
            'ikm_year'  => date('Y'),
        ];
    }

    public function saveIkm(string $score, string $year): bool
    {
        $payload = [
            'ikm_score'  => trim($score) !== '' ? trim($score) : '-',
            'ikm_year'   => trim($year) !== '' ? trim($year) : date('Y'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];

        try {
            if ($this->find(1) !== null) {
                return (bool) $this->update(1, $payload);
            }

            $payload['id'] = 1;
            return (bool) $this->insert($payload);
        } catch (\Throwable $e) {
            return false;
        }
    }
}
