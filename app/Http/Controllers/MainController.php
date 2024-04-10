<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Service;
use App\Models\Feature;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderShipped;

class MainController extends Controller
{
    public function index(){
        $services = Service::all();
        return view("index", compact('services'));
    }

    public function object($id){
        $service=Service::findOrFail($id);
        $services=Service::all()->where('id','!=',$id);
        return view("object",compact('services','service'));
    }

    public function create_order_validate(Request $request)
    {
        $request->validate([
            'square' => 'required|numeric|min:30|max:999',
            'service' => 'required',
            'date' => 'required|date',
            'phone' => 'required|min:11|max:11',
            'address' => 'required',
        ], [
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
        ]);

        $square = $request->input('square');
        $serviceName = $request->input('service');
        $date = $request->input('date');
        $phone = $request->input('phone');
        $address = $request->input('address');

        $service = Service::where('cost', $serviceName)->first();

        $cost = $square * $service->cost;

        $order = new Order();
        $order->square = $square;
        $order->service = $service->id;
        $order->cost = $cost;
        $order->date = $date;
        $order->phone = $phone;
        $order->address = $address;
        $order->status = 1;
        $order->user = Auth::id();
        $order->save();

        $user = Auth::user();
        $user->notify(new OrderShipped($order));

        return redirect()->back()->with('success', 'Вы сделали заказ');
    }
}
