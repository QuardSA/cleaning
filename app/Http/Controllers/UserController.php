<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function personal(){
        $user = Auth::user();
        $orders = $user->user_order()->paginate(2);
        return view('personal', compact('orders'));
    }

    public function profile(){
        return view('profile');
    }

    public function update_profile(Request $request){
        $request->validate([
            'name' => 'required|alpha|max:100',
            'surname' => 'required|alpha|max:100',
            'lastname' => 'nullable|alpha|max:100',
            'email' => 'required|string|email|max:100|unique:users,email,' . Auth::user()->id,
        ], [
            'name.required' => 'Поле обязательно для заполнения',
            'name.string' => 'Поле должно состоять только из букв',
            'name.max' => 'Поле не должно превышать 100 символов',
            'surname.required' => 'Поле обязательно для заполнения',
            'surname.string' => 'Поле должно состоять только из букв',
            'surname.max' => 'Поле не должно превышать 100 символов',
            'lastname.string' => 'Поле должно состоять только из букв',
            'lastname.max' => 'Поле не должно превышать 100 символов',
            'email.required' => 'Поле обязательно для заполнения',
            'email.email' => 'Поле должно быть корректным адресом электронной почты',
            'email.max' => 'Поле не должно превышать 100 символов',
            'email.unique' => 'Пользователь с таким "Email" уже существует',
        ]);
        $user = Auth::user();
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->save();
        if ($user->save()){
            return redirect()->back()->with('success', 'Данные успешно изменены');
        }else{
            return redirect()->back()->with('error', 'Ошибка изменения данных');
        }

    }
}
