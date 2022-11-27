<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessData;
use App\Library\SourceAPI;
use Illuminate\Http\Request;

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
