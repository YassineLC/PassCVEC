<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BackOfficeController extends Controller
{
    public function index(Request $request) {
        $query = Post::query();

        // Filtres
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

        // Pagination
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

        return redirect()->route('backoffice.index')->with('success', 'Statut des demandes mis à jour avec succès.');
    }
}
