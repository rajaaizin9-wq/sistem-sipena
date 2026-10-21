<?php

namespace App\Models;

use CodeIgniter\Model;

class QuizAttemptModel extends Model
{
    protected $table = 'quiz_attempts';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $allowedFields = ['quiz_id', 'question_id', 'participant_name', 'participant_age', 'answer', 'is_correct', 'user_id', 'submission_id', 'submitted_at', 'created_at', 'updated_at'];

    public function getAdminQuizSessions(int $quizId, string $search = '', string $sort = 'submitted_at', string $order = 'desc', int $perPage = 10): array
    {
        $allowedSorts = [
            'participant_name' => 'quiz_attempts.participant_name',
            'participant_age'  => 'quiz_attempts.participant_age',
            'submitted_at'     => 'submitted_at',
        ];

        $sortColumn = $allowedSorts[$sort] ?? 'submitted_at';
        $orderDirection = strtolower($order) === 'asc' ? 'ASC' : 'DESC';

        $search = trim($search);

        $builder = $this
            ->select('quiz_attempts.submission_id, quiz_attempts.participant_name, quiz_attempts.participant_age, MAX(quiz_attempts.submitted_at) AS submitted_at, MAX(quiz_attempts.created_at) AS created_at, quizzes.title AS quiz_title, COUNT(quiz_attempts.id) AS question_count, SUM(CASE WHEN quiz_attempts.is_correct = 1 THEN 1 ELSE 0 END) AS correct_count')
            ->join('quizzes', 'quizzes.id = quiz_attempts.quiz_id')
            ->where('quiz_attempts.quiz_id', $quizId);

        if ($search !== '') {
            $builder->like('quiz_attempts.participant_name', $search);
        }

        $builder->groupBy('quiz_attempts.submission_id, quiz_attempts.participant_name, quiz_attempts.participant_age, quizzes.title')
                ->orderBy($sortColumn, $orderDirection);

        $sessions = $this->paginate($perPage, 'session');

        return [
            'sessions' => $sessions ?: [],
            'pager'    => $this->pager,
            'total'    => $this->pager ? $this->pager->getTotal('session') : 0,
        ];
    }
}
