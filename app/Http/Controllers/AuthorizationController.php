<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthorizationController extends Controller

{
    public function signup_validation(Request $request){

        $request->validate([
            'name' => 'required|alpha|max:100',
            'surname' => 'required|alpha|max:100',
            'lastname' => 'nullable|alpha|max:100',
            'email' => 'required|string|email|max:100|unique:users,email,',
            'password' => 'nullable|min:8',
            'confirm_password' => 'required|same:password',
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
            'password.min' => 'Пароль должен содержать как минимум 8 символов',
            'confirm_password.required' => 'Поле обязательно для заполнения',
            'confirm_password.same' => 'Пароли не совпадают',
        ]);

        $userInfo = $request->all();
        $userCreate = User::create([
            'name' => $userInfo['name'],
            'surname' => $userInfo['surname'],
            'lastname' => $userInfo['lastname'],
            'email' => $userInfo['email'],
            'password' => Hash::make($userInfo['password']),
            'role' => "1",
        ]);

        if($userCreate){
            Auth::login($userCreate);
            return redirect()->back()->with('success','Вы зарегистрировались');
        }else{
            return redirect()->back()->with('error','Ошибка регистрации');
        }
    }

    public function signin_validation(Request $request){

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ],[
            'email.required' => 'Поле обязательно для заполнения',
            'email.email' => 'Введите корректный Email',
            'password.required' => 'Поле обязательно для заполнения',
        ]);

        $user_authorization = $request->only("email","password");

        if(Auth::attempt(['email' => $user_authorization['email'], 'password' => $user_authorization['password']])){
            if(Auth::user()->role == 2) {
                return redirect('/admin/index')->with('success','Вы вошли как Администратор');
            }else{
                return redirect()->back()->with('success','Добро пожаловать');
            }
        }else{
            return redirect()->back()->with('error','Ошибка авторизации');
        }
    }

    public function signout(){
        Session::flush();
        Auth::logout();
        return redirect('/')->with('success','Вы вышли из аккаунта');
    }
}
