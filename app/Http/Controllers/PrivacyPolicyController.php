<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PrivacyPolicyController extends Controller
{
    public function index()
    {
        $headerTitle = 'Políticas de privacidade | NoSuper';

        return view('privacy-policy', compact('headerTitle'));
    }
}
