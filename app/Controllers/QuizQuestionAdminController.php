<?php

namespace App\Controllers;

use App\Models\QuizModel;
use App\Models\QuizQuestionModel;

class QuizQuestionAdminController extends BaseController
{
    public function __construct(private readonly QuizModel $quizzes = new QuizModel(), private readonly QuizQuestionModel $questions = new QuizQuestionModel()) {}

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

    public function index(int $quizId)
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        $quiz = $this->quizzes->find($quizId);
        if ($quiz === null) return redirect()->to('/dashboard/quizzes')->with('error', 'Kuis tidak ditemukan.');
        $items = $this->questions->where('quiz_id', $quizId)->orderBy('sort_order', 'ASC')->findAll();
        return view('dashboard/layout', ['user' => session()->get('auth_user'), 'content' => view('dashboard/quizzes/questions', ['quiz' => $quiz, 'questions' => $items])]);
    }

    public function create(int $quizId)
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        $quiz = $this->quizzes->find($quizId);
        if ($quiz === null) return redirect()->to('/dashboard/quizzes')->with('error', 'Kuis tidak ditemukan.');
        return view('dashboard/layout', ['user' => session()->get('auth_user'), 'content' => view('dashboard/quizzes/_question_form', ['quiz' => $quiz, 'question' => null])]);
    }

    public function store(int $quizId)
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        $quiz = $this->quizzes->find($quizId);
        if ($quiz === null) return redirect()->to('/dashboard/quizzes')->with('error', 'Kuis tidak ditemukan.');
        $rules = ['question' => 'required', 'option_a' => 'required', 'option_b' => 'required', 'option_c' => 'required', 'option_d' => 'required', 'correct_option' => 'required|in_list[1,2,3,4]'];
        if (! $this->validate($rules)) return redirect()->back()->withInput()->with('error', 'Semua kolom pertanyaan wajib diisi.');
        $data = $this->request->getPost(array_keys($rules));
        $data['correct_option'] = (int) $data['correct_option'];
        $data['quiz_id'] = $quizId;
        // compute sort_order as max+1
        $max = (int) ($this->questions->where('quiz_id', $quizId)->selectMax('sort_order')->first()['sort_order'] ?? 0);
        $data['sort_order'] = $max + 1;
        $this->questions->insert($data);
        return redirect()->to('/dashboard/quizzes/' . $quizId . '/questions')->with('success', 'Pertanyaan berhasil ditambahkan.');
    }

    public function edit(int $quizId, int $questionId)
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        $quiz = $this->quizzes->find($quizId);
        $question = $this->questions->find($questionId);
        if ($quiz === null || $question === null || (int) $question['quiz_id'] !== $quizId) return redirect()->to('/dashboard/quizzes')->with('error', 'Data tidak ditemukan.');
        return view('dashboard/layout', ['user' => session()->get('auth_user'), 'content' => view('dashboard/quizzes/_question_form', ['quiz' => $quiz, 'question' => $question])]);
    }

    public function update(int $quizId, int $questionId)
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        $quiz = $this->quizzes->find($quizId);
        $question = $this->questions->find($questionId);
        if ($quiz === null || $question === null || (int) $question['quiz_id'] !== $quizId) return redirect()->to('/dashboard/quizzes')->with('error', 'Data tidak ditemukan.');
        $rules = ['question' => 'required', 'option_a' => 'required', 'option_b' => 'required', 'option_c' => 'required', 'option_d' => 'required', 'correct_option' => 'required|in_list[1,2,3,4]'];
        if (! $this->validate($rules)) return redirect()->back()->withInput()->with('error', 'Semua kolom pertanyaan wajib diisi.');
        $data = $this->request->getPost(array_keys($rules));
        $data['correct_option'] = (int) $data['correct_option'];
        $this->questions->update($questionId, $data);
        return redirect()->to('/dashboard/quizzes/' . $quizId . '/questions')->with('success', 'Pertanyaan berhasil diperbarui.');
    }

    public function delete(int $quizId, int $questionId)
    {
        if (! $this->authorized()) return redirect()->to('/dashboard');
        $question = $this->questions->find($questionId);
        if ($question !== null && (int) $question['quiz_id'] === $quizId) {
            $this->questions->delete($questionId);
        }
        return redirect()->to('/dashboard/quizzes/' . $quizId . '/questions')->with('success', 'Pertanyaan dihapus.');
    }
}
