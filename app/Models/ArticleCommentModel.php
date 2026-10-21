<?php

namespace App\Models;

use CodeIgniter\Model;

class ArticleCommentModel extends Model
{
    protected $table = 'article_comments';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['article_id', 'name', 'comment', 'created_at', 'updated_at'];

    public function getCommentsByArticle(int $articleId, int $limit = 5, int $offset = 0): array
    {
        return $this->where('article_id', $articleId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit, $offset);
    }

    public function getCommentCount(int $articleId): int
    {
        return $this->where('article_id', $articleId)->countAllResults();
    }
}
