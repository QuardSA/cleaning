<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function personal(){
        return view('personal');
    }

    public function profile(){
        return view('profile');
    }

    public function update_profile(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'lastname' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::user()->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user = Auth::user();

        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');

        if ($request->has('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->back()->with('success', 'Данные успешно изменены');
    }
}
