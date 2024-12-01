<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Models\Student;
use Exception;
use HttpResponseException;

class StudentController extends AControllerBase
{
    public function index(): Response
    {
        return $this->html([
            'students' => Student::getAll()
        ]);
    }

    /**
     * @throws HTTPException
     * @throws Exception
     */
    public function delete(): Response
    {
        $id = (int) $this->request()->getValue('id');
        $student = Student::getOne($id);

        if (is_null($student)) {
            throw new HTTPException(404);
        } else {
            $student->delete();
            return new RedirectResponse($this->url('student.index'));
        }

    }

    public function add(): Response
    {
        return $this->html();
    }
}