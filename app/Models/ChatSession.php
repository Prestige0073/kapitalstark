<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatSession extends Model
{
    protected $fillable = ['token', 'ip_address', 'user_agent', 'last_seen_at'];

    protected $casts = ['last_seen_at' => 'datetime'];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'session_id');
    }

    public function lastMessage()
    {
        return $this->hasOne(ChatMessage::class, 'session_id')->latestOfMany();
    }

    public function unreadCount()
    {
        return $this->messages()->where('direction', 'visitor')->where('read', false)->count();
    }
}
