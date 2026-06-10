<?php

namespace App\Models;

use App\Enums\CategorieEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Depense extends Model
{
    protected $fillable = [
        'recu_id',
        'libelle',
        'quantite',
        'prix_unitaire',
        'categorie',
    ];

    protected function casts(): array
    {
        return [
            'quantite' => 'integer',
            'prix_unitaire' => 'decimal:2',
            'categorie' => CategorieEnum::class,
        ];
    }

    public function recu(): BelongsTo
    {
        return $this->belongsTo(Recu::class, 'recu_id');
    }
}
