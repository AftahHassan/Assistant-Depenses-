<?php

namespace App\AI;

use App\Enums\CategorieEnum;
use Illuminate\Contracts\JsonSchema\JsonSchema;

class ArticleExtrait
{
    public function __construct(
        public readonly string $libelle,
        public readonly int $quantite,
        public readonly float $prix_unitaire,
        public readonly CategorieEnum $categorie,
    ) {}

    public static function schema(JsonSchema $schema): array
    {
        return [
            'libellé' => $schema->string()->required(),
            'quantité' => $schema->integer()->required()->min(1),
            'prix_unitaire' => $schema->number()->required()->min(0),
            'catégorie' => $schema->string()->enum(CategorieEnum::class)->required(),
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            libelle: $data['libellé'] ?? '',
            quantite: (int) ($data['quantité'] ?? 0),
            prix_unitaire: (float) ($data['prix_unitaire'] ?? 0),
            categorie: CategorieEnum::tryFrom($data['catégorie'] ?? '') ?? CategorieEnum::Autre,
        );
    }
}
