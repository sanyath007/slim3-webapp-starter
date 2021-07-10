<?php

namespace App\Middleware;

class OldInputMiddleware extends Middleware
{
    public function __invoke($request, $response, $next)
    {
        if(array_key_exists('errors', $_SESSION)) {
            $this->container->view->getEnvironment()->addGlobal('old', $_SESSION['old']);
            $_SESSION['old'] = $request->getParams();
        }

        return $next($request, $response);
    }
}
