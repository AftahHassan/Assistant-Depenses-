<?php

namespace App\Http\Controllers;

use App\Enums\CategorieEnum;
use App\Enums\StatutEnum;
use App\Models\Depense;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $nb_recus_total = $user->recus()->count();
        $nb_recus_traites = $user->recus()->where('statut', StatutEnum::Traite)->count();
        $nb_recus_en_attente = $user->recus()->where('statut', StatutEnum::EnAttente)->count();

        $total_depenses = (float) Depense::whereHas('recu', fn ($q) => $q->where('user_id', $user->id))
            ->selectRaw('SUM(quantite * prix_unitaire) as total')
            ->value('total') ?? 0;

        $categoryTotals = Depense::whereHas('recu', fn ($q) => $q->where('user_id', $user->id))
            ->selectRaw('categorie, SUM(quantite * prix_unitaire) as total')
            ->groupBy('categorie')
            ->pluck('total', 'categorie');

        $depenses_par_categorie = [];
        foreach (CategorieEnum::cases() as $case) {
            $depenses_par_categorie[$case->name] = (float) ($categoryTotals[$case->value] ?? 0);
        }

        $recents = $user->recus()
            ->with('depenses')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'nb_recus_total',
            'nb_recus_traites',
            'nb_recus_en_attente',
            'total_depenses',
            'depenses_par_categorie',
            'recents',
        ));
    }
}
