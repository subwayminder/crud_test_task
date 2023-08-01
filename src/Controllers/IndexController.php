<?php

namespace Subwayminder\CrudTestTask\Controllers;

use Subwayminder\CrudTestTask\Services\TestService;

class IndexController
{
    public function __construct(public readonly TestService $service)
    {
    }

    public function index(): void
    {
        echo json_encode($this->service->test());
    }
}