<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class ClearRedisJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'horizon:clear-redis';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear redis failed queue';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Redis::connection()->del('horizon:failed:*');
        Redis::connection()->del('horizon:failed_jobs');
    }
}
