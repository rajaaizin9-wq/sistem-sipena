<?php

namespace App\Controllers;

use App\Models\ArticleModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class ArticleController extends BaseController
{
    public function __construct(private readonly ArticleModel $articles = new ArticleModel()) {}

    private function authorized(): bool
    {
        $role = session()->get('auth_user')['role'] ?? '';

        return in_array($role, [
            'humas_umum',
            'humas_rehabilitasi',
            'humas_dayamas',
            'humas_pencegahan',
        ], true);
    }

    public function index(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        $user = session()->get('auth_user');

        $search = trim((string) $this->request->getGet('search'));
        $sort   = (string) $this->request->getGet('sort');
        $order  = strtolower((string) $this->request->getGet('order'));

        $result = $this->articles->getAdminArticles($search, $sort, $order, 10);

        return view('dashboard/layout', [
            'user' => $user,
            'content' => view('dashboard/articles/index', [
                'user'     => $user,
                'articles' => $result['articles'] ?? [],
                'pager'    => $result['pager'] ?? null,
                'total'    => $result['total'] ?? 0,
                'search'   => $search,
                'sort'     => $sort,
                'order'    => $order,
            ]),
        ]);
    }

    public function create(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        return view('dashboard/layout', ['user' => session()->get('auth_user'), 'content' => view('dashboard/articles/form', ['article' => null])]);
    }

    public function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        $rules = ['title' => 'required|max_length[255]', 'tag' => 'permit_empty|max_length[100]', 'description' => 'permit_empty|max_length[500]', 'content' => 'required', 'status' => 'required|in_list[draft,published]'];
        $imageFile = $this->request->getFile('image');
        if ($imageFile !== null && $imageFile->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['image'] = 'uploaded[image]|is_image[image]|mime_in[image,image/png,image/jpeg,image/jpg,image/webp,image/gif]|ext_in[image,png,jpg,jpeg,webp,gif]|max_size[image,2048]';
        }
        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Data artikel atau file gambar tidak valid. Gambar harus berupa file JPG, PNG, WebP, atau GIF max 2 MB.');
        }
        $title = trim((string) $this->request->getPost('title'));
        $image = $this->storeImage($imageFile);
        $createdAtRaw = trim((string) $this->request->getPost('created_at'));
        $createdAt = (! empty($createdAtRaw) && strtotime($createdAtRaw) !== false)
            ? date('Y-m-d H:i:s', strtotime($createdAtRaw))
            : date('Y-m-d H:i:s');
        $this->articles->insert(['title' => $title, 'tag' => trim((string) $this->request->getPost('tag')) ?: null, 'description' => trim((string) $this->request->getPost('description')) ?: null, 'content' => $this->sanitizeContent((string) $this->request->getPost('content')), 'image' => $image, 'status' => $this->request->getPost('status'), 'created_by' => session()->get('auth_user')['id'] ?? null, 'created_at' => $createdAt]);
        return redirect()->to('/dashboard/articles')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(int $id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        $article = $this->articles->find($id);
        if ($article === null) return redirect()->to('/dashboard/articles')->with('error', 'Artikel tidak ditemukan.');
        return view('dashboard/layout', ['user' => session()->get('auth_user'), 'content' => view('dashboard/articles/form', ['article' => $article])]);
    }

    public function update(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        $rules = ['title' => 'required|max_length[255]', 'tag' => 'permit_empty|max_length[100]', 'description' => 'permit_empty|max_length[500]', 'content' => 'required', 'status' => 'required|in_list[draft,published]'];
        $imageFile = $this->request->getFile('image');
        if ($imageFile !== null && $imageFile->getError() !== UPLOAD_ERR_NO_FILE) {
            $rules['image'] = 'uploaded[image]|is_image[image]|mime_in[image,image/png,image/jpeg,image/jpg,image/webp,image/gif]|ext_in[image,png,jpg,jpeg,webp,gif]|max_size[image,2048]';
        }
        if (! $this->validate($rules)) return redirect()->back()->withInput()->with('error', 'Data artikel atau file gambar tidak valid. Gambar harus berupa file JPG, PNG, WebP, atau GIF max 2 MB.');
        $article = $this->articles->find($id);
        if ($article === null) return redirect()->to('/dashboard/articles')->with('error', 'Artikel tidak ditemukan.');
        $title = trim((string) $this->request->getPost('title'));
        $image = $this->storeImage($imageFile);
        if ($image !== null) $this->removeImage($article['image'] ?? null);
        $data = ['title' => $title, 'tag' => trim((string) $this->request->getPost('tag')) ?: null, 'description' => trim((string) $this->request->getPost('description')) ?: null, 'content' => $this->sanitizeContent((string) $this->request->getPost('content')), 'status' => $this->request->getPost('status')];
        if ($image !== null) $data['image'] = $image;
        $createdAtRaw = trim((string) $this->request->getPost('created_at'));
        if (! empty($createdAtRaw) && strtotime($createdAtRaw) !== false) {
            $data['created_at'] = date('Y-m-d H:i:s', strtotime($createdAtRaw));
        }
        $this->articles->update($id, $data);
        if (isset($data['created_at'])) {
            $this->articles->builder()->where('id', $id)->update(['created_at' => $data['created_at']]);
        }
        return redirect()->to('/dashboard/articles')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function delete(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        $article = $this->articles->find($id);
        if ($article !== null) {
            $this->removeImage($article['image'] ?? null);
            $this->articles->delete($id);
        }
        return redirect()->to('/dashboard/articles')->with('success', 'Artikel berhasil dihapus.');
    }

    private function storeImage(?UploadedFile $image): ?string
    {
        if ($image === null || ! $image->isValid() || $image->hasMoved() || ! str_starts_with($image->getMimeType(), 'image/')) return null;
        $directory = FCPATH . 'uploads/articles';
        if (! is_dir($directory)) mkdir($directory, 0755, true);
        $name = $image->getRandomName();
        $image->move($directory, $name);
        return 'uploads/articles/' . $name;
    }

    private function removeImage(?string $path): void
    {
        if ($path !== null && str_starts_with($path, 'uploads/articles/')) {
            $file = FCPATH . $path;
            if (is_file($file)) unlink($file);
        }
    }

    private function sanitizeContent(string $content): string
    {
        if (trim($content) === '') return '';

        $document = new \DOMDocument();
        libxml_use_internal_errors(true);
        $document->loadHTML('<?xml encoding="UTF-8"><div>' . $content . '</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $allowedTags = [
            'div', 'p', 'br', 'strong', 'b', 'em', 'i', 'u', 's', 'strike',
            'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'ul', 'ol', 'li',
            'blockquote', 'a', 'span', 'sub', 'sup', 'table', 'thead',
            'tbody', 'tr', 'th', 'td', 'img', 'figure', 'figcaption', 'code', 'pre'
        ];

        $allowedAttributes = ['href', 'src', 'alt', 'title', 'target', 'class'];

        foreach (iterator_to_array($document->getElementsByTagName('*')) as $node) {
            $tag = strtolower($node->nodeName);
            if (! in_array($tag, $allowedTags, true)) {
                $node->parentNode?->removeChild($node);
                continue;
            }

            if ($node->hasAttributes()) {
                $attributesToRemove = [];
                foreach ($node->attributes as $attr) {
                    $attrName = strtolower($attr->nodeName);
                    if (! in_array($attrName, $allowedAttributes, true) || str_starts_with(trim(strtolower($attr->nodeValue)), 'javascript:')) {
                        $attributesToRemove[] = $attr->nodeName;
                    }
                }
                foreach ($attributesToRemove as $attrName) {
                    $node->removeAttribute($attrName);
                }
            }
        }

        $wrapper = $document->getElementsByTagName('div')->item(0);
        $html = '';
        if ($wrapper !== null) {
            foreach ($wrapper->childNodes as $child) {
                $html .= $document->saveHTML($child);
            }
        }

        return trim($html);
    }
}
