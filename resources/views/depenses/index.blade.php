<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">
            Dépenses
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4">

        <form method="GET" class="mb-6 flex items-center gap-4">
            <label for="categorie" class="text-sm font-medium text-gray-700">Filtrer par catégorie</label>
            <select name="categorie" id="categorie"
                    class="border border-gray-300 rounded-xl px-3 py-2 text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                    onchange="this.form.submit()">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $cat)
                    @php
                        $catLabel = match($cat) {
                            \App\Enums\CategorieEnum::Alimentaire => 'Alimentaire',
                            \App\Enums\CategorieEnum::Boissons => 'Boissons',
                            \App\Enums\CategorieEnum::Hygiene => 'Hygiène',
                            \App\Enums\CategorieEnum::Entretien => 'Entretien',
                            \App\Enums\CategorieEnum::Autre => 'Autre',
                        };
                    @endphp
                    <option value="{{ $cat->value }}"
                        {{ request('categorie') === $cat->value ? 'selected' : '' }}>
                        {{ $catLabel }}
                    </option>
                @endforeach
            </select>
            @if(request('categorie'))
                <a href="{{ route('depenses.index') }}"
                   class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                    Réinitialiser
                </a>
            @endif
        </form>

        @if($depenses->isEmpty())
            <div class="text-center py-16">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                <h3 class="text-lg font-medium text-gray-900 mb-1">Aucune dépense trouvée</h3>
                <p class="text-sm text-gray-500">Aucune dépense ne correspond à vos critères.</p>
            </div>
        @else
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Libellé</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Quantité</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Prix unitaire</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Catégorie</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Date du reçu</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($depenses as $depense)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $depense->libelle }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700">{{ $depense->quantite }}</td>
                                <td class="px-4 py-3 text-sm text-gray-700 font-medium">{{ number_format($depense->prix_unitaire, 2) }} MAD</td>
                                <td class="px-4 py-3">
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
                                <td class="px-4 py-3 text-sm text-gray-500">
                                    {{ $depense->recu->created_at->format('d/m/Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
