<?php

namespace App\Controller;

use App\Core\BaseController;
use App\Model\User;
use App\Service\SessionService;
use App\Service\UserService;

class LoginController extends BaseController
{
    public function __construct(private UserService $userService)
    {
    }

    public function index()
    {
        if (SessionService::getVariable('user_id')) {
            return $this->redirect('article', 'index');
        }

        $message = [];
        if (SessionService::getVariable('redirect_message')){
            $message = SessionService::getVariable('redirect_message');
            SessionService::unsetVariable('redirect_message');
        }
        return $this->render('/login/login.html.twig', $message);
    }

    public function validate(array $params)
    {
        $username = $params['username'];
        if ($user = $this->userService->getUserByUsername($username)) {
            if ($this->validatePassword($user, $params['password'])) {
                session_regenerate_id();
                SessionService::setVariable('user_id', $user->getId());

                return $this->redirect('article', 'index');
            } else {
                return $this->redirect('login', 'index', ['login_error_message' => 'Wrong Login Data']);
            }
        } else {
            return $this->redirect('login', 'index', ['login_error_message' => 'Wrong Login Data']);
        }
    }

    public function logout()
    {
        session_destroy();
        return $this->redirect('login', 'index');
    }

    private function validatePassword(User $user, string $password): bool
    {
        return password_verify($password, $user->getPassword());
    }
}
