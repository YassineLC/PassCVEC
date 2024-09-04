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

    public function updateRequestStatus(Request $request, $id)
    {
        // Validation du statut
        $request->validate([
            'status' => 'required|string|in:A traiter,En cours,Traité',
        ]);

        // Récupérer la demande par son ID
        $demande = Post::find($id);

        // Vérifiez si la demande existe
        if (!$demande) {
            return redirect()->back()->withErrors(['error' => 'Demande non trouvée.']);
        }

        // Mettre à jour le statut
        $demande->statut = $request->input('status');
        $demande->save();

        // Rediriger avec un message de succès
        return redirect()->route('backoffice.demande', ['id' => $id])->with('success', 'Statut mis à jour avec succès.');
    }


}
