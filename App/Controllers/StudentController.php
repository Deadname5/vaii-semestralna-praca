<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Models\Student;

class StudentController extends AControllerBase
{
    public function index(): Response
    {
        return $this->html([
            'students' => Student::getAll()
        ]);
    }
}