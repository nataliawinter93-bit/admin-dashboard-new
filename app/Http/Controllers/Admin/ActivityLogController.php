<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        // ⭐ Сортировка по дате
        $direction = $request->get('direction', 'desc');
        $query->orderBy('created_at', $direction);

        // ⭐ Фильтр по пользователю
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        // ⭐ Фильтр по действию
        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        // ⭐ Фильтр по модели
        if ($request->filled('model')) {
            $query->where('model', $request->model);
        }

        // ⭐ Фильтр по дате "от"
        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        // ⭐ Фильтр по дате "до"
        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        // ⭐ Поиск
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('url', 'like', "%$search%")
                  ->orWhere('user_agent', 'like', "%$search%")
                  ->orWhere('ip_address', 'like', "%$search%")
                  ->orWhere('model', 'like', "%$search%")
                  ->orWhere('action', 'like', "%$search%")
                  ->orWhere('model_id', 'like', "%$search%");
            });
        }

        // ⭐ paginate
        $logs = $query->paginate(20)->appends($request->query());

        $users = User::all();

        $models = [
            'App\Models\User',
            'App\Models\Role',
            'App\Models\Permission',
        ];

        return view('admin.logs.index', compact('logs', 'users', 'models', 'direction'));
    }

    // ⭐ 
    public function show($id)
    {
        $log = ActivityLog::findOrFail($id);

        return response()->json([
            'id'   => $log->id,
            'diff' => $log->getDiff(),
        ]);
    }
    public function export(Request $request)
{
    // Получаем те же данные, что и на странице
    $logs = ActivityLog::with('user')
        ->when($request->user_id, fn($q) => $q->where('user_id', $request->user_id))
        ->when($request->action, fn($q) => $q->where('action', $request->action))
        ->when($request->model, fn($q) => $q->where('model', $request->model))
        ->when($request->from_date, fn($q) => $q->whereDate('created_at', '>=', $request->from_date))
        ->when($request->to_date, fn($q) => $q->whereDate('created_at', '<=', $request->to_date))
        ->when($request->search, function ($q) use ($request) {
            $q->where(function ($query) use ($request) {
                $query->where('url', 'like', "%{$request->search}%")
                      ->orWhere('user_agent', 'like', "%{$request->search}%")
                      ->orWhere('ip_address', 'like', "%{$request->search}%")
                      ->orWhere('model', 'like', "%{$request->search}%");
            });
        })
        ->orderBy('created_at', 'desc')
        ->get();

    // Формируем CSV
    $filename = 'logs_export_' . now()->format('Y-m-d_H-i-s') . '.csv';

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => "attachment; filename=\"$filename\"",
    ];

    $callback = function () use ($logs) {
        $file = fopen('php://output', 'w');

        // Заголовки CSV
        fputcsv($file, [
            'ID', 'User', 'Action', 'Model', 'Model ID',
            'IP', 'URL', 'Method', 'User Agent', 'Date'
        ]);

        // Данные
        foreach ($logs as $log) {
            fputcsv($file, [
                $log->id,
                $log->user->name ?? 'System',
                $log->action,
                $log->model,
                $log->model_id,
                $log->ip_address,
                $log->url,
                $log->method,
                $log->user_agent,
                $log->created_at,
            ]);
        }

        fclose($file);
    };

    return response()->stream($callback, 200, $headers);
}

}
