<?php

namespace App\Services;

use App\Models\Duty;
use App\Repositories\DutyRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class DutyService
{
    private DutyRepository $dutyRepository;
    public function __construct(DutyRepository $dutyRepository)
    {
        $this->dutyRepository = $dutyRepository;
    }

    public function getOvertimedDuties(): Collection
    {
        return $this->dutyRepository->get()->reject(function (Duty $duty) {
            return !Carbon::parse($duty->next_execution_date)->isFuture();
        });
    }
}
