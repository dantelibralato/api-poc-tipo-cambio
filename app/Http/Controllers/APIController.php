<?php

namespace App\Http\Controllers;

use App\Repositories\TipoCambioRepo;

class APIController extends Controller {

    protected $tipocambioRepo;

    public function __construct(TipoCambioRepo $tipocambioRepo) {
        $this->tipocambioRepo = $tipocambioRepo;
    }

}
