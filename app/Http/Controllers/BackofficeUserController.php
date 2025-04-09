<?php

namespace App\Http\Controllers;

use App\Models\BackofficeUser;
use Illuminate\Http\Request;

class BackofficeUserController extends Controller
{
    public function index()
    {
        $users = BackofficeUser::where('is_active', false)
            ->orderBy('last_login_at', 'desc')
            ->paginate(20);
            
        // Récupérer les attributs Shibboleth
        $shibbolethAttributes = $this->getShibbolethAttributes();

        return view('backoffice.users.index', compact('users', 'shibbolethAttributes'));
    }

    public function activate($id)
    {
        $user = BackofficeUser::findOrFail($id);
        $user->is_active = true;
        $user->save();

        return redirect()->route('backoffice.users.index')
            ->with('success', 'L\'utilisateur a été activé avec succès.');
    }

    public function deactivate($id)
    {
        $user = BackofficeUser::findOrFail($id);
        $user->is_active = false;
        $user->save();

        return redirect()->route('backoffice.users.index')
            ->with('success', 'L\'utilisateur a été désactivé avec succès.');
    }
    
    /**
     * Récupère les attributs Shibboleth
     */
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