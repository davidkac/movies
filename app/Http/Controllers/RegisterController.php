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
        $data = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => [
                'required',
                'email',
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
                'unique:users,email', // Provera da li email već postoji u bazi
            ],
            'password' => [
                'required',
                Password::min(8)
                    ->numbers(),
                'confirmed'
            ]
        ], [
            // Prilagođene poruke za greške
            'email.regex' => 'The email must be a valid format (e.g., name@example.com) and must include a dot (.) after the domain.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already in use.', // Poruka kada email već postoji
        ]);


        $user = User::create($data);


        Auth::login($user);

        return redirect('/movies');
    }
}
