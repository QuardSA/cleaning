<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
use App\Models\Feature;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function index(){
        $services = Service::all();
        return view("index", compact('services'));
    }

    public function object($id){
        $services=Service::findOrFail($id);
        return view("object",compact('services'));
    }

    public function create_order_validate(Request $request)
    {
        $request->validate([
            'square' => 'required|numeric|min:30|max:999',
            'service_id' => 'required',
            'date' => 'required|date',
            'phone' => 'required',
            'address' => 'required',
        ], [
            'square.required' => 'Поле обязательно для заполнения',
            'square.numeric' => 'Поле должно быть числом',
            'square.min' => 'Минимальное значение поля - 30',
            'square.max' => 'Максимальное значение поля - 999',
            'service_id.required' => 'Поле обязательно для выбора',
            'date.required' => 'Поле обязательно для заполнения',
            'date.date' => 'Поле должно быть датой',
            'phone.required' => 'Поле обязательно для заполнения',
            'address.required' => 'Поле обязательно для заполнения',
        ]);

        $square = $request->input('square');
        $service = $request->input('service');

        $cost = $square * $service;

        $order = new Order();
        $order->square = $square;
        $order->service_id = $service;
        $order->cost = $cost;
        $order->date = $request->input('date');
        $order->phone = $request->input('phone');
        $order->address = $request->input('address');
        $order->status_id = 1;
        $order->user_id = Auth::id();
        $order->save();

        return redirect()->back()->with('success', 'Вы сделали заказ');
    }
}
