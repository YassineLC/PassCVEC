<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Attachment; // Importer le modèle Attachment
use App\Http\Resources\PostResource;
use App\Http\Resources\AttachmentResource; // Importer la ressource AttachmentResource

class PostApiController extends Controller
{
    // Récupérer tous les posts
    public function index()
    {
        $posts = Post::all();

        if ($posts->isEmpty()) {
            return response()->json(['message' => 'No posts found'], 404);
        }

        return PostResource::collection($posts);
    }

    // Récupérer un post spécifique avec les données des pièces jointes
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $attachments = Attachment::where('post_id', $id)->get();

        $postResource = new PostResource($post);
        $postResource->attachments = AttachmentResource::collection($attachments); // Inclure les données des pièces jointes

        return $postResource;
    }

    // Mettre à jour un post existant
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $post->nom = $request->nom;
        $post->prenom = $request->prenom;
        $post->ine = $request->ine;
        $post->email = $request->email;
        $post->adresse = $request->adresse;
        $post->save();

        return new PostResource($post);
    }

    // Supprimer un post
    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return response()->json(['message' => 'Post deleted successfully']);
    }
}
