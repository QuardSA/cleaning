<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Order;
use App\Models\Faq;
use App\Models\Mailing;
use App\Models\Mailingsend;
use App\Models\Orderstatus;
use App\Mail\MailingMail;
use App\Exports\ReportExport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class ManagerController extends Controller
{
    public function index()
    {
        $reports = Report::where('user', auth()->user()->id)->get();
        $faqs = Faq::all()->count();
        $mailings = Mailingsend::all();
        $newOrdersCount = Order::where('status', '1')->count();
        return view('manager.index', compact('newOrdersCount', 'mailings', 'faqs', 'reports'));
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

        return view('manager.orders', compact('orders', 'orderstatuses'));
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

    public function faq()
    {
        $faqs = Faq::paginate(5);
        return view('manager.faq', compact('faqs'));
    }

    public function faq_create(Request $request)
    {
        $request->validate([
            'titlefaq' => 'required|string',
            'description' => 'required|string',
        ]);

        $faq = new faq();
        $faq->titlefaq = $request->input('titlefaq');
        $faq->description = $request->input('description');

        if ($faq->save()) {
            $user = Auth::user();

            Log::info('Пользователь создал FAQ', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'user_role' => $user->role,
                'ip_address' => $request->ip(),
                'action' => 'Создал FAQ',
            ]);

            return redirect()->back()->with('success', 'Вы добавили FAQ');
        } else {
            return redirect()->back()->with('error', 'Ошибка добавления');
        }
    }

    public function faq_edit(Request $request, $id)
    {
        $request->validate([
            'titlefaq' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $faq = faq::findOrFail($id);

        $faq->titlefaq = $request->input('titlefaq');
        $faq->description = $request->input('description');

        if ($faq->save()) {
            Log::info('Пользователь ' . Auth::user()->email . ' отредактировал FAQ "' . $faq->titlefaq . '"', [
                'user_id' => Auth::user()->id,
                'user_email' => Auth::user()->email,
                'ip_address' => $request->ip(),
                'action' => 'Отредактировал FAQ',
            ]);

            return redirect()->back()->with('success', 'Вы отредактировали FAQ');
        } else {
            return redirect()->back()->with('error', 'Ошибка редактирования');
        }
    }
    public function faq_delete($id)
    {
        $faq = Faq::findOrFail($id);
        $user = Auth::user();
        if ($faq->delete()) {
            Log::info('Пользователь ' . $user->email . 'Удалил FAQ ' . $faq, [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'ip_address' => request()->ip(),
                'action' => 'Удаление FAQ',
            ]);

            return redirect()->back()->with('success', 'Вы удалили FAQ');
        } else {
            return redirect()->back()->with('error', 'Ошибка удаления');
        }
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

        $mails = Mailing::all();
        $title = $request['titlemailing'];
        $description = $request['description'];

        $mailMessage = new MailingMail($title, $description);

        foreach ($mails as $mail) {
            Mail::to($mail->email)->send($mailMessage);
        }

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
        $mails = Mailing::all();
        $title = $mailing->titlemailing;
        $description = $mailing->description;
        $mailMessage = new MailingMail($title, $description);

        foreach ($mails as $mail) {
            Mail::to($mail->email)->send($mailMessage);
        }

        return redirect()->back()->with('success', 'Рассылка повторно отправлена');
    }

    public function mailing_delete($id)
    {
        $mailing = Mailingsend::findOrFail($id);
        $mailing->delete();

        return redirect()->back()->with('success', 'Рассылка успешно удалена');
    }
    public function report()
    {
        $report = new ReportExport;
        $reportFile = 'report.xlsx';

        Excel::store($report, $reportFile, 'local');

        if (!Storage::exists($reportFile)) {
            return 'File does not exist in storage';
        }

        $report = new Report;
        $report->file = $reportFile;
        $report->user = auth()->user()->id;
        $report->save();

        return redirect()->back()->with('success', 'Отчёт добавлен');
    }
    public function downloadReport($filename)
    {
        // Проверка существования файла в хранилище Laravel
        if (!Storage::exists($filename)) {
            // Файл не существует, выводим сообщение об ошибке
            return 'File does not exist in storage';
        }

        // Скачивание файла из хранилища Laravel
        return Storage::download($filename);
    }
    public function deleteReport($id)
    {
        $report = Report::find($id);

        if ($report) {
            if (Storage::exists($report->file)) {
                Storage::delete($report->file);
            }

            $report->delete();
            return redirect()->back()->with('success','Отчёт удалён');
        } else {
            return redirect()->back()->with('error','Отчёт не найден');
        }
    }

}
