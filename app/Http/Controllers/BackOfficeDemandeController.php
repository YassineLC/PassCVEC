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
        
        // On récupère le chemin du certificat de scolarité
        $scolarite_path = $this->getPath($id, 'scolarite');
        
        // On récupère le chemin de l'attestation CVEC uniquement si l'étudiant n'est pas en résidence
        $cvec_path = !$demande->is_in_residence ? $this->getPath($id, 'cvec') : null;
        
        // Ajouter des indicateurs pour faciliter l'affichage dans la vue
        $has_scolarite = ($scolarite_path !== null);
        $needs_cvec = !$demande->is_in_residence;
        $has_cvec = ($cvec_path !== null);
        
        // Récupérer les pièces jointes pour la vue
        $attachments = [];
        if ($has_scolarite) {
            $attachments['scolarite'] = true;
        }
        if ($has_cvec) {
            $attachments['cvec'] = true;
        }
    
        return view('backoffice.demande', [
            'data' => $demande,
            'scolarite_path' => $scolarite_path,
            'cvec_path' => $cvec_path,
            'has_scolarite' => $has_scolarite,
            'needs_cvec' => $needs_cvec,
            'has_cvec' => $has_cvec,
            'attachments' => $attachments
        ]);
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

    public function afficherPDF($id, $type)
    {
        $path = self::getPath($id, $type);
        
        if (!$path || !file_exists($path)) {
            abort(404);
        }
        
        $response = response()->file($path);
        
        // Supprimer l'en-tête X-Frame-Options qui peut empêcher l'affichage dans un iframe
        $response->headers->remove('X-Frame-Options');
        
        $response->header('Content-Security-Policy', "frame-ancestors 'self'");
        
        return $response;
    }
}
