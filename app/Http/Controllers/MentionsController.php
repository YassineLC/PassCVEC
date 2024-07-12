<?php

namespace App\Http\Controllers;

class MentionsController extends Controller
{
    public function index() {
        return view('mentions-legales');
    }
}
