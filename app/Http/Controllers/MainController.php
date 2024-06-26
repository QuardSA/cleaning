<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
use App\Models\Feature;
use App\Models\Comment;
use App\Models\Additionalservice;
use App\Models\Faq;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderShipped;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class MainController extends Controller
{
    public function index()
    {
        $additionalservices = Additionalservice::all();
        $services = Service::all();
        $faqs = Faq::all();
        $comment = Comment::all()->count();
        $averageRating = Comment::averageRating(2);
        $comments = Comment::all();
        return view('index', compact('services', 'faqs', 'comments', 'additionalservices', 'averageRating', 'comment'));
    }
    public function getBookedSlots(Request $request)
    {
        try {
            $date = $request->query('date');
            if (!$date) {
                return response()->json(['error' => 'Date parameter is required'], 400);
            }
            $orders = Order::where('status', [1, 2, 5])->whereDate('start_time', $date)->get();
            $bookedSlots = [];
            foreach ($orders as $order) {
                $start_time = is_string($order->start_time) ? \Carbon\Carbon::parse($order->start_time) : $order->start_time;
                $end_time = is_string($order->end_time) ? \Carbon\Carbon::parse($order->end_time) : $order->end_time;
                $current = $start_time->copy();
                while ($current->lessThan($end_time)) {
                    $bookedSlots[] = $current->format('H:i');
                    $current->addHour();
                }
            }
            return response()->json($bookedSlots);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ошибка 500'], 500);
        }
    }

    public function comments_validate(Request $request)
    {
        $request->validate(
            [
                'description' => 'required|string|max:255',
                'rating' => 'required|integer|between:1,5',
            ],
            [
                'description.required' => 'Поле обязательно для заполнения.',
                'description.max' => 'Максимальная длина поля отзыва составляет 255 символов.',
            ],
        );

        $comment = new Comment();

        $comment->user = Auth::id();
        $comment->description = $request->input('description');
        $comment->rating = $request->rating;
        $comment->save();

        Log::info('Пользователь ' . Auth::user()->email . ' оставил отзыв', [
            'user_id' => Auth::id(),
            'user_email' => Auth::user()->email,
            'ip_address' => request()->ip(),
            'action' => 'Оставление отзыва',
        ]);

        return redirect()->back()->with('success', 'Вы оставили отзыв');
    }
    public function create_order_validate(Request $request)
    {
        $rules = [
            'square' => 'required|numeric|min:30|max:999',
            'service' => 'required|exists:services,id',
            'date' => 'required|date',
            'phone' => 'required|min:16|max:16',
            'address' => 'required',
        ];

        if (!Auth::check()) {
            $rules['name'] = 'required|string|max:255';
            $rules['email'] = 'required|email|max:255';
        }

        $request->validate($rules, [
            'square.required' => 'Поле обязательно для заполнения',
            'square.numeric' => 'Поле должно быть числом',
            'square.min' => 'Минимальное значение поля - 30',
            'square.max' => 'Максимальное значение поля - 999',
            'service.required' => 'Поле обязательно для выбора',
            'service.exists' => 'Выбранная услуга не существует',
            'date.required' => 'Поле обязательно для заполнения',
            'date.date' => 'Поле должно быть датой',
            'phone.required' => 'Поле обязательно для заполнения',
            'phone.max' => 'Поле не должно превышать 11 символов',
            'phone.min' => 'Поле не должно быть меньше 11 символов',
            'address.required' => 'Поле обязательно для заполнения',
            'name.required' => 'Поле обязательно для заполнения',
            'name.string' => 'Поле должно быть строкой',
            'name.max' => 'Поле не должно превышать 255 символов',
            'email.required' => 'Поле обязательно для заполнения',
            'email.email' => 'Поле должно быть действительным адресом электронной почты',
            'email.max' => 'Поле не должно превышать 255 символов',
        ]);

        $service = Service::findOrFail($request->input('service'));
        $additionalServices = AdditionalService::whereIn('id', $request->input('additionalservices', []))->get();
        $availableAdditionalServices = $service->additionalServices->pluck('id')->toArray();

        $square = $request->input('square');
        $date = $request->input('date');
        $phone = $request->input('phone');
        $address = $request->input('address');

        $baseCost = $square * $service->cost;
        $baseWorkTime = $square * $service->work_time;

        $additionalCost = $additionalServices->sum('cost');
        $additionalWorkTime = $additionalServices->sum('work_time');

        $totalCost = $baseCost + $additionalCost;
        $totalWorkTime = $baseWorkTime + $additionalWorkTime;

        $is_time_busy = Order::where('status', [1, 2, 5])
            ->whereDate('start_time', $date)
            ->where(function ($query) use ($request, $totalWorkTime) {
                $query
                    ->where(function ($query) use ($request, $totalWorkTime) {
                        $query->whereTime('start_time', '<=', $request->input('time'))
                            ->whereTime('start_time', '>=', date('H:i:s', strtotime($request->input('time') . ' - ' . $totalWorkTime . ' minutes')));
                    })
                    ->orWhere(function ($query) use ($request, $totalWorkTime) {
                        $query->whereTime('start_time', '<=', date('H:i:s', strtotime($request->input('time') . ' + ' . $totalWorkTime . ' minutes')))
                            ->whereTime('start_time', '>=', $request->input('time'));
                    });
            })
            ->exists();

        if ($is_time_busy) {
            return redirect()->back()->with('error', 'Выбранное время уже занято. Пожалуйста, выберите другое время.');
        }

        $order = new Order();
        $order->square = $square;
        $order->service = $service->id;
        $order->cost = $totalCost;
        $order->work_time = $totalWorkTime;
        $order->phone = $phone;
        $order->address = $address;
        $order->status = 1;
        $order->start_time = date('Y-m-d H:i:s', strtotime($date . ' ' . $request->input('time')));
        $order->end_time = date('Y-m-d H:i:s', strtotime($order->start_time . ' + ' . $totalWorkTime . ' minutes'));

        if (Auth::check()) {
            $order->user = Auth::id();
        } else {
            $order->name = $request->input('name');
            $order->email = $request->input('email');
        }

        $order->save();
        foreach ($additionalServices as $additionalService) {
            $order->additionalServices()->attach($additionalService->id);
        }

        if (Auth::check()) {
            $user = Auth::user();
            Log::info('Пользователь ' . $user->email . ' создал заказ на услугу ' . $service->titleservice, [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'ip_address' => request()->ip(),
                'action' => 'Создание заказа',
            ]);
            $user->notify(new OrderShipped($order));
        } else {
            Log::info('Неавторизованный пользователь создал заказ на услугу ' . $service->titleservice, [
                'user_email' => $request->input('email'),
                'ip_address' => request()->ip(),
                'action' => 'Создание заказа',
            ]);
            Notification::route('mail', $order->email)->notify(new OrderShipped($order));
        }

        return redirect()->back()->with('success', 'Вы сделали заказ');
    }

    public function cancelOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if (!in_array($order->status, [1, 2])) {
            return redirect()->back()->with('error', 'Заказ нельзя отменить.');
        }

        $currentDate = Carbon::now();
        $orderDate = Carbon::parse($order->start_time);

        if ($orderDate->diffInDays($currentDate) < 2) {
            return redirect()->back()->with('error', 'До исполнения заказа остается меньше 2 дней, его нельзя отменить.');
        }
        $order->status = 4;
        $order->save();

        return redirect()->back()->with('success', 'Заказ успешно отменен.');
    }
}
