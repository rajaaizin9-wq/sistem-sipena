<?php

namespace App\Controllers;

use App\Models\ScormModuleModel;

class Learning extends BaseController
{
    private const INITIAL_LIMIT = 9;
    private const MORE_LIMIT = 3;

    public function index(): string
    {
        $search = trim((string) $this->request->getGet('q'));
        $model = new ScormModuleModel();
        $modules = $model->getPublishedModules(self::INITIAL_LIMIT + 1, 0, $search);

        return view('layouts/public', [
            'title'   => 'Learning Center | BNN Kota Tanjungpinang',
            'content' => view('learning/index', [
                'modules' => array_slice($modules, 0, self::INITIAL_LIMIT),
                'hasMore' => count($modules) > self::INITIAL_LIMIT,
                'search'  => $search,
            ]),
        ]);
    }

    public function more(): \CodeIgniter\HTTP\ResponseInterface
    {
        $offset  = max(0, (int) $this->request->getGet('offset'));
        $search  = trim((string) $this->request->getGet('q'));
        $limit   = ($offset === 0) ? self::INITIAL_LIMIT : self::MORE_LIMIT;
        $modules = (new ScormModuleModel())->getPublishedModules($limit + 1, $offset, $search);

        return $this->response->setJSON([
            'html'    => view('learning/_module_cards', ['modules' => array_slice($modules, 0, $limit)]),
            'hasMore' => count($modules) > $limit,
        ]);
    }

    public function search(): \CodeIgniter\HTTP\ResponseInterface
    {
        $search = trim((string) $this->request->getGet('q'));
        $limit = $search === '' ? self::INITIAL_LIMIT + 1 : 0;
        $modules = (new ScormModuleModel())->getPublishedModules($limit, 0, $search);
        $hasMore = $search === '' && count($modules) > self::INITIAL_LIMIT;
        $visibleModules = $hasMore ? array_slice($modules, 0, self::INITIAL_LIMIT) : $modules;

        return $this->response->setJSON([
            'html' => view('learning/_module_cards', ['modules' => $visibleModules]),
            'hasMore' => $hasMore,
            'count' => count($visibleModules),
        ]);
    }
}
