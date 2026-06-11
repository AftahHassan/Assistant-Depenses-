<?php

namespace App\Http\Controllers;

use App\Enums\StatutEnum;
use App\Http\Requests\StoreRecuRequest;
use App\Models\Recu;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RecuController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $recus = Recu::with('depenses')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('recus.index', compact('recus'));
    }

    public function create()
    {
        return view('recus.create');
    }

    public function store(StoreRecuRequest $request)
    {
        $recu = Recu::create([
            'user_id'    => auth()->id(),
            'texte_brut' => $request->texte_brut,
            'statut'     => StatutEnum::EnAttente,
        ]);

        ExtraireDepensesDuRecu::dispatch($recu);

        return redirect()->route('recus.index')
            ->with('success', 'Reçu en cours de traitement.');
    }

    public function show(Recu $recu)
    {
        $this->authorize('view', $recu);

        $recu->load('depenses');

        return view('recus.show', compact('recu'));
    }

    public function destroy(Recu $recu)
    {
        $this->authorize('delete', $recu);

        $recu->delete();

        return redirect()->route('recus.index')
            ->with('success', 'Reçu supprimé.');
    }
}