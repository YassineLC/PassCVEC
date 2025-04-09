<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\BackofficeUser;

class ShibbolethAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Récupérer l'email de l'utilisateur depuis les attributs Shibboleth
        $email = $this->getShibbolethEmail($request);
        
        if (!$email) {
            return redirect()->route('backoffice.unauthorized')->with('error', 'Email non trouvé dans les attributs Shibboleth.');
        }

        // Récupérer ou créer l'utilisateur
        $user = $this->getOrCreateUser($email);
        
        // Si l'utilisateur n'est pas autorisé, rediriger vers la page non autorisée
        if (!$user->is_active) {
            return redirect()->route('backoffice.unauthorized')->with('error', 'Vous n\'êtes pas autorisé à accéder à cette application.');
        }
        
        return $next($request);
    }
    
    /**
     * Récupère l'email depuis les attributs Shibboleth
     */
    private function getShibbolethEmail(Request $request)
    {
        $prefixes = ['REDIRECT_AJP_', 'AJP_', 'REDIRECT_', ''];
        foreach ($prefixes as $prefix) {
            $key = $prefix . 'mail';
            if (isset($_SERVER[$key])) {
                return $_SERVER[$key];
            }
        }
        return null;
    }
    
    /**
     * Récupère ou crée un utilisateur avec les attributs Shibboleth
     */
    private function getOrCreateUser($email)
    {
        $user = BackofficeUser::where('email', $email)->first();
        
        if (!$user) {
            $user = new BackofficeUser();
            $user->email = $email;
            $user->is_active = false; // Par défaut, l'utilisateur n'est pas autorisé
            $user->last_login_at = now();
            
            // Récupérer les autres attributs Shibboleth
            $prefixes = ['REDIRECT_AJP_', 'AJP_', 'REDIRECT_', ''];
            $attributes = [
                'given_name' => 'givenName',
                'surname' => 'sn',
                'matricule' => 'supannEmpId',
                'function' => 'title',
                'affiliation' => 'primary-affiliation',
                'establishment' => 'supannEtablissement',
                'postal_code' => 'postalCode',
                'eppn' => 'eppn',
                'display_name' => 'displayName',
                'cn' => 'cn',
                'unscoped_affiliation' => 'unscoped-affiliation',
                'uid' => 'uid',
                'remote_user' => 'REMOTE_USER'
            ];
            
            foreach ($attributes as $field => $attr) {
                foreach ($prefixes as $prefix) {
                    $key = $prefix . $attr;
                    if (isset($_SERVER[$key])) {
                        $user->$field = $_SERVER[$key];
                        break;
                    }
                }
            }
            
            $user->save();
        } else {
            // Mettre à jour la dernière connexion
            $user->last_login_at = now();
            $user->save();
        }
        
        return $user;
    }
}