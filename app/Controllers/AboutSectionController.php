<?php

namespace App\Controllers;

use App\Models\AboutSectionModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class AboutSectionController extends BaseController
{
    public function __construct(private readonly AboutSectionModel $sections = new AboutSectionModel()) {}

    private function authorized(): bool
    {
        return (session()->get('auth_user')['role'] ?? '') === 'humas_umum';
    }

    public function create(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        $section = $this->sections->orderBy('id', 'DESC')->first();
        if ($section !== null) {
            return redirect()->to('/dashboard/landing-page/about/' . $section['id']);
        }
        return $this->form(null);
    }

    public function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        $section = $this->sections->orderBy('id', 'DESC')->first();
        if ($section !== null) {
            return redirect()->to('/dashboard/landing-page/about/' . $section['id'])
                ->with('error', 'Section Tentang Kami sudah tersedia. Silakan edit section yang ada.');
        }
        if (! $this->validate($this->rules())) return redirect()->back()->withInput()->with('error', 'Data section Tentang Kami atau gambar tidak valid. Gambar harus berupa file JPG, PNG, WebP, atau GIF max 2 MB.');
        $this->sections->insert($this->payload());
        return redirect()->to('/dashboard/landing-page')->with('success', 'Section Tentang Kami berhasil ditambahkan.');
    }

    public function edit(int $id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        $section = $this->sections->find($id);
        if ($section === null) return redirect()->to('/dashboard/landing-page')->with('error', 'Section tidak ditemukan.');
        return $this->form($section);
    }

    public function update(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        $section = $this->sections->find($id);
        if ($section === null) return redirect()->to('/dashboard/landing-page')->with('error', 'Section tidak ditemukan.');
        if (! $this->validate($this->rules())) return redirect()->back()->withInput()->with('error', 'Data section Tentang Kami atau gambar tidak valid. Gambar harus berupa file JPG, PNG, WebP, atau GIF max 2 MB.');

        $data = $this->payload();
        if ($data['image'] === null) unset($data['image']);
        else $this->removeImage($section['image'] ?? null);
        $this->sections->update($id, $data);
        return redirect()->to('/dashboard/landing-page')->with('success', 'Section Tentang Kami berhasil diperbarui.');
    }

    public function delete(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        $section = $this->sections->find($id);
        if ($section !== null) {
            $this->removeImage($section['image'] ?? null);
            $this->sections->delete($id);
        }
        return redirect()->to('/dashboard/landing-page')->with('success', 'Section Tentang Kami berhasil dihapus.');
    }

    private function form(?array $section): string
    {
        return view('dashboard/layout', [
            'user' => session()->get('auth_user'),
            'content' => view('dashboard/about_sections/form', ['section' => $section]),
        ]);
    }

    private function rules(): array
    {
        $rules = [
            'title' => 'required|max_length[150]',
            'description' => 'required|max_length[1000]',
            'link' => 'permit_empty|max_length[255]',
        ];
        $imageFile = $this->request->getFile('image');
        if ($imageFile !== null && $imageFile->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['image'] = 'uploaded[image]|is_image[image]|mime_in[image,image/png,image/jpeg,image/jpg,image/webp,image/gif]|ext_in[image,png,jpg,jpeg,webp,gif]|max_size[image,2048]';
        }
        return $rules;
    }

    private function payload(): array
    {
        return [
            'title' => trim((string) $this->request->getPost('title')),
            'description' => trim((string) $this->request->getPost('description')),
            'link' => trim((string) $this->request->getPost('link')) ?: null,
            'image' => $this->storeImage($this->request->getFile('image')),
        ];
    }

    private function storeImage(?UploadedFile $image): ?string
    {
        if ($image === null || ! $image->isValid() || $image->hasMoved() || ! str_starts_with($image->getMimeType(), 'image/')) return null;
        $directory = FCPATH . 'uploads/about-sections';
        if (! is_dir($directory)) mkdir($directory, 0755, true);
        $name = $image->getRandomName();
        $image->move($directory, $name);
        return 'uploads/about-sections/' . $name;
    }

    private function removeImage(?string $path): void
    {
        if ($path !== null && str_starts_with($path, 'uploads/about-sections/')) {
            $file = FCPATH . $path;
            if (is_file($file)) unlink($file);
        }
    }
}
