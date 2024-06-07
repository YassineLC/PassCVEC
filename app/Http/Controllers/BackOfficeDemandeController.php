<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Attachment;
use Illuminate\Http\Request;

class BackOfficeDemandeController extends Controller
{
    public function afficherDemande($id) {
        $demande = Post::find($id);

        if (!$demande) {
            abort(404);
        }

        $scolarite_path = $this->getPath($id, 'scolarite');
        $cvec_path = $this->getPath($id, 'cvec');

        return view('backoffice.demande', ['data' => $demande, 'scolarite_path' => $scolarite_path, 'cvec_path' => $cvec_path]);
    }

    public static function getPath($id, $type) {
        $path = Attachment::where('type', $type)
                          ->where('pass_cvec_request_id', $id)
                          ->value('path');

        if ($path) {
            $document_path = storage_path("app/documents/{$path}");

            if (file_exists($document_path)) {
                return $document_path;
            }
        }

        return null;
    }
}
