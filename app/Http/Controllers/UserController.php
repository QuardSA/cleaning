<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function personal()
    {
        $user = Auth::user();
        $orders = $user->user_order()->orderBy('status', 'ASC')->paginate(2);
        foreach ($orders as $order) {
            $order->formatted_work_time = $this->roundWorkTime($order->work_time);
        }
        return view('personal', compact('orders'));
    }

    private function roundWorkTime($minutes)
    {
        $hours = $minutes / 60;
        $floorHours = floor($hours);
        $decimalPart = $hours - $floorHours;

        if ($decimalPart <= 0.01) {
            return $floorHours . ' ' . $this->getCorrectHoursDeclension($floorHours);
        } elseif ($decimalPart <= 0.25) {
            return $floorHours . ' ' . $this->getCorrectHoursDeclension($floorHours);
        } elseif ($decimalPart <= 0.5) {
            return $floorHours . ' ' . $this->getCorrectHoursDeclension($floorHours) . ' 30 минут';
        } else {
            $ceilHours = ceil($hours);
            return $ceilHours . ' ' . $this->getCorrectHoursDeclension($ceilHours);
        }
    }

    private function getCorrectHoursDeclension($hours)
    {
        if ($hours % 10 == 1 && $hours % 100 != 11) {
            return 'часа';
        } elseif ($hours % 10 >= 2 && $hours % 10 <= 4 && ($hours % 100 < 10 || $hours % 100 >= 20)) {
            return 'часов';
        } else {
            return 'часов';
        }
    }

    public function profile()
    {
        return view('profile');
    }

    public function update_profile(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|alpha|max:100',
                'surname' => 'required|alpha|max:100',
                'lastname' => 'nullable|alpha|max:100',
                'email' => 'required|string|email|max:100|unique:users,email,' . Auth::user()->id,
                'current_password' => 'nullable|string|min:8',
                'new_password' => 'nullable|string|min:8|confirmed',
            ],
            [
                'name.required' => 'Поле обязательно для заполнения',
                'name.alpha' => 'Поле должно состоять только из букв',
                'name.max' => 'Поле не должно превышать 100 символов',
                'surname.required' => 'Поле обязательно для заполнения',
                'surname.alpha' => 'Поле должно состоять только из букв',
                'surname.max' => 'Поле не должно превышать 100 символов',
                'lastname.alpha' => 'Поле должно состоять только из букв',
                'lastname.max' => 'Поле не должно превышать 100 символов',
                'email.required' => 'Поле обязательно для заполнения',
                'email.email' => 'Поле должно быть корректным адресом электронной почты',
                'email.max' => 'Поле не должно превышать 100 символов',
                'email.unique' => 'Пользователь с таким "Email" уже существует',
                'current_password.min' => 'Пароль должен быть не менее 8 символов',
                'new_password.min' => 'Пароль должен быть не менее 8 символов',
                'new_password.confirmed' => 'Подтверждение пароля не совпадает',
            ],
        );

        $user = Auth::user();
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');

        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (Hash::check($request->input('current_password'), $user->password)) {
                $user->password = Hash::make($request->input('new_password'));
            } else {
                return redirect()
                    ->back()
                    ->withErrors(['current_password' => 'Текущий пароль неверен']);
            }
        }

        $user->save();

        Log::info('Пользователь ' . $user->email . ' изменил профиль', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'ip_address' => $request->ip(),
            'action' => 'Изменение профиля',
        ]);

        return redirect()->back()->with('success', 'Данные успешно изменены');
    }
}
