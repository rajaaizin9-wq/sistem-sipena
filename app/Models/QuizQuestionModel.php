<?php

namespace App\Models;

use CodeIgniter\Model;

class QuizQuestionModel extends Model
{
    protected $table = 'quiz_questions';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useTimestamps = true;
    protected $allowedFields = ['quiz_id', 'question', 'option_a', 'option_b', 'option_c', 'option_d', 'correct_option', 'sort_order'];
}
