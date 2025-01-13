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
        if ($auth->getLoggedUserRole() == 1) {
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
        if ($auth->getLoggedUserRole() == 1) {
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

    /**
     * @throws Exception
     */
    public function save(): Response
    {
        $id = (int) $this->request()->getValue('id');
        if ($id > 0) {
            $schedule = Schedule::getOne($id);
        } else {
            $schedule = new Schedule();
        }


        $teacher = Teacher::getOne((int) $this->request()->getValue('teacher'));
        $student = Student::getOne((int) $this->request()->getValue('student'));
        if (is_null($teacher)) {
            throw new HTTPException(404, "Teacher doesn't exist");
        }

        if (is_null($student)) {
            throw new HTTPException(404, "Student doesn't exist");
        }

        $schedule->setTeacherId((int) $this->request()->getValue('teacher'));
        $schedule->setStudentId((int) $this->request()->getValue('student'));
        $schedule->setLanguage($teacher->getLanguage());
        $schedule->setStart($this->request()->getValue('start'));
        $this->request()->getValue('end') === "" ? $schedule->setEnd(null) : $schedule->setEnd($this->request()->getValue('end'));

        $formErrors = $this->formErrors();

        if (count($formErrors) > 0) {
            $students = Student::getAll();
            if ($this->app->getAuth()->getLoggedUserRole() == 1) {
                $teachers = Teacher::getAll();
                return $this->html([
                    'students' => $students,
                    'teachers' => $teachers,
                    'schedule' => $schedule,
                    'errors' => $formErrors
                ], ($id > 0) ? 'edit' : 'add');
            } else {
                return $this->html([
                    'students' => $students,
                    'teacher' => $teacher,
                    'schedule' => $schedule,
                    'errors' => $formErrors
                ], ($id > 0) ? 'edit' : 'add');
            }

        } else {
            $schedule->save();
            return new RedirectResponse($this->url('schedule.index'));
        }

    }

    private function formErrors(): array
    {
        $errors = [];

        if ($this->request()->getValue('student') == "") {
            $errors[] = "Pole student musi byt vyplnene!";
        }

        if ($this->request()->getValue('teacher') == "" && $this->app->getAuth()->getLoggedUserRole() == 1) {
            $errors[] = "Pole ucitel musi byt vyplnene!";
        }

        if ($this->request()->getValue('start') == "") {
            $errors[] = "Pole zaciatok vyucby musi byt vyplnene!";
        }

        if ($this->request()->getValue('start') != "" && $this->request()->getValue('end') != "" && $this->request()->getValue('end') < $this->request()->getValue('start')) {
            $errors[] = "Koniec vyucby musi byt neskor ako zaciatok vyucby!";
        }

        return $errors;
    }


}
