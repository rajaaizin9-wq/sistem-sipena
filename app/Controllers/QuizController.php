<?php

namespace App\Controllers;

use App\Models\QuizAttemptModel;
use App\Models\QuizModel;
use App\Models\QuizQuestionModel;

class QuizController extends BaseController
{
    private const INITIAL_LIMIT = 6;
    private const MORE_LIMIT = 2;

    public function __construct(private readonly QuizModel $quizzes = new QuizModel(), private readonly QuizAttemptModel $attempts = new QuizAttemptModel()) {}

    public function index(): string
    {
        $search = trim((string) $this->request->getGet('q'));
        $quizzes = $this->quizzes->findAllWithQuestionCount(self::INITIAL_LIMIT + 1, 0, $search);

        return view('layouts/public', [
            'title' => 'Kuis | BNN Kota Tanjungpinang',
            'content' => view('quiz/index', [
                'quizzes' => array_slice($quizzes, 0, self::INITIAL_LIMIT),
                'hasMore' => count($quizzes) > self::INITIAL_LIMIT,
                'search' => $search,
            ]),
        ]);
    }

    public function more(): \CodeIgniter\HTTP\ResponseInterface
    {
        $offset = max(0, (int) $this->request->getGet('offset'));
        $search = trim((string) $this->request->getGet('q'));
        $limit  = ($offset === 0) ? self::INITIAL_LIMIT : self::MORE_LIMIT;
        $quizzes = $this->quizzes->findAllWithQuestionCount($limit + 1, $offset, $search);

        return $this->response->setJSON([
            'html'    => view('quiz/_cards', ['quizzes' => array_slice($quizzes, 0, $limit)]),
            'hasMore' => count($quizzes) > $limit,
        ]);
    }

    public function search(): \CodeIgniter\HTTP\ResponseInterface
    {
        $search = trim((string) $this->request->getGet('q'));
        $quizzes = $this->quizzes->findAllWithQuestionCount(self::INITIAL_LIMIT + 1, 0, $search);

        return $this->response->setJSON([
            'html' => view('quiz/_cards', ['quizzes' => array_slice($quizzes, 0, self::INITIAL_LIMIT)]),
            'hasMore' => count($quizzes) > self::INITIAL_LIMIT,
            'count' => min(count($quizzes), self::INITIAL_LIMIT),
        ]);
    }

    public function show(int $id): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $quiz = $this->quizzes->find($id);
        if ($quiz === null) return redirect()->to('/quiz')->with('error', 'Kuis tidak ditemukan.');
        $questionModel = new QuizQuestionModel();
        $questions = $questionModel->where('quiz_id', $id)->orderBy('sort_order', 'ASC')->findAll();
        return view('layouts/public', ['title' => $quiz['title'], 'content' => view('quiz/show', ['quiz' => $quiz, 'questions' => $questions])]);
    }

    public function submit(int $id): \CodeIgniter\HTTP\RedirectResponse
    {
        $quiz = $this->quizzes->find($id);
        if ($quiz === null) return redirect()->to('/quiz')->with('error', 'Kuis tidak ditemukan.');
        if (! $this->validate(['participant_name' => 'required|max_length[100]', 'participant_age' => 'required|integer|greater_than_equal_to[7]|less_than_equal_to[80]'])) {
            $ageErr = $this->validator->getError('participant_age');
            $msg = $ageErr ? 'Umur tidak valid! Harap masukkan umur berupa angka 7 - 80 tahun.' : 'Harap isi nama dan umur Anda dengan benar.';
            return redirect()->back()->withInput()->with('error', $msg);
        }

        $questionModel = new QuizQuestionModel();
        $questions = $questionModel->where('quiz_id', $id)->orderBy('sort_order', 'ASC')->findAll();
        $answers = $this->request->getPost('answer'); // expect array: question_id => selected_option
        if ($questions === [] || ! is_array($answers) || count($answers) !== count($questions)) {
            return redirect()->back()->withInput()->with('error', 'Semua pertanyaan wajib dijawab.');
        }

        foreach ($questions as $question) {
            $selected = $answers[$question['id']] ?? null;
            if (! in_array((int) $selected, [1, 2, 3, 4], true)) {
                return redirect()->back()->withInput()->with('error', 'Semua pertanyaan wajib dijawab.');
            }
        }

        $participantName = trim((string) $this->request->getPost('participant_name'));
        $participantAge = (int) $this->request->getPost('participant_age');
        $submissionId = 'quiz-' . $id . '-' . bin2hex(random_bytes(4));
        $submittedAt = date('Y-m-d H:i:s');
        $results = ['correct' => 0, 'total' => 0];
        foreach ($questions as $question) {
            $selected = (int) $answers[$question['id']];
            $isCorrect = $selected === (int) $question['correct_option'];
            $this->attempts->insert([
                'quiz_id' => $id,
                'question_id' => $question['id'],
                'participant_name' => $participantName,
                'participant_age' => $participantAge,
                'answer' => $selected,
                'is_correct' => $isCorrect ? 1 : 0,
                'submission_id' => $submissionId,
                'submitted_at' => $submittedAt,
                'created_at' => $submittedAt,
            ]);
            $results['total']++;
            if ($isCorrect) $results['correct']++;
        }

        return redirect()->to('/quiz/' . $id . '/hasil/' . $submissionId);
    }

    public function result(int $id, string $submissionId): string|\CodeIgniter\HTTP\RedirectResponse
    {
        $quiz = $this->quizzes->find($id);
        if ($quiz === null) return redirect()->to('/quiz')->with('error', 'Kuis tidak ditemukan.');

        $answers = $this->attempts
            ->select('quiz_attempts.*, quiz_questions.question, quiz_questions.option_a, quiz_questions.option_b, quiz_questions.option_c, quiz_questions.option_d, quiz_questions.correct_option')
            ->join('quiz_questions', 'quiz_questions.id = quiz_attempts.question_id')
            ->where(['quiz_attempts.quiz_id' => $id, 'quiz_attempts.submission_id' => $submissionId])
            ->orderBy('quiz_questions.sort_order', 'ASC')
            ->findAll();
        if ($answers === []) return redirect()->to('/quiz/' . $id)->with('error', 'Hasil kuis tidak ditemukan.');

        return view('layouts/public', [
            'title' => 'Hasil ' . $quiz['title'],
            'content' => view('quiz/result', [
                'quiz' => $quiz,
                'answers' => $answers,
                'submissionId' => $submissionId,
            ]),
        ]);
    }
}
