<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Feature;
use App\Models\Order;
use App\Models\User;
use App\Models\Orderstatus;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index');
    }

    public function users()
    {
        $users = User::paginate(20);
        return view('admin.users',compact('users'));
    }

    public function logs()
    {
        return view('admin.logs');
    }

    public function service()
    {
        $services = Service::paginate(4);
        return view('admin.service', compact('services'));
    }

    public function addservice()
    {
        return view('admin.addservice');
    }

    public function addservice_validate(Request $request)
    {
        $request->validate([
            'titleservice' => 'required',
            'description' => 'required',
            'work_time' => 'required',
            'cost' => 'required|numeric',
            'photo' => 'required|image|mimes:jpeg,png,jpg',
        ], [
            'titleservice.required' => 'Поле обязательно для заполнения',
            'description.required' => 'Поле обязательно для заполнения',
            'work_time.required' => 'Поле обязательно для заполнения',
            'cost.required' => 'Поле обязательно для заполнения',
            'cost.numeric' => 'Поле должно быть числом',
            'photo.required' => 'Поле обязательно для заполнения',
            'photo.image' => 'Загружаемый файл должен быть изображением',
            'photo.mimes' => 'Поддерживаемые форматы изображений: jpeg, png, jpg'
        ]);

        $service = new Service();
        $service->titleservice = $request->input('titleservice');
        $service->work_time = $request->input('work_time');
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

        return redirect('/admin/service')->with('success', 'Услуга успешно создана');
    }

    public function service_redact($id)
    {
        $service = Service::findOrFail($id);
        return view('admin.serviceredact', compact('service'));
    }

    public function service_redact_validate(Request $request, $id)
    {
        $request->validate([
            'titleservice' => 'required',
            'description' => 'required',
            'cost' => 'required|numeric',
            'photo' => 'required|image|mimes:jpeg,png,jpg',
        ], [
            'titleservice.required' => 'Поле обязательно для заполнения',
            'description.required' => 'Поле обязательно для заполнения',
            'cost.required' => 'Поле обязательно для заполнения',
            'cost.numeric' => 'Поле должно быть числом',
            'photo.required' => 'Поле обязательно для заполнения',
            'photo.image' => 'Загружаемый файл должен быть изображением',
            'photo.mimes' => 'Поддерживаемые форматы изображений: jpeg, png, jpg'
        ]);

        $service = Service::findOrFail($id);
        $service->titleservice = $request->input('titleservice');
        $service->work_time = $request->input('work_time');
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

        return redirect('/admin/service')->with('success', 'Услуга успешно отредактирована');
    }

    public function service_delete($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();
        return redirect()->back()->with('success', 'Вы успешно удалили услугу');
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

    public function orders(Request $request)
    {
        $orderstatuses = Orderstatus::all();
        $query = Order::query();

        if ($request->filled('date')) {
            $date = $request->input('date');
            $query->whereDate('date', '=', $date);
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('status', $status);
        }

        $orders = $query->paginate(10);

        return view('admin.orders', compact('orders', 'orderstatuses'));
    }
}
