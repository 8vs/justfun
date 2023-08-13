<?php

namespace AdventureTime\Controllers;

use AdventureTime\Utils\ResponseJson;

abstract class Controller
{
    use ResponseJson;

    protected array $set = [];
}