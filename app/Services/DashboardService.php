<?php

namespace App\Services;

use App\Enums\DutyFrequency;
use App\Models\Duty;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class DashboardService
{
    private User $user;

    public function getTasks(): Collection
    {
        $this->user = auth()->user()->load(['pickedHouse.duties.entries', 'pickedHouse.entries']);

        $tasks = collect();
        foreach ($this->user->pickedHouse->duties as $duty) {
            if (
                $duty->status != 'active' &&
                !($this->compareDutyFrequency($duty) && $duty->last_performed != null) &&
                ($duty->user_id != $this->user->id && !empty($duty->user_id))
            ) {
                continue;
            }
            $lastEntry = $duty->entries->last();
            do {
                $lastPerformed = Carbon::parse($duty->start_date);
                $frequency = DutyFrequency::fromKey(Str::upper($duty->frequency));
                $nextExecutionDate = $lastPerformed->addDays($frequency->value);
            } while ($nextExecutionDate->gte(now()));

            $tasks->push([
                'id' => $duty->id,
                'name' => $duty->name,
                'execution_date' => $nextExecutionDate->format('d-m-Y'),
                'status' => $lastEntry->is_succeed ?? false ? 'done' : 'to be done',
                'color' => $this->getDutyColor($nextExecutionDate, $lastEntry->is_succeed ?? false),
            ]);
        }

        return $tasks;
    }

    private function compareDutyFrequency(Duty $duty): bool
    {
        $lastPerformed = Carbon::parse($duty->last_performed ?? $duty->start_date);
        $frequency = DutyFrequency::fromKey(Str::upper($duty->frequency));
        $taskExecutionRangeStart = now()->subDays(5);
        $taskExecutionRangeEnd = now()->addDay();
        $nextTaskExecutionDate = $lastPerformed->addDays($frequency->value);

        return $nextTaskExecutionDate->gte($taskExecutionRangeStart) && $nextTaskExecutionDate->lte($taskExecutionRangeEnd);
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
        } elseif ($executionDate->isTomorrow()) {
            return 'info';
        }

        return 'danger';
    }
}
