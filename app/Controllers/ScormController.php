<?php

namespace App\Controllers;

use App\Models\ScormModuleModel;
use App\Services\DocumentToScormService;
use App\Services\ScormService;

class ScormController extends BaseController
{
    public function __construct(
        private readonly ScormModuleModel $model = new ScormModuleModel(),
        private readonly ScormService $scormService = new ScormService(),
        private readonly DocumentToScormService $documentToScormService = new DocumentToScormService(),
    ) {}

    public function index(): string
    {
        $user = session()->get('auth_user');

        $search = trim((string) $this->request->getGet('search'));
        $sort   = (string) $this->request->getGet('sort');
        $order  = strtolower((string) $this->request->getGet('order'));

        $result = $this->model->getAdminModules($search, $sort, $order, 10);

        return view('dashboard/layout', [
            'user' => $user,
            'content' => view('dashboard/scorm/index', [
                'user'    => $user,
                'modules' => $result['modules'] ?? [],
                'pager'   => $result['pager'] ?? null,
                'total'   => $result['total'] ?? 0,
                'page'    => $result['page'] ?? 1,
                'perPage' => $result['perPage'] ?? 10,
                'search'  => $search,
                'sort'    => $sort,
                'order'   => $order,
            ]),
        ]);
    }

    public function create(): string
    {
        $user = session()->get('auth_user');

        return view('dashboard/layout', [
            'user' => $user,
            'content' => view('dashboard/scorm/form', [
                'user'   => $user,
                'module' => null,
                'edit'   => false,
            ]),
        ]);
    }

    public function edit(string $id): string
    {
        $user = session()->get('auth_user');
        $module = $this->model->getModuleById($id);

        if ($module === null) {
            return redirect()->to('/dashboard/scorm')->with('error', 'Modul tidak ditemukan.');
        }

        return view('dashboard/layout', [
            'user' => $user,
            'content' => view('dashboard/scorm/form', [
                'user'   => $user,
                'module' => $module,
                'edit'   => true,
            ]),
        ]);
    }

    public function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        $user = session()->get('auth_user');
        if ($user === null || ($user['role'] ?? '') !== 'humas_umum') {
            return redirect()->to('/dashboard');
        }

        $thumbnailFile = $this->request->getFile('thumbnail');
        if ($thumbnailFile !== null && $thumbnailFile->getError() !== UPLOAD_ERR_NO_FILE) {
            if (! $this->validate(['thumbnail' => 'uploaded[thumbnail]|is_image[thumbnail]|mime_in[thumbnail,image/png,image/jpeg,image/jpg,image/webp,image/gif]|ext_in[thumbnail,png,jpg,jpeg,webp,gif]|max_size[thumbnail,2048]'])) {
                return redirect()->back()->withInput()->with('error', 'Thumbnail harus berupa file gambar valid (JPG, PNG, WebP, GIF) maksimal 2 MB.');
            }
        }

        $uploadFile = $this->request->getFile('file');
        if ($thumbnailFile !== null && ! $thumbnailFile->isValid()) {
            $thumbnailFile = null;
        }

        $metadata = [
            'title'       => trim((string) $this->request->getPost('title')),
            'description' => trim((string) $this->request->getPost('description')),
            'published'   => (int) ($this->request->getPost('published') ?? 0),
            'created_by'  => (int) ($user['id'] ?? 0),
        ];

        try {
            if ($uploadFile === null || ! $uploadFile->isValid()) {
                return redirect()->back()->withInput()->with('error', 'File modul wajib diunggah.');
            }

            if (strtolower($uploadFile->getExtension()) === 'zip') {
                $result = $this->scormService->uploadAndExtract($uploadFile, $thumbnailFile, $metadata);
            } else {
                $packagePath = $this->documentToScormService->createPackage($uploadFile, $metadata['title']);
                try {
                    $result = $this->scormService->importGeneratedPackage($packagePath, $thumbnailFile, $metadata);
                } finally {
                    @unlink($packagePath);
                    @rmdir(dirname($packagePath));
                    @rmdir(dirname(dirname($packagePath)));
                }
            }
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        if (! $result['success']) {
            return redirect()->back()->withInput()->with('error', $result['message']);
        }

        return redirect()->to('/dashboard/scorm')->with('success', $result['message']);
    }

    public function update(string $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $user = session()->get('auth_user');
        if ($user === null) {
            return redirect()->to('/dashboard');
        }

        $rules = [
            'title'       => 'required|string|max_length[255]',
            'description' => 'permit_empty|string',
            'published'   => 'permit_empty|in_list[0,1]',
        ];

        $thumbnailFile = $this->request->getFile('thumbnail');
        if ($thumbnailFile !== null && $thumbnailFile->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['thumbnail'] = 'uploaded[thumbnail]|is_image[thumbnail]|mime_in[thumbnail,image/png,image/jpeg,image/jpg,image/webp,image/gif]|ext_in[thumbnail,png,jpg,jpeg,webp,gif]|max_size[thumbnail,2048]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Data modul atau thumbnail tidak valid (gambar harus JPG, PNG, WebP, GIF max 2 MB).');
        }

        $thumbnailFile = $this->request->getFile('thumbnail');
        if ($thumbnailFile !== null && ! $thumbnailFile->isValid()) {
            $thumbnailFile = null;
        }

        $result = $this->scormService->updateModule(
            $id,
            [
                'title'       => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'published'   => $this->request->getPost('published'),
            ],
            $thumbnailFile
        );

        if (! $result['success']) {
            return redirect()->back()->withInput()->with('error', $result['message']);
        }

        return redirect()->to('/dashboard/scorm')->with('success', $result['message']);
    }

    public function delete(string $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $this->scormService->deleteModule($id);

        return redirect()->to('/dashboard/scorm')->with('success', 'Modul berhasil dihapus.');
    }

    public function togglePublished(string $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $result = $this->scormService->togglePublished($id);

        if (! $result['success']) {
            return redirect()->to('/dashboard/scorm')->with('error', $result['message']);
        }

        return redirect()->to('/dashboard/scorm')->with('success', $result['message']);
    }

    public function publish(string $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $module = $this->model->getModuleById($id);
        if ($module === null) {
            return redirect()->to('/dashboard/scorm')->with('error', 'Modul tidak ditemukan.');
        }

        $this->model->togglePublished($id, 1);

        return redirect()->to('/dashboard/scorm')->with('success', 'Modul berhasil diterbitkan.');
    }

    public function unpublish(string $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $module = $this->model->getModuleById($id);
        if ($module === null) {
            return redirect()->to('/dashboard/scorm')->with('error', 'Modul tidak ditemukan.');
        }

        $this->model->togglePublished($id, 0);

        return redirect()->to('/dashboard/scorm')->with('success', 'Modul berhasil ditarik.');
    }
}
