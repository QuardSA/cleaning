<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function logs(Request $request)
    {
        $users = User::all();
        $roles = Role::all();
        $filteredLogs = [];

        $logFilePath = storage_path('logs/laravel.log');

        $file = fopen($logFilePath, 'r');
        if ($file) {
            while (($line = fgets($file)) !== false) {
                if (strpos($line, 'local.INFO') !== false) {
                    $logData = json_decode(substr($line, strpos($line, '{')), true);
                    if (isset($logData['user_email'])) {
                        $user = User::where('email', $logData['user_email'])->first();
                        if ($user && ($request->input('user_id') == '' || $request->input('user_id') == $user->id) && ($request->input('role_id') == '' || $request->input('role_id') == $user->role) && ($request->input('action') == '' || $request->input('action') == $logData['action'])) {
                            $filteredLogs[] = [
                                'user_id' => $user ? $user->id : null,
                                'user_email' => $logData['user_email'],
                                'user_name' => $user ? $user->name : '',
                                'user_surname' => $user ? $user->surname : '',
                                'user_lastname' => $user ? $user->lastname : '',
                                'user_role' => $user ? $user->user_role->titlerole : '',
                                'ip_address' => $logData['ip_address'] ?? null,
                                'action' => $logData['action'] ?? null,
                                'url' => $logData['url'] ?? null,
                                'date_time' => substr($line, 1, 19),
                            ];
                        }
                    }
                }
            }
            fclose($file);
        }
        return view('admin.logs', compact('filteredLogs', 'users', 'roles'));
    }
}
