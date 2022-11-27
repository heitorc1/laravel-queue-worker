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

class ProcessPiece implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $piece;
    private $guzzle;

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

        $url = $this->setDataUrl($this->piece);

        try {
            $response = $this->guzzle->request(
                'GET',
                $url
            );
            $data = json_decode($response->getBody()->getContents());
            if (!empty($data->features)) {
                $attributes = (array) $data->features[0]->attributes;
                Data::firstOrCreate(
                    ['nrinscr' => $attributes['nrinscr']],
                    $attributes
                );
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function setDataUrl(string $cod)
    {
        return env('DATA_URL') . $cod . '&returnGeometry=false&spatialRel=esriSpatialRelIntersects&outFields=nrinscr,tplogradou,nmlogradou,cdlogradou,nrimovel,incompl,nrquadra,nrlote,nmbairro,cdbairro,ttsublot,insubprinc,nrfrenter,areaterr,areatest,areaedif,propriedad,situacao,topografia,nivel,solo,uso,uso1,formauso,cdedificio,nmedificio,nrpaviment,localizac,nrelevador,nrvagascob,nrvagasdes,nrgaragem,tpedif1,tpedif2,posicaoedf,estrutura,esquadria,piso,forro,insteletri,vlvenal,ininstsani,revinterno,acinterno,revexterno,acexterno,cobertura,conserva,agua,esgoto,ocupacao,fecho,passeio,nrarvores,nrpostes,pontedific,VALR_M2_EDF_LAN,VALR_M2_TERRENO_LAN,VALR_M2_ZPA_LAN';
    }
}
