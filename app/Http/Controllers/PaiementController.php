<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Solde;

use App\Models\Paiement;
use Illuminate\Http\Request;

use App\Models\Paiement_expediteur;
use Illuminate\Support\Facades\Validator;

class PaiementController extends Controller

{
    public function get_expediteur_name($id)
{
    $expediteur = User::find($id);

    return response()->json([
        'expediteur_name' => $expediteur ? $expediteur->name : null,
    ], 200);
}



public function get_all_expediteur_paiements($id)
{
    $paiements = Paiement_expediteur::with('expediteur')
        ->whereHas('expediteur', function ($query) use ($id) {
            $query->where('id', $id);
        })
        ->latest('created_at')
        ->get();

    return response()->json([
        'paiements' => $paiements,
    ], 200);
}

public function createPaiement(Request $request){
    $rules = [
        'prix' => [
            'required',
            'numeric',
            'min:100', // Add this rule to enforce a minimum value of 100
            function ($attribute, $value, $fail) use ($request) {
                // Get the current solde
                $solde = Solde::where('expediteur_id', $request->expediteur_id)->first();
                $prix = $request->prix;

                if ($solde->solde < $prix) {
                    $fail("Le montant à payer doit être inférieur ou égal au solde actuel de l'expéditeur.");
                }
            },
        ],
        'expediteur_id' => 'required|numeric',
    ];

    $messages = [
        'required' => 'Ce champ est requis.',
        'numeric' => 'Ce champ doit être un nombre.',
        'min' => 'Le montant doit être au moins :min.',

    ];


    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    $prix=$request->prix;
    $expediteur_id=$request->expediteur_id;



        Paiement_expediteur::create([
            'expediteur_id' => $expediteur_id,
            'montant' => $prix,
        ]);

        $solde = Solde::where('expediteur_id', $expediteur_id)->first();
        $solde->solde-=$prix;
        $solde->save();
    }






// public function get_all_expediteur_paiements($id)
// {
//     $paiements = Paiement_expediteur::with('expediteur')
//         ->whereHas('expediteur', function ($query) use ($id) {
//             $query->where('id', $id);
//         })
//         ->latest('created_at')
//         ->get();

//     return response()->json([
//         'paiements' => $paiements,
//     ], 200);
// }

// public function createPaiement(Request $request){
//     $rules = [
//         'prix' => [
//             'required',
//             'numeric',
//             function ($attribute, $value, $fail) use ($request) {
//                 // Get the most recent solde
//                 $solde = Paiement_expediteur::where('expediteur_id', $request->expediteur_id)
//                     ->latest('created_at')
//                     ->first();

//                 if ($solde && $value > $solde->montant) {
//                     $fail("Le montant à payer doit être inférieur ou égale au solde actuel de l'expéditeur.");
//                 }
//             },
//         ],
//         'expediteur_id' => 'required|numeric',
//     ];

//     $messages = [
//         'required' => 'Ce champ est requis.',
//         'numeric' => 'Ce champ doit être un nombre.',
//     ];


//     $validator = Validator::make($request->all(), $rules, $messages);

//     if ($validator->fails()) {
//         return response()->json(['errors' => $validator->errors()], 400);
//     }

//     $prix=$request->prix;
//     $expediteur_id=$request->expediteur_id;


//     $totalByExpediteur = Paiement::where('expediteur_id', $expediteur_id)
//     ->selectRaw('expediteur_id, sum(expedition) as montant')
//     ->groupBy('expediteur_id')
//     ->get();

//     $totalByExpediteur = $totalByExpediteur->sortBy('created_at');

//     $solde = Paiement_expediteur::where('expediteur_id', $expediteur_id)
// ->latest('created_at')
// ->first();

// if($solde){

//     if($totalByExpediteur->isNotEmpty()){
//     foreach ($totalByExpediteur as $total) {
//         Paiement_expediteur::create([
//             'expediteur_id' => $total->expediteur_id,
//             'montant' => $total->montant+$solde->montant-$prix,
//         ]);
//     }
//     Paiement::where('expediteur_id', $expediteur_id)->delete();

// }
// else{
//         Paiement_expediteur::create([
//             'expediteur_id' => $solde->expediteur_id,
//             'montant' => $solde->montant-$prix,
//         ]);
//     }
// }


// //Cas initiale
// else{

//     foreach ($totalByExpediteur as $total) {
//         Paiement_expediteur::create([
//             'expediteur_id' => $total->expediteur_id,
//             'montant' => $total->montant-$prix,
//         ]);
//     }

//     Paiement::where('expediteur_id', $expediteur_id)->delete();

// }
// }

    // public function createPaiement(Request $request){
    //     $rules = [
    //         'prix' => 'required|numeric',
    //         'expediteur_id' => 'required|numeric',
    //     ];

    //     $messages = [
    //         'required' => 'Ce champ est requis.',
    //         'numeric' => 'Ce champ doit être un nombre.',



    //     ];


    //     $validator = Validator::make($request->all(), $rules, $messages);

    //     if ($validator->fails()) {
    //         return response()->json(['errors' => $validator->errors()], 400);
    //     }

    //     $prix=$request->prix;
    //     $expediteur_id=$request->expediteur_id;


    //     $totalByExpediteur = Paiement::where('expediteur_id', $expediteur_id)
    //     ->selectRaw('expediteur_id, sum(expedition) as montant')
    //     ->groupBy('expediteur_id')
    //     ->get();

    //     foreach ($totalByExpediteur as $total) {
    //         Paiement_expediteur::create([
    //             'expediteur_id' => $total->expediteur_id,
    //             'montant' => $total->montant-$prix,
    //         ]);
    //     }

    // }



}
