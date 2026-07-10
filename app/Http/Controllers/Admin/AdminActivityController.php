<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminActivityController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->query('q'));
        $userId = (string) $request->query('user');
        $action = (string) $request->query('action');
        $from = $request->query('from');
        $to = $request->query('to');

        $logs = AdminActivityLog::query()
            ->with('user')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($builder) use ($search) {
                    $builder->where('description', 'like', "%{$search}%")
                        ->orWhere('subject_label', 'like', "%{$search}%")
                        ->orWhere('action', 'like', "%{$search}%");
                });
            })
            ->when($userId !== '', fn ($query) => $query->where('user_id', $userId))
            ->when($action !== '', fn ($query) => $query->where('action', $action))
            ->when($from, fn ($query) => $query->whereDate('created_at', '>=', $from))
            ->when($to, fn ($query) => $query->whereDate('created_at', '<=', $to))
            ->latest()
            ->paginate(50)
            ->withQueryString();

        return view('admin.activity.index', [
            'logs' => $logs,
            'users' => User::query()->orderBy('name')->get(['id', 'name', 'email']),
            'actions' => AdminActivityLog::query()->select('action')->distinct()->orderBy('action')->pluck('action'),
            'counts' => [
                'today' => AdminActivityLog::whereDate('created_at', today())->count(),
                'week' => AdminActivityLog::where('created_at', '>=', now()->subDays(7))->count(),
                'users' => AdminActivityLog::whereNotNull('user_id')->distinct('user_id')->count('user_id'),
                'total' => AdminActivityLog::count(),
            ],
        ]);
    }
}
