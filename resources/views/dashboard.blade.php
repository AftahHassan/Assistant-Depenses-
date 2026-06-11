<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                    Dashboard
                </h2>
                <p class="text-sm text-gray-500 mt-0.5">
                    Bienvenue {{ auth()->user()->name }} 👋 — voici l'aperçu de vos dépenses.
                </p>
            </div>
            <a href="{{ route('recus.create') }}"
               class="inline-flex items-center gap-2 rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14m-7-7h14"/></svg>
                Nouveau reçu
            </a>
        </div>
    </x-slot>

    <div class="py-8 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

        {{-- KPIs --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <div class="p-2.5 rounded-xl bg-indigo-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $nb_recus_total }}</p>
                <p class="text-sm text-gray-500 mt-1">Reçus totaux</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <div class="p-2.5 rounded-xl bg-emerald-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $nb_recus_traites }}</p>
                <p class="text-sm text-gray-500 mt-1">Reçus traités</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <div class="p-2.5 rounded-xl bg-amber-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ $nb_recus_en_attente }}</p>
                <p class="text-sm text-gray-500 mt-1">En attente</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
                <div class="flex items-center justify-between mb-3">
                    <div class="p-2.5 rounded-xl bg-blue-50">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900">{{ number_format($total_depenses, 2) }} <span class="text-base font-medium text-gray-400">MAD</span></p>
                <p class="text-sm text-gray-500 mt-1">Dépenses totales</p>
            </div>
        </div>

        {{-- Répartition par catégorie + Activité récente --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            {{-- Répartition catégories --}}
            <div class="lg:col-span-1 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider mb-4">
                    Répartition par catégorie
                </h3>

                @php
                    $colors = [
                        'Alimentaire' => 'bg-blue-500',
                        'Boissons' => 'bg-cyan-500',
                        'Hygiène' => 'bg-purple-500',
                        'Entretien' => 'bg-orange-500',
                        'Autre' => 'bg-gray-400',
                    ];
                    $maxVal = max(array_values($depenses_par_categorie) ?: [1]);
                @endphp

                <div class="space-y-4">
                    @foreach($depenses_par_categorie as $cat => $montant)
                        <div>
                            <div class="flex justify-between text-sm mb-1">
                                <span class="font-medium text-gray-700">{{ $cat }}</span>
                                <span class="text-gray-500">{{ number_format($montant, 2) }} MAD</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-2">
                                <div class="{{ $colors[$cat] ?? 'bg-gray-400' }} h-2 rounded-full transition-all"
                                     style="width: {{ $maxVal > 0 ? ($montant / $maxVal * 100) : 0 }}%"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Activité récente --}}
            <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-gray-900 uppercase tracking-wider">
                        Activité récente
                    </h3>
                    <a href="{{ route('recus.index') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">
                        Voir tout
                    </a>
                </div>

                @if($recents->isEmpty())
                    <div class="text-center py-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 mx-auto text-gray-300 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        <p class="text-sm text-gray-500">Aucune activité pour le moment.</p>
                    </div>
                @else
                    <div class="divide-y divide-gray-100">
                        @foreach($recents as $recu)
                            @php
                                $iconBg = match($recu->statut) {
                                    \App\Enums\StatutEnum::Traite => 'bg-emerald-100 text-emerald-600',
                                    \App\Enums\StatutEnum::Echoue => 'bg-red-100 text-red-600',
                                    default => 'bg-amber-100 text-amber-600',
                                };
                                $title = match($recu->statut) {
                                    \App\Enums\StatutEnum::Traite => 'Extraction terminée',
                                    \App\Enums\StatutEnum::Echoue => 'Extraction échouée',
                                    default => 'Reçu en cours de traitement',
                                };
                            @endphp
                            <a href="{{ route('recus.show', $recu) }}" class="flex items-center gap-4 py-3 hover:bg-gray-50 -mx-2 px-2 rounded-xl transition">
                                <div class="p-2 rounded-lg {{ $iconBg }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-medium text-gray-900">{{ $title }}</p>
                                    <p class="text-xs text-gray-500">{{ $recu->depenses->count() }} dépense(s) extraite(s)</p>
                                </div>
                                <span class="text-xs text-gray-400 shrink-0">{{ $recu->created_at->diffForHumans() }}</span>
                            </a>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Accès rapides --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <a href="{{ route('recus.create') }}"
               class="flex items-center gap-4 p-4 rounded-2xl border border-gray-200 bg-white hover:border-indigo-200 hover:shadow-md transition group">
                <div class="p-2.5 rounded-xl bg-indigo-100 group-hover:bg-indigo-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14m-7-7h14"/></svg>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Soumettre un reçu</p>
                    <p class="text-xs text-gray-500">Extraire les dépenses via IA</p>
                </div>
            </a>
            <a href="{{ route('recus.index') }}"
               class="flex items-center gap-4 p-4 rounded-2xl border border-gray-200 bg-white hover:border-indigo-200 hover:shadow-md transition group">
                <div class="p-2.5 rounded-xl bg-indigo-100 group-hover:bg-indigo-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Mes Reçus</p>
                    <p class="text-xs text-gray-500">Consulter l'historique</p>
                </div>
            </a>
            <a href="{{ route('depenses.index') }}"
               class="flex items-center gap-4 p-4 rounded-2xl border border-gray-200 bg-white hover:border-indigo-200 hover:shadow-md transition group">
                <div class="p-2.5 rounded-xl bg-indigo-100 group-hover:bg-indigo-200 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <div>
                    <p class="font-medium text-gray-900">Dépenses</p>
                    <p class="text-xs text-gray-500">Toutes les dépenses extraites</p>
                </div>
            </a>
        </div>
    </div>
</x-app-layout>