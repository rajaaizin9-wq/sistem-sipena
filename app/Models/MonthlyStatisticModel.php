<?php

namespace App\Models;

use CodeIgniter\Model;

class MonthlyStatisticModel extends Model
{
    protected $table = 'monthly_statistics';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['year', 'month', 'skhpn_count', 'rehab_count', 'created_at', 'updated_at'];

    public static function monthNames(): array
    {
        return [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
    }

    public function getYearData(int $year): array
    {
        $rows = $this->where('year', $year)->findAll();
        $indexed = [];
        foreach ($rows as $row) {
            $indexed[(int) $row['month']] = $row;
        }

        $result = [];
        foreach (self::monthNames() as $m => $name) {
            $result[$m] = [
                'month'       => $m,
                'name'        => $name,
                'skhpn_count' => (int) ($indexed[$m]['skhpn_count'] ?? 0),
                'rehab_count' => (int) ($indexed[$m]['rehab_count'] ?? 0),
            ];
        }

        return $result;
    }

    public function getAvailableYears(): array
    {
        $rows = $this->select('year')->distinct()->orderBy('year', 'DESC')->findAll();
        $years = array_values(array_unique(array_map('intval', array_column($rows, 'year'))));
        $currentYear = (int) date('Y');
        if (! in_array($currentYear, $years, true)) {
            array_unshift($years, $currentYear);
        }

        rsort($years);
        return array_values(array_unique($years));
    }

    public function saveYearData(int $year, array $monthsData): void
    {
        foreach ($monthsData as $m => $data) {
            $m = (int) $m;
            if ($m < 1 || $m > 12) continue;

            $skhpn = max(0, (int) ($data['skhpn_count'] ?? 0));
            $rehab = max(0, (int) ($data['rehab_count'] ?? 0));

            $existing = $this->where(['year' => $year, 'month' => $m])->first();
            if ($existing) {
                $this->update($existing['id'], [
                    'skhpn_count' => $skhpn,
                    'rehab_count' => $rehab,
                ]);
            } else {
                $this->insert([
                    'year'        => $year,
                    'month'       => $m,
                    'skhpn_count' => $skhpn,
                    'rehab_count' => $rehab,
                ]);
            }
        }
    }
}
