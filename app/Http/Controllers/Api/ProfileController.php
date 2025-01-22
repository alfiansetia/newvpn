<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function general(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'name'      => 'required|max:25|min:3',
            'gender'    => 'in:male,female',
            'phone'     => 'required|max:15|min:9|regex:/^\+?[0-9#_]{7,15}$/',
            'address'   => 'required|max:100|min:3',
        ]);
        $user->Update([
            'name'     => $request->name,
            'gender'   => $request->gender,
            'phone'    => $request->phone,
            'address'  => $request->address,
        ]);
        return $this->send_response('Success Update Profile!');
    }

    public function social(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'instagram' => 'required|max:30|min:3',
            'facebook'  => 'required|max:30|min:3',
            'linkedin'  => 'required|max:30|min:3',
            'github'    => 'required|max:30|min:3',
        ]);
        $user->Update([
            'instagram' => $request->instagram,
            'facebook'  => $request->facebook,
            'linkedin'  => $request->linkedin,
            'github'    => $request->github,
        ]);
        return $this->send_response('Success Update Profile!');
    }

    public function password(Request $request)
    {
        $user = auth()->user();
        $this->validate($request, [
            'password'  => ['required', 'same:password_confirmation', Password::min(8)->numbers()],
            'password_confirmation' => 'required',
        ]);
        if (Hash::check($request->password, $user->password)) {
            return $this->send_response_unauthorize("Password can't be the same as before!");
        }
        $user = $user->Update([
            'password'     => Hash::make($request->password),
        ]);
        return $this->send_response('Success Update Password!');
    }
}
