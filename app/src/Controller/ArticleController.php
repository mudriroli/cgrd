<?php

namespace App\Controller;

use App\Core\BaseController;
use App\Model\Article;
use App\Service\ArticleService;
use App\Service\ValidatorService;
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

    public function article(array $params)
    {
        $articleId = $params['articleId'];
        $article = $this->articleService->getArticleByIdAsArray($articleId);

        echo json_encode($article);
    }

    public function create(array $params)
    {
        $validator = ValidatorService::validateLength($params['title'], 1, 20);
        if (!$validator['is_valid']) {
            return $this->redirect('article', 'index', ['validator_error' => $validator['message']]);
        }
        $article = new Article();
        $article->setTitle($params['title']);
        $article->setDescription($params['description']);

        $this->em->persist($article);
        $this->em->flush();

        return $this->redirect('article', 'index', ['article_created_success' => 'News Successfully Created!']);
    }

    public function edit($params)
    {
        $validator = ValidatorService::validateLength($params['title'], 1, 20);
        if (!$validator['is_valid']) {
            return $this->redirect('article', 'index', ['validator_error' => $validator['message']]);
        }

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