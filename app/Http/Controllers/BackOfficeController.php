<?php
namespace App\Http\Controllers;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BackOfficeController extends Controller
{
    public function index(Request $request) {
        $shibbolethAttributes = $this->getShibbolethAttributes();

        $query = Post::query();
        
        $filters = ['nom', 'prenom', 'ine', 'id', 'statut'];
        foreach ($filters as $filter) {
            if ($request->filled($filter)) {
                if ($filter == 'statut') {
                    $query->where($filter, '=', $request->input($filter));
                } else {
                    $query->where($filter, 'like', '%' . $request->input($filter) . '%');
                }
            }
        }
        
        // Exclure les demandes traitées par défaut, sauf si 'statut' est spécifié
        if (!$request->filled('statut')) {
            $query->where('statut', '!=', 'Traité');
        }
        
        $rowsPerPage = $request->input('rowsPerPage', 25);
        $allRequests = $query->paginate($rowsPerPage);
        
        $incomingRequests = Post::where('statut', 'A traiter')->count();
        $pendingRequests = Post::where('statut', 'En cours')->count();
        $assignedRequests = Post::where('statut', 'Traité')->count();
        
        return view('backoffice.backoffice', [
            'allRequests' => $allRequests,
            'incomingRequests' => $incomingRequests,
            'pendingRequests' => $pendingRequests,
            'assignedRequests' => $assignedRequests,
            'shibbolethAttributes' => $shibbolethAttributes,
        ]);
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'demande_ids' => 'required|array',
            'status' => 'required|string'
        ]);
        $demandeIds = $request->input('demande_ids');
        $status = $request->input('status');
        Post::whereIn('id', $demandeIds)->update(['statut' => $status]);
        
        // Récupérer les paramètres de redirection s'ils existent
        $redirectParams = $request->input('redirect_params', []);
        
        // Rediriger vers la page d'index avec les paramètres de filtrage et de pagination
        return redirect()->route('backoffice.index', $redirectParams)->with('success', 'Statut des demandes mis à jour avec succès.');
    }

    private function getShibbolethAttributes()
    {
        $attributes = [];
        
        // Liste des attributs Shibboleth que nous voulons récupérer
        $shibbolethAttrs = [
            'cn',
            'displayName',
            'eppn',
            'givenName',
            'mail',
            'postalCode',
            'primary-affiliation',
            'sn',
            'supannEmpId',
            'supannEtablissement',
            'title',
            'uid',
            'unscoped-affiliation'
        ];
        
        // Chercher les attributs avec le préfixe REDIRECT_AJP_
        foreach ($shibbolethAttrs as $attr) {
            $serverKey = 'REDIRECT_AJP_' . $attr;
            if (isset($_SERVER[$serverKey])) {
                $attributes[$attr] = $_SERVER[$serverKey];
            }
        }
        
        if (empty($attributes)) {
            $prefixes = ['AJP_', 'REDIRECT_', ''];
            
            foreach ($shibbolethAttrs as $attr) {
                foreach ($prefixes as $prefix) {
                    $serverKey = $prefix . $attr;
                    if (isset($_SERVER[$serverKey])) {
                        $attributes[$attr] = $_SERVER[$serverKey];
                        break;
                    }
                }
            }
        }
        
        if (isset($_SERVER['REMOTE_USER'])) {
            $attributes['remote_user'] = $_SERVER['REMOTE_USER'];
        } elseif (isset($_SERVER['REDIRECT_REMOTE_USER'])) {
            $attributes['remote_user'] = $_SERVER['REDIRECT_REMOTE_USER'];
        }
        
        return $attributes;
    }
}