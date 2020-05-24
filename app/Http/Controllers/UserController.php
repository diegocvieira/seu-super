<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Validator;

class UserController extends Controller
{
    public function registerIndex()
    {
        return view('user.register');
    }

    public function register(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users',
            'password' => 'confirmed|min:8',
            'name' => 'required|max:255'
        ]);

        if ($validate->fails()) {
            $data['success'] = false;
            $data['message'] = $validate->errors()->first();

            return response()->json($data);
        }

        try {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);

            $this->login($request);

            $data['success'] = true;
            $data['route'] = route('home');
            session()->flash('session_flash', 'Cadastro realizado com sucesso!');
        } catch (\Throwable $th) {
            $data['success'] = false;
            $data['message'] = _defaultErrorMessage();
        }

        return response()->json($data);
    }

    public function loginIndex()
    {
        return view('user.login');
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {
            $data['success'] = true;
            $data['route'] = route('home');
        } else {
            $data['success'] = false;
            $data['message'] = 'Não identificamos o e-mail e/ou a senha que você informou.';
        }

        return response()->json($data);
    }
}
