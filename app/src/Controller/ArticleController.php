<?php

namespace App\Controller;

use App\Core\BaseController;
use App\Model\Article;
use App\Service\ArticleService;
use App\Service\LoggerService;
use App\Service\SessionService;
use App\Service\ValidatorService;
use Doctrine\ORM\EntityManager;

class ArticleController extends BaseController
{
    public function __construct(
        private ArticleService $articleService,
        private EntityManager $em,
        private LoggerService $logger)
    {
    }

    public function index($params)
    {
        $message = [];
        if (SessionService::getVariable('redirect_message')){
            $message = SessionService::getVariable('redirect_message');
            SessionService::unsetVariable('redirect_message');
            return $this->render('/article/articles.html.twig', ['articles' => $this->articleService->getArticles(), key($message) => $message[key($message)]]);
        }
        if (SessionService::getVariable('user_id')) {
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

        try {
            $this->em->persist($article);
            $this->em->flush();
        } catch (\Exception $e) {
            $this->logger->log($e->getMessage());
            return $this->redirect('article', 'index', ['exception_message' => 'Failed to create News!']);
        }

        return $this->redirect('article', 'index', ['article_created_success' => 'News Successfully Created!']);
    }

    public function edit(array $params)
    {
        $validator = ValidatorService::validateLength($params['title'], 1, 20);
        if (!$validator['is_valid']) {
            return $this->redirect('article', 'index', ['validator_error' => $validator['message']]);
        }

        $article = $this->articleService->getArticleById($params['articleId']);
        $article->setTitle($params['title']);
        $article->setDescription($params['description']);

        try {
            $this->em->persist($article);
            $this->em->flush();
        } catch (\Exception $e) {
            $this->logger->log($e->getMessage());
            return $this->redirect('article', 'index', ['exception_message' => 'Failed to change News']);
        }

        return $this->redirect('article', 'index', ['article_changed_success' => 'News Was Successfully Changed!']);
    }

    public function delete(array $params)
    {
        $article = $this->articleService->getArticleById($params['articleId']);
        try {
            $this->em->remove($article);
            $this->em->flush();
        } catch (\Exception $e) {
            $this->logger->log($e->getMessage());
            return $this->redirect('article', 'index', ['exception_message' => 'Failed to delete!']);
        }

        return $this->redirect('article', 'index', ['article_deleted_success' => 'News Was Deleted!']);
    }
}