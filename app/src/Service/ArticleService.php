<?php

namespace App\Service;

use App\Repository\ArticleRepository;
use Doctrine\ORM\AbstractQuery;

class ArticleService
{
    public function __construct(private ArticleRepository $repository)
    {
    }

    public function getArticles()
    {
        return $this->repository->getArticles();
    }

    public function getArticleById(int $id)
    {
        return $this->repository->getArticleById($id);
    }

    public function getArticleByIdAsArray(int $id)
    {
        return $this->repository->getArticleByIdAsArray($id);
    }


}