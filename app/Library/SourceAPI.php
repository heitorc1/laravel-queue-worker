<?php

namespace App\Library;

use App\Jobs\ProcessData;
use App\Models\Data;
use GuzzleHttp\Client;

class SourceAPI
{
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
