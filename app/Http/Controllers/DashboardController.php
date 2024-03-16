<?php

namespace App\Http\Controllers;

use App\Models\Coli;
use App\Models\Affectation;
use App\Models\Affectation2;

use App\Models\User;
use App\Models\Paiement;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

//////////////////////Admin/////////////////////////////////////
    public function fetchAdminsCount()
    {
        $adminsCount = User::where('role', 1)->count();

        return response()->json(['adminsCount' => $adminsCount]);
    }

    public function fetchExpediteursCount()
    {
        $expediteursCount = User::where('role', 2)->count();

        return response()->json(['expediteursCount' => $expediteursCount]);
    }

    public function fetchLivreursCount()
    {
        $livreursCount = User::where('role', 3)->count();

        return response()->json(['livreursCount' => $livreursCount]);
    }

    public function fetchTotalColisCount()
    {
        $totalColisCount = Coli::all()->count();

        return response()->json(['totalColisCount' => $totalColisCount]);
    }

    public function fetchColisAttenteCount()
    {
        $colisAttenteCount = coli::where('etat', 'En attente')->count();

        return response()->json(['colisAttenteCount' => $colisAttenteCount]);
    }

    public function fetchColisEnDepotCount()
    {
        $colisEnDepotCount = coli::where('etat', 'Pickup dépôt entrant')->count();

        return response()->json(['colisEnDepotCount' => $colisEnDepotCount]);
    }

    public function fetchRetourDepotCount()
    {
        $retourDepotCount = coli::where('etat', 'Retour Dépôt')->count();

        return response()->json(['retourDepotCount' => $retourDepotCount]);
    }

    public function fetchEncoursCount()
    {
        $EncoursCount = coli::where('etat', 'En cours de livraison')->count();

        return response()->json(['EncoursCount' => $EncoursCount]);
    }

    public function fetchColisLivreCount()
    {
        $colisLivreCount = coli::where('etat', 'Livré')->count();

        return response()->json(['colisLivreCount' => $colisLivreCount]);
    }

    public function fetchRetourDefinitifCount()
    {
        $retourDefinitifCount = coli::where('etat', 'Retour Définitif')->count();

        return response()->json(['retourDefinitifCount' => $retourDefinitifCount]);
    }



    public function cityBarChart()
{
    $colis = DB::table('colis')
            ->select('gouvernorat', DB::raw('count(*) as colis_count'))
            ->where('colis.etat','Livré')
            ->groupBy('gouvernorat')
            ->orderByDesc('colis_count')
            ->limit(10)
            ->get();

    return response()->json([
        'colis' => $colis,
    ], 200);
}


public function topLivreurBarChart()
{
    $colis = Affectation2::with(['livreur', 'colis'])
            ->whereHas('colis', function ($query) {
                $query->where('etat', '=', 'Livré');
            })
            ->select('livreur_id', DB::raw('count(*) as colis_count'))
            ->groupBy('livreur_id')
            ->orderByDesc('colis_count')
            ->limit(10)
            ->get();

    return response()->json([
        'colis' => $colis,
    ], 200);
}





//////////////////////Expediteurs/////////////////////////////////////
public function expediteur_fetchTotalColisCount($id)
    {
        $totalColisCount = Coli::where('expediteur_id',$id)->count();

        return response()->json(['totalColisCount' => $totalColisCount]);
    }

    public function expediteur_fetchColisAttenteCount($id)
    {
        $colisAttenteCount = coli::where('etat', 'En attente')->where('expediteur_id',$id)->count();

        return response()->json(['colisAttenteCount' => $colisAttenteCount]);
    }

    public function expediteur_fetchColisEnDepotCount($id)
    {
        $colisEnDepotCount = coli::where('etat', 'Pickup dépôt entrant')->where('expediteur_id',$id)->count();

        return response()->json(['colisEnDepotCount' => $colisEnDepotCount]);
    }

    public function expediteur_fetchRetourDepotCount($id)
    {
        $retourDepotCount = coli::where('etat', 'Retour Dépôt')->where('expediteur_id',$id)->count();

        return response()->json(['retourDepotCount' => $retourDepotCount]);
    }

    public function expediteur_fetchEncoursCount($id)
    {
        $EncoursCount = coli::where('etat', 'En cours de livraison')->where('expediteur_id',$id)->count();

        return response()->json(['EncoursCount' => $EncoursCount]);
    }

    public function expediteur_fetchColisLivreCount($id)
    {
        $colisLivreCount = coli::where('etat', 'Livré')->where('expediteur_id',$id)->count();

        return response()->json(['colisLivreCount' => $colisLivreCount]);
    }

    public function expediteur_fetchRetourDefinitifCount($id)
    {
        $retourDefinitifCount = coli::where('etat', 'Retour Définitif')->where('expediteur_id',$id)->count();

        return response()->json(['retourDefinitifCount' => $retourDefinitifCount]);
    }

    public function expediteur_cityBarChart($id)
    {
        $colis = DB::table('colis')
                ->select('gouvernorat', DB::raw('count(*) as colis_count'))
                ->groupBy('gouvernorat')
                ->where('expediteur_id',$id)
                ->where('colis.etat','Livré')
                ->orderByDesc('colis_count')
                ->limit(10)
                ->get();

        return response()->json([
            'colis' => $colis,
        ], 200);
    }




    //////////////////////Livreurs/////////////////////////////////////

public function livreur_fetchColisAttenteCount()
{
    $colisAttenteCount = coli::where('etat', 'En attente')->count();

    return response()->json(['colisAttenteCount' => $colisAttenteCount]);
}

public function livreur_fetchColisEnDepotCount($id)
{
    $colisEnDepotCount = Affectation::with(['livreur', 'colis'])
        ->where('livreur_id', $id)
        ->whereHas('colis', function ($query) {
            $query->where('etat', 'Pickup dépôt entrant');
        })
        ->count();

    return response()->json(['colisEnDepotCount' => $colisEnDepotCount]);
}



public function livreur_fetchColisEnLivreurCount($id)
{
    $colisEnLivreurCount = Affectation::with(['livreur', 'colis'])
    ->where('livreur_id', $id)
    ->whereHas('colis', function ($query) {
        $query->where('etat', 'Pickup enlever chez livreur');
    })
    ->count();
    return response()->json(['colisEnLivreurCount' => $colisEnLivreurCount]);
}

public function livreur_fetchRetourDepotCount($id)
{
    $retourDepotCount = Affectation2::with(['livreur', 'colis'])
    ->where('livreur_id', $id)
    ->whereHas('colis', function ($query) {
        $query->where('etat', 'Retour Dépôt');
    })
    ->count();
    return response()->json(['retourDepotCount' => $retourDepotCount]);
}

public function livreur_fetchEncoursCount($id)
{
    $EncoursCount = Affectation2::with(['livreur', 'colis'])
    ->where('livreur_id', $id)
    ->whereHas('colis', function ($query) {
        $query->where('etat', 'En cours de livraison');
    })
    ->count();

    return response()->json(['EncoursCount' => $EncoursCount]);
}

public function livreur_fetchColisLivreCount($id)
{
    $colisLivreCount = Affectation2::with(['livreur', 'colis'])
    ->where('livreur_id', $id)
    ->whereHas('colis', function ($query) {
        $query->where('etat', 'Livré');
    })
    ->count();
    return response()->json(['colisLivreCount' => $colisLivreCount]);
}

public function livreur_fetchRetourDefinitifCount($id)
{
    $retourDefinitifCount = Affectation2::with(['livreur', 'colis'])
    ->where('livreur_id', $id)
    ->whereHas('colis', function ($query) {
        $query->where('etat', 'Retour Définitif');
    })
    ->count();
    return response()->json(['retourDefinitifCount' => $retourDefinitifCount]);
}

public function livreur_cityBarChart($id)
{
    $colis = DB::table('affectations2')
        ->join('colis', 'affectations2.colis_id', '=', 'colis.id')
        ->select('colis.gouvernorat', DB::raw('count(*) as colis_count'))
        ->where('colis.etat', 'Livré')
        ->groupBy('colis.gouvernorat')
        ->where('affectations2.livreur_id', $id)
        ->orderByDesc('colis_count')
        ->limit(10)
        ->get();

    return response()->json([
        'colis' => $colis,
    ], 200);
}






}
