<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\LogementController;
use App\Http\Controllers\PDFCheckController;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    protected $logementController;

    public function __construct(LogementController $logementController, PDFCheckController $pdfCheckController)
    {
        $this->logementController = $logementController;
        $this->pdfCheckController = $pdfCheckController;
    }

    public function index()
    {
        $logements = $this->logementController->index();
        return view('cvec-post-form', ['logements' => $logements]);
    }

    // Méthode pour traiter la soumission du formulaire de création de post
    public function store(Request $request)
    {
        try {
            $validator = \Validator::make($request->all(), (new PostRequest)->rules(), (new PostRequest)->messages());

            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            $this->validate($request, (new PostRequest)->rules());

            /* //Vérification de la validité du certificat CVEC
            $pdfFile = $request->file('cvec');

            // Vérifiez si le fichier PDF a été correctement téléchargé
            if (!$pdfFile) {
                throw ValidationException::withMessages(['cvec' => 'Veuillez soumettre un fichier PDF valide.']);
            }

            // Obtenez le chemin temporaire du fichier PDF
            $pdfFilePath = $pdfFile->path();

            $apiResponse = $this->pdfCheckController->checkCVEC($pdfFilePath);

            if (!$apiResponse) {
                throw ValidationException::withMessages(['cvec' => 'Le certificat CVEC soumis n\'est pas valide.']);
            }

            $ine = $apiResponse['ine'];
            if ($request->ine != $ine) {
                throw ValidationException::withMessages(['ine' => 'Le numéro INE fourni n\' est pas valide.']);
            } */
            //TODO : Revoir la vérification de la validité du certificat CVEC

            $is_in_residence = $request->input('is_in_residence') === 'true' ? true : false;

            $post = new Post;
            $post->nom = $request->nom;
            $post->prenom = $request->prenom;
            $post->ine = $request->ine;
            $post->email = $request->email;
            $post->adresse = $request->adresse;
            $post->is_in_residence = $is_in_residence;
            if ($request->residence) {
                $post->residence = $request->residence;
            }
            $post->save();

            // Gérer les pièces jointes et les enregistrer dans la base de données
            $this->handleAttachments($request, $post);

            return back()->with('success', 'La demande a bien été enregistrée.');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();
            return back()->withErrors($errors)->withInput();
        }
    }

    // Cette méthode a pour but de gérer la soumission des pièces jointes dans le formulaire
    private function handleAttachments(Request $request, Post $post)
    {
        try {
            $this->validate($request, (new PostRequest)->attachment_rules());

            foreach ($request->file() as $key => $file) {
                // Déterminer le dossier de destination en fonction du type de pièce jointe
                switch ($key) {
                    case 'scolarite':
                        $folder = 'scolarite';
                        break;
                    case 'cvec':
                        $folder = 'cvec';
                        break;
                    default:
                        $folder = 'autre';
                        break;
                }

                $path = $file->storeAs("{$folder}", "{$post->nom}_{$post->prenom}_{$key}.{$file->getClientOriginalExtension()}", 'local_custom');

                $attachment = new Attachment;
                $attachment->pass_cvec_request_id = $post->id;
                $attachment->type = $key;
                $attachment->filename = "{$post->nom}_{$post->prenom}_{$key}.{$file->getClientOriginalExtension()}";
                $attachment->path = $path;
                $attachment->save();
            }
        } catch (ValidationException $e) {
            throw $e;
        }
    }

}

