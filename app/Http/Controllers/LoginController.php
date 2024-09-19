<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        return view('auth.login');
    }


    public function store(Request $request)
    {
        $credentials = request()->validate(
            [
                'email' => [
                    'required',
                    'email',
                    'regex:/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', // Regex za validaciju emaila sa tačkom nakon domena
                ],
                'password' => ['required']
            ],
                [
                    'email.regex' => 'The email must be a valid format (e.g., name@example.com) and must include a dot (.) after the domain.', // Poruka za regex
                    'email.email' => 'Please enter a valid email address.', // Poruka za osnovnu email validaciju
                ]
        );

        if (! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => 'Sorry, those credentials do not match.',
                'password' => 'Sorry, those credentials do not match.'
            ]);
        }

        request()->session()->regenerate();

        return redirect('/movies');
    }


    public function destroy()
    {
        Auth::logout();

        return redirect('login/create');
    }
}
