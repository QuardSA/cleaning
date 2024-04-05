<?php

namespace App\Http\Controllers;

use App\Models\Mailing;
use Illuminate\Http\Request;

class MailingController extends Controller

{
    public function mailing_validation(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:mailings|email'
        ], [
            'email.required' => 'Поле обязательно для заполнения',
            'email.unique' => 'Данный email уже подписан',
            'email.email' => 'Введите корректный email',
        ]);

        $mailingInfo = $request->all();
        $mailingCreate = Mailing::create([
            'email' => $mailingInfo['email'],
        ]);

        if ($mailingCreate) {
            return redirect()->back()->with('success', 'Вы подписались на рассылку!');
        } else {
            return redirect()->back()->with('error', 'Что-то пошло не так');
        }
    }
}
