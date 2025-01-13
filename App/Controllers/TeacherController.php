<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\Responses\Response;
use App\Core\HTTPException;
use App\Core\Responses\RedirectResponse;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Exception;

class TeacherController extends AControllerBase
{

    /**
     * @throws Exception
     */
    public function index(): Response
    {
        $auth = $this->app->getAuth();


        if (!$auth->isLogged()) {
            return new RedirectResponse($this->url('auth.login'));
        }

        return $this->html([
            'teachers' => Teacher::getAll()
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
        $teacher = Teacher::getOne($id);

        if (is_null($teacher)) {
            throw new HTTPException(404);
        } else {
            $user = User::getAll('teacher_id = ?', [$teacher->getId()]);
            $user[0]->delete();
            $teacher->delete();

            return new RedirectResponse($this->url('teacher.index'));
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
        $teacher = Teacher::getOne($id);

        if (is_null($teacher)) {
            throw new HTTPException(404);
        }
        $user = User::getAll('teacher_id = ?', [$teacher->getId()]);

        return $this->html([
            'teacher' => $teacher,
            'user' => $user[0]
        ]);
    }

    /**
     * @throws Exception
     */
    public function save(): Response
    {
        $auth = $this->app->getAuth();


        if (!$auth->isLogged()) {
            return new RedirectResponse($this->url('auth.login'));
        }
        $checkNew = false;
        $id = (int) $this->request()->getValue('id');
        if ($id > 0) {
            $teacher = Teacher::getOne($id);
        } else {
            $teacher = new Teacher();
            $checkNew = true;
        }
        $uid = (int) $this->request()->getValue('uid');
        if ($uid > 0) {
            $user = User::getOne($uid);
        } else {
            $user = new User();
        }

        $teacher->setName($this->request()->getValue('name'));
        $teacher->setSurname($this->request()->getValue('surname'));
        $teacher->setLanguage($this->request()->getValue('language'));
        $user->setLogin($this->request()->getValue('login'));
        $user->setPassword($this->request()->getValue('password'));
        $user->setRolesId(2);
        $formErrors = $this->formErrors();

        if (count($formErrors) > 0) {
            return $this->html([
                'teacher' => $teacher,
                'user' => $user,
                'errors' => $formErrors
            ], ($id > 0) ? 'edit' : 'add');
        } else {


            $teacher->save();
            if ($checkNew) {
                $teachers = Teacher::getAll(orderBy: '`id` desc');
                $user->setTeacherId($teachers[0]->getId());
            } else {
                $user->setTeacherId($teacher->getId());
            }
            $user->save();
            return new RedirectResponse($this->url('teacher.index'));
        }

    }

    private function formErrors(): array
    {
        $errors = [];
        if ($this->request()->getValue('name') == "") {
            $errors[] = "Pole meno musi byt vyplnene!";
        }
        if ($this->request()->getValue('surname') == "") {
            $errors[] = "Pole priezvisko musi byt vyplnene!";
        }

        if ($this->request()->getValue('language') == "") {
            $errors[] = "Pole vyucovaci jazyk musi byt vyplnene!";
        }

        if ($this->request()->getValue('login') == "") {
            $errors[] = "Pole login musi byt vyplnene!";
        }

        if ($this->request()->getValue('password') == "") {
            $errors[] = "Pole password musi byt vyplnene!";
        }

        if ($this->request()->getValue('language') != "" && (strlen(str_replace(' ', '', $this->request()->getValue('language'))) != 3 || strlen($this->request()->getValue('language')) != 3)) {
            $errors[] = "Vyucovaci jazyk sa musi skladat z troch pismen bez medzier!";
        }

        if ($this->request()->getValue('login') != "" && strpos($this->request()->getValue('login'), ' ') !== false) {
            $errors[] = "Login nesmie obsahovat ziadne medzery!";
        }

        if ($this->request()->getValue('login') != "" && strpos($this->request()->getValue('login'), ' ') === false) {
            $user = User::getAll('login LIKE ?', [$this->request()->getValue('login')]);
            if (count($user) > 0 && $user[0]->getTeacherId() != $this->request()->getValue('id')) {
                $errors[] = "Takyto login uz existuje!";
            }
        }

        if ($this->request()->getValue('password') != "" && strpos($this->request()->getValue('password'), ' ') !== false) {
            $errors[] = "Heslo nesmie obsahovat ziadne medzery!";
        }

        if ($this->request()->getValue('password') != "" && strpos($this->request()->getValue('password'), ' ') === false && strlen($this->request()->getValue('password')) < 6) {
            $errors[] = "Heslo musi mat aspon 6 znakov!";
        }

        return $errors;
    }
}