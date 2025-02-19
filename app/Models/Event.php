<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'eventName',
        'eventImage',
        'startDate',
        'endingDate',
        'place',
        'description'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        // 'startDate' => 'date',
        // 'endingDate' => 'date',
    ];

    public function eventDays(): HasMany
    {
        return $this->hasMany(EventDay::class);
    }
}
