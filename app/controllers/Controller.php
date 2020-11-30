<?php

namespace App\Controllers;

use Psr\Container\ContainerInterface;
use Slim\Views\Twig as View;

class Controller
{
    protected $container;

    public function __construct(ContainerInterface $container) 
    {
        $this->container = $container;
    }

    public function __get($property)
    {
        if($this->container->{$property}) {
            return $this->container->{$property};
        }
    }
}
