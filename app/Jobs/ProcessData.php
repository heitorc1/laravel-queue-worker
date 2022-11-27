<?php

namespace App\Jobs;

use App\Models\Data;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\ThrottlesExceptions;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class ProcessData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $setor;
    private $guzzle;
    private $url;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($setor)
    {
        $this->setor = $setor;
    }

    /**
     * Get the middleware the job should pass through.
     *
     * @return array
     */
    public function middleware()
    {
        return [(new ThrottlesExceptions(10, 5))->backoff(5)];
    }

    /**
     * Determine the time at which the job should timeout.
     *
     * @return \DateTime
     */
    public function retryUntil()
    {
        return now()->addMinutes(5);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->guzzle = new Client();

        $response = $this->guzzle->request(
            'GET',
            env('SETORES_URL') . $this->setor . '&returnGeometry=false&spatialRel=esriSpatialRelIntersects&outFields=ci,nrinscr'
        );

        $data = json_decode($response->getBody()->getContents());
        $imoveis = $data->features;

        foreach ($imoveis as $imovel) {
            $cod = $imovel->attributes->nrinscr;
            ProcessPiece::dispatch($cod);
        }
    }
}
