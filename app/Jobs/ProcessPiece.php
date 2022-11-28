<?php

namespace App\Jobs;

use App\Models\Data;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessPiece implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $piece;
    private $guzzle;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 25;

    /**
     * The maximum number of unhandled exceptions to allow before failing.
     *
     * @var int
     */
    public $maxExceptions = 10;


    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 300;

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
    public function __construct($piece)
    {
        $this->piece = $piece;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->guzzle = new Client();

        $url = env('DATA_URL') . $this->piece . '&returnGeometry=false&spatialRel=esriSpatialRelIntersects&outFields=nrinscr,tplogradou,nmlogradou,cdlogradou,nrimovel,incompl,nrquadra,nrlote,nmbairro,cdbairro,ttsublot,insubprinc,nrfrenter,areaterr,areatest,areaedif,propriedad,situacao,topografia,nivel,solo,uso,uso1,formauso,cdedificio,nmedificio,nrpaviment,localizac,nrelevador,nrvagascob,nrvagasdes,nrgaragem,tpedif1,tpedif2,posicaoedf,estrutura,esquadria,piso,forro,insteletri,vlvenal,ininstsani,revinterno,acinterno,revexterno,acexterno,cobertura,conserva,agua,esgoto,ocupacao,fecho,passeio,nrarvores,nrpostes,pontedific,VALR_M2_EDF_LAN,VALR_M2_TERRENO_LAN,VALR_M2_ZPA_LAN';

        try {
            $response = $this->guzzle->request(
                'GET',
                $url
            );
            $data = json_decode($response->getBody()->getContents());
            if (!empty($data->features)) {
                $attributes = (array) $data->features[0]->attributes;
                Log::info('Trying to insert ' . $attributes['nrinscr']);
                $data = Data::firstOrCreate(
                    ['nrinscr' => $attributes['nrinscr']],
                    $attributes
                );
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
