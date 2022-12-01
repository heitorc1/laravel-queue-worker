<?php

namespace App\Library;

use App\Jobs\ProcessData;

class SourceAPI
{
  public function process()
  {
    try {
      for ($i = 1; $i <= 10000; $i++) {
        ProcessData::dispatch($i)->onQueue('high');
      }
    } catch (\Exception $e) {
      throw $e;
    }
  }
}
