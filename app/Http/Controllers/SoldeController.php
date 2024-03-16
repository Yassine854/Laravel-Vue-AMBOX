<?php

namespace App\Http\Controllers;

use App\Models\Paiement;
use App\Models\Paiement_expediteur;
use App\Models\Solde;


use Illuminate\Http\Request;

class SoldeController extends Controller
{

    public function get_solde($id)
{

    $solde = Solde::where('expediteur_id', $id)->first();

    return response()->json([
        'solde' => $solde->solde,
    ], 200);
}


public function calcule_solde($id)
{
    $new_paiement = Paiement::where('expediteur_id', $id)
        ->selectRaw('expediteur_id, sum(expedition) as montant')
        ->groupBy('expediteur_id')
        ->first();

    $solde = Solde::where('expediteur_id', $id)
        ->latest('created_at')
        ->first();

    if ($new_paiement) {
        $solde->solde = $new_paiement->montant + $solde->solde;
        $solde->save();
        Paiement::where('expediteur_id', $id)->delete();

    }

    return response()->json([
        'solde' => $solde->solde,
    ], 200);
}


}
