<?php

namespace App\Repositories;

use App\Enums\DutyFrequency;
use App\Models\Duty;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

class DutyRepository
{
    public function get(): Collection
    {
        $duties = collect();
        $user = auth()->user()->load(['pickedHouse.duties.entries']);

        foreach ($user->pickedHouse->duties as $duty) {
            if (
                $duty->status != 'active' &&
                (
                    !($this->compareDutyFrequency($duty) && $duty->last_performed != null) ||
                    ($duty->user_id != $this->user->id && !empty($duty->user_id))
                )
            ) {
                continue;
            }
            $lastPerformed = Carbon::parse($duty->last_performed ?? $duty->start_date);
            $frequency = DutyFrequency::fromKey(Str::upper($duty->frequency));
            $nextExecutionDate = $lastPerformed->addDays($frequency->value);
            $duty->next_execution_date = $nextExecutionDate->format('d-m-Y');
            $duty->task_status = $this->getStatus(optional($duty->entries->last())->is_succeed); //Todo: check if last entry is executed near the execution date

            $duties->push($duty);
        }

        return $duties;
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

    private function getStatus(null|bool $isSucceeded = null): string
    {
        if ($isSucceeded === null) {
            return 'to be done';
        }

        return !$isSucceeded ? 'overtimed' : 'done';
    }
}
