<?php

namespace App\Http\Controllers;

use App\User;
use App\Mail\Welcome;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function create()
    {
    	return view('registration.create');
    }

    public function store()
    {
    	$this->validate(request(), [
    		'name' => 'required',
    		'email' => 'required|email',
    		// confirmed means to match up with a name _confirmation
    		// in our case, this is password_confirmation_field
    		'password' => 'required|confirmed'
    	]);

    	$user = User::create(
    		request(['name', 'email', 'password'])
    	);

    	auth()->login($user);

        \Mail::to($user)->send(new Welcome($user));

    	return redirect()->home();
    }
}
