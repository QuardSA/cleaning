<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class AuthorizationController extends Controller

{
    public function signup_validation(Request $request)
    {
        $request->validate([
            'name' => 'required|alpha|max:100',
            'surname' => 'required|alpha|max:100',
            'lastname' => 'required|alpha|max:100',
            'email' => 'required|email|max:100|unique:users,email,',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ], [
            'name.required' => 'Поле обязательно для заполнения',
            'name.alpha' => 'Поле должно состоять только из букв',
            'name.max' => 'Поле не должно превышать 100 символов',
            'surname.required' => 'Поле обязательно для заполнения',
            'surname.alpha' => 'Поле должно состоять только из букв',
            'surname.max' => 'Поле не должно превышать 100 символов',
            'lastname.required' => 'Поле обязательно для заполнения',
            'lastname.alpha' => 'Поле должно состоять только из букв',
            'lastname.max' => 'Поле не должно превышать 100 символов',
            'email.required' => 'Поле обязательно для заполнения',
            'email.email' => 'Поле должно быть корректным адресом электронной почты',
            'email.max' => 'Поле не должно превышать 100 символов',
            'email.unique' => 'Пользователь с таким "Email" уже существует',
            'password.required' => 'Поле обязательно для заполнения',
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

        if ($userCreate) {
            Log::info('Пользователь ' . $userCreate->email . 'Регистрация', [
                'user_id' => $userCreate->id,
                'user_email' => $userCreate->email,
                'ip_address' => $request->ip(),
                'action' => 'Регистрация',
            ]);
            Auth::login($userCreate);
            return redirect()->back()->with('success', 'Вы зарегистрировались');
        } else {
            return redirect()->back()->with('error', 'Ошибка регистрации');
        }
    }


    public function signin_validation(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Поле обязательно для заполнения',
            'email.email' => 'Введите корректный Email',
            'password.required' => 'Поле обязательно для заполнения',
        ]);

        $user_authorization = $request->only("email", "password");

        if (Auth::attempt(['email' => $user_authorization['email'], 'password' => $user_authorization['password']])) {
            Log::info('Пользователь ' . Auth::user()->email . 'Вход в систему', [
                'user_id' => Auth::user()->id,
                'user_email' => Auth::user()->email,
                'ip_address' => $request->ip(),
                'action' => 'Вход в систему',
            ]);
            if (Auth::user()->role == 2) {
                return redirect('/admin')->with('success', 'Вы вошли как Администратор');
            } elseif (Auth::user()->role == 3) {
                return redirect()->back()->with('success', 'Вы вошли как Менеджер');
            } else {
                return redirect()->back()->with('success', 'Добро пожаловать');
            }
        } else {
            return redirect()->back()->with('error', 'Ошибка авторизации');
        }
    }

    public function signout(Request $request)
    {
        $user = Auth::user();
        Session::flush();
        Auth::logout();
        if ($user) {
            Log::info('Пользователь ' . $user->email . 'Выход из системы', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'ip_address' => $request->ip(),
                'action' => 'Выход из системы',
            ]);
        }

        return redirect('/')->with('success', 'Вы вышли из аккаунта');
    }
}
