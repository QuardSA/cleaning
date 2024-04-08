<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\service;

class AdminController extends Controller
{
    public function index() {
        $services = service::paginate(4);
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
            'titlefeatures' => 'required|array|min:1',
            'photo' => 'image|mimes:jpeg,png,jpg',
        ], [
            'titleservice.required' => 'Поле обязательно для заполнения',
            'description.required' => 'Поле обязательно для заполнения',
            'cost.required' => 'Поле обязательно для заполнения',
            'cost.numeric' => 'Только числа',
            'titlefeatures.required' => 'Поле обязательно для заполнения',
            'photo.image' => 'Только картинки',
            'photo.mimes' => 'Только jpeg, png, jpg'
        ]);

        $service = new service();
        $service->titleservice = $request->input('titleservice');
        $service->description = $request->input('description');
        $service->cost = $request->input('cost');

        if ($request->hasFile('photo')) {
            $name_photo = $request->file('photo')->hashName();
            $path_photo = $request->file('photo')->store('public/images');
            $service->photo = $path_photo;
        }

        $service->save();

        $features = $request->input('titlefeatures');
        $service->features()->attach($features);

        return redirect('/admin')->with('success', 'Услуга успешно создана');
    }

    public function service_redact($id){
        $service = service::findOrFali($id);
        return view('admin.serviceredact',compact('service'));
    }

    public function service_redact_validate(Request $request, $id){
        $request->validate([
            'titleservice' => 'required',
            'description' => 'required',
            'cost' => 'required|numeric',
            'titlefeatures' => 'required|array|min:1',
            'photo' => 'image|mimes:jpeg,png,jpg',
        ], [
            'titleservice.required' => 'Поле обязательно для заполнения',
            'description.required' => 'Поле обязательно для заполнения',
            'cost.required' => 'Поле обязательно для заполнения',
            'cost.numeric' => 'Только числа',
            'titlefeatures.required' => 'Поле обязательно для заполнения',
            'photo.image' => 'Только картинки',
            'photo.mimes' => 'Только jpeg, png, jpg'
        ]);

        $service = service::findOrFail($id);
        $service->titleservice = $request->input('titleservice');
        $service->description = $request->input('description');
        $service->cost = $request->input('cost');

        if ($request->hasFile('photo')) {
            $name_photo = $request->file('photo')->hashName();
            $path_photo = $request->file('photo')->store('public/images');
            $service->photo = $path_photo;
        }

        $service->save();

        $features = $request->input('titlefeatures');
        $service->features()->attach($features);

        return redirect('/admin')->with('success', 'Услуга успешно создана');
    }

    public function service_delete($id){
        $service = service::findOrFali($id);
        $service->delete();
        return redirect()->back()->with('success','Вы успешно удалили услугу');
    }
    public function orders(){
        return view('admin.orders');
    }
}
