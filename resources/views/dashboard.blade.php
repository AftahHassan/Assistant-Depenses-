<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="flex items-center gap-4 mb-6">
                    <div class="p-3 rounded-xl bg-indigo-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 12l2 2 4-4"/><path d="M12 2a10 10 0 1 0 10 10"/></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-900">{{ __("You're logged in!") }}</h3>
                        <p class="text-sm text-gray-500">Bienvenue sur votre assistant de gestion des dépenses.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8">
                    <a href="{{ route('recus.create') }}"
                       class="flex items-center gap-4 p-4 rounded-xl border border-gray-200 hover:border-indigo-200 hover:bg-indigo-50/50 transition group">
                        <div class="p-2.5 rounded-lg bg-indigo-100 group-hover:bg-indigo-200 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14m-7-7h14"/></svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Soumettre un reçu</p>
                            <p class="text-xs text-gray-500">Extraire les dépenses via IA</p>
                        </div>
                    </a>
                    <a href="{{ route('recus.index') }}"
                       class="flex items-center gap-4 p-4 rounded-xl border border-gray-200 hover:border-indigo-200 hover:bg-indigo-50/50 transition group">
                        <div class="p-2.5 rounded-lg bg-indigo-100 group-hover:bg-indigo-200 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Mes Reçus</p>
                            <p class="text-xs text-gray-500">Consulter l'historique</p>
                        </div>
                    </a>
                    <a href="{{ route('depenses.index') }}"
                       class="flex items-center gap-4 p-4 rounded-xl border border-gray-200 hover:border-indigo-200 hover:bg-indigo-50/50 transition group">
                        <div class="p-2.5 rounded-lg bg-indigo-100 group-hover:bg-indigo-200 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Dépenses</p>
                            <p class="text-xs text-gray-500">Toutes les dépenses extraites</p>
                        </div>
                    </a>
                    <a href="{{ route('profile.edit') }}"
                       class="flex items-center gap-4 p-4 rounded-xl border border-gray-200 hover:border-indigo-200 hover:bg-indigo-50/50 transition group">
                        <div class="p-2.5 rounded-lg bg-indigo-100 group-hover:bg-indigo-200 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        </div>
                        <div>
                            <p class="font-medium text-gray-900">Profil</p>
                            <p class="text-xs text-gray-500">Gérer votre compte</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
