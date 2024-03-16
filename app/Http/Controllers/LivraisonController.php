<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Livraison;
use Illuminate\Http\Request;

class LivraisonController extends Controller
{
    public function get_livreur_name($id)
    {
        $livreur = User::find($id);

        return response()->json([
            'livreur_name' => $livreur ? $livreur->name : null,
        ], 200);
    }


    public function get_all_livraisons($id)
    {
        $livraisons = Livraison::where('livreur_id', $id)
            ->latest('created_at')
            ->get();

        return response()->json([
            'livraisons' => $livraisons,
        ], 200);
    }

}
