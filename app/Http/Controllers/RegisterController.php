<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create()
    {
        return view('auth.register');
    }


    public function store(Request $request)
    {

        $data = request()->validate([
            'name' => ['required','min:3'],
            'email'      => ['required', 'email'],
            'password'   => ['required', Password::min(6), 'confirmed']
        ]);

        $user = User::create($data);


        Auth::login($user);

        return redirect('/');
    }
}
