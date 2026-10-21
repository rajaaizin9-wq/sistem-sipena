<?php

namespace App\Controllers;

use App\Models\QuizModel;
use App\Models\QuizAttemptModel;
use App\Models\QuizQuestionModel;
use CodeIgniter\HTTP\Files\UploadedFile;

class QuizAdminController extends BaseController
{
    public function __construct(
        private readonly QuizModel $quizzes = new QuizModel(),
        private readonly QuizAttemptModel $attempts = new QuizAttemptModel(),
    ) {}

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

        $result = $this->quizzes->getAdminQuizzes($search, $sort, $order, 10);

        return view('dashboard/layout', [
            'user' => $user,
            'content' => view('dashboard/quizzes/index', [
                'user'    => $user,
                'quizzes' => $result['quizzes'] ?? [],
                'pager'   => $result['pager'] ?? null,
                'total'   => $result['total'] ?? 0,
                'search'  => $search,
                'sort'    => $sort,
                'order'   => $order,
            ]),
        ]);
    }

    public function create(): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        return view('dashboard/layout', ['user' => session()->get('auth_user'), 'content' => view('dashboard/quizzes/form', ['quiz' => null, 'questions' => []])]);
    }

    public function logs(): string|\CodeIgniter\HTTP\ResponseInterface
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');

        $quizId       = (int) ($this->request->getGet('quiz_id') ?? 0);
        $submissionId = trim((string) ($this->request->getGet('submission_id') ?? ''));
        $search       = trim((string) ($this->request->getGet('search') ?? ''));
        $sort         = (string) ($this->request->getGet('sort') ?? 'submitted_at');
        $order        = strtolower((string) ($this->request->getGet('order') ?? 'desc'));

        $quizSearch   = trim((string) ($this->request->getGet('quiz_search') ?? ''));
        $quizSort     = (string) ($this->request->getGet('quiz_sort') ?? 'created_at');
        $quizOrder    = strtolower((string) ($this->request->getGet('quiz_order') ?? 'desc'));

        $quizResult   = $this->quizzes->getAdminQuizzes($quizSearch, $quizSort, $quizOrder, 10);
        $quizzes      = $quizResult['quizzes'];
        $quizPager    = $quizResult['pager'];
        $quizTotal    = $quizResult['total'];

        $selectedQuiz    = null;
        $selectedSession = null;
        $sessions        = [];
        $pager           = null;
        $totalSessions   = 0;
        $details         = [];
        $summary         = [
            'total_sessions'      => 0,
            'unique_participants' => 0,
            'average_score'       => null,
            'latest_submission'   => null,
        ];

        if ($quizId > 0) {
            $selectedQuiz = $this->quizzes->find($quizId);
            if ($selectedQuiz !== null) {
                // Calculate overall summary across all sessions for this quiz
                $allSessions = $this->attempts
                    ->select('quiz_attempts.submission_id, quiz_attempts.participant_name, COUNT(quiz_attempts.id) AS question_count, SUM(CASE WHEN quiz_attempts.is_correct = 1 THEN 1 ELSE 0 END) AS correct_count, MAX(quiz_attempts.submitted_at) AS submitted_at, MAX(quiz_attempts.created_at) AS created_at')
                    ->where('quiz_attempts.quiz_id', $quizId)
                    ->groupBy('quiz_attempts.submission_id, quiz_attempts.participant_name')
                    ->orderBy('submitted_at', 'DESC')
                    ->findAll();

                $summary['total_sessions'] = count($allSessions);
                $summary['unique_participants'] = count(array_unique(array_filter(array_map(
                    static fn(array $session): string => trim((string) ($session['participant_name'] ?? '')),
                    $allSessions
                ))));

                if ($allSessions !== []) {
                    $scores = array_map(static function (array $session): float {
                        $questions = (int) ($session['question_count'] ?? 0);
                        return $questions > 0 ? ((int) ($session['correct_count'] ?? 0) / $questions) * 100 : 0;
                    }, $allSessions);
                    $summary['average_score'] = array_sum($scores) / count($scores);
                    $summary['latest_submission'] = $allSessions[0]['submitted_at'] ?? $allSessions[0]['created_at'] ?? null;
                }

                // Retrieve paginated, searched, and sorted sessions
                $paginatedResult = $this->attempts->getAdminQuizSessions($quizId, $search, $sort, $order, 10);
                $sessions        = $paginatedResult['sessions'];
                $pager           = $paginatedResult['pager'];
                $totalSessions   = $paginatedResult['total'];

                if ($submissionId !== '') {
                    foreach ($sessions as $session) {
                        if ((string) ($session['submission_id'] ?? '') === $submissionId) {
                            $selectedSession = $session;
                            break;
                        }
                    }

                    if ($selectedSession === null) {
                        $selectedSession = $this->attempts
                            ->select('quiz_attempts.submission_id, quiz_attempts.participant_name, quiz_attempts.participant_age, MAX(quiz_attempts.submitted_at) AS submitted_at, MAX(quiz_attempts.created_at) AS created_at, quizzes.title AS quiz_title, COUNT(quiz_attempts.id) AS question_count, SUM(CASE WHEN quiz_attempts.is_correct = 1 THEN 1 ELSE 0 END) AS correct_count')
                            ->join('quizzes', 'quizzes.id = quiz_attempts.quiz_id')
                            ->where('quiz_attempts.quiz_id', $quizId)
                            ->where('quiz_attempts.submission_id', $submissionId)
                            ->groupBy('quiz_attempts.submission_id, quiz_attempts.participant_name, quiz_attempts.participant_age, quizzes.title')
                            ->first();
                    }

                    $details = $this->attempts
                        ->select('quiz_attempts.*, quiz_questions.question, quiz_questions.option_a, quiz_questions.option_b, quiz_questions.option_c, quiz_questions.option_d, quiz_questions.correct_option')
                        ->join('quiz_questions', 'quiz_questions.id = quiz_attempts.question_id')
                        ->where('quiz_attempts.quiz_id', $quizId)
                        ->where('quiz_attempts.submission_id', $submissionId)
                        ->orderBy('quiz_attempts.question_id', 'ASC')
                        ->findAll();
                }
            }
        }

        if ($this->request->isAJAX() || (string) $this->request->getGet('ajax') === '1') {
            return $this->response->setJSON([
                'selectedQuiz'    => $selectedQuiz,
                'selectedSession' => $selectedSession,
                'details'         => $details,
            ]);
        }

        return view('dashboard/layout', ['user' => session()->get('auth_user'), 'content' => view('dashboard/quizzes/logs', [
            'quizzes'         => $quizzes,
            'quizPager'       => $quizPager,
            'quizTotal'       => $quizTotal,
            'quizSearch'      => $quizSearch,
            'quizSort'        => $quizSort,
            'quizOrder'       => $quizOrder,
            'selectedQuiz'    => $selectedQuiz,
            'sessions'        => $sessions,
            'pager'           => $pager,
            'totalSessions'   => $totalSessions,
            'search'          => $search,
            'sort'            => $sort,
            'order'           => $order,
            'details'         => $details,
            'selectedSession' => $selectedSession,
            'submissionId'    => $submissionId,
            'quizId'          => $quizId,
            'summary'         => $summary,
        ])]);
    }

    public function store(): \CodeIgniter\HTTP\RedirectResponse
    {
        return $this->saveQuiz();
    }

    public function edit(int $id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        $quiz = $this->quizzes->find($id);
        if ($quiz === null) return redirect()->to('/dashboard/quizzes')->with('error', 'Kuis tidak ditemukan.');
        // load all questions for inline editing
        $questionModel = new QuizQuestionModel();
        $questions = $questionModel->where('quiz_id', $id)->orderBy('sort_order', 'ASC')->findAll();
        return view('dashboard/layout', ['user' => session()->get('auth_user'), 'content' => view('dashboard/quizzes/form', ['quiz' => $quiz, 'questions' => $questions])]);
    }

    public function update(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        return $this->saveQuiz($id);
    }

    public function delete(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        if ($this->authorized()) {
            $quiz = $this->quizzes->find($id);
            if ($quiz !== null) {
                $this->removeImage($quiz['image'] ?? null);
                $this->quizzes->delete($id);
            }
        }
        return redirect()->to('/dashboard/quizzes')->with('success', 'Kuis berhasil dihapus.');
    }

    private function saveQuiz(?int $id = null): \CodeIgniter\HTTP\RedirectResponse
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        // support multiple questions posted as arrays
        $title = trim((string) $this->request->getPost('title'));
        $description = trim((string) $this->request->getPost('description'));
        if ($title === '') return redirect()->back()->withInput()->with('error', 'Judul kuis wajib diisi.');

        $rawQuestions = $this->request->getPost('question');
        if (! is_array($rawQuestions) || count(array_filter($rawQuestions, fn($q) => trim((string) $q) !== '')) === 0) {
            return redirect()->back()->withInput()->with('error', 'Kuis harus memiliki minimal 1 pertanyaan.');
        }

        $imageFile = $this->request->getFile('image');
        if ($imageFile !== null && $imageFile->getError() !== UPLOAD_ERR_NO_FILE) {
            if (! $this->validate(['image' => 'uploaded[image]|is_image[image]|mime_in[image,image/png,image/jpeg,image/jpg,image/webp,image/gif]|ext_in[image,png,jpg,jpeg,webp,gif]|max_size[image,2048]'])) {
                return redirect()->back()->withInput()->with('error', 'Gambar kuis harus berupa JPG, PNG, WebP, atau GIF dengan ukuran maksimal 2 MB.');
            }
        }

        $uploadedImage = $this->storeImage($imageFile);
        $quizData = ['title' => $title, 'description' => $description !== '' ? $description : null];
        $this->quizzes->protect(false);
        if ($id === null) {
            $quizId = $this->quizzes->insert($quizData + ['image' => $uploadedImage, 'created_by' => session()->get('auth_user')['id'] ?? null]);
        } else {
            $quiz = $this->quizzes->find($id);
            if ($quiz === null) return redirect()->to('/dashboard/quizzes')->with('error', 'Kuis tidak ditemukan.');
            if ($uploadedImage !== null) {
                $this->removeImage($quiz['image'] ?? null);
                $quizData['image'] = $uploadedImage;
            }
            $this->quizzes->update($id, $quizData);
            $quizId = $id;
        }

        $questionModel = new QuizQuestionModel();
        $questions = $this->request->getPost('question');
        $optionA = $this->request->getPost('option_a');
        $optionB = $this->request->getPost('option_b');
        $optionC = $this->request->getPost('option_c');
        $optionD = $this->request->getPost('option_d');
        $corrects = $this->request->getPost('correct_option');
        $questionIds = $this->request->getPost('question_id');

        if (is_array($questions)) {
            $sort = 0;
            foreach ($questions as $i => $qText) {
                $qText = trim((string) $qText);
                if ($qText === '') continue;
                $data = [
                    'quiz_id' => $quizId,
                    'question' => $qText,
                    'option_a' => (string) ($optionA[$i] ?? ''),
                    'option_b' => (string) ($optionB[$i] ?? ''),
                    'option_c' => (string) ($optionC[$i] ?? ''),
                    'option_d' => (string) ($optionD[$i] ?? ''),
                    'correct_option' => (int) ($corrects[$i] ?? 1),
                    'sort_order' => $sort++,
                ];
                $qid = (int) ($questionIds[$i] ?? 0);
                if ($qid > 0 && $questionModel->find($qid)) {
                    $questionModel->update($qid, $data);
                } else {
                    $questionModel->insert($data);
                }
            }
        }
        return redirect()->to('/dashboard/quizzes')->with('success', 'Kuis berhasil disimpan.');
    }

    private function storeImage(?UploadedFile $image): ?string
    {
        if ($image === null || ! $image->isValid() || $image->hasMoved() || ! str_starts_with($image->getMimeType(), 'image/')) return null;

        $directory = FCPATH . 'uploads/quizzes';
        if (! is_dir($directory)) mkdir($directory, 0755, true);
        $name = $image->getRandomName();
        $image->move($directory, $name);

        return 'uploads/quizzes/' . $name;
    }

    private function removeImage(?string $path): void
    {
        if ($path !== null && str_starts_with($path, 'uploads/quizzes/')) {
            $file = FCPATH . $path;
            if (is_file($file)) unlink($file);
        }
    }
}
