<?php

namespace App\Controllers;

use App\Models\ArticleModel;
use App\Models\QuizAttemptModel;
use App\Models\QuizModel;
use App\Models\ScormModuleModel;

class DashboardController extends BaseController
{
    public function index(): string
    {
        $user = session()->get('auth_user') ?? [];

        return view('dashboard/layout', [
            'user'    => $user,
            'content' => view('dashboard/humas/index', [
                'user' => $user,
                ...$this->buildStats(),
            ]),
        ]);
    }

    private function buildStats(): array
    {
        $scormModel  = new ScormModuleModel();
        $articleModel = new ArticleModel();
        $quizModel    = new QuizModel();
        $attemptModel = new QuizAttemptModel();

        /*
         * SCORM
         * Ambil statistik langsung dari database.
         */
        $scormStats = $scormModel
            ->select('
                COUNT(*) AS total,
                SUM(CASE WHEN published = 1 THEN 1 ELSE 0 END) AS published
            ')
            ->get()
            ->getRowArray();

        $totalModules = (int) ($scormStats['total'] ?? 0);
        $publishedModules = (int) ($scormStats['published'] ?? 0);

        $recentModules = $scormModel
            ->orderBy('created_at', 'DESC')
            ->findAll(5);

        /*
         * ARTICLES
         * Tidak mengambil seluruh artikel.
         */
        $articleStats = $articleModel
            ->select('
                COUNT(*) AS total,
                SUM(CASE WHEN status = "published" THEN 1 ELSE 0 END) AS published
            ')
            ->get()
            ->getRowArray();

        $totalArticles = (int) ($articleStats['total'] ?? 0);
        $publishedArticles = (int) ($articleStats['published'] ?? 0);

        $recentArticles = $articleModel
            ->orderBy('created_at', 'DESC')
            ->findAll(5);

        /*
         * QUIZZES
         */
        $totalQuizzes = $quizModel->countAllResults();

        /*
         * QUIZ SESSIONS
         *
         * Tidak perlu:
         * SELECT submission_id ... findAll()
         * lalu count() di PHP.
         *
         * Database langsung menghitung DISTINCT.
         */
        $totalQuizSessions = $attemptModel
            ->select('COUNT(DISTINCT submission_id) AS total')
            ->get()
            ->getRowArray();

        $totalQuizSessions = (int) ($totalQuizSessions['total'] ?? 0);

        return [
            // SCORM
            'totalModules'      => $totalModules,
            'publishedModules'  => $publishedModules,
            'draftModules'      => max(0, $totalModules - $publishedModules),
            'recentModules'     => $recentModules,

            // Articles
            'totalArticles'     => $totalArticles,
            'publishedArticles' => $publishedArticles,
            'draftArticles'     => max(0, $totalArticles - $publishedArticles),
            'recentArticles'    => $recentArticles,

            // Quizzes
            'totalQuizzes'      => $totalQuizzes,
            'totalQuizSessions' => $totalQuizSessions,
        ];
    }
}