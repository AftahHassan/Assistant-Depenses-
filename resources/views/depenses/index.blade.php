<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dépenses
        </h2>
    </x-slot>

    <div class="py-8 max-w-5xl mx-auto px-4">

        <form method="GET" class="mb-6 flex items-center gap-4">
            <label for="categorie" class="text-gray-700 font-medium">Filtrer par catégorie</label>
            <select name="categorie" id="categorie"
                    class="border rounded px-3 py-2"
                    onchange="this.form.submit()">
                <option value="">Toutes les catégories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->value }}"
                        {{ request('categorie') === $cat->value ? 'selected' : '' }}>
                        {{ match($cat) {
                            \App\Enums\CategorieEnum::Alimentaire => 'Alimentaire',
                            \App\Enums\CategorieEnum::Boissons => 'Boissons',
                            \App\Enums\CategorieEnum::Hygiene => 'Hygiène',
                            \App\Enums\CategorieEnum::Entretien => 'Entretien',
                            \App\Enums\CategorieEnum::Autre => 'Autre',
                        } }}
                    </option>
                @endforeach
            </select>
            @if(request('categorie'))
                <a href="{{ route('depenses.index') }}"
                   class="text-sm text-blue-600 hover:underline">
                    Réinitialiser
                </a>
            @endif
        </form>

        @if($depenses->isEmpty())
            <p class="text-gray-500">Aucune dépense trouvée.</p>
        @else
            <table class="w-full bg-white shadow rounded">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Libellé</th>
                        <th class="p-3 text-left">Quantité</th>
                        <th class="p-3 text-left">Prix unitaire</th>
                        <th class="p-3 text-left">Catégorie</th>
                        <th class="p-3 text-left">Date du reçu</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($depenses as $depense)
                        <tr class="border-t">
                            <td class="p-3">{{ $depense->libelle }}</td>
                            <td class="p-3">{{ $depense->quantite }}</td>
                            <td class="p-3">{{ number_format($depense->prix_unitaire, 2) }} MAD</td>
                            <td class="p-3">
                                @php
                                    $label = match($depense->categorie) {
                                        \App\Enums\CategorieEnum::Alimentaire => 'Alimentaire',
                                        \App\Enums\CategorieEnum::Boissons => 'Boissons',
                                        \App\Enums\CategorieEnum::Hygiene => 'Hygiène',
                                        \App\Enums\CategorieEnum::Entretien => 'Entretien',
                                        \App\Enums\CategorieEnum::Autre => 'Autre',
                                    };
                                @endphp
                                {{ $label }}
                            </td>
                            <td class="p-3">
                                {{ $depense->recu->created_at->format('d/m/Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
