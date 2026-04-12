<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdminTemplateDocument extends Model
{
    protected $fillable = [
        'title', 'category', 'description',
        'file_path', 'original_name', 'mime', 'size_bytes', 'uploaded_by',
    ];

    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function sizeForHumans(): string
    {
        $kb = $this->size_bytes / 1024;
        if ($kb < 1024) return round($kb, 0) . ' Ko';
        return round($kb / 1024, 1) . ' Mo';
    }
}
