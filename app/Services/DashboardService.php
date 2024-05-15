<?php

namespace App\Services;

use App\Enums\DutyFrequency;
use App\Models\Duty;
use App\Models\User;
use App\Repositories\DutyRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class DashboardService
{
    private DutyRepository $dutyRepository;

    public function __construct(DutyRepository $dutyRepository)
    {
        $this->dutyRepository = $dutyRepository;
    }

    public function getTasks(): Collection
    {
        $duties = $this->dutyRepository->get();

        $tasks = collect();
        foreach ($duties as $duty) {
            $tasks->push([
                'id' => $duty->id,
                'name' => $duty->name,
                'execution_date' => $duty->next_execution_date,
                'status' => $duty->task_status,
                'color' => $this->getDutyColor(Carbon::parse($duty->next_execution_date), $duty->task_status == 'done'),
            ]);
        }

        return $tasks;
    }
    public function getTasksForWeekTimeline(Collection|null $tasks = null): array
    {
        $array = [];
        if ($tasks === null) {
            $tasks = $this->getTasks();
        }
        foreach ($tasks as $task) {
            $array[] = [
                'name' => $task['name'],
                'date' => Carbon::parse($task['execution_date'])->format('Y-m-d')
            ];
        }
        return $array;
    }

    private function getDutyColor(Carbon $executionDate, bool $isSucceeded = false): string
    {
        if ($isSucceeded) {
            return 'success';
        }

        if ($executionDate->isYesterday()) {
            return 'warning';
        } elseif ($executionDate->isToday()) {
            return 'primary';
        } elseif ($executionDate->isFuture()) {
            return 'info';
        }

        return 'danger';
    }
}
