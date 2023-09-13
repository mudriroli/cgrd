<?php

namespace App\Repository;

use Doctrine\ORM\EntityManager;

class UserRepository
{
    public function __construct(private EntityManager $entityManager)
    {
    }

    public function getUserByUsername(string $username)
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
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