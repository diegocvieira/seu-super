<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use Mail;
use App\Mail\SendMailContact;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        if ($validate->fails()) {
            $data['success'] = false;
            $data['message'] = $validate->errors()->first();

            return response()->json($data);
        }

        try {
            Mail::send(new SendMailContact($request));

            $data['success'] = true;
            $data['message'] = 'Mensagem enviada com sucesso!';
        } catch (\Throwable $th) {
            $data['success'] = false;
            $data['message'] = _defaultErrorMessage();
        }

        return response()->json($data);
    }
}
