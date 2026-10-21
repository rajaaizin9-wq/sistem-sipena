<?php

namespace App\Controllers;

use App\Models\ArticleModel;
use App\Models\ArticleCommentModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PublicArticleController extends BaseController
{
    private const INITIAL_LIMIT = 6;
    private const MORE_LIMIT = 2;
    private const COMMENT_LIMIT = 5;

    public function __construct(private readonly ArticleModel $articles = new ArticleModel()) {}

    public function index(): string
    {
        $search = trim((string) $this->request->getGet('q'));

        $builder = $this->articles->where('status', 'published');
        if ($search !== '') {
            $builder->groupStart()
                ->like('title', $search)
                ->orLike('description', $search)
                ->orLike('tag', $search)
                ->orLike('content', $search)
                ->groupEnd();
        }

        $articles = $builder->orderBy('created_at', 'DESC')->findAll(self::INITIAL_LIMIT + 1);

        return view('layouts/public', [
            'title'   => 'Artikel | BNN Kota Tanjungpinang',
            'content' => view('articles/index', [
                'articles' => array_slice($articles, 0, self::INITIAL_LIMIT),
                'hasMore'  => count($articles) > self::INITIAL_LIMIT,
                'search'   => $search,
            ]),
        ]);
    }

    public function more(): \CodeIgniter\HTTP\ResponseInterface
    {
        $offset = max(0, (int) $this->request->getGet('offset'));
        $search = trim((string) $this->request->getGet('q'));
        $limit  = ($offset === 0) ? self::INITIAL_LIMIT : self::MORE_LIMIT;

        $builder = $this->articles->where('status', 'published');
        if ($search !== '') {
            $builder->groupStart()
                ->like('title', $search)
                ->orLike('description', $search)
                ->orLike('tag', $search)
                ->orLike('content', $search)
                ->groupEnd();
        }

        $articles = $builder->orderBy('created_at', 'DESC')->findAll($limit + 1, $offset);

        return $this->response->setJSON([
            'html'    => view('articles/_cards', ['articles' => array_slice($articles, 0, $limit)]),
            'hasMore' => count($articles) > $limit,
        ]);
    }

    public function show(int $id): string
    {
        $article = $this->articles->where(['id' => $id, 'status' => 'published'])->first();
        if ($article === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        helper('date');
        $commentModel = new ArticleCommentModel();
        $totalComments = $commentModel->getCommentCount($id);
        $comments = $commentModel->getCommentsByArticle($id, self::COMMENT_LIMIT, 0);

        return view('layouts/public', [
            'title' => $article['title'] . ' | BNN Kota Tanjungpinang',
            'content' => view('articles/show', [
                'article'       => $article,
                'comments'      => $comments,
                'totalComments' => $totalComments,
                'hasMore'       => $totalComments > count($comments),
            ]),
        ]);
    }

    public function moreComments(int $id): \CodeIgniter\HTTP\ResponseInterface
    {
        $offset = max(0, (int) $this->request->getGet('offset'));
        $limit  = self::COMMENT_LIMIT;

        $commentModel = new ArticleCommentModel();
        $comments = $commentModel->getCommentsByArticle($id, $limit, $offset);
        $totalComments = $commentModel->getCommentCount($id);

        return $this->response->setJSON([
            'html'    => view('articles/_comment_items', ['comments' => $comments]),
            'hasMore' => ($offset + count($comments)) < $totalComments,
        ]);
    }

    public function comment(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $article = $this->articles->where(['id' => $id, 'status' => 'published'])->first();
        if ($article === null) {
            throw PageNotFoundException::forPageNotFound();
        }

        $rules = [
            'name'    => 'required|max_length[100]',
            'comment' => 'required|max_length[1000]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('error', 'Nama dan komentar wajib diisi (maksimal 1000 karakter).');
        }

        (new ArticleCommentModel())->insert([
            'article_id' => $id,
            'name'       => trim((string) $this->request->getPost('name')),
            'comment'    => trim((string) $this->request->getPost('comment')),
        ]);

        return redirect()->to(base_url("artikel/{$id}#komentar"))->with('success', 'Komentar Anda berhasil dikirim.');
    }
}
