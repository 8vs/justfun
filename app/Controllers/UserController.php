<?php

namespace AdventureTime\Controllers;

use AdventureTime\Controllers\Controller;

class UserController extends Controller
{
    public function getProfile()
    {
        // var_dump($_SESSION, $_REQUEST, $_SERVER);

        $this->response([
            $_SERVER['HTTP_AUTHORIZATION']
        ]);
    }
}