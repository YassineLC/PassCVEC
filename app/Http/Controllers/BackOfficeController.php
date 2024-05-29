<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Post;
use Illuminate\Http\Request;

class BackOfficeController extends Controller
{
    public function index(Request $request) {
        $query = Post::query();

        // Filtrer par présence en résidence
        if ($request->has('is_in_residence')) {
            $query->where('is_in_residence', $request->input('is_in_residence'));
        }

        // Filtrer par nom
        if ($request->has('search_nom')) {
            $query->where('nom', 'like', '%' . $request->input('search_nom') . '%');
        }

        // Filtrer par prénom
        if ($request->has('search_prenom')) {
            $query->where('prenom', 'like', '%' . $request->input('search_prenom') . '%');
        }

        $allRequests = $query->get();

        return view('backoffice', ['allRequests' => $allRequests]);
    }


    public function afficherDemande($id) {
        $demande = Post::find($id);

        if (!$demande) {
            abort(404);
        }

        $scolarite_path = $this->getPath($id, 'scolarite');
        $cvec_path = $this->getPath($id, 'cvec');

        return view('demande', ['data' => $demande, 'scolarite_path' => $scolarite_path, 'cvec_path' => $cvec_path]);
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
