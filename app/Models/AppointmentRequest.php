<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppointmentRequest extends Model
{
    protected $fillable = [
        'first_name', 'last_name', 'phone', 'email',
        'project_type', 'date', 'time', 'notes', 'ip', 'handled',
    ];

    protected $casts = [
        'date' => 'date',
    ];
}
