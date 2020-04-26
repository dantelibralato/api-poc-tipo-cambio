<?php

namespace App\Repositories;

use App\Entities\TipoCambio;
use Illuminate\Support\Arr;
use Carbon\Carbon;

class TipoCambioRepo extends BaseRepo {

    public function obtener($data = []) {
        $tipocambio = TipoCambio::limit(200)
                ->orderBy('fecha', 'asc')
                ->pluck('tipo_cambio', 'fecha')
                ->toArray()
        ;

        foreach ($tipocambio as $key => $value) {
            $tipocambio[$key] = Arr::get($this->procesarTipoCambio([$key => $value], $key), $key, '');
        }

        return $tipocambio;
    }

    public function buscarPorFecha($data = []) {
        $fecha = $this->obtenerFecha($data);
        $_tipocambio = $this->obtenerTipoCambio($fecha);
        $tipocambio = $this->procesarTipoCambio($_tipocambio, $fecha);
        return $tipocambio;
    }

    protected function obtenerFecha($data) {
        #validar
        $_fecha = Arr::get($data, 'fecha', '');
        $fecha = Carbon::createFromFormat('Ymd', $_fecha)
                ->format('d/m/Y')
        ;

        return $fecha;
    }

    protected function obtenerTipoCambio($fecha) {
        $tipocambio = TipoCambio::where('fecha', '=', $fecha)
                ->pluck('tipo_cambio', 'fecha')
                ->toArray()
        ;

        return $tipocambio;
    }

    public function buscarPorFechas($data = []) {
        $_fechas = Arr::get($data, 'fechas', []);
        $fechas = $this->obtenerFechas($_fechas);
        $_tipocambio = $this->obtenerTipoCambioxFechas($fechas);
        foreach ($_tipocambio as $key => $value) {
            $tipocambio = Arr::get($this->procesarTipoCambio([$key => $value], $key), $key, '');
            $_tipocambio[$key] = $tipocambio;
        }
        return $_tipocambio;
    }

    protected function obtenerFechas($data) {
        #validar
        foreach ($data as $key => $value) {
            $_fecha = $value;
            $fecha = Carbon::createFromFormat('Ymd', $_fecha)
                    ->format('d/m/Y')
            ;
            $data[$key] = $fecha;
        }

        return $data;
    }

    protected function obtenerTipoCambioxFechas($fechas) {
        $lista = TipoCambio::whereIn('fecha', $fechas)
                ->pluck('tipo_cambio', 'fecha')
                ->toArray()
        ;

        return $lista;
    }

    protected function procesarTipoCambio($data, $fecha) {
        $datos = $data;
        $_tipocambio = Arr::get($data, $fecha, '');

        if (!empty($_tipocambio)) {
            $r01 = str_replace(',', '.', $_tipocambio);
            $c01 = is_numeric($r01) ? $r01 : '';
            $datos[$fecha] = $c01;
        }

        return $datos;
    }

}
