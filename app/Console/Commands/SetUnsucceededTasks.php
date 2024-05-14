<?php

namespace App\Console\Commands;

use App\Services\DutyService;
use Illuminate\Console\Command;

class SetunsucceededTasks extends Command
{
    private DutyService $dutyService;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-unsucceeded-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(DutyService $dutyService)
    {
        $this->dutyService = $dutyService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $duties = $this->dutyService->getOvertimedDuties();
        foreach ($duties as $duty) {
            $duty->entries()->create([
                'house_id' => $duty->house_id,
                'user_id' => $duty->user_id,
                'is_succeed' => false,
                'title' => $duty->name,
                'is_generated' => true
            ]);
        }

    }
}
