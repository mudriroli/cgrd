<?php

namespace App\Repository;

use Doctrine\ORM\AbstractQuery;
use Doctrine\ORM\EntityManager;

class ArticleRepository
{
    private $queryBuilder;
    public function __construct(private EntityManager $entityManager)
    {
        $this->queryBuilder = $this->entityManager->createQueryBuilder();
    }

    public function getArticles()
    {
        $articles = $this->queryBuilder
            ->select('a')
            ->from('App\Model\Article', 'a')
            ->getQuery()
            ->execute();

        return $articles;
    }

    public function getArticleById(int $id)
    {
        $article = $this->queryBuilder
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
        $article = $this->queryBuilder
            ->select('a')
            ->from('App\Model\Article', 'a')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult(AbstractQuery::HYDRATE_ARRAY);

        return $article;
    }

}