<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Détail du reçu
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4">

        <div class="mb-6 p-4 bg-white shadow rounded">
            <p class="text-gray-600 mb-2">
                Soumis le {{ $recu->created_at->format('d/m/Y à H:i') }}
            </p>
            @php
                $couleur = match($recu->statut) {
                    \App\Enums\StatutEnum::EnAttente => 'bg-yellow-100 text-yellow-800',
                    \App\Enums\StatutEnum::Traite    => 'bg-green-100 text-green-800',
                    \App\Enums\StatutEnum::Echoue   => 'bg-red-100 text-red-800',
                };
                $label = match($recu->statut) {
                    \App\Enums\StatutEnum::EnAttente => 'En attente',
                    \App\Enums\StatutEnum::Traite    => 'Traité',
                    \App\Enums\StatutEnum::Echoue   => 'Échoué',
                };
            @endphp
            <span class="px-3 py-1 rounded {{ $couleur }}">{{ $label }}</span>
        </div>

        <div class="mb-6 p-4 bg-white shadow rounded">
            <h3 class="font-semibold mb-2">Texte source</h3>
            <pre class="text-sm text-gray-700 whitespace-pre-wrap">{{ $recu->texte_brut }}</pre>
        </div>

        <div class="p-4 bg-white shadow rounded">
            <h3 class="font-semibold mb-4">Dépenses extraites</h3>

            @if($recu->statut === \App\Enums\StatutEnum::EnAttente)
                <p class="text-yellow-600">⏳ Extraction en cours...</p>
            @elseif($recu->statut === \App\Enums\StatutEnum::Echoue)
                <p class="text-red-600">❌ Extraction échouée.</p>
            @elseif($recu->depenses->isEmpty())
                <p class="text-gray-500">Aucune dépense extraite.</p>
            @else
                <table class="w-full border-collapse">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-3 text-left">Libellé</th>
                            <th class="p-3 text-left">Quantité</th>
                            <th class="p-3 text-left">Prix unitaire</th>
                            <th class="p-3 text-left">Catégorie</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recu->depenses as $depense)
                            <tr class="border-t">
                                <td class="p-3">{{ $depense->libelle }}</td>
                                <td class="p-3">{{ $depense->quantite }}</td>
                                <td class="p-3">{{ number_format($depense->prix_unitaire, 2) }} MAD</td>
                                <td class="p-3 capitalize">{{ $depense->categorie->value }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <div class="mt-4">
            <a href="{{ route('recus.index') }}" class="text-blue-600 hover:underline">
                 Retour à la liste
            </a>
        </div>
    </div>
</x-app-layout>