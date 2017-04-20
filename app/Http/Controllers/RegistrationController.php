<?php

namespace App\Http\Controllers;

use App\User;
use App\Mail\Welcome;
use Illuminate\Http\Request;
use App\Http\Requests\RegistrationRequest;

class RegistrationController extends Controller
{
    public function create()
    {
    	return view('registration.create');
    }

    public function store(RegistrationRequest $request)
    {
    	$user = User::create(
    		request(['name', 'email', 'password'])
    	);

    	auth()->login($user);

        \Mail::to($user)->send(new Welcome($user));

        session()->flash('message', 'Thank you so much for signing up!');

    	return redirect()->home();
    }
}
