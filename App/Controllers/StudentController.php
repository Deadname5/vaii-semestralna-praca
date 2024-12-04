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

    /**
     * @throws HTTPException
     */
    public function edit(): Response
    {
        $id = (int) $this->request()->getValue('id');
        $student = Student::getOne($id);

        if (is_null($student)) {
            throw new HTTPException(404);
        }

        return $this->html([
            'student' => $student
        ]);
    }

    public function save(): Response
    {
        $id = (int) $this->request()->getValue('id');
        if ($id > 0) {
            $student = Student::getOne($id);
        } else {
            $student = new Student();
        }

        $student->setJazyk(strtoupper($this->request()->getValue('jazyk')));
        $student->setZaciatok($this->request()->getValue('zaciatok'));
        $this->request()->getValue('koniec') === "" ? $student->setKoniec(null) : $student->setKoniec($this->request()->getValue('koniec'));

        $formErrors = $this->formErrors();

        if (count($formErrors) > 0) {
            return $this->html([
                'student' => $student,
                'errors' => $formErrors
            ], ($id > 0) ? 'edit' : 'add');
        } else {
            $student->save();
            return new RedirectResponse($this->url('student.index'));
        }
    }

    private function formErrors(): array
    {
        $errors = [];
        if ($this->request()->getValue('jazyk') == "") {
            $errors[] = "Pole jazyk musi byt vyplnene!";
        }
        if ($this->request()->getValue('zaciatok') == "") {
            $errors[] = "Pole zaciatok musi byt vyplnene!";
        }

        if ($this->request()->getValue('jazyk') != "" && (strlen(str_replace(' ', '', $this->request()->getValue('jazyk'))) != 3 || strlen($this->request()->getValue('jazyk')) != 3)) {
            $errors[] = "Jazyk sa musi skladat z troch pismen";
        }

        return $errors;
    }
}
