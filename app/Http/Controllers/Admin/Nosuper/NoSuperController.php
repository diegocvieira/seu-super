<?php

namespace App\Http\Controllers\Admin\Nosuper;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Models\Nosuper;

class NoSuperController extends Controller
{
    public function index()
    {
        return view('admin.nosuper.index');
    }

    public function loginIndex()
    {
        return view('admin.nosuper.login');
    }

    public function login(Request $request)
    {
        if (Auth::guard('nosuper')->attempt(['email' => $request->email, 'password' => $request->password], true)) {
            return redirect()->route('nosuper.index');
        } else {
            session()->flash('session_flash', 'Não identificamos o e-mail e/ou a senha que você informou.');

            return redirect()->back();
        }
    }

    public function logout()
    {
        Auth::guard('nosuper')->logout();

        return redirect()->route('home');
    }
}
