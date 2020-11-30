<?php
namespace App\Controllers;

class HomeController extends Controller
{
    public function home($req, $res, $args)
    {
        $this->view->render($res, 'home.html.twig');
    }
}
