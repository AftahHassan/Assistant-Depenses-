<?php

namespace App\Http\Controllers;

use App\Enums\CategorieEnum;
use App\Models\Depense;
use Illuminate\Http\Request;

class DepenseController extends Controller
{
    public function index(Request $request)
    {
        $categorie = $request->query('categorie');

        $depenses = Depense::select('depenses.*')
            ->join('recus', 'depenses.recu_id', '=', 'recus.id')
            ->with('recu')
            ->where('recus.user_id', auth()->id())
            ->when($categorie, fn ($q) => $q->where('depenses.categorie', $categorie))
            ->orderBy('recus.created_at', 'desc')
            ->get();

        $categories = CategorieEnum::cases();

        return view('depenses.index', compact('depenses', 'categories'));
    }
}
