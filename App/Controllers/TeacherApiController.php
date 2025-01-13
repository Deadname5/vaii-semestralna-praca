<?php

namespace App\Controllers;

use App\Core\AControllerBase;
use App\Core\HTTPException;
use App\Core\Responses\EmptyResponse;
use App\Core\Responses\JsonResponse;
use App\Core\Responses\RedirectResponse;
use App\Core\Responses\Response;
use App\Models\Schedule;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\User;

class TeacherApiController extends AControllerBase
{

    /**
     * @inheritDoc
     * @throws HTTPException
     */
    public function index(): Response
    {
        throw new HTTPException(501, "Not Implemented");
    }

    /**
     * @throws HTTPException
     * @throws \JsonException
     * @throws \Exception
     */
    public function findUser() : Response
    {
        $jsonData = $this->app->getRequest()->getRawBodyJSON();
        if (
            is_object($jsonData)
            && property_exists($jsonData, 'username') && property_exists($jsonData, 'teacher')
            && !empty($jsonData->username)
        ) {
            $users = User::getAll('login LIKE ?', [$jsonData->username]);
            if ((int) $jsonData->teacher > 0) {
                $teacher = Teacher::getOne((int)$jsonData->teacher);
                if (sizeof($users) > 0 && $users[0]->getTeacherId() != $teacher->getId()) {
                    return new EmptyResponse();
                } else {
                    return new JsonResponse([]);
                }


            } else {
                if (sizeof($users) > 0) {
                    return new EmptyResponse();
                } else {
                    return new JsonResponse([]);
                }
            }


        }
        throw new HTTPException(400, "Bad atributes");
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
            && property_exists($jsonData, 'teacher') &&  property_exists($jsonData, 'user') && property_exists($jsonData, 'name') && property_exists($jsonData, 'surname')
            && property_exists($jsonData, 'language') && property_exists($jsonData, 'username') && property_exists($jsonData, 'password')
            && !empty($jsonData->name) && !empty($jsonData->surname) && !empty($jsonData->language) && !empty($jsonData->username) && !empty($jsonData->password)
        ) {
            $checkNew = false;
            $id = (int) $jsonData->teacher;
            if ($id > 0) {
                $teacher = Teacher::getOne($id);
            } else {
                $teacher = new Teacher();
                $checkNew = true;
            }
            $uid = (int) $jsonData->user;
            if ($uid > 0) {
                $user = User::getOne($uid);
            } else {
                $user = new User();
            }

            $teacher->setName($jsonData->name);
            $teacher->setSurname($jsonData->surname);
            $teacher->setLanguage($jsonData->language);
            $user->setLogin($jsonData->username);
            $user->setPassword($jsonData->password);
            $user->setRolesId(2);
            $formErrors = $this->formErrors($jsonData);

            if (count($formErrors) > 0) {
                return $this->json([
                    'formErrors' => $formErrors
                ]);
            } else {


                $teacher->save();
                if ($checkNew) {
                    $teachers = Teacher::getAll(orderBy: '`id` desc');
                    $user->setTeacherId($teachers[0]->getId());
                } else {
                    $user->setTeacherId($teacher->getId());
                }
                $hash = password_hash($jsonData->password, PASSWORD_DEFAULT);
                $user->setPassword($hash);
                $user->save();
                return $this->json([
                    'formErrors' => null
                ]);
            }
        }
        throw new HTTPException(400, "Bad atributes");
    }

    private function formErrors($jsonData): array
    {
        $errors = [];
        if ($jsonData->name == "") {
            $errors[] = "Pole meno musi byt vyplnene!";
        }
        if ($jsonData->surname == "") {
            $errors[] = "Pole priezvisko musi byt vyplnene!";
        }

        if ($jsonData->language == "") {
            $errors[] = "Pole vyucovaci jazyk musi byt vyplnene!";
        }

        if ($jsonData->username == "") {
            $errors[] = "Pole login musi byt vyplnene!";
        }

        if ($jsonData->password == "") {
            $errors[] = "Pole password musi byt vyplnene!";
        }

        if ($jsonData->language != "" && (strlen(str_replace(' ', '', $jsonData->language)) != 3 || strlen($jsonData->language) != 3)) {
            $errors[] = "Vyucovaci jazyk sa musi skladat z troch pismen bez medzier!";
        }

        if ($jsonData->username != "" && strpos($jsonData->username, ' ') !== false) {
            $errors[] = "Login nesmie obsahovat ziadne medzery!";
        }

        if ($jsonData->username != "" && strpos($jsonData->username, ' ') === false) {
            $user = User::getAll('login LIKE ?', [$jsonData->username]);
            if (count($user) > 0 && $user[0]->getTeacherId() != $jsonData->teacher) {
                $errors[] = "Takyto login uz existuje!";
            }
        }

        if ($jsonData->password != "" && strpos($jsonData->password, ' ') !== false) {
            $errors[] = "Heslo nesmie obsahovat ziadne medzery!";
        }

        if ($jsonData->password != "" && strpos($jsonData->password, ' ') === false && strlen($jsonData->password) < 6) {
            $errors[] = "Heslo musi mat aspon 6 znakov!";
        }

        return $errors;
    }
}