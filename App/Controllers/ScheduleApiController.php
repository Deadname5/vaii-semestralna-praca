<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\EmptyResponse;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Teacher;

class ScheduleApiController extends AControllerBase
{
    /**
     * @inheritDoc
     */
    public function index(): Response
    {
        throw new HTTPException(501, "Not Implemented");
    }

    public function isAdmin(): Response
    {
        if ($this->app->getAuth()->getLoggedUserRole() == 1) {
            return new EmptyResponse();
        }


        throw new HTTPException(401, "Not an admin");
    }

    /**
     * @throws \JsonException
     * @throws \Exception
     */
    public function getStudent(): Response
    {
        $jsonData = $this->app->getRequest()->getRawBodyJSON();

        if (
            is_object($jsonData)
            && property_exists($jsonData, 'id')
            && !empty($jsonData->id)
        ) {
            $schedule = Schedule::getOne((int) $jsonData->id);
            $student = Student::getOne($schedule->getStudentId());

            return $this->json($student);
        }

        throw new HTTPException(400, "Bad attributes");
    }

    /**
     * @throws HTTPException
     * @throws \JsonException
     * @throws \Exception
     */
    public function getTeacher(): Response
    {
        $jsonData = $this->app->getRequest()->getRawBodyJSON();

        if (
            is_object($jsonData)
            && property_exists($jsonData, 'id')
            && !empty($jsonData->id)
        ) {
            $schedule = Schedule::getOne((int) $jsonData->id);
            $teacher = Teacher::getOne($schedule->getTeacherId());

            return $this->json($teacher);
        }

        throw new HTTPException(400, "Bad attributes");
    }


    /**
     * @throws HTTPException
     * @throws \JsonException
     * @throws \Exception
     */
    public function save(): Response
    {
        $jsonData = $this->app->getRequest()->getRawBodyJSON();

        if (
            is_object($jsonData)
            && property_exists($jsonData, 'student') &&  property_exists($jsonData, 'teacher') && property_exists($jsonData, 'start') && property_exists($jsonData, 'end')
            && property_exists($jsonData, 'schedule')
            && !empty($jsonData->student) && !empty($jsonData->teacher)
        ) {
            $id = (int)$jsonData->schedule;
            if ($id > 0) {
                $schedule = Schedule::getOne($id);
            } else {
                $schedule = new Schedule();
            }

            $teacher = Teacher::getOne((int)$jsonData->teacher);
            $student = Student::getOne((int)$jsonData->student);
            if (is_null($teacher)) {
                throw new HTTPException(404, "Teacher doesn't exist");
            }

            if (is_null($student)) {
                throw new HTTPException(404, "Student doesn't exist");
            }

            $schedule->setTeacherId((int)$jsonData->teacher);
            $schedule->setStudentId((int)$jsonData->student);
            $schedule->setLanguage($teacher->getLanguage());
            $schedule->setStart($jsonData->start);
            $jsonData->end === "" ? $schedule->setEnd(null) : $schedule->setEnd($jsonData->end);

            $formErrors = $this->formErrors($jsonData);

            if (count($formErrors) > 0) {
                return $this->json([
                    'formErrors' => $formErrors
                ]);
            } else {
                $schedule->save();
                return $this->json([
                    'formErrors' => null
                ]);
            }
        }
        throw new HTTPException(400, "Bad attributes");
    }

    private function formErrors($jsonData): array
    {
        $errors = [];

        if ($jsonData->student == "") {
            $errors[] = "Pole student musi byt vyplnene!";
        }

        if ($jsonData->teacher == "" && $this->app->getAuth()->getLoggedUserRole() == 1) {
            $errors[] = "Pole ucitel musi byt vyplnene!";
        }

        if ($jsonData->start == "") {
            $errors[] = "Pole zaciatok vyucby musi byt vyplnene!";
        }

        if ($jsonData->start != "" && $jsonData->end != "" && $jsonData->end < $jsonData->start) {
            $errors[] = "Koniec vyucby musi byt neskor ako zaciatok vyucby!";
        }

        return $errors;
    }
}
