<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    protected $fillable = [
        'user_id', 'type', 'amount', 'remaining', 'monthly',
        'rate', 'start_date', 'end_date', 'progress', 'status', 'next_payment_date',
    ];

    protected $casts = [
        'start_date'        => 'date',
        'end_date'          => 'date',
        'next_payment_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function typeLabel(): string
    {
        return match ($this->type) {
            'immobilier' => 'Prêt Immobilier',
            'automobile' => 'Prêt Automobile',
            'personnel'  => 'Prêt Personnel',
            'entreprise' => 'Prêt Entreprise',
            'agricole'   => 'Prêt Agricole',
            'microcredit'=> 'Microcrédit',
            default      => ucfirst($this->type),
        };
    }

    public function typeIcon(): string
    {
        return match ($this->type) {
            'immobilier' => '🏠',
            'automobile' => '🚗',
            'personnel'  => '💳',
            'entreprise' => '🏢',
            'agricole'   => '🌾',
            'microcredit'=> '🤝',
            default      => '💰',
        };
    }

    public function statusLabel(): string
    {
        return match ($this->status) {
            'active' => 'Actif',
            'closed' => 'Clôturé',
            'late'   => 'En retard',
            default  => 'Inconnu',
        };
    }
}
