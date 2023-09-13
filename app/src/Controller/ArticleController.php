<?php

namespace App\Controller;

use App\Core\BaseController;
use App\Model\Article;
use App\Service\ArticleService;
use Doctrine\ORM\EntityManager;

class ArticleController extends BaseController
{
    public function __construct(private ArticleService $articleService, private EntityManager $em)
    {
    }

    public function index($params)
    {
        $message = [];
        if (isset($_SESSION['redirect_message'])){
            $message = $_SESSION['redirect_message'];
            unset($_SESSION['redirect_message']);
            return $this->render('/article/articles.html.twig', ['articles' => $this->articleService->getArticles(), key($message) => $message[key($message)]]);

        }
        if (isset($_SESSION['user_id'])) {
            return $this->render('/article/articles.html.twig', ['articles' => $this->articleService->getArticles()]);
        } else {
            return $this->redirect('login', 'index');
        }
    }

    public function article($params)
    {
        $articleId = $params['articleId'];
        $article = $this->articleService->getArticleByIdAsArray($articleId);

        echo json_encode($article);
    }

    public function create($params)
    {
        $article = new Article();
        $article->setTitle($params['title']);
        $article->setDescription($params['description']);

        $this->em->persist($article);
        $this->em->flush();

        return $this->redirect('article', 'index', ['article_created_success' => 'News Successfully Created!']);
    }

    public function edit($params)
    {
        $article = $this->articleService->getArticleById($params['articleId']);
        $article->setTitle($params['title']);
        $article->setDescription($params['description']);

        $this->em->persist($article);
        $this->em->flush();

        return $this->redirect('article', 'index', ['article_changed_success' => 'News Was Successfully Changed!']);
    }

    public function delete($params)
    {
        $article = $this->articleService->getArticleById($params['articleId']);
        $this->em->remove($article);
        $this->em->flush();

        return $this->redirect('article', 'index', ['article_deleted_success' => 'News Was Deleted!']);
    }
}