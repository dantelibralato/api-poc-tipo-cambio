<?php

namespace App\Http\Controllers;

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;

class TipoCambioController extends APIController {

    public function index(Request $request) {
        return $this->tipocambioRepo->obtener($request->input());
    }

    public function buscarPorFecha(Request $request, $fecha) {
        \Log::info('request', ['fecha' => $fecha, 'request' => $request->input()]);
        return $this->tipocambioRepo->buscarPorFecha(compact('fecha'));
    }

    public function buscarPorFechas(Request $request) {
        return $this->tipocambioRepo->buscarPorFechas($request->input());
    }

}
