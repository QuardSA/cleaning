<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Feature;
use App\Models\Order;
use App\Models\User;
use App\Models\Role;
use App\Models\Orderstatus;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $newOrdersCount = Order::where('status', '1')->count();
        $users = User::count();
        $services = Service::count();
        $orders = Order::all();
        $totalCostByDate = [];
        if ($request->ajax()) {
            $month = $request->month;
            $year = $request->year;
            $orders = $orders->whereMonth('updated_at', Carbon::parse($month)->month)->whereYear('updated_at', $year);
        }

        foreach ($orders as $order) {
            $date = $order->updated_at->format('d-m-Y');
            if (isset($totalCostByDate[$date])) {
                $totalCostByDate[$date] += $order->cost;
            } else {
                $totalCostByDate[$date] = $order->cost;
            }
        }

        $labels = array_keys($totalCostByDate);
        $data = array_values($totalCostByDate);

        $uniqueMonths = $orders
            ->pluck('updated_at')
            ->map(function ($date) {
                return Carbon::parse($date)->format('F');
            })
            ->unique();

        $uniqueYears = $orders
            ->pluck('updated_at')
            ->map(function ($date) {
                return Carbon::parse($date)->format('Y');
            })
            ->unique();

        if ($request->ajax()) {
            return response()->json([
                'labels' => $labels,
                'data' => $data,
            ]);
        }

        return view('admin.index', compact('orders', 'newOrdersCount', 'users', 'services'), [
            'labels' => json_encode($labels),
            'data' => json_encode($data),
            'uniqueMonths' => $uniqueMonths,
            'uniqueYears' => $uniqueYears,
        ]);
    }

    public function filterData(Request $request)
    {
        $orders = Order::query();

        if ($request->has('month') && $request->has('year')) {
            $month = $request->month;
            $year = $request->year;

            $orders = $orders->whereMonth('updated_at', Carbon::parse($month)->month)->whereYear('updated_at', $year);
        }

        $totalCostByDate = [];

        foreach ($orders->get() as $order) {
            $date = $order->updated_at->format('d-m-Y');

            if (isset($totalCostByDate[$date])) {
                $totalCostByDate[$date] += $order->cost;
            } else {
                $totalCostByDate[$date] = $order->cost;
            }
        }

        $labels = array_keys($totalCostByDate);
        $data = array_values($totalCostByDate);

        return response()->json([
            'labels' => $labels,
            'data' => $data,
        ]);
    }

    public function users()
    {
        $users = User::paginate(20);
        $roles = Role::all();
        return view('admin.users', compact('users', 'roles'));
    }

    public function users_edit_validate(Request $request, $id)
    {
        $request->validate(
            [
                'name' => 'required|alpha|max:100',
                'surname' => 'required|alpha|max:100',
                'lastname' => 'nullable|alpha|max:100',
                'email' => 'required|string|email|max:100',
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
            ],
        );

        $user = User::FindOrFail($id);
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->save();

        if ($user) {
            Log::info('Пользователь ' . $user->email . ' изменил данные', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'ip_address' => $request->ip(),
                'action' => 'Изменение данных',
            ]);
            return redirect()->back()->with('success', 'Данные успешно изменены');
        } else {
            return redirect()->back()->with('error', 'Ошибка изменения данных');
        }
    }

    public function users_delete($id)
    {
        $user = User::FindOrFail($id);

        $userEmail = $user->email;
        $userName = $user->name;
        $userSurname = $user->surname;
        $userLastname = $user->lastname;
        $userRole = $user->user_role->titlerole;
        $userId = $user->id;

        $currentUser = Auth::user();

        if ($user->delete()) {
            return redirect()->back()->with('success', 'Пользователь удалён');
        } else {
            return redirect()->back()->with('error', 'Ошибка удаления пользователя');
        }
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
        $request->validate(
            [
                'titleservice' => 'required',
                'description' => 'required',
                'work_time' => 'required',
                'cost' => 'required|numeric',
            ],
            [
                'titleservice.required' => 'Поле обязательно для заполнения',
                'description.required' => 'Поле обязательно для заполнения',
                'work_time.required' => 'Поле обязательно для заполнения',
                'cost.required' => 'Поле обязательно для заполнения',
                'cost.numeric' => 'Поле должно быть числом',
                'photo.required' => 'Поле обязательно для заполнения',
                'photo.image' => 'Загружаемый файл должен быть изображением',
                'photo.mimes' => 'Поддерживаемые форматы изображений: jpeg, png, jpg',
            ],
        );

        $service = new Service();
        $service->titleservice = $request->input('titleservice');
        $service->work_time = $request->input('work_time');
        $service->description = $request->input('description');
        $service->cost = $request->input('cost');

        $service->save();
        $user = Auth::user();
        Log::info('Пользователь ' . $user->email . ' создал услугу ' . $service->titleservice, [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'ip_address' => $request->ip(),
            'action' => 'Создание услуги',
        ]);

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
        $request->validate(
            [
                'titleservice' => 'required',
                'description' => 'required',
                'cost' => 'required|numeric',
            ],
            [
                'titleservice.required' => 'Поле обязательно для заполнения',
                'description.required' => 'Поле обязательно для заполнения',
                'cost.required' => 'Поле обязательно для заполнения',
                'cost.numeric' => 'Поле должно быть числом',
                'photo.required' => 'Поле обязательно для заполнения',
                'photo.image' => 'Загружаемый файл должен быть изображением',
                'photo.mimes' => 'Поддерживаемые форматы изображений: jpeg, png, jpg',
            ],
        );

        $service = Service::findOrFail($id);
        $service->titleservice = $request->input('titleservice');
        $service->work_time = $request->input('work_time');
        $service->description = $request->input('description');
        $service->cost = $request->input('cost');

        $service->save();
        $user = Auth::user();
        Log::info('Пользователь ' . $user->email . 'Отредактировал услугу ' . $service->titleservice, [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'ip_address' => $request->ip(),
            'action' => 'Редактирование услуги',
        ]);
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
        $titleService = $service->titleservice;
        $service->delete();
        $user = Auth::user();
        Log::info('Пользователь ' . $user->email . 'Удалил услугу ' . $titleService, [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'ip_address' => request()->ip(),
            'action' => 'Удаление услуги',
        ]);
        return redirect()->back()->with('success', 'Вы успешно удалили услугу');
    }

    public function accept(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 2;
        $order->save();
        $user = Auth::user();
        Log::info('Пользователь ' . $user->email . 'Принял заявку ', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'ip_address' => $request->ip(),
            'action' => 'Принял заявку',
        ]);
        return redirect()->back()->with('success', 'Заказ успешно принят');
    }

    public function deny(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 3;
        $order->save();
        $user = Auth::user();
        Log::info('Пользователь ' . $user->email . 'Отклонил заявку ', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'ip_address' => $request->ip(),
            'action' => 'Отклонил заявку',
        ]);
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
