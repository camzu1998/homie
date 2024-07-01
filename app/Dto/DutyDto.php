<?php

namespace App\Dto;

use Spatie\DataTransferObject\DataTransferObject;

class DutyDto extends DataTransferObject
{
    public string $name;
    public ?string $description;
    public ?int $user_id;
    public ?int $room_id;
    public string $status;
    public string $frequency;
    public string $start_date;
    public ?string $end_date;
    public ?int $owner_id;
}
