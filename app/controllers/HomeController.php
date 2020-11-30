<?php
namespace App\Controllers;

class HomeController extends Controller
{
    public function home($req, $res, $args)
    {
        $user = $this->db->table('users')->find(1);

        // die();
        $this->view->render($res, 'home.html.twig', [
            'user' => $user
        ]);
    }
}
