<?php

namespace App\Http\Controllers;

use ZipArchive;
use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Additionalservice;
use App\Models\Order;
use App\Models\User;
use App\Models\Mailing;
use App\Models\Mailingsend;
use App\Models\Orderstatus;
use App\Mail\MailingMail;
use App\Mail\OrderDenied;
use App\Mail\OrderDone;
use App\Mail\OrderAccept;
use App\Exports\ReportExport;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use PDF;


class ManagerController extends Controller
{
    public function index(Request $request)
    {
        $authenticatedUsers = User::leftJoin('orders', 'users.id', '=', 'orders.user')
        ->select('users.name', 'users.email', DB::raw('MAX(orders.phone) as phone'))->where('users.role', 1)->groupBy('users.name', 'users.email');
        $guestUsers = Order::select('name', 'email', 'phone')->whereNull('user')->groupBy('name', 'email', 'phone');
        $users = $authenticatedUsers->union($guestUsers)->count();
        $mailings = Mailingsend::all();
        $newOrdersCount = Order::where('status', '1')->count();
        return view('manager.index', compact('newOrdersCount', 'mailings', 'users'));
    }

    public function clients()
    {
        $authenticatedUsers = User::leftJoin('orders', 'users.id', '=', 'orders.user')
        ->select('users.name', 'users.email', DB::raw('MAX(orders.phone) as phone'))->where('users.role', 1)->groupBy('users.name', 'users.email');
        $guestUsers = Order::select('name', 'email', 'phone')->whereNull('user')->groupBy('name', 'email', 'phone');
        $users = $authenticatedUsers->union($guestUsers)->paginate(14);

        return view('manager.clients', compact('users'));
    }
    public function contract()
    {
        return view('manager.contract',);
    }

    public function orders(Request $request)
    {

        $additionalservices = Additionalservice::all();

        $orderstatuses = Orderstatus::all();

        $query = Order::orderBy('status', 'ASC');

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $query->whereBetween('start_time', [$startDate, $endDate]);
        } elseif ($request->filled('start_date')) {
            $startDate = $request->input('start_date');
            $query->whereDate('start_time', '>=', $startDate);
        } elseif ($request->filled('end_date')) {
            $endDate = $request->input('end_date');
            $query->whereDate('start_time', '<=', $endDate);
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('status', $status);
        }

        if ($request->filled('order_id')) {
            $orderId = $request->input('order_id');
            $query->where('id', $orderId);
        }

        $orders = $query->paginate(10);

        return view('manager.orders', compact('orders', 'orderstatuses','additionalservices'));

    }



    public function accept(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 2;
        $order->save();
        $user = Auth::user();
        $orderUser = $order->order_user;

        $pdf = PDF::loadView('manager.service_report', compact('order'));
        $pdfPath = storage_path('app/public/service_report_' . $order->id . '.pdf');
        $pdf->save($pdfPath);
        $pdf_contract = PDF::loadView('manager.contract', compact('order'));
        $pdfPath_contract = storage_path('app/public/contract_' . $order->id . '.pdf');
        $pdf_contract->save($pdfPath_contract);

        if ($user) {
            Log::info('Пользователь ' . $user->email . ' Принял заявку ', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'ip_address' => $request->ip(),
                'action' => 'Принял заявку',
            ]);
        }

        if ($orderUser) {
            Mail::to($orderUser->email)
                ->send(new OrderAccept($order, $pdfPath_contract));
        } elseif ($order->email) {
            Mail::to($order->email)
                ->send(new OrderAccept($order, $pdfPath_contract));
        }

        return redirect()->back()->with('success', 'Заказ успешно принят');
    }


    public function done(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 5;
        $order->save();
        $user = Auth::user();
        $orderUser = $order->order_user;
        if ($user) {
            Log::info('Пользователь ' . $user->email . ' Заказ выполнен', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'ip_address' => $request->ip(),
                'action' => 'Заказ выполнен',
            ]);
        }

        if ($orderUser) {
            Mail::to($orderUser->email)->send(new OrderDone($order));
        } else {
            Mail::to($order->email)->send(new OrderDone($order));
        }

        return redirect()->back()->with('success', 'Заказ выполнен');
    }

    public function deny(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 3;
        $order->save();

        $reason = $request->input('reason');
        $user = Auth::user();
        $orderUser = $order->order_user;

        Log::info('Пользователь ' . $user->email . ' отклонил заявку ', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'ip_address' => $request->ip(),
            'action' => 'Отклонил заявку',
        ]);
        if ($orderUser) {
            Mail::to($orderUser->email)->send(new OrderDenied($order, $reason));
        } else {
            Mail::to($order->email)->send(new OrderDenied($order, $reason));
        }


        return redirect()->back()->with('success', 'Заказ успешно отклонен');
    }



    public function mailing(Request $request)
    {
        $request->validate([
            'titlemailing' => 'required|string|max:100',
            'description' => 'required',
        ]);

        $mailing = new Mailingsend();
        $mailing->titlemailing = $request['titlemailing'];
        $mailing->description = $request['description'];
        $mailing->save();

        $title = $request['titlemailing'];
        $description = $request['description'];

        $mailMessage = new MailingMail($title, $description);

        $emails = Mailing::pluck('email')->toArray();

        Mail::to($emails)->send($mailMessage);

        return redirect()->back()->with('success', 'Рассылка успешно создана');
    }

    public function mailing_edit(Request $request, $id)
    {
        $request->validate([
            'titlemailing' => 'required|string|max:100',
            'description' => 'required',
        ]);

        $mailing = Mailingsend::findOrFail($id);
        $mailing->titlemailing = $request['titlemailing'];
        $mailing->description = $request['description'];
        $mailing->save();

        return redirect()->back()->with('success', 'Рассылка успешно отредактирована');
    }

    public function mailing_repeat($id)
    {
        $mailing = Mailingsend::findOrFail($id);

        $title = $mailing->titlemailing;
        $description = $mailing->description;
        $mailMessage = new MailingMail($title, $description);
        $emails = Mailing::pluck('email')->toArray();
        Mail::to($emails)->send($mailMessage);


        return redirect()->back()->with('success', 'Рассылка повторно отправлена');
    }

    public function mailing_delete($id)
    {
        $mailing = Mailingsend::findOrFail($id);
        $mailing->delete();

        return redirect()->back()->with('success', 'Рассылка успешно удалена');
    }
    public function downloadPDF($id)
    {
        $order = Order::findOrFail($id);
        $pdfPath = storage_path('app/public/service_report_' . $order->id . '.pdf');
        $pdfPath_contract = storage_path('app/public/contract_' . $order->id . '.pdf');

        if (!file_exists($pdfPath)) {
            $pdf = PDF::loadView('manager.service_report', compact('order'));
            $pdf->save($pdfPath);
        }
        if (!file_exists($pdfPath_contract)) {
            $pdf_contract = PDF::loadView('manager.contract', compact('order'));
            $pdf_contract->save($pdfPath_contract);
        }

        $zip = new ZipArchive;
        $zipFileName = 'order_' . $order->id . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            $zip->addFile($pdfPath, 'service_report_' . $order->id . '.pdf');
            $zip->addFile($pdfPath_contract, 'contract_' . $order->id . '.pdf');
            $zip->close();

            return response()->download($zipFilePath)->deleteFileAfterSend(true);
        } else {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }
    }
}
