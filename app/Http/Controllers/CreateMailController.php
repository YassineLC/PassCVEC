<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Mail\Newsletter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CreateMailController extends Controller
{
    public function index() {
        return view('backoffice.create');
    }

    public function send(Request $request) {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
        ]);

        $subscribers = Post::newsletterSubscribers();

        foreach($subscribers as $subscriber) {
            Mail::to($subscriber)->send(new Newsletter($data['title'], $data['body']));
        }

        return back()->with('success', 'Le mail a bien été envoyé');
    }
}
