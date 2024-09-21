<?php

namespace App\MensaComune;

use App\Models\Grado;
use App\Models\Municipio;
use Carbon\Carbon;

class Client
{
    private static $cookieSourceURL = 'https://www.comune.roma.it/servizi/mesis-portal-reports-war/loadMenuRistorazione.do';
    private static $dataURL = 'https://www.comune.roma.it/servizi/mesis-portal-reports-war/elencoMenuGiorno.do';

    /**
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    public static function getMenu(string|int $municipio, string|int $grado, Carbon $date = null): ?string
    {
        if ($date == null) {
            $date = Carbon::now();
        }

        $response = \Cache::remember("mensa_{$municipio}_{$grado}_" . $date->format('YMD'), 259200, function () use ($municipio, $grado, $date) {
            return self::getData($municipio, $grado, $date);
        });

        $nomeMunicipio = Municipio::find($municipio)->name;
        $nomeGrado = Grado::find($grado)->name;
        $prettyDate = $date->format('d/m/Y');

        $prettyMenu = '';
        foreach ($response as $pasto => $menu) {
            $prettyMenu .= "<b>{$pasto}:</b>\n" . implode(', ', $menu) . ".\n\n";
        }

        return count($response)? <<<EOF
                  Ciao!

                  Il menu del $prettyDate nel $nomeMunicipio, $nomeGrado è:

                  $prettyMenu
                  EOF : null;
    }

    /**
     * @throws \Illuminate\Http\Client\ConnectionException
     */
    private static function getData(string|int $municipio, string|int $grado, Carbon $date): array
    {
        $cookieRequest = \Http::get(self::$cookieSourceURL, []);
        $request = \Http::acceptJson()->withOptions(['cookies' => $cookieRequest->cookies])->get(self::$dataURL, [
            'municipio'         => $municipio,
            'cicloScolastico'   => $grado,
            'giornoSelezionato' => $date->format('d/m/Y'),
        ]);

        $pasti = [];
        foreach ($request->json() as $pasto) {
            $pasti[$pasto['tipoPasto']][] = $pasto['descPasto'];
        }
        return $pasti;
    }
}
