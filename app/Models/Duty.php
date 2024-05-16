<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Duty extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'description',
        'user_id',
        'room_id',
        'house_id',
        'status',
        'frequency',
        'start_date',
        'end_date',
        'last_performed',
    ];

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function entries(): MorphMany
    {
        return $this->morphMany(Entry::class, 'entriesable');
    }
}
