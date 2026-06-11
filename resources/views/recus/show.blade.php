<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                Détail du reçu
            </h2>
            <a href="{{ route('recus.index') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5m7 7l-7-7 7-7"/></svg>
                Retour
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4 space-y-6">

        @php
            $badge = match($recu->statut) {
                \App\Enums\StatutEnum::EnAttente => 'bg-amber-100 text-amber-800',
                \App\Enums\StatutEnum::Traite    => 'bg-emerald-100 text-emerald-800',
                \App\Enums\StatutEnum::Echoue   => 'bg-red-100 text-red-800',
            };
            $label = match($recu->statut) {
                \App\Enums\StatutEnum::EnAttente => 'En attente',
                \App\Enums\StatutEnum::Traite    => 'Traité',
                \App\Enums\StatutEnum::Echoue   => 'Échoué',
            };
        @endphp

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Soumis le {{ $recu->created_at->format('d/m/Y à H:i') }}</p>
            </div>
            <span class="inline-flex items-center gap-1.5 rounded-full px-4 py-1.5 text-sm font-medium {{ $badge }}">
                @if($recu->statut === \App\Enums\StatutEnum::EnAttente)
                    <svg class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                @elseif($recu->statut === \App\Enums\StatutEnum::Traite)
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                @else
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                @endif
                {{ $label }}
            </span>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Texte source</h3>
                <button type="button"
                        onclick="document.getElementById('source-text').classList.toggle('line-clamp-6')"
                        class="text-xs text-indigo-600 hover:text-indigo-700 font-medium">
                    Afficher / Masquer
                </button>
            </div>
            <pre id="source-text" class="text-sm text-gray-700 whitespace-pre-wrap line-clamp-6">{{ $recu->texte_brut }}</pre>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="p-6 pb-3">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">Dépenses extraites</h3>
            </div>

            @if($recu->statut === \App\Enums\StatutEnum::EnAttente)
                <div class="px-6 pb-6 flex items-center gap-3 text-amber-700">
                    <svg class="h-5 w-5 animate-spin" viewBox="0 0 24 24" fill="none">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    <span class="text-sm font-medium">Extraction en cours...</span>
                </div>
            @elseif($recu->statut === \App\Enums\StatutEnum::Echoue)
                <div class="mx-6 mb-6 p-4 bg-red-50 border border-red-200 rounded-xl flex items-start gap-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mt-0.5 shrink-0 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    <div>
                        <p class="text-sm font-medium text-red-800">Extraction échouée</p>
                        <p class="text-xs text-red-600 mt-0.5">Une erreur s'est produite lors du traitement. Vous pouvez réessayer en soumettant à nouveau le reçu.</p>
                    </div>
                </div>
            @elseif($recu->depenses->isEmpty())
                <div class="px-6 pb-6 text-sm text-gray-500">Aucune dépense extraite.</div>
            @else
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Libellé</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Quantité</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Prix unitaire</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Catégorie</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($recu->depenses as $depense)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3 text-sm text-gray-700">{{ $depense->libelle }}</td>
                                <td class="px-6 py-3 text-sm text-gray-700">{{ $depense->quantite }}</td>
                                <td class="px-6 py-3 text-sm text-gray-700 font-medium">{{ number_format($depense->prix_unitaire, 2) }} MAD</td>
                                <td class="px-6 py-3">
                                    @php
                                        $catBadge = match($depense->categorie) {
                                            \App\Enums\CategorieEnum::Alimentaire => 'bg-blue-100 text-blue-700',
                                            \App\Enums\CategorieEnum::Boissons => 'bg-cyan-100 text-cyan-700',
                                            \App\Enums\CategorieEnum::Hygiene => 'bg-purple-100 text-purple-700',
                                            \App\Enums\CategorieEnum::Entretien => 'bg-orange-100 text-orange-700',
                                            \App\Enums\CategorieEnum::Autre => 'bg-gray-100 text-gray-700',
                                        };
                                        $catLabel = match($depense->categorie) {
                                            \App\Enums\CategorieEnum::Alimentaire => 'Alimentaire',
                                            \App\Enums\CategorieEnum::Boissons => 'Boissons',
                                            \App\Enums\CategorieEnum::Hygiene => 'Hygiène',
                                            \App\Enums\CategorieEnum::Entretien => 'Entretien',
                                            \App\Enums\CategorieEnum::Autre => 'Autre',
                                        };
                                    @endphp
                                    <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $catBadge }}">
                                        {{ $catLabel }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-app-layout>
