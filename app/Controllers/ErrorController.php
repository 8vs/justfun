<?php

namespace AdventureTime\Controllers;

class ErrorController extends Controller
{
    public function notAuthorization(): void
    {
        $this->response(
            ['message' => 'Пользователь не авторизован.']
        );
    }

    public function resourceNotFound(): void
    {
        $this->response(
            ['message' => 'Запрашиваемый ресурс не найден.']
        );
    }
}