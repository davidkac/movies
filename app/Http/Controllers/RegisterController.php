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
                'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', // Regex za validaciju emaila sa tačkom nakon domena
            ],
            'password' => [
                'required',
                Password::min(8)
                    ->numbers(),
                'confirmed'
            ]
        ], [
            // Prilagođene poruke za greške
            'email.regex' => 'The email must be a valid format (e.g., name@example.com) and must include a dot (.) after the domain.', // Poruka za regex
            'email.email' => 'Please enter a valid email address.', // Poruka za osnovnu email validaciju
        ]);

        $user = User::create($data);


        Auth::login($user);

        return redirect('/movies');
    }
}
