<?php

namespace App\Models;

use App\Enums\StatutEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Recu extends Model
{
    protected $fillable = [
        'user_id',
        'texte_brut',
        'statut',
        'payload_brut',
    ];

    protected function casts(): array
    {
        return [
            'statut' => StatutEnum::class,
            'payload_brut' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function depenses(): HasMany
    {
        return $this->hasMany(Depense::class, 'recu_id');
    }
}
