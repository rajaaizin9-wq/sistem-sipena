<?php

namespace App\Models;

use CodeIgniter\Model;

class ScormModuleModel extends Model
{
    protected $table = 'scorm_modules';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = false;
    protected $returnType = 'array';
    protected $allowedFields = [
        'id',
        'title',
        'description',
        'version',
        'folder_name',
        'launch_file',
        'thumbnail',
        'published',
        'created_by',
        'created_at',
        'updated_at',
    ];

    public function getModules(): array
    {
        try {
            $rows = $this->orderBy('created_at', 'DESC')->findAll();
            if (is_array($rows) && $rows !== []) {
                return $rows;
            }
        } catch (\Throwable $e) {
        }

        return $this->readJsonFallback();
    }

    public function getAdminModules(string $search = '', string $sort = 'created_at', string $order = 'desc', int $perPage = 10): array
    {
        $allowedSorts = ['title', 'published', 'created_at'];
        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }
        $order = strtolower($order) === 'asc' ? 'asc' : 'desc';

        try {
            $search = trim($search);
            if ($search !== '') {
                $this->groupStart()
                    ->like('title', $search)
                    ->orLike('description', $search)
                    ->groupEnd();
            }
            $this->orderBy($sort, strtoupper($order));

            $modules = $this->paginate($perPage, 'scorm');

            return [
                'modules' => $modules ?: [],
                'pager'   => $this->pager,
                'total'   => $this->pager ? $this->pager->getTotal('scorm') : 0,
            ];
        } catch (\Throwable $e) {
            $all = $this->readJsonFallback();
            $search = trim($search);
            if ($search !== '') {
                $all = array_values(array_filter($all, static fn($item): bool => 
                    stripos((string) ($item['title'] ?? ''), $search) !== false || 
                    stripos((string) ($item['description'] ?? ''), $search) !== false
                ));
            }

            usort($all, static function($a, $b) use ($sort, $order): int {
                $valA = $a[$sort] ?? '';
                $valB = $b[$sort] ?? '';
                $cmp = strcmp((string) $valA, (string) $valB);
                return $order === 'asc' ? $cmp : -$cmp;
            });

            $total = count($all);
            $page = (int) (service('request')->getGet('page_scorm') ?? 1);
            if ($page < 1) $page = 1;
            $offset = ($page - 1) * $perPage;
            $sliced = array_slice($all, $offset, $perPage);

            return [
                'modules' => $sliced,
                'pager'   => null,
                'total'   => $total,
                'page'    => $page,
                'perPage' => $perPage,
            ];
        }
    }

    public function getPublishedModules(int $limit = 0, int $offset = 0, string $search = ''): array
    {
        try {
            $builder = $this->where('published', 1)->orderBy('created_at', 'DESC');

            $search = trim($search);
            if ($search !== '') {
                $builder->groupStart()
                    ->like('title', $search)
                    ->orLike('description', $search)
                    ->groupEnd();
            }

            return $limit > 0 ? $builder->findAll($limit, $offset) : $builder->findAll();
        } catch (\Throwable $e) {
            $all = array_values(array_filter($this->readJsonFallback(), static fn($item) => (int) ($item['published'] ?? 0) === 1));
            $search = trim($search);
            if ($search !== '') {
                $all = array_values(array_filter($all, static fn($item): bool => 
                    stripos((string) ($item['title'] ?? ''), $search) !== false || 
                    stripos((string) ($item['description'] ?? ''), $search) !== false
                ));
            }
            if ($limit > 0) {
                return array_slice($all, $offset, $limit);
            }
            return $all;
        }
    }

    public function getModuleById(string $id): ?array
    {
        try {
            $row = $this->find($id);
            if (is_array($row) && $row !== []) {
                return $row;
            }
        } catch (\Throwable $e) {
        }

        $modules = $this->readJsonFallback();
        foreach ($modules as $module) {
            if (($module['id'] ?? '') === $id) {
                return $module;
            }
        }

        return null;
    }

    public function saveModule(array $data): string
    {
        $id = (string) ($data['id'] ?? uniqid('scorm-', true));
        $timestamp = date('Y-m-d H:i:s');
        $module = [
            'id' => $id,
            'title' => trim((string) ($data['title'] ?? '')),
            'description' => trim((string) ($data['description'] ?? '')),
            'version' => trim((string) ($data['version'] ?? '')),
            'folder_name' => trim((string) ($data['folder_name'] ?? '')),
            'launch_file' => trim((string) ($data['launch_file'] ?? '')),
            'thumbnail' => trim((string) ($data['thumbnail'] ?? '')),
            'published' => (int) ($data['published'] ?? 0),
            'created_by' => (int) ($data['created_by'] ?? 0),
            'created_at' => $timestamp,
            'updated_at' => $timestamp,
        ];

        try {
            if ($this->find($id) !== null) {
                $this->update($id, $module);
            } else {
                $this->insert($module);
            }

            return $id;
        } catch (\Throwable $e) {
            $this->writeJsonFallback($module);

            return $id;
        }
    }

    public function togglePublished(string $id, int $published): bool
    {
        $module = $this->getModuleById($id);
        if ($module === null) {
            return false;
        }

        $module['published'] = $published;
        $module['updated_at'] = date('Y-m-d H:i:s');

        try {
            $this->update($id, $module);

            return true;
        } catch (\Throwable $e) {
            $this->writeJsonFallback($module);

            return true;
        }
    }

    public function deleteModule(string $id): bool
    {
        try {
            if ($this->db->tableExists($this->table)) {
                $this->delete($id);
            }
        } catch (\Throwable $e) {
        }

        $modules = $this->readJsonFallback();
        $remaining = array_values(array_filter($modules, static fn(array $module): bool => ($module['id'] ?? '') !== $id));
        $this->writeJsonFallbackList($remaining);

        return true;
    }

    private function readJsonFallback(): array
    {
        $path = WRITEPATH . 'scorm_modules.json';
        if (! is_file($path)) {
            return [];
        }

        $content = file_get_contents($path);
        if ($content === false) {
            return [];
        }

        $decoded = json_decode($content, true);
        if (! is_array($decoded)) {
            return [];
        }

        return $decoded;
    }

    private function writeJsonFallback(array $module): void
    {
        $path = WRITEPATH . 'scorm_modules.json';
        $modules = $this->readJsonFallback();

        foreach ($modules as $index => $item) {
            if (($item['id'] ?? '') === ($module['id'] ?? '')) {
                $modules[$index] = $module;
                file_put_contents($path, json_encode($modules, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

                return;
            }
        }

        $modules[] = $module;
        file_put_contents($path, json_encode($modules, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }

    private function writeJsonFallbackList(array $modules): void
    {
        $path = WRITEPATH . 'scorm_modules.json';
        file_put_contents($path, json_encode($modules, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    }
}
