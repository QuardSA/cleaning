<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Feature;
use App\Models\Order;
use App\Models\Orderstatus;

class AdminController extends Controller
{
    public function index() {
        $services = Service::paginate(4);
        return view('admin.index', compact('services'));
    }
    public function addservice() {
        return view('admin.addservice');
    }

    public function addservice_validate(Request $request) {
        $request->validate([
            'titleservice' => 'required',
            'description' => 'required',
            'cost' => 'required|numeric',
            'photo' => 'image|mimes:jpeg,png,jpg',
        ], [
            'titleservice.required' => 'Поле "Название услуги" обязательно для заполнения',
            'description.required' => 'Поле "Описание" обязательно для заполнения',
            'cost.required' => 'Поле "Цена" обязательно для заполнения',
            'cost.numeric' => 'Поле "Цена" должно быть числом',
            'photo.image' => 'Загружаемый файл должен быть изображением',
            'photo.mimes' => 'Поддерживаемые форматы изображений: jpeg, png, jpg'
        ]);

        $service = new Service();
        $service->titleservice = $request->input('titleservice');
        $service->description = $request->input('description');
        $service->cost = $request->input('cost');

        if ($request->hasFile('photo')) {
            $name_photo = $request->file('photo')->hashName();
            $path_photo = $request->file('photo')->store('public/images');
            $service->photo = $name_photo;
        }

        $service->save();

        $titleFeatures = $request->input('titlefeatures');
        foreach ($titleFeatures as $titleFeature) {
            $feature = new Feature();
            $feature->titlefeatures = $titleFeature;
            $feature->save();
            $service->features()->attach($feature);
        }

        return redirect('/admin')->with('success', 'Услуга успешно создана');
    }

    public function service_redact($id){
        $service = Service::findOrFail($id);
        return view('admin.serviceredact',compact('service'));
    }

    public function service_redact_validate(Request $request, $id){
        $request->validate([
            'titleservice' => 'required',
            'description' => 'required',
            'cost' => 'required|numeric',
            'photo' => 'image|mimes:jpeg,png,jpg',
        ], [
            'titleservice.required' => 'Поле "Название услуги" обязательно для заполнения',
            'description.required' => 'Поле "Описание" обязательно для заполнения',
            'cost.required' => 'Поле "Цена" обязательно для заполнения',
            'cost.numeric' => 'Поле "Цена" должно быть числом',
            'photo.image' => 'Загружаемый файл должен быть изображением',
            'photo.mimes' => 'Поддерживаемые форматы изображений: jpeg, png, jpg'
        ]);

        $service = Service::findOrFail($id);
        $service->titleservice = $request->input('titleservice');
        $service->description = $request->input('description');
        $service->cost = $request->input('cost');

        if ($request->hasFile('photo')) {
            $name_photo = $request->file('photo')->hashName();
            $path_photo = $request->file('photo')->store('public/images');
            $service->photo = $name_photo;
        }

        $service->save();

        $service->features()->detach();

        $titleFeatures = $request->input('titlefeatures');
        foreach ($titleFeatures as $titleFeature) {
            $feature = new Feature();
            $feature->titlefeatures = $titleFeature;
            $feature->save();
            $service->features()->attach($feature);
        }

        return redirect('/admin')->with('success', 'Услуга успешно отредактирована');
    }

    public function service_delete($id){
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->back()->with('success','Вы успешно удалили услугу');
    }


    public function accept(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 2;
        $order->save();

        return redirect()->back()->with('success', 'Заказ успешно принят');
    }

    public function deny(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 3;
        $order->save();

        return redirect()->back()->with('success', 'Заказ успешно отклонен');
    }

    public function orders(Request $request){
        $orderstatuses = Orderstatus::all();
        $query = Order::query();

        // Применяем фильтр по дате, если он задан
        if ($request->filled('date')) {
            $date = $request->input('date');
            $query->whereDate('date', $date);
        }

        // Применяем фильтр по статусу, если он задан
        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('status', $status);
        }

        // Получаем отфильтрованные заказы
        $orders = $query->paginate(10);

        return view('admin.orders', compact('orders', 'orderstatuses'));
    }

}
