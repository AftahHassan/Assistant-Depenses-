<?php

namespace App\Jobs;

use App\AI\ReponseIA;
use App\Enums\StatutEnum;
use App\Models\Recu;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;
use Laravel\Ai\Messages\UserMessage;

use function Laravel\Ai\agent;

class ExtraireDepensesDuRecu implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public Recu $recu,
    ) {}

    public function handle(): void
    {
        try {
            $response = agent(
                instructions: 'Extrais les dépenses à partir du texte du reçu fournisseur.',
                messages: [new UserMessage($this->recu->texte_brut)],
                schema: fn (JsonSchema $schema) => ReponseIA::schema($schema),
            )->prompt('', model: 'llama-3.1-8b-instant');

            $data = $response->toArray();

            $this->recu->payload_brut = $data;

            $reponseIA = ReponseIA::fromArray($data);

            foreach ($reponseIA->articles as $article) {
                $this->recu->depenses()->create([
                    'libelle' => $article->libelle,
                    'quantite' => $article->quantite,
                    'prix_unitaire' => $article->prix_unitaire,
                    'categorie' => $article->categorie,
                ]);
            }

            $this->recu->statut = StatutEnum::Traite;
            $this->recu->save();
        } catch (\Throwable $e) {
            $this->recu->statut = StatutEnum::Echoue;
            $this->recu->save();

            Log::error('ExtraireDepensesDuRecu a échoué', [
                'recu_id' => $this->recu->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
