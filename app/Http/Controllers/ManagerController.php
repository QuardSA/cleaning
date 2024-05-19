<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
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
        // $reportsQuery = Report::query();
        // if ($request->has('date') && $request->date != '') {
        //     $reportsQuery->whereDate('created_at', $request->date);
        // }
        // $reports = $reportsQuery->where('user', auth()->user()->id)->get();
        // $usersWithRole2 = User::where('role', 2)->get();
        $mailings = Mailingsend::all();
        $newOrdersCount = Order::where('status', '1')->count();

        return view('manager.index', compact('newOrdersCount', 'mailings'));
    }

    public function orders(Request $request)
    {
        $orderstatuses = Orderstatus::all();

        $query = Order::orderBy('status', 'ASC');

        if ($request->filled('start_time')) {
            $date = $request->input('start_time');
            $query->whereDate('start_time', '=', $date);
        }

        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('status', $status);
        }

        $orders = $query->paginate(10);

        return view('manager.orders', compact('orders', 'orderstatuses'));
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

        Log::info('Пользователь ' . $user->email . ' Принял заявку ', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'ip_address' => $request->ip(),
            'action' => 'Принял заявку',
        ]);

        Mail::to($orderUser->email)->send(new OrderAccept($order));

        return redirect()->back()->with('success', 'Заказ успешно принят');
    }
    public function done(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->status = 5;
        $order->save();
        $user = Auth::user();
        $orderUser = $order->order_user;

        Log::info('Пользователь ' . $user->email . 'Заказ выполнен', [
            'user_id' => $user->id,
            'user_email' => $user->email,
            'ip_address' => $request->ip(),
            'action' => 'Заказ выполнен',
        ]);

        Mail::to($orderUser->email)->send(new OrderDone($order));

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
        Mail::to($orderUser->email)->send(new OrderDenied($order, $reason));

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

        if (!file_exists($pdfPath)) {
            $pdf = PDF::loadView('manager.service_report', compact('order'));
            $pdf->save($pdfPath);
        }

        return response()->download($pdfPath);
    }
    // public function report()
    // {
    //     $user = auth()->user();
    //     $currentDateTime = now()->format('d-m-y');
    //     $username = $user->name;

    //     $reportFilename = "Отчёт_{$currentDateTime}_{$username}.xlsx";

    //     $report = new ReportExport;

    //     Excel::store($report, $reportFilename, 'local');

    //     if (!Storage::exists($reportFilename)) {
    //         return 'File does not exist in storage';
    //     }

    //     $report = new Report;
    //     $report->file = $reportFilename;
    //     $report->user = $user->id;
    //     $report->save();

    //     return redirect()->back()->with('success', 'Отчёт добавлен');
    // }
    // public function downloadReport($filename)
    // {
    //     if (!Storage::exists($filename)) {
    //         return 'File does not exist in storage';
    //     }
    //     return Storage::download($filename);
    // }
    // public function deleteReport($id)
    // {
    //     $report = Report::find($id);

    //     if ($report) {
    //         if (Storage::exists($report->file)) {
    //             Storage::delete($report->file);
    //         }

    //         $report->delete();
    //         return redirect()->back()->with('success', 'Отчёт удалён');
    //     } else {
    //         return redirect()->back()->with('error', 'Отчёт не найден');
    //     }
    // }
}
