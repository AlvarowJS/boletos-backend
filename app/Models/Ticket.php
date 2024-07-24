<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ticket extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'dateRegister',
        'event_day_id',
        'validate',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        // 'dateRegister' => 'date',
        'event_day_id' => 'integer',
    ];

    public function eventDay(): BelongsTo
    {
        return $this->belongsTo(EventDay::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
