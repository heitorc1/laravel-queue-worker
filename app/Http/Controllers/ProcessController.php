<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessData;
use Illuminate\Http\Request;

class ProcessController extends Controller
{
    private $job;

    public function __construct(ProcessData $data)
    {
        $this->job = $data;
    }

    public function start()
    {
        $this->job->dispatch();
    }
}
