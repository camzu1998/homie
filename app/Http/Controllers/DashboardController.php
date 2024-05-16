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
        $doneTasks = $tasks->where('status', 'done');
        $week = $this->dashboardService->getTasksForWeekTimeline($tasks);
        $todayDutiesCount = $tasks->where('execution_date', today())->count();
        $addedDutiesCount = auth()->user()->createdDuties->count();
        $doneDutiesCount = $doneTasks->count();

        return response()->json([
            'tasks' => $tasks->take(3),
            'doneTasks' => $doneTasks->take(3),
            'week' => $week,
            'todayDutiesCount' => $todayDutiesCount,
            'addedDutiesCount' => $addedDutiesCount,
            'doneDutiesCount' => $doneDutiesCount,
        ]);
    }
}
