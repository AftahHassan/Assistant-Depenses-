<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mes Reçus
        </h2>
    </x-slot>

    <div class="py-8 max-w-4xl mx-auto px-4">

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4">
            <a href="{{ route('recus.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Nouveau reçu
            </a>
        </div>

        @if($recus->isEmpty())
            <p class="text-gray-500">Aucun reçu pour le moment.</p>
        @else
            <table class="w-full bg-white shadow rounded">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3 text-left">Date</th>
                        <th class="p-3 text-left">Statut</th>
                        <th class="p-3 text-left">Dépenses</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recus as $recu)
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
                        <tr class="border-t">
                            <td class="p-3">{{ $recu->created_at->format('d/m/Y H:i') }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-sm {{ $couleur }}">
                                    {{ $label }}
                                </span>
                            </td>
                            <td class="p-3">{{ $recu->depenses->count() }} dépense(s)</td>
                            <td class="p-3 flex gap-2">
                                <a href="{{ route('recus.show', $recu) }}"
                                   class="text-blue-600 hover:underline">Voir</a>
                                <form action="{{ route('recus.destroy', $recu) }}"
                                      method="POST"
                                      onsubmit="return confirm('Supprimer ce reçu ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">
                                        Supprimer
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>