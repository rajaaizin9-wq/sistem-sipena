<?php

namespace App\Models;

use CodeIgniter\Model;

class QuizModel extends Model
{
    protected $table = 'quizzes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['title', 'image', 'description', 'share_code', 'created_by'];

    public function findAllWithQuestionCount(int $limit = 0, int $offset = 0, string $search = ''): array
    {
        $builder = $this
            ->select('quizzes.*, COUNT(quiz_questions.id) AS question_count')
            ->join('quiz_questions', 'quiz_questions.quiz_id = quizzes.id', 'left')
            ->groupBy('quizzes.id')
            ->orderBy('quizzes.created_at', 'DESC');

        $search = trim($search);
        if ($search !== '') {
            $builder->groupStart()
                ->like('quizzes.title', $search)
                ->orLike('quizzes.description', $search)
                ->groupEnd();
        }

        return $limit > 0 ? $builder->findAll($limit, $offset) : $builder->findAll();
    }

    public function getAdminQuizzes(string $search = '', string $sort = 'created_at', string $order = 'desc', int $perPage = 10): array
    {
        $allowedSorts = ['title', 'description', 'created_at'];
        if (! in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }
        $order = strtolower($order) === 'asc' ? 'asc' : 'desc';

        $search = trim($search);
        if ($search !== '') {
            $this->groupStart()
                 ->like('title', $search)
                 ->orLike('description', $search)
                 ->groupEnd();
        }

        $this->orderBy($sort, strtoupper($order));

        $quizzes = $this->paginate($perPage, 'quiz');

        return [
            'quizzes' => $quizzes ?: [],
            'pager'   => $this->pager,
            'total'   => $this->pager ? $this->pager->getTotal('quiz') : 0,
        ];
    }
}
