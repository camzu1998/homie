<?php

namespace App\Http\Controllers;


use App\Services\DashboardService;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    private DashboardService $dashboardService;
    public function __construct(
        DashboardService $dashboardService
    )
    {
        $this->dashboardService = $dashboardService;
    }
    public function dashboardData(): JsonResponse
    {
        $tasks = $this->dashboardService->getTasks();
        $doneTasks = $tasks->where('status', 'done')->take(3);
        $week = $this->dashboardService->getTasksForWeekTimeline($tasks);
        return response()->json([
            'tasks' => $tasks->take(3),
            'doneTasks' => $doneTasks,
            'week' => $week,
        ]);
    }
}
