<?php

namespace App\Http\Controllers;

use App\Models\Historique;
use Illuminate\Http\Request;

class HistoriqueController extends Controller
{
    public function showHistoriques($id){
        $historiques = Historique::where('colis_id', $id)
                           ->orderBy('created_at', 'asc')
                           ->get();
        return response()->json([
            'historiques' => $historiques
        ], 200);
    }
}
