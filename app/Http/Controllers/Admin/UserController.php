<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\District;
use App\Models\Address;
use Auth;
use Validator;
use Hash;
use App\Models\Order;

class UserController extends Controller
{
    public function dataIndex()
    {
        $user = User::findOrFail(Auth::user()->id);

        $navigation = 'data';

        return view('admin.user.data', compact('user', 'navigation'));
    }

    public function dataSave(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'cellphone' => 'required|max:17',
            'telephone' => 'max:17',
            'birthdate' => 'required|date_format:"d/m/Y"',
            'gender' => 'required|boolean',
            'cpf_cnpj' => 'required|max:20',
            'rg' => 'required|max:10'
        ]);

        if ($validate->fails()) {
            $data['message'] = $validate->errors()->first();
            return response()->json($data);
        }

        try {
            User::findOrFail(Auth::user()->id)->update([
                'name' => $request->name,
                'cellphone' => _removeNonNumericCharacters($request->cellphone),
                'telephone' => _removeNonNumericCharacters($request->telephone),
                'birthdate' => _formatDateToDB($request->birthdate),
                'gender' => $request->gender,
                'cpf_cnpj' => _removeNonNumericCharacters($request->cpf_cnpj),
                'rg' => $request->rg
            ]);

            $data['message'] = 'Informações atualizadas com sucesso!';
        } catch (\Throwable $th) {
            $data['message'] = _defaultErrorMessage();
        }

        return response()->json($data);
    }

    public function accessIndex()
    {
        $user = User::findOrFail(Auth::user()->id);

        $navigation = 'access';

        return view('admin.user.access', compact('user', 'navigation'));
    }

    public function accessSave(Request $request)
    {
        $userId = Auth::user()->id;
        $password = $request->password;
        $passwordCurrent = $request->password_current;
        $email = $request->email;
        $emailCurrent = $request->email_current;

        if (!$email && !$password && !$emailCurrent && !$passwordCurrent) {
            $data['message'] = 'Atualize seu e-mail e/ou senha.';
            return response()->json($data);
        }

        if ($email || $emailCurrent) {
            $rules['email'] = 'required|confirmed|max:100|unique:users,email,' . $userId;
            $update['email'] = $email;

            if ($emailCurrent != Auth::user()->email) {
                $data['message'] = 'O e-mail atual não confere.';
                return response()->json($data);
            }
        }

        if ($password || $passwordCurrent) {
            $rules['password'] = 'required|confirmed|min:8';
            $update['password'] = bcrypt($password);

            if (!Hash::check($passwordCurrent, Auth::user()->password)) {
                $data['message'] = 'A senha atual não confere.';
                return response()->json($data);
            }
        }

        $validate = Validator::make($request->all(), $rules);

        if ($validate->fails()) {
            $data['message'] = $validate->errors()->first();
            return response()->json($data);
        }

        try {
            User::findOrFail($userId)->update($update);

            $data['message'] = 'Informações atualizadas com sucesso!';
        } catch (\Throwable $th) {
            $data['message'] = _defaultErrorMessage();
        }

        return response()->json($data);
    }

    public function addressesIndex()
    {
        $user = User::with('addresses')->findOrFail(Auth::user()->id);

        $navigation = 'addresses';

        $districts = District::orderBy('name', 'ASC')->get();

        return view('admin.user.addresses', compact('user', 'navigation', 'districts'));
    }

    public function addressesSave(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'cep' => 'required|min:9|max:9',
            'district_id' => 'required|numeric',
            'street' => 'required|max:150',
            'number' => 'required|max:20',
            'complement' => 'max:200'
        ]);

        if ($validate->fails()) {
            $data['message'] = $validate->errors()->first();
            return response()->json($data);
        }

        try {
            Address::updateOrCreate(['user_id' => Auth::user()->id], [
                'cep' => _removeNonNumericCharacters($request->cep),
                'street' => $request->street,
                'number' => $request->number,
                'district_id' => $request->district_id,
                'complement' => $request->complement
            ]);

            $data['message'] = 'Informações atualizadas com sucesso!';
        } catch (\Throwable $th) {
            $data['message'] = _defaultErrorMessage();
        }

        return response()->json($data);
    }

    public function orders()
    {
        $orders = Order::with('market')
            ->where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'DESC')
            ->get();

        $navigation = 'orders';

        return view('admin.user.orders', compact('orders', 'navigation'));
    }

    public function orderDetails($code)
    {
        $order = Order::with('market', 'products')
            ->where('code', $code)
            ->where('user_id', Auth::user()->id)
            ->firstOrFail();

        $navigation = 'orders';

        return view('admin.user.order-details', compact('order', 'navigation'));
    }

    public function deleteAccount(Request $request)
    {
        if (!Hash::check($request->password, Auth::user()->password)) {
            $data['success'] = false;
            return response()->json($data);
        }

        try {
            User::findOrFail(Auth::user()->id)->delete();

            $this->logout();

            $data['success'] = true;
            $data['route'] = route('home');

            session()->flash('session_flash', 'A sua conta foi removida!');
        } catch (\Throwable $th) {
            $data['success'] = false;
        }

        return response()->json($data);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('home');
    }
}
