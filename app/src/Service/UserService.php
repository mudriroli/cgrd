<?php

namespace App\Service;

use App\Model\User;
use Doctrine\ORM\EntityManager;

class UserService
{
    public function __construct(private EntityManager $em)
    {
    }

    public function getUserByUsername(string $username): ?User
    {
        $queryBuilder = $this->em->createQueryBuilder();
        $user = $queryBuilder
            ->select('u')
            ->from('App\Model\User', 'u')
            ->where($queryBuilder->expr()->eq('u.username', ':username'))
            ->setParameter('username', $username)
            ->getQuery()
            ->getOneOrNullResult();

        return $user;
    }
}