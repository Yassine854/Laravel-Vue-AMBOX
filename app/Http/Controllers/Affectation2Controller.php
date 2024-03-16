<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Coli;
use App\Models\User;
use App\Models\Livraison;
use App\Models\Historique;
use App\Models\Affectation;
use App\Models\Affectation2;
use App\Models\LastVoyageId;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Affectation2Controller extends Controller
{
    public function PickupDepotSortant(Request $request)
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

        $lastVoyageIdRecord = LastVoyageId::first();
        $lastVoyageId = $lastVoyageIdRecord->last_id;

        foreach ($coliIds as $coliId) {

            $affectation = new Affectation2();

            $affectation->colis_id = $coliId;
            $affectation->livreur_id = $request->livreur_id;
            $affectation->voyage_id = $lastVoyageId;
            $colis = Coli::with(['expediteur'])->find($coliId);
        $colis->etat=$request->etat;
        $colis->update();
        switch ($colis->etat) {
            case 'En cours de livraison':
                $description = 'Le livreur ' . $livreur->name . ' a procédé le pickup du colis depuis le dépôt';
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
        $lastVoyageIdRecord->last_id++;
        $lastVoyageIdRecord->save();
        return response()->json([
            'message'=>'affectation created successfully'
        ]);

    }

    public function get_all_Encours_colis($livreur_id)
    {
        $affectation = Affectation2::with(['colis', 'livreur'])
            ->whereHas('colis', function ($query) {
                $query->where('etat', '=', 'En cours de livraison');
            })
            ->where('voyage_done',0)
            ->where('livreur_id', '=', $livreur_id)
            ->latest('created_at')
            ->get();

        return response()->json([
            'colis' => $affectation->pluck('colis')->flatten(),
        ], 200);
    }



    public function get_all_livreurs_livraisons()
    {
        $livreurs = Affectation2::with(['livreur'])
        ->select('livreur_id')
        ->groupBy('livreur_id')
        ->get();

        return response()->json([
            'livreurs' => $livreurs,
        ], 200);
        }


}
