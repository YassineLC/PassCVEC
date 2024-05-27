<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'nom' => ['required'],
            'prenom' => ['required'],
            'ine' => ['required', 'unique:pass_cvec_requests'],
            'email' => ['required', 'string', 'unique:pass_cvec_requests', 'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'],
            'adresse' => ['required'],
            'scolarite' => ['required', 'mimes:pdf']
        ];
    }

    public function attachment_rules() {
        return [
            'scolarite' => ['required', 'mimes:pdf'],
            'cvec' => ['required', 'mimes:pdf']
        ];
    }

    public function messages() {
        return [
            'nom.required' => 'Le nom est requis.',
            'prenom.required' => 'Le prénom est requis.',
            'ine.required' => 'L\'INE est requis.',
            'ine.unique' => 'Ce numéro INE est déjà utilisé.',
            'email.required' => 'L\'email est requis.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'email.regex' => 'Le format de l\'email est invalide.',
            'adresse.required' => 'L\'adresse est requise.',
            'scolarite.required' => 'Le certificat de scolarité est requis.',
            'scolarite.mimes' => 'Le certificat de scolarité doit être un fichier PDF.',
            'cvec.required' => 'L\'attestation de paiement CVEC est requise.',
            'cvec.mimes' => 'L\'attestation de paiement CVEC doit être un fichier PDF.'
        ];
    }

}
