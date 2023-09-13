<?php
namespace App\Controller;

use App\Core\BaseController;

class _404Controller extends BaseController
{
    public function index()
    {
        $this->render('/_404/_404.html.twig');
    }
}