<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Smalot\PdfParser\Parser;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;

class PDFCheckController extends Controller {

    public function checkCVEC($path) {
        $text = $this->extractText($path);
        $code = $this->extractCvecCode($text);
        $apiResponse = $this->verifyCodeValidity($code);
        return $apiResponse;
    }
    private function extractText($path) {
        $parser = new Parser();
        $pdf = $parser->parseContent(file_get_contents($path));
        $text = $pdf->getText();
        return $text;
    }

    private function extractCvecCode($text) {
        if (preg_match("/VER\d{1} [A-Z]{6} \d{1,2} \/ [A-Z]{2,6}/", $text, $matches)) {
            $numero = str_replace([' ', '/'], '', $matches[0]);
            return $numero;
        } else {
            return null;
        }
    }

    private function verifyCodeValidity($code) {
        $client = new Client([
            'verify' => 'C:\wamp64\www\passcvec\passcvec\storage\certificates\cacert.pem' // TODO: Modifier le chemin d'accès pour le chemin absolu plus tard
        ]);

        try {
            $response = $client->get("https://cvec-ctrl.etudiant.gouv.fr/api/attestation/$code");
            if ($response->getStatusCode() === 200) {
                $data = json_decode($response->getBody()->getContents(), true);
                return $data;
            } else {
                return false;
            }
        } catch (RequestException $e) {
            return Log::error($e->getMessage());
        }
    }
}
