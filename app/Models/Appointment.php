<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'user_id', 'date', 'time', 'subject', 'channel', 'advisor', 'notes', 'status',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function channelLabel(): string
    {
        return match ($this->channel) {
            'video'  => 'Visioconférence',
            'agency' => 'En agence',
            'call'   => 'Téléphone',
            'chat'   => 'Chat',
            default  => $this->channel,
        };
    }
}
