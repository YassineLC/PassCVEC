<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use App\Models\Post;
use Illuminate\Http\Request;

class BackOfficeController extends Controller
{
    public function index(Request $request) {
        $query = Post::query();

        $filters = ['nom', 'prenom', 'ine', 'id'];

        foreach ($filters as $filter) {
            if ($request->filled($filter)) {
                $query->where($filter, 'like', '%' . $request->input($filter) . '%');
            }
        }

        $allRequests = $query->get();

        $incomingRequests = Post::where('statut', 'A traiter')->count();
        $pendingRequests = Post::where('statut', 'En cours')->count();
        $assignedRequests = Post::where('statut', 'Traité')->count();

        return view('backoffice/backoffice', [
            'allRequests' => $allRequests,
            'incomingRequests' => $incomingRequests,
            'pendingRequests' => $pendingRequests,
            'assignedRequests' => $assignedRequests,
        ]);
    }



    public function afficherDemande($id) {
        $demande = Post::find($id);

        if (!$demande) {
            abort(404);
        }

        $scolarite_path = $this->getPath($id, 'scolarite');
        $cvec_path = $this->getPath($id, 'cvec');

        return view('backoffice/demande', ['data' => $demande, 'scolarite_path' => $scolarite_path, 'cvec_path' => $cvec_path]);
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
