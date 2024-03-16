<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Coli;
use App\Models\User;
use App\Models\Historique;
use App\Models\Affectation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;



class AffectationController extends Controller
{

    public function get_livreurs_colis_par_agence($id, $agence)
{
    $affectation = Affectation::with(['colis', 'livreur','colis.expediteur'])
        ->where('livreur_id', $id)
        ->whereHas('colis', function ($query) use ($agence) {
            $query->where('gouvernorat', $agence);
            // ->where('colis.etat','Pickup enlever chez livreur');
        })
        ->latest('created_at')
        ->get();

    return response()->json([
        'colis' => $affectation
    ], 200);
}


    public function get_livreurs_colis($id)
    {
        $affectation = Affectation::with(['colis', 'livreur'])
            ->where('livreur_id', $id)
            ->get()
            ->groupBy('colis.gouvernorat'); // Grouping by the "gouvernorat" field of the related "colis"

        $result = [];

        foreach ($affectation as $gouvernorat => $group) {

            $result[] = [
                'agence' => $gouvernorat,
                'colis' => $group,
            ];
        }

        return response()->json([
            'colis' => $result,
        ], 200);
    }






    public function affecterLivreur(Request $request)
    {
        $rules = [
            'colis_id' => 'required',
            'livreur_id' => 'required',
            'etat' => 'required',

        ];

        $messages = [
            'required' => 'Ce champ est requis.',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }


        $livreur=User::find($request->livreur_id);
        $colis=Coli::find($request->colis_id);

        $affectation = new Affectation();
        $affectation->colis_id = $request->colis_id;
        $affectation->livreur_id = $request->livreur_id;
        $colis->etat=$request->etat;
        $colis->update();
        switch ($colis->etat) {
            case 'Manifest chez livreur':
                $description = "Le colis a été récupéré par le livreur ".$livreur->name." chez l'expéditeur ".$request->user()->name." en vue de sa livraison au dépôt";
                break;
            default:
                break;
        }
        $currentDateTime = Carbon::now()->format('d-m-Y H:i:s');
        $descriptionWithDate = $description . ' le ' . $currentDateTime;


        Historique::create([
            'etat' => $colis->etat,
            'information' => $descriptionWithDate,
            'role' => $request->user()->name,
            'colis_id'=>$colis->id,
        ]);

        $affectation->save();
        return response()->json([
            'message'=>'affectation created successfully'
        ]);
    }

    public function PickupEnleverLivreur(Request $request)
    {
        $rules = [
            'coliIds' => 'required',
            'livreur_id' => 'required',
            'etat'=>'required'

        ];

        $messages = [
            'required' => 'Ce champ est requis.',
        ];


        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $coliIds=$request->coliIds;

        $livreur=User::find($request->livreur_id);
        $currentDateTime = Carbon::now()->format('d-m-Y H:i:s');

        foreach ($coliIds as $coliId) {

            $affectation = new Affectation();

            $affectation->colis_id = $coliId;
            $affectation->livreur_id = $request->livreur_id;

        $colis = Coli::with(['expediteur'])->find($coliId);
        $colis->etat=$request->etat;
        $colis->update();
        switch ($colis->etat) {
            case 'Pickup enlever chez livreur':
                $description = "Le colis a été récupéré par le livreur ".$livreur->name." chez l'expéditeur ".$colis->expediteur->name." en vue de sa livraison au dépôt";
                break;
            default:
                break;
        }
        $descriptionWithDate = $description . ' le ' . $currentDateTime;

        Historique::create([
            'etat' => $colis->etat,
            'information' => $descriptionWithDate,
            'role' => $request->user()->name,
            'colis_id'=>$colis->id,
        ]);

            $affectation->save();
        }
        return response()->json([
            'message'=>'affectation created successfully'
        ]);

    }








}
