<?php

namespace App\Library;

use App\Jobs\ProcessData;
use App\Models\Data;
use GuzzleHttp\Client;

class SourceAPI
{
  private $guzzle;

  public function __construct(Client $guzzle)
  {
    $this->guzzle = $guzzle;
  }

  public function process()
  {
    try {
      $setores = explode(",", env('SETORES'));
      foreach ($setores as $setor) {
        ProcessData::dispatch($setor);
      }
    } catch (\Exception $e) {
      throw $e;
    }
  }
}
