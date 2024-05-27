<?php

namespace App\Http\Controllers;

use SimpleXMLElement;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class LogementController extends Controller
{
    public function index()
    {
        $logements = $this->fetchLogements();
        return $logements;
    }

    private function fetchLogements()
    {
        $cacheKey = 'logements_data'; // Clé de cache

        // Vérifier si les données sont en cache
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey); // Renvoyer les données en cache
        }

        $xml = Http::get('http://webservices-v2.crous-mobile.fr/feed/versailles/versailles-logement.xml')->body();
        $xmlData = new SimpleXMLElement($xml);

        $logements = [];
        foreach ($xmlData->residence as $residence) {
            $logement = [
                'title' => (string)$residence['title'],
                'short_desc' => (string)$residence['short_desc'],
                'address' => (string)$residence->address,
                'phone' => (string)$residence->phone,
                'mail' => (string)$residence->mail,
                'internetUrl' => (string)$residence->internetUrl,
            ];
            $logements[] = $logement;
        }

        // Mettre les données en cache pour une heure (3600 secondes)
        Cache::put($cacheKey, $logements, 3600);

        return $logements;
    }
}



