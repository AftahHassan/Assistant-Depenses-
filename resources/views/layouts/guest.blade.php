<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Assistant Dépenses') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen grid lg:grid-cols-2">

            {{-- Colonne gauche : formulaire --}}
            <div class="flex flex-col justify-center px-6 py-12 sm:px-12 lg:px-20">
                <div class="mx-auto w-full max-w-sm">
                    <div class="mb-8 flex items-center gap-3">
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        </div>
                        <span class="text-lg font-bold tracking-tight text-gray-900">
                            {{ config('app.name', 'Assistant Dépenses') }}
                        </span>
                    </div>

                    {{ $slot }}
                </div>
            </div>

            {{-- Colonne droite : image / pitch --}}
            <div class="hidden lg:flex relative bg-indigo-600 items-center justify-center overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-indigo-600 via-indigo-700 to-purple-700"></div>

                {{-- décor --}}
                <div class="absolute -top-24 -right-24 h-96 w-96 rounded-full bg-white/10 blur-3xl"></div>
                <div class="absolute -bottom-24 -left-24 h-96 w-96 rounded-full bg-white/10 blur-3xl"></div>

                <div class="relative z-10 max-w-md px-10 text-center text-white">
                    <div class="mx-auto mb-8 flex h-20 w-20 items-center justify-center rounded-2xl bg-white/10 backdrop-blur-sm border border-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-8 2a2 2 0 1 1-4 0 2 2 0 0 1 4 0z"/></svg>
                    </div>
                    <h2 class="text-3xl font-bold tracking-tight mb-4">
                        Vos reçus, transformés en dépenses en un clic
                    </h2>
                    <p class="text-indigo-100 text-base leading-relaxed">
                        Collez le texte de votre reçu fournisseur, notre IA extrait
                        automatiquement chaque article, sa quantité, son prix et sa
                        catégorie — sans saisie manuelle.
                    </p>

                    <div class="mt-10 grid grid-cols-3 gap-4 text-left">
                        <div class="rounded-xl bg-white/10 backdrop-blur-sm border border-white/10 p-4">
                            <p class="text-2xl font-bold">100%</p>
                            <p class="text-xs text-indigo-100 mt-1">Automatisé</p>
                        </div>
                        <div class="rounded-xl bg-white/10 backdrop-blur-sm border border-white/10 p-4">
                            <p class="text-2xl font-bold">5s</p>
                            <p class="text-xs text-indigo-100 mt-1">Extraction</p>
                        </div>
                        <div class="rounded-xl bg-white/10 backdrop-blur-sm border border-white/10 p-4">
                            <p class="text-2xl font-bold">5</p>
                            <p class="text-xs text-indigo-100 mt-1">Catégories</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>