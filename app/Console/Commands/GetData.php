<?php

namespace App\Console\Commands;

use App\Models\Data;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class GetData extends Command
{

    private $guzzle;
    private $data;

    public function __construct(Client $guzzle)
    {
        parent::__construct();
        $this->guzzle = $guzzle;
    }
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get data from source';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try {
            $setores = explode(",", env('SETORES'));
            foreach ($setores as $setor) {
                $response = $this->guzzle->request(
                    'GET',
                    env('SETORES_URL') . $setor . '&returnGeometry=false&spatialRel=esriSpatialRelIntersects&outFields=ci,nrinscr'
                );

                $data = json_decode($response->getBody()->getContents());
                $imoveis = $data->features;

                foreach ($imoveis as $imovel) {
                    $cod = $imovel->attributes->nrinscr;
                    $this->setDataUrl($cod);

                    try {
                        $response = $this->guzzle->request(
                            'GET',
                            $this->data
                        );
                        $data = json_decode($response->getBody()->getContents());
                        if (!empty($data->features)) {
                            $attributes = (array) $data->features[0]->attributes;
                            Data::firstOrCreate(
                                ['nrinscr' => $attributes['nrinscr']],
                                $attributes
                            );
                        }
                        $this->info('Inserting ' . $attributes['nrinscr']);
                    } catch (\Exception $e) {
                        throw $e;
                    }
                }
            }
        } catch (\Exception $e) {
            throw $e;
        }
    }

    private function setDataUrl(string $cod)
    {
        $this->data = env('DATA_URL') . $cod . '&returnGeometry=false&spatialRel=esriSpatialRelIntersects&outFields=nrinscr,tplogradou,nmlogradou,cdlogradou,nrimovel,incompl,nrquadra,nrlote,nmbairro,cdbairro,ttsublot,insubprinc,nrfrenter,areaterr,areatest,areaedif,propriedad,situacao,topografia,nivel,solo,uso,uso1,formauso,cdedificio,nmedificio,nrpaviment,localizac,nrelevador,nrvagascob,nrvagasdes,nrgaragem,tpedif1,tpedif2,posicaoedf,estrutura,esquadria,piso,forro,insteletri,vlvenal,ininstsani,revinterno,acinterno,revexterno,acexterno,cobertura,conserva,agua,esgoto,ocupacao,fecho,passeio,nrarvores,nrpostes,pontedific,VALR_M2_EDF_LAN,VALR_M2_TERRENO_LAN,VALR_M2_ZPA_LAN';
    }
}
