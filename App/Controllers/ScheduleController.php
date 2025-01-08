<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;
use Exception;
use HttpResponseException;

class ScheduleController extends AControllerBase
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

        $username = $auth->getLoggedUserName();

        $user = User::getAll('login LIKE ?', [$username]);
        if (count($user) != 1) {
            throw new HTTPException(400);
        }

        $role = Role::getOne($user[0]->getRolesId());

        if ($role->getRole() == 'admin') {
            return $this->html([
                'schedules' => Schedule::getAll()
            ]);
        }
        else
        {
            return $this->html([

                'schedules' => Schedule::getAll('teacher_id = ?', [$user[0]->getTeacherId()])
            ]);
        }


    }

    /**
     * @throws HTTPException
     * @throws Exception
     */
    public function delete(): Response
    {
        $id = (int) $this->request()->getValue('id');
        $schedule = Schedule::getOne($id);

        if (is_null($schedule)) {
            throw new HTTPException(404);
        } else {
            $schedule->delete();
            return new RedirectResponse($this->url('schedule.index'));
        }
    }

    /**
     * @throws Exception
     */
    public function add(): Response
    {
        $auth = $this->app->getAuth();

        if (!$auth->isLogged()) {
            return new RedirectResponse($this->url('auth.login'));
        }

        $students = Student::getAll();
        if ($auth->getLoggedUserName() == 'admin') {
            $teachers = Teacher::getAll();
            return $this->html([
                'students' => $students,
                'teachers' => $teachers
            ]);
        }
        else
        {
            $user = User::getAll('login LIKE ?', [$auth->getLoggedUserName()]);
            if (count($user) != 1) {
                throw new HTTPException(400);
            }
            $teacher = Teacher::getOne($user[0]->getTeacherId());
            return $this->html([
                'students' => $students,
                'teacher' => $teacher
            ]);
        }

        return $this->html();
    }

    /**
     * @throws HTTPException
     * @throws Exception
     */
    public function edit(): Response
    {
        $auth = $this->app->getAuth();

        if (!$auth->isLogged()) {
            return new RedirectResponse($this->url('auth.login'));
        }
        $id = (int)$this->request()->getValue('id');
        $schedule = Schedule::getOne($id);

        if (is_null($schedule)) {
            throw new HTTPException(404);
        }

        $students = Student::getAll();
        if ($auth->getLoggedUserName() == 'admin') {
            $teachers = Teacher::getAll();
            return $this->html([
                'students' => $students,
                'teachers' => $teachers,
                'schedule' => $schedule
            ]);
        } else {
            $user = User::getAll('login LIKE ?', [$auth->getLoggedUserName()]);
            if (count($user) != 1) {
                throw new HTTPException(400);
            }
            $teacher = Teacher::getOne($user[0]->getTeacherId());
            return $this->html([
                'students' => $students,
                'teacher' => $teacher,
                'schedule' => $schedule
            ]);
        }
    }

    public function save(): Response
    {
        $id = (int) $this->request()->getValue('id');
        if ($id > 0) {
            $schedule = Schedule::getOne($id);
        } else {
            $schedule = new Schedule();
        }

        $schedule->setTeacherId((int) $this->request()->getValue('teacher'));
        $schedule->setStudentId((int) $this->request()->getValue('student'));
        $teacher = Teacher::getOne((int) $this->request()->getValue('teacher'));
        $schedule->setLanguage($teacher->getLanguage());
        $schedule->setStart($this->request()->getValue('start'));
        $this->request()->getValue('end') === "" ? $schedule->setEnd(null) : $schedule->setEnd($this->request()->getValue('end'));

        // TODO: implement form errors
        $schedule->save();
        return new RedirectResponse($this->url('schedule.index'));

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
