<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Coli;
use App\Models\Paiement;
use App\Models\Livraison;
use App\Models\Historique;
use App\Models\Affectation;
use App\Models\Affectation2;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class ColiController extends Controller
{

    public function get_expediteurs_colis($id)
    {
        $colis=Coli::with(['expediteur'])->where('expediteur_id', $id)
        ->latest('created_at')
        ->get();
        return response()->json([
            'colis'=>$colis
        ],200);
    }

    public function get_all_expediteurs_colis()
{
    $colis = Coli::with(['expediteur'])->get()->groupBy(function ($item) {
        // Assuming 'id' is the unique identifier for Expediteur
        return $item->expediteur->id;
    });

    $result = [];

    foreach ($colis as $expediteurId => $group) {
        // Assuming Expediteur has a 'name' field, adjust as needed
        $expediteur = $group->first()->expediteur;

        $result[] = [
            'expediteur' => [
                'id'   => $expediteur->id,
                'name' => $expediteur->name,
            ],
            'colis' => $group,
        ];
    }

    return response()->json([
        'colis' => $result,
    ], 200);
}





    public function get_all_colis()
    {
        $colis=Coli::latest('created_at')->get();
        return response()->json([
            'colis'=>$colis
        ],200);
    }
    public function get_all_manifestes_colis()
{
    $colis = Coli::where('etat', '=', 'Pickup dépôt entrant')
        ->orWhere('etat', '=', 'Retour Dépôt')
        ->latest('created_at')
        ->get();

    return response()->json([
        'colis' => $colis
    ], 200);
}




    public function get_all_paiements_colis()
    {
        $colis=Coli::with(['expediteur'])->where('etat', '=', 'Livré')
        ->latest('created_at')
        ->get();
        return response()->json([
            'colis'=>$colis
        ],200);
    }

    public function get_all_retours_colis()
{
    $colis = Coli::with(['expediteur'])
        ->whereIn('etat', ['Retour Dépôt', 'Retour Définitif'])
        ->latest('created_at')
        ->get();

    return response()->json([
        'colis' => $colis
    ], 200);
}


    public function imprimerColis($id)
    {
        $colis=Coli::with(['expediteur'])->find($id);
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
        $colis->expediteur_id = $request->expediteur_id;
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
    $colis->save();

    return response()->json([
        'message' => 'Colis updated successfully'
    ]);
}

public function updateState(Request $request, $id)
{
    $rules = [
        'etat' => 'required',
    ];

    $messages = [
        'required' => 'Ce champ est requis.',
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

    // Check if the requested state is the same as the current state
    if ($colis->etat == $request->etat) {
        return response()->json(['error' => 'Requested state is the same as the current state'], 422);
}

    // Update the Colis with the new data
    $colis->etat = $request->etat;
    $colis->update();

    $userRole = $request->user()->role;
    $roleLabel='';
    switch ($userRole) {
        case 1:
            $roleLabel = 'Responsable dépôt';
            break;
        case 2:
            $roleLabel = 'Expéditeur';
            break;
        case 3:
            $roleLabel = 'Livreur';
            break;

    }
    $description = '';

    switch ($colis->etat) {
        case 'En attente de collecte':
            $description = 'L\'expéditeur ' . $request->user()->name . ' a marqué le colis comme "en attente de collecte" pour le transporteur';
            break;
        case 'Collecté':
            $description = 'Le responsable du dépôt ' . $request->user()->name . ' a marqué le colis comme "collecté"';
            break;
        case 'Réceptionné':
            $description = 'Le responsable du dépôt ' . $request->user()->name . ' a réceptionné le colis pour le tri';
            break;
        case 'Pickup':
            $description = 'Le livreur ' . $request->user()->name . ' a marqué le colis comme "Pickup", en train de quitter le dépôt';
            break;
        case 'En cours de livraison':
            $description = 'Le livreur ' . $request->user()->name . ' est en cours de livraison';
            break;
        case 'Livré':
            $description = 'Le livreur ' . $request->user()->name . ' a remis le colis au destinataire avec succès';
            break;
        case 'Manquant ou perdu':
            $description = 'Le responsable du dépôt ' . $request->user()->name . ' a marqué le colis comme "manquant ou perdu"';
            break;
        default:
            break;
    }

    $currentDateTime = Carbon::now()->format('d-m-Y H:i:s');
    $descriptionWithDate = $description . ' le ' . $currentDateTime;



    Historique::create([
        'etat' => $colis->etat,
        'information' => $descriptionWithDate,
        'role' => $roleLabel,
        'colis_id'=>$id,
    ]);

    return response()->json([
        'message' => 'Colis updated successfully'
    ]);
}





public function updateSelectedStates(Request $request)
    {
        $rules = [
            'coliIds' => 'required',
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

        $currentDateTime = Carbon::now()->format('d-m-Y H:i:s');

        foreach ($coliIds as $coliId) {


        $colis=Coli::find($coliId);
        $colis->etat=$request->etat;
        $colis->update();
        switch ($colis->etat) {
            case 'Pickup dépôt entrant':
                $description = "Le colis a été récupéré par le responsable du dépôt ".$request->user()->name;
                break;
            case 'En cours':
                $affectation = Affectation::with(['colis', 'livreur'])
                ->where('colis_id', $coliId)
                ->first();

                    $description = "Le colis a été récupéré par le livreur ".$affectation->livreur->name." et en cours de livraison";
                    break;
                case 'Livré':
                        $affectation = Affectation::with(['colis', 'colis.expediteur','livreur'])
                        ->where('colis_id', $coliId)
                        ->first();
                            $description = "Le colis a été livré avec succés par le livreur ".$affectation->livreur->name;
                            $paiement=new Paiement();
                            $paiement->colis_id=$affectation->colis->id;
                            $paiement->livraison=$affectation->colis->expediteur->prix_livraison;
                            $paiement->expedition=$affectation->colis->prix-$paiement->livraison;
                            $paiement->expediteur_id=$affectation->colis->expediteur->id;
                            $paiement->save();

                            break;
                case 'Retour Dépôt':
                    $description = "Le colis a été retourné vers le dépôt ";
                case 'Retour Définitif':

                    $affectation = Affectation::with(['colis', 'colis.expediteur','livreur'])
                        ->where('colis_id', $coliId)
                        ->first();
                    $description = "Le colis a été retourné définitivement";


                    $paiement=new Paiement();
                            $paiement->colis_id=$affectation->colis->id;
                            $paiement->retour=$affectation->colis->expediteur->prix_retour;
                            $paiement->expediteur_id=$affectation->colis->expediteur->id;
                            $paiement->save();

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

        }
        return response()->json([
            'message'=>'affectation created successfully'
        ]);

    }


    public function LivrerRetour(Request $request)
    {
        $rules = [
            'coliIds' => 'required',
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

        $currentDateTime = Carbon::now()->format('d-m-Y H:i:s');

        foreach ($coliIds as $coliId) {


        $colis=Coli::find($coliId);
        $colis->etat=$request->etat;
        $colis->update();
        switch ($colis->etat) {
                case 'Livré':
                    $affectation = Affectation2::with(['colis', 'colis.expediteur', 'livreur'])
                    ->where('voyage_done',0)
                    ->whereHas('colis', function ($query) use ($coliId) {
                        $query->where('id', $coliId)->where('payer', 0);
                    })
                    ->first();
                            $description = "Le colis a été livré avec succés par le livreur ".$affectation->livreur->name;
                            $paiement=new Paiement();
                            $paiement->colis_id=$affectation->colis->id;
                            $paiement->livraison=$affectation->colis->expediteur->prix_livraison;
                            $paiement->expedition=$affectation->colis->prix-$paiement->livraison;
                            $paiement->expediteur_id=$affectation->colis->expediteur->id;
                            $paiement->save();
                            $affectation->colis->payer=True;
                            $affectation->colis->save();
                            $affectation->save();



                            $allowedEtats = ['Livré', 'Retour Dépôt', 'Retour Définitif'];

                            $nb_voyages = Affectation2::with(['colis', 'colis.expediteur', 'livreur'])
                                ->whereHas('colis', function ($query) use ($allowedEtats) {
                                    $query->whereNotIn('etat', $allowedEtats);
                                })
                                ->where('voyage_id',$affectation->voyage_id)
                                ->where('voyage_done', 0)
                                ->count();


                                //Continue here :
                            if($nb_voyages==0){
                                //nb et livreur id
                                $voyage = Affectation2::with(['colis', 'livreur'])
                                ->where('voyage_id', $affectation->voyage_id)
                                ->selectRaw('livreur_id, voyage_id, count(colis_id) as nb_total')
                                ->groupBy('voyage_id', 'livreur_id')
                                ->first();


                                //nb colis livrés
                                $nb_livre = Affectation2::where('voyage_id', $voyage->voyage_id)
                                ->where('livreur_id', $voyage->livreur_id)
                                ->whereHas('colis', function ($query) {
                                    $query->where('etat', 'Livré');
                                })
                                ->count();

                                //nb colis retour
                                $nb_retour = Affectation2::where('voyage_id', $voyage->voyage_id)
                                ->where('livreur_id', $voyage->livreur_id)
                                ->whereHas('colis', function ($query) {
                                    $query->whereIn('etat', ['Retour Dépôt', 'Retour Définitif']);
                                })
                                ->count();

                                //somme du montant livrés
                                $voyage_livre = Affectation2::with(['colis'])
                                ->where('voyage_id', $voyage->voyage_id)
                                ->where('livreur_id', $voyage->livreur_id)
                                ->whereHas('colis', function ($query) {
                                    $query->where('etat', 'Livré');
                                })->get();

                                $montant_livre=0;
                                foreach($voyage_livre as $voy_liv){
                                    $montant_livre=$montant_livre+$voy_liv->colis->prix;
                                }

                                //somme totale
                                $voyage_totale = Affectation2::with(['colis'])
                                ->where('voyage_id', $voyage->voyage_id)
                                ->where('livreur_id', $voyage->livreur_id)
                                ->whereHas('colis', function ($query) {
                                    $query->whereIn('etat', ['Livré', 'Retour Dépôt', 'Retour Définitif']);
                                })->get();

                                $montant_totale=0;
                                foreach($voyage_totale as $voy_tot){
                                    $montant_totale=$montant_totale+$voy_tot->colis->prix;
                                }


                                Livraison::create([
                                    'livreur_id' => $voyage->livreur_id,
                                    'nb_total' => $voyage->nb_total,
                                    'nb_livre' => $nb_livre,
                                    'nb_retour' => $nb_retour,
                                    'montant_totale' => $montant_totale,
                                    'montant_livre' => $montant_livre,
                                ]);

                                Affectation2::where('voyage_id', $voyage->voyage_id)
                                ->where('livreur_id', $voyage->livreur_id)
                                ->update(['voyage_done' => 1]);

                                // return response()->json(['montant_totale' => $montant_totale], Response::HTTP_NOT_FOUND);

                            }


                            break;
                case 'Retour Définitif':

                    $affectation = Affectation2::with(['colis', 'colis.expediteur','livreur'])
                        ->where('colis_id', $coliId)
                        ->where('voyage_done',0)
                        ->first();
                    $description = "Le colis a été retourné définitivement";


                    $paiement=new Paiement();
                            $paiement->colis_id=$affectation->colis->id;
                            $paiement->expedition=-$affectation->colis->expediteur->prix_retour;
                            $paiement->expediteur_id=$affectation->colis->expediteur->id;
                            $paiement->save();


                            $allowedEtats = ['Livré', 'Retour Dépôt', 'Retour Définitif'];

                            $nb_voyages = Affectation2::with(['colis', 'colis.expediteur', 'livreur'])
                                ->whereHas('colis', function ($query) use ($allowedEtats) {
                                    $query->whereNotIn('etat', $allowedEtats);
                                })
                                ->where('voyage_id',$affectation->voyage_id)
                                ->where('voyage_done', 0)
                                ->count();


                                //Continue here :
                            if($nb_voyages==0){
                                //nb et livreur id
                                $voyage = Affectation2::with(['colis', 'livreur'])
                                ->where('voyage_id', $affectation->voyage_id)
                                ->selectRaw('livreur_id, voyage_id, count(colis_id) as nb_total')
                                ->groupBy('voyage_id', 'livreur_id')
                                ->first();


                                //nb colis livrés
                                $nb_livre = Affectation2::where('voyage_id', $voyage->voyage_id)
                                ->where('livreur_id', $voyage->livreur_id)
                                ->whereHas('colis', function ($query) {
                                    $query->where('etat', 'Livré');
                                })
                                ->count();

                                //nb colis retour
                                $nb_retour = Affectation2::where('voyage_id', $voyage->voyage_id)
                                ->where('livreur_id', $voyage->livreur_id)
                                ->whereHas('colis', function ($query) {
                                    $query->whereIn('etat', ['Retour Dépôt', 'Retour Définitif']);
                                })
                                ->count();

                                //somme du montant livrés
                                $voyage_livre = Affectation2::with(['colis'])
                                ->where('voyage_id', $voyage->voyage_id)
                                ->where('livreur_id', $voyage->livreur_id)
                                ->whereHas('colis', function ($query) {
                                    $query->where('etat', 'Livré');
                                })->get();

                                $montant_livre=0;
                                foreach($voyage_livre as $voy_liv){
                                    $montant_livre=$montant_livre+$voy_liv->colis->prix;
                                }

                                //somme totale
                                $voyage_totale = Affectation2::with(['colis'])
                                ->where('voyage_id', $voyage->voyage_id)
                                ->where('livreur_id', $voyage->livreur_id)
                                ->whereHas('colis', function ($query) {
                                    $query->whereIn('etat', ['Livré', 'Retour Dépôt', 'Retour Définitif']);
                                })->get();

                                $montant_totale=0;
                                foreach($voyage_totale as $voy_tot){
                                    $montant_totale=$montant_totale+$voy_tot->colis->prix;
                                }


                                Livraison::create([
                                    'livreur_id' => $voyage->livreur_id,
                                    'nb_total' => $voyage->nb_total,
                                    'nb_livre' => $nb_livre,
                                    'nb_retour' => $nb_retour,
                                    'montant_totale' => $montant_totale,
                                    'montant_livre' => $montant_livre,
                                ]);

                                Affectation2::where('voyage_id', $voyage->voyage_id)
                                ->where('livreur_id', $voyage->livreur_id)
                                ->update(['voyage_done' => 1]);

                                // return response()->json(['montant_totale' => $montant_totale], Response::HTTP_NOT_FOUND);

                            }
                            break;


                            case 'Retour Dépôt':

                                $affectation = Affectation2::with(['colis', 'colis.expediteur','livreur'])
                                    ->where('colis_id', $coliId)
                                    ->where('voyage_done',0)
                                    ->first();
                                    $description = "Le colis a été retourné vers le dépôt ";


                                        $allowedEtats = ['Livré', 'Retour Dépôt', 'Retour Définitif'];

                                        $nb_voyages = Affectation2::with(['colis', 'colis.expediteur', 'livreur'])
                                            ->whereHas('colis', function ($query) use ($allowedEtats) {
                                                $query->whereNotIn('etat', $allowedEtats);
                                            })
                                            ->where('voyage_id',$affectation->voyage_id)
                                            ->where('voyage_done', 0)
                                            ->count();


                                            //Continue here :
                                        if($nb_voyages==0){
                                            //nb et livreur id
                                            $voyage = Affectation2::with(['colis', 'livreur'])
                                            ->where('voyage_id', $affectation->voyage_id)
                                            ->selectRaw('livreur_id, voyage_id, count(colis_id) as nb_total')
                                            ->groupBy('voyage_id', 'livreur_id')
                                            ->first();


                                            //nb colis livrés
                                            $nb_livre = Affectation2::where('voyage_id', $voyage->voyage_id)
                                            ->where('livreur_id', $voyage->livreur_id)
                                            ->whereHas('colis', function ($query) {
                                                $query->where('etat', 'Livré');
                                            })
                                            ->count();

                                            //nb colis retour
                                            $nb_retour = Affectation2::where('voyage_id', $voyage->voyage_id)
                                            ->where('livreur_id', $voyage->livreur_id)
                                            ->whereHas('colis', function ($query) {
                                                $query->whereIn('etat', ['Retour Dépôt', 'Retour Définitif']);
                                            })
                                            ->count();

                                            //somme du montant livrés
                                            $voyage_livre = Affectation2::with(['colis'])
                                            ->where('voyage_id', $voyage->voyage_id)
                                            ->where('livreur_id', $voyage->livreur_id)
                                            ->whereHas('colis', function ($query) {
                                                $query->where('etat', 'Livré');
                                            })->get();

                                            $montant_livre=0;
                                            foreach($voyage_livre as $voy_liv){
                                                $montant_livre=$montant_livre+$voy_liv->colis->prix;
                                            }

                                            //somme totale
                                            $voyage_totale = Affectation2::with(['colis'])
                                            ->where('voyage_id', $voyage->voyage_id)
                                            ->where('livreur_id', $voyage->livreur_id)
                                            ->whereHas('colis', function ($query) {
                                                $query->whereIn('etat', ['Livré', 'Retour Dépôt', 'Retour Définitif']);
                                            })->get();

                                            $montant_totale=0;
                                            foreach($voyage_totale as $voy_tot){
                                                $montant_totale=$montant_totale+$voy_tot->colis->prix;
                                            }


                                            Livraison::create([
                                                'livreur_id' => $voyage->livreur_id,
                                                'nb_total' => $voyage->nb_total,
                                                'nb_livre' => $nb_livre,
                                                'nb_retour' => $nb_retour,
                                                'montant_totale' => $montant_totale,
                                                'montant_livre' => $montant_livre,
                                            ]);

                                            Affectation2::where('voyage_id', $voyage->voyage_id)
                                            ->where('livreur_id', $voyage->livreur_id)
                                            ->where('voyage_done', 0)
                                            ->update(['voyage_done' => 1]);

                                            // return response()->json(['montant_totale' => $montant_totale], Response::HTTP_NOT_FOUND);

                                        }
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

        }
        return response()->json([
            'message'=>'affectation created successfully'
        ]);

    }



}
