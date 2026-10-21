<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleModel extends Model
{
    protected $table = 'articles';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['title', 'tag', 'description', 'content', 'image', 'status', 'created_by', 'created_at'];

    public function getAdminArticles(string $search = '', string $sort = 'created_at', string $order = 'desc', int $perPage = 10): array
    {
        $allowedSorts = ['title', 'status', 'created_at'];
        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }
        $order = strtolower($order) === 'asc' ? 'asc' : 'desc';

        $search = trim($search);
        if ($search !== '') {
            $this->groupStart()
                 ->like('title', $search)
                 ->orLike('description', $search)
                 ->orLike('tag', $search)
                 ->groupEnd();
        }

        $this->orderBy($sort, strtoupper($order));

        $articles = $this->paginate($perPage, 'article');

        return [
            'articles' => $articles ?: [],
            'pager'    => $this->pager,
            'total'    => $this->pager ? $this->pager->getTotal('article') : 0,
        ];
    }
}
