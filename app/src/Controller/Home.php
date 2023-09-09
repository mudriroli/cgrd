<?php

namespace App\Controller;

use App\Core\BaseController;

class Home extends BaseController
{
    public function index($params)
    {
        $this->render('/base.html.twig');
    }
}