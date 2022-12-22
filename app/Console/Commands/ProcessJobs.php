<?php

namespace App\Console\Commands;

use App\Library\SourceAPI;
use Illuminate\Console\Command;

class ProcessJobs extends Command
{
    public function __construct(private SourceAPI $api)
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process all jobs';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->api->process();
        return Command::SUCCESS;
    }
}
