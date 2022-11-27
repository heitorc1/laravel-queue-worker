<?php

namespace App\Jobs;

use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $setor;
    private $guzzle;
    private $url;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 5;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 3;


    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 120;

    /**
     * Indicate if the job should be marked as failed on timeout.
     *
     * @var bool
     */
    public $failOnTimeout = true;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($setor)
    {
        $this->setor = $setor;
        $this->guzzle = new Client();
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
