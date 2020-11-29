<?php
namespace App\Controllers;

use Psr\Container\ContainerInterface;

class HomeController
{
	protected $container;
    protected $view;

    public function __construct(ContainerInterface $container) 
    {
        $this->container = $container;
        $this->view = $container['view'];
    }

    public function home($req, $res, $args)
    {
        $this->view->render($res, 'home.html.twig');
    }
}
