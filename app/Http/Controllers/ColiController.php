<?php

namespace App\Http\Controllers;

use App\Models\Coli;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ColiController extends Controller
{

    public function get_all_colis()
    {
        $colis=Coli::all();
        return response()->json([
            'colis'=>$colis
        ],200);
    }


    public function createColis(Request $request)
    {
        $rules = [
            'prix' => 'required|numeric',
            'Nb_pieces' => 'required|numeric',
            'designation' => 'required|string|max:255',
            'poid' => 'required|numeric',
            'echange' => 'required|boolean',
            'type' => 'required|string|max:255',
            'fragile' => 'required|boolean',
            'tel' => [
                'required',
                'numeric',
                'digits:8',
            ],
            'nom' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'tel2' => [
                'nullable',
                'numeric',
                'digits:8'
            ],
            'gouvernorat' => 'required|string|max:255',
            'delegation' => 'required|string|max:255',
            'localite' => 'required|string|max:255',
            'commentaire' => 'nullable|string|max:255',
            'livraison' => 'required|boolean',
        ];

        $messages = [
            'required' => 'Ce champ est requis.',
            'string' => 'Ce champ doit être une chaîne de caractères.',
            'max' => 'Ce champ ne doit pas dépasser :max caractères.',
            'numeric' => 'Ce champ doit être un nombre.',
            'boolean' => 'Ce champ doit être un booléen.',
            'digits' => 'Ce champ doit être composé de 8 chiffres.',


        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }



        $colis = new Coli();

        $colis->prix = $request->prix;
        $colis->Nb_pieces = $request->Nb_pieces;
        $colis->designation = $request->designation;
        $colis->poid = $request->poid;
        $colis->echange = $request->echange;
        $colis->type = $request->type;
        $colis->fragile = $request->fragile;
        $colis->tel = $request->tel;
        $colis->nom = $request->nom;
        $colis->address = $request->address;
        $colis->tel2 = $request->tel2;
        $colis->gouvernorat = $request->gouvernorat;
        $colis->delegation = $request->delegation;
        $colis->localite = $request->localite;
        $colis->commentaire = $request->commentaire;
        $colis->livraison = $request->livraison;
        $colis->save();
        return response()->json([
            'message'=>'colis created successfully'
        ]);
    }

    public function updateColis(Request $request, $id)
{
    $rules = [
        'prix' => 'required|numeric',
        'Nb_pieces' => 'required|numeric',
        'designation' => 'required|string|max:255',
        'poid' => 'required|numeric',
        'echange' => 'required|boolean',
        'type' => 'required|string|max:255',
        'fragile' => 'required|boolean',
        'tel' => [
            'required',
            'numeric',
            'digits:8',
        ],
        'nom' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'tel2' => [
            'nullable',
            'numeric',
            'digits:8'
        ],
        'gouvernorat' => 'required|string|max:255',
        'delegation' => 'required|string|max:255',
        'localite' => 'required|string|max:255',
        'commentaire' => 'nullable|string|max:255',
        'livraison' => 'required|boolean',
    ];

    $messages = [
        'required' => 'Ce champ est requis.',
        'string' => 'Ce champ doit être une chaîne de caractères.',
        'max' => 'Ce champ ne doit pas dépasser :max caractères.',
        'numeric' => 'Ce champ doit être un nombre.',
        'boolean' => 'Ce champ doit être un booléen.',
        'digits' => 'Ce champ doit être composé de 8 chiffres.',
    ];

    $validator = Validator::make($request->all(), $rules, $messages);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }

    // Retrieve the existing Colis by ID
    $colis = Coli::find($id);

    if (!$colis) {
        return response()->json(['error' => 'Colis not found'], 404);
    }

    // Update the Colis with the new data
    $colis->prix = $request->prix;
    $colis->Nb_pieces = $request->Nb_pieces;
    $colis->designation = $request->designation;
    $colis->poid = $request->poid;
    $colis->echange = $request->echange;
    $colis->type = $request->type;
    $colis->fragile = $request->fragile;
    $colis->tel = $request->tel;
    $colis->nom = $request->nom;
    $colis->address = $request->address;
    $colis->tel2 = $request->tel2;
    $colis->gouvernorat = $request->gouvernorat;
    $colis->delegation = $request->delegation;
    $colis->localite = $request->localite;
    $colis->commentaire = $request->commentaire;
    $colis->livraison = $request->livraison;
    $colis->save();

    return response()->json([
        'message' => 'Colis updated successfully'
    ]);
}



}
