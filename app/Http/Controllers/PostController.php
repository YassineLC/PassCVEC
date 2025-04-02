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
            
            // Modification des règles de validation en fonction du statut de résidence
            if ($request->input('resident_crous') === 'oui') {
                unset($rules['cvec']);
            }
            
            $messages = $postRequest->messages();

            // Validation des données
            $validator = Validator::make($request->all(), $rules, $messages);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            // Validation spécifique pour le fichier PDF 'cvec' uniquement pour les non-résidents
            if ($request->input('resident_crous') === 'non') {
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
                $ine = $matches[0] ?? null;
                if ($request->ine != $ine) {
                    throw ValidationException::withMessages(['ine' => 'Le numéro INE fourni n\'est pas valide.']);
                }
            }

            // Traitement de la résidence
            $isInResidence = $request->input('resident_crous') === 'oui';

            // Préparation des données pour l'insertion
            $data = $request->only(['nom', 'prenom', 'ine', 'email', 'adresse', 'code_postal', 'ville', 'numero_chambre']);
            $data['is_in_residence'] = $isInResidence;
            $data['is_sub_to_newsletter'] = !$request->has('newsletter');
            if ($request->residence) {
                $data['residence'] = $request->residence;
            }
            $data['statut'] = 'A traiter';  // Ajout du statut par défaut

            // Insertion des données
            $post = new Post;
            $post->fill($data);
            $post->save();

            $data['demande_id'] = $post->id;

            // Gestion des pièces jointes
            $this->handleAttachments($request, $post);

            // Envoi de la confirmation par email
            Mail::to($data['email'])->send(new ConfirmationMail($data));

            // Nettoyage explicite de la session et ajout du message de succès
            $request->session()->forget(['_old_input', 'errors']);
            $request->session()->flash('success', 'Votre demande a bien été enregistrée. Un email de confirmation vous a été envoyé.');

            // Redirection vers la page du formulaire
            return redirect()->route('form');
        } catch (ValidationException $e) {
            return back()->withErrors($e->validator->errors())->withInput();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Une erreur est survenue lors de l\'enregistrement de votre demande.'])->withInput();
        }
    }

    private function handleAttachments(Request $request, Post $post)
    {
        try {
            // On ne valide que les règles applicables en fonction du statut de résidence
            $attachmentRules = (new PostRequest)->attachment_rules();
            if ($post->is_in_residence) {
                unset($attachmentRules['cvec']);
            }
            
            $validator = Validator::make($request->all(), $attachmentRules);
            if ($validator->fails()) {
                throw new ValidationException($validator);
            }

            foreach ($request->file() as $key => $file) {
                if (!$file || ($key === 'cvec' && $post->is_in_residence)) {
                    continue;
                }

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

                // Assurons-nous que le dossier existe
                $storage_path = storage_path("app/documents/{$folder}");
                if (!file_exists($storage_path)) {
                    mkdir($storage_path, 0755, true);
                }

                $filename = "{$post->id}_{$key}.{$file->getClientOriginalExtension()}";
                $path = $file->storeAs("documents/{$folder}", $filename, 'local');

                $attachment = new Attachment;
                $attachment->pass_cvec_request_id = $post->id;
                $attachment->type = $key;
                $attachment->filename = "{$post->nom}_{$post->prenom}_{$key}.{$file->getClientOriginalExtension()}";
                $attachment->path = "{$folder}/{$filename}";
                $attachment->save();
            }
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            \Log::error("Erreur lors du traitement des pièces jointes: " . $e->getMessage());
            throw $e;
        }
    }
}