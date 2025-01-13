<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\EmptyResponse;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Models\Student;
use Exception;
use HttpResponseException;

class StudentController extends AControllerBase
{
    public function index(): Response
    {

        $auth = $this->app->getAuth();


        if (!$auth->isLogged()) {
            return new RedirectResponse($this->url('auth.login'));
        }

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
        $auth = $this->app->getAuth();


        if (!$auth->isLogged()) {
            return new RedirectResponse($this->url('auth.login'));
        }

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
        $auth = $this->app->getAuth();


        if (!$auth->isLogged()) {
            return new RedirectResponse($this->url('auth.login'));
        }

        return $this->html();
    }

    /**
     * @throws HTTPException
     */
    public function edit(): Response
    {
        $auth = $this->app->getAuth();


        if (!$auth->isLogged()) {
            return new RedirectResponse($this->url('auth.login'));
        }

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
        header('Access-Control-Allow-Origin: *');
        $auth = $this->app->getAuth();


        if (!$auth->isLogged()) {
            return new RedirectResponse($this->url('auth.login'));
        }

        $id = (int) $this->request()->getValue('id');
        if ($id > 0) {
            $student = Student::getOne($id);
        } else {
            $student = new Student();
        }

        $student->setName(rtrim($this->request()->getValue('name')));
        $student->setSurname(rtrim($this->request()->getValue('surname')));

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
        if (rtrim($this->request()->getValue('name')) == "") {
            $errors[] = "Pole meno musi byt vyplnene!";
        }
        if (rtrim($this->request()->getValue('surname')) == "") {
            $errors[] = "Pole priezvisko musi byt vyplnene!";
        }

        return $errors;
    }
}
