<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function registerUser(Request $request)
    {
        $useExists = User::where('email', '=', $request->get('email'));
        if (!$useExists) abort(403, 'This email already exists.');

        $input = $request->all();
        $input['password'] = Hash::make($request->get('password'), [
            'rounds' => 10,
        ]);
        $newUser = User::create($input);
        $newUser->save();
        return $newUser;
    }

    public function loginUser(Request $request)
    {
        Log::debug('Showing login user.');
        $userLogged = User::where('email', '=', $request->get('email'))->get();
        if (!$userLogged) abort(403);

        if (!Hash::check($request->get('password'), $userLogged[0]->password)) {
            abort(403, 'Wrong password.');
        }

        return $userLogged;
    }

    public function findUserById($id)
    {
        return User::where('id', '=', $id)->get();
    }
}
