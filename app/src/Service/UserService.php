<?php

namespace App\Service;

use App\Model\User;
use App\Repository\UserRepository;

class UserService
{
    public function __construct(private UserRepository $repository)
    {
    }

    public function getUserByUsername(string $username): ?User
    {
        return $this->repository->getUserByUsername($username);
    }
}