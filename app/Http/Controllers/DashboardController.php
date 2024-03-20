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
        return response()->json([
            'tasks' => $this->dashboardService->getTasks(),
        ]);
    }
}
