<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'house_id',
        'owner_id',
        'user_id',
        'entriesable_id',
        'entriesable_type',
        'title',
        'description',
        'is_succeed',
        'is_generated'
    ];

    public function entriesable(): MorphTo
    {
        return $this->morphTo();
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
