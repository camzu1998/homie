<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'picked_house_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function ownHouses(): HasMany
    {
        return $this->hasMany(House::class, 'owner_id');
    }

    public function houses(): BelongsToMany
    {
        return $this->belongsToMany(House::class)->withPivot(['status', 'last_viewed_entry_id']);
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class);
    }

    public function pickedHouse(): BelongsTo
    {
        return $this->belongsTo(House::class, 'picked_house_id');
    }

    public function createdEntries(): HasMany
    {
        return $this->hasMany(Entry::class, 'owner_id');
    }

    public function createdDuties(): HasMany
    {
        return $this->hasMany(Duty::class, 'owner_id');
    }

    public function duties(): HasMany
    {
        return $this->hasMany(Duty::class);
    }

    public function ownEntries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }

    public function entries(): MorphMany
    {
        return $this->morphMany(Entry::class, 'entriesable');
    }
}
