<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $tasks = auth()->user()->tasks()
            ->where('completed', false)
            ->orderBy('created_at', 'asc')
            ->limit(5)
            ->get();

        $createdCurrentMonth = auth()->user()->tasks()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $createdLastMonth = auth()->user()->tasks()
            ->whereMonth('created_at', now()->subMonth())
            ->whereYear('created_at', now()->year)
            ->count();

        $completedCurrentMonth = auth()->user()->tasks()
            ->whereMonth('completed_at', now()->month)
            ->whereYear('completed_at', now()->year)->count();

        $completedLastMonth = auth()->user()->tasks()
            ->whereMonth('completed_at', now()->subMonth())
            ->whereYear('completed_at', now()->year)
            ->count();

        $createdCompletedCurrentMonth = auth()->user()->tasks()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->whereMonth('completed_at', now()->month)
            ->whereYear('completed_at', now()->year)
            ->count();
        $createdCompletedLastMonth = auth()->user()->tasks()
            ->whereMonth('created_at', now()->subMonth())
            ->whereYear('created_at', now()->year)
            ->whereMonth('completed_at', now()->subMonth())
            ->whereYear('completed_at', now()->year)
            ->count();

        $createdPendingCurrentMonth = auth()->user()->tasks()
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('completed', false)
            ->count();

        $createdPendingLastMonth = auth()->user()->tasks()
            ->whereMonth('created_at', now()->subMonth())
            ->whereYear('created_at', now()->year)
            ->where('completed', false)
            ->count();

        return view('dashboard', ['tasks' => $tasks, 'createdCurrentMonth' => $createdCurrentMonth, 'createdLastMonth' => $createdLastMonth, 'completedCurrentMonth' => $completedCurrentMonth, 'completedLastMonth' => $completedLastMonth, 'createdCompletedCurrentMonth' => $createdCompletedCurrentMonth, 'createdCompletedLastMonth' => $createdCompletedLastMonth, 'createdPendingCurrentMonth' => $createdPendingCurrentMonth, 'createdPendingLastMonth' => $createdPendingLastMonth]);
    }
}
