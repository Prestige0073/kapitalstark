<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    protected $fillable = [
        'user_id', 'loan_request_id', 'original_name', 'stored_name', 'category', 'mime', 'size_bytes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function loanRequest(): BelongsTo
    {
        return $this->belongsTo(LoanRequest::class);
    }

    public function formattedSize(): string
    {
        $bytes = $this->size_bytes;
        if ($bytes < 1024)    return $bytes . ' o';
        if ($bytes < 1048576) return round($bytes / 1024, 1) . ' Ko';
        return round($bytes / 1048576, 1) . ' Mo';
    }
}
