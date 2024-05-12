<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
use App\Models\Feature;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderShipped;
use Illuminate\Support\Facades\Log;

class MainController extends Controller
{
    public function index()
    {
        $services = Service::all();
        $comments = Comment::all();
        return view('index', compact('services', 'comments'));
    }

    public function comments_validate(Request $request)
    {
        $request->validate(
            [
                'description' => 'required|string|max:255',
            ],
            [
                'description.required' => 'Поле обязательно для заполнения.',
                'description.max' => 'Максимальная длина поля отзыва составляет 255 символов.',
            ],
        );

        $comment = new Comment();

        $comment->user = Auth::id();

        $comment->description = $request->input('description');
        $comment->save();

        Log::info('Пользователь ' . Auth::user()->email . ' оставил отзыв', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'ip_address' => request()->ip(),
            'action' => 'Оставление отзыва',
        ]);

        return redirect()->back()->with('success', 'Вы оставили отзыв');
    }

    public function object($id)
    {
        $service = Service::findOrFail($id);
        $services = Service::all()->where('id', '!=', $id);
        return view('object', compact('services', 'service'));
    }

    public function create_order_validate(Request $request)
    {
        $request->validate(
            [
                'square' => 'required|numeric|min:30|max:999',
                'service' => 'required',
                'date' => 'required|date',
                'phone' => 'required|min:11|max:11',
                'address' => 'required',
            ],
            [
                'square.required' => 'Поле обязательно для заполнения',
                'square.numeric' => 'Поле должно быть числом',
                'square.min' => 'Минимальное значение поля - 30',
                'square.max' => 'Максимальное значение поля - 999',
                'service.required' => 'Поле обязательно для выбора',
                'date.required' => 'Поле обязательно для заполнения',
                'date.date' => 'Поле должно быть датой',
                'phone.required' => 'Поле обязательно для заполнения',
                'phone.max' => 'Поле не должно превышать 11 символов',
                'phone.min' => 'Поле не должно быть меньше 11 символов',
                'address.required' => 'Поле обязательно для заполнения',
            ],
        );
        $service_work_time = $request->input('service_work_time');
        $square = $request->input('square');
        $serviceName = $request->input('service');
        $date = $request->input('date');
        $phone = $request->input('phone');
        $address = $request->input('address');
        $is_time_busy = Order::whereDate('start_time', $date)
            ->where(function ($query) use ($request, $service_work_time) {
                $query
                    ->where(function ($query) use ($request, $service_work_time) {
                        $query->whereTime('start_time', '<=', $request->input('time'))->whereTime('start_time', '>=', date('H:i:s', strtotime($request->input('time') . ' - ' . $service_work_time . ' minutes')));
                    })
                    ->orWhere(function ($query) use ($request, $service_work_time) {
                        $query->whereTime('start_time', '<=', date('H:i:s', strtotime($request->input('time') . ' + ' . $service_work_time . ' minutes')))->whereTime('start_time', '>=', $request->input('time'));
                    });
            })
            ->exists();

        if ($is_time_busy) {
            return redirect()->back()->with('error', 'Выбранное время уже занято. Пожалуйста, выберите другое время.');
        }
        $service = Service::where('cost', $serviceName)->first();
        $service_work_time = Service::where('work_time', $serviceName)->first();

        $cost = $square * $service->cost;
        $work_time = ($square * $service->work_time);

        $order = new Order();
        $order->square = $square;
        $order->service = $service->id;
        $order->cost = $cost;
        $order->work_time = $work_time;
        $order->phone = $phone;
        $order->address = $address;
        $order->status = 1;
        $order->user = Auth::id();
        $order->start_time = date('Y-m-d H:i:s', strtotime($date . ' ' . $request->input('time')));

        $end_time = date('Y-m-d H:i:s', strtotime($order->start_time . ' + ' . $work_time . ' minutes'));
        $order->end_time = $end_time;

        $order->save();

        $user = Auth::user();
        Log::info('Пользователь ' . $user->email . ' создал заказ на услугу ' . $serviceName, [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'ip_address' => request()->ip(),
            'action' => 'Создание заказа',
        ]);
        $user->notify(new OrderShipped($order));

        return redirect()->back()->with('success', 'Вы сделали заказ');
    }
}
