<?php

namespace App\Service;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;

class ArticleService
{
    public function __construct(private EntityManager $em)
    {
    }

    public function getArticles()
    {
        $queryBuilder = $this->em->createQueryBuilder();
        $articles = $queryBuilder
            ->select('a')
            ->from('App\Model\Article', 'a')
            ->getQuery()
            ->execute();

        return $articles;
    }

    public function getArticleById(int $id)
    {
        $queryBuilder = $this->em->createQueryBuilder();
        $article = $queryBuilder
            ->select('a')
            ->from('App\Model\Article', 'a')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();

        return $article;
    }

    public function getArticleByIdAsArray(int $id)
    {
        $queryBuilder = $this->em->createQueryBuilder();
        $article = $queryBuilder
            ->select('a')
            ->from('App\Model\Article', 'a')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);

        return $article;
    }


}