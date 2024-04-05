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
            'name' => 'required|alpha',
            'surname' => 'required|alpha',
            'lastname' => 'required|alpha',
            'email' => 'required|unique:users|email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ],[
            'email.required' => 'Поле обязательно для заполнения',
            'email.email' => 'Введите email',
            'email.unique' => 'Данный email уже занят',
            'name.required' => 'Поле обязательно для заполнения',
            'name.alpha' => 'Имя должно состоять только из букв',
            'lastname.required' => 'Поле обязательно для заполнения',
            'lastname.alpha' => 'Отчество должно состоять только из букв',
            'surname.required' => 'Поле обязательно для заполнения',
            'surname.alpha' => 'Фамилия должна состоять только из букв',
            'password.required' => 'Поле обязательно для заполнения',
            'confirm_password.required' => 'Поле обязательно для заполнения',
            'confirm_password.same' => 'Пароли не совпадают',
        ]);

        $userInfo = $request->all();
        $userCreate = User::create([
            'name'=> $userInfo['name'],
            'surname'=> $userInfo['surname'],
            'lastname'=> $userInfo['lastname'],
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
            'email' => 'required',
            'password' => 'required',
        ],[
            'email.required' => 'Поле обязательно для заполнения',
            'password.required' => 'Поле обязательно для заполнения',
        ],
    );

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
