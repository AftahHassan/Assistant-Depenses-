<?php

namespace App\AI;

use Illuminate\Contracts\JsonSchema\JsonSchema;

class ReponseIA
{
    /** @var ArticleExtrait[] */
    public readonly array $articles;

    public function __construct(
        array $articles,
        public readonly float $total_estime,
        public readonly string $devise,
    ) {
        $this->articles = $articles;
    }

    public static function schema(JsonSchema $schema): array
    {
        return [
            'articles' => $schema->array()
                ->items($schema->object(ArticleExtrait::schema($schema)))
                ->required(),
            'total_estimé' => $schema->number()->required()->min(0),
            'devise' => $schema->string()->required(),
        ];
    }

    public static function fromArray(array $data): self
    {
        return new self(
            articles: array_map(
                fn (array $item) => ArticleExtrait::fromArray($item),
                $data['articles'] ?? [],
            ),
            total_estime: (float) ($data['total_estimé'] ?? 0),
            devise: $data['devise'] ?? 'EUR',
        );
    }
}
