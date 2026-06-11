<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Soumettre un reçu
        </h2>
    </x-slot>

    <div class="py-8 max-w-2xl mx-auto px-4">
        <form action="{{ route('recus.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Texte du reçu</label>
                <textarea
                    name="texte_brut"
                    rows="10"
                    class="w-full border rounded p-3 @error('texte_brut') border-red-500 @enderror"
                    placeholder="Colle le texte de ton reçu ici...">{{ old('texte_brut') }}</textarea>
                @error('texte_brut')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                Lancer l'extraction
            </button>
            <a href="{{ route('recus.index') }}" class="ml-4 text-gray-600 hover:underline">
                Annuler
            </a>
        </form>
    </div>
</x-app-layout>