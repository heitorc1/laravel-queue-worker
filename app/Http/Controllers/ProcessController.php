<?php

namespace App\Http\Controllers;

use App\Library\SourceAPI;

class ProcessController extends Controller
{
    private $api;

    public function __construct(SourceAPI $api)
    {
        $this->api = $api;
    }

    public function start()
    {
        $this->api->process();
    }
}
