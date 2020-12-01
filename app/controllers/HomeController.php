<?php

namespace App\Controllers;

use App\Models\User;

class HomeController extends Controller
{
    public function home($req, $res, $args)
    {
        $user = User::find(1);

        $this->view->render($res, 'home.twig', [
            'user' => $user
        ]);
    }
}
