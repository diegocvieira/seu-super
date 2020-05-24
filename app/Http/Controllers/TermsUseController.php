<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TermsUseController extends Controller
{
    public function index()
    {
        $headerTitle = 'Termos de uso | NoSuper';

        return view('terms-use', compact('headerTitle'));
    }
}
