<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index');
    }

    public function store(Request $request)
    {
        $validateData = $request->validate([
            'username' => ['required', 'min:5', 'max:15', 'unique:users'],
            'name' => 'required|max:255',
            'phone' => ['required', 'regex:/^[0-9]{11,}$/'],
            'password' => 'required|min:5|max:255',
            'confirm_password' => 'required|same:password',
        ]);

        if (substr($validateData['phone'], 0, 1) !== '0') {
            $validateData['phone'] = '0' . $validateData['phone'];
        }
        
        $validateData['role_id'] = 3;
        $validateData['password'] = Hash::make($validateData['password']);

        User::create($validateData);

        return redirect('/login')->with('success', 'Registration Successfull! Please Login');
    }
}
