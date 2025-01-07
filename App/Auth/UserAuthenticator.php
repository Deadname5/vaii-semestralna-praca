<?php

namespace App\Auth;

use App\Core\IAuthenticator;
use App\Models\User;

class UserAuthenticator implements IAuthenticator
{



    public function __construct()
    {
        session_start();
    }

    /**
     * @inheritDoc
     */
    public function login($login, $password): bool
    {
        $user = User::getAll('`login` LIKE ?', [$login]);
        if (count($user) === 0) {
            return false;
        }
        else
        {
            $student = $user[0];
            if ($login == $student->getLogin() && $password == $student->getPassword()) {
                $_SESSION['user'] = $login;
                return true;
            }
        }
        return false;
    }

    /**
     * @inheritDoc
     */
    public function logout(): void
    {
        if (isset($_SESSION["user"])) {
            unset($_SESSION["user"]);
            session_destroy();
        }
    }

    /**
     * @inheritDoc
     */
    public function getLoggedUserName(): string
    {
        return isset($_SESSION['user']) ? $_SESSION['user'] : throw new \Exception("User not logged in");
    }

    /**
     * @inheritDoc
     */
    public function getLoggedUserId(): mixed
    {
        return $_SESSION['user'];
    }

    /**
     * @inheritDoc
     */
    public function getLoggedUserContext(): mixed
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    public function isLogged(): bool
    {
        return isset($_SESSION['user']) && $_SESSION['user'] != null;
    }
}