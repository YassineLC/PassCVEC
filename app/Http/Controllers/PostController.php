<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Attachment;
use Jenssegers\Agent\Agent;
use Illuminate\Http\Request;
use App\Mail\ConfirmationMail;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\LogementController;
use App\Http\Controllers\PDFCheckController;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    protected $logementController;
    protected $pdfCheckController;
    protected $agent;

    public function __construct(LogementController $logementController, PDFCheckController $pdfCheckController, Agent $agent)
    {
        $this->logementController = $logementController;
        $this->pdfCheckController = $pdfCheckController;
        $this->agent = $agent;
    }

    public function index()
    {
        $logements = $this->logementController->index();
        if ($this->agent->isMobile()) {
            return view('cvec-post-form-mobile', ['logements' => $logements]);
        } else {
            return view('cvec-post-form', ['logements' => $logements]);
        }
    }

    public function store(Request $request)
    {
        try {
            // Récupération des règles et messages de validation
            $postRequest = new PostRequest();
            $rules = $postRequest->rules();
            $messages = $postRequest->messages();

            // Validation des données
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Validation spécifique pour le fichier PDF 'cvec'
            $pdfFile = $request->file('cvec');
            if (!$pdfFile) {
                throw ValidationException::withMessages(['cvec' => 'Veuillez soumettre un fichier PDF valide.']);
            }

            // Vérification du contenu du fichier PDF via API
            $pdfFilePath = $pdfFile->path();
            $apiResponse = $this->pdfCheckController->checkCVEC($pdfFilePath);
            if (!$apiResponse) {
                throw ValidationException::withMessages(['cvec' => 'Le certificat CVEC soumis n\'est pas valide.']);
            }

            // Extraction et vérification du numéro INE
            preg_match('/(\d{9}[A-Z]{2})/', $apiResponse['content'], $matches);
            $ine = $matches[0] ?? null; // Ajout d'une vérification de l'existence d'une correspondance
            if ($request->ine != $ine) {
                throw ValidationException::withMessages(['ine' => 'Le numéro INE fourni n\'est pas valide.']);
            }

            // Traitement de la résidence
            $isInResidence = $request->input('is_in_residence') === 'true';

            // Préparation des données pour l'insertion
            $data = $request->only(['nom', 'prenom', 'ine', 'email', 'adresse', 'code_postal', 'ville', 'numero_chambre']);
            $data['is_in_residence'] = $isInResidence;
            if ($request->residence) {
                $data['residence'] = $request->residence;
            }

            // Insertion des données
            $post = new Post;
            $post->fill($data);
            $post->save();

            // Gestion des pièces jointes
            $this->handleAttachments($request, $post);

            // Envoi de la confirmation par email
            Mail::to($data['email'])->send(new ConfirmationMail($data));

            return back()->with('success', 'La demande a bien été enregistrée.');
        } catch (ValidationException $e) {
                $errors = $e->validator->errors();
                return back()->withErrors($errors)->withInput();
            }
    }



    private function handleAttachments(Request $request, Post $post)
    {
        try {
            $this->validate($request, (new PostRequest)->attachment_rules());

            foreach ($request->file() as $key => $file) {
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

                $path = $file->storeAs("{$folder}", "{$post->id}_{$key}.{$file->getClientOriginalExtension()}", 'local_custom');

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


