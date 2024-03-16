<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livraison extends Model
{
    use HasFactory;
    protected $table = 'livraisons';

    protected $fillable = [
        'livreur_id',
        'nb_total',
        'nb_livre',
        'nb_retour',
        'montant_totale',
        'montant_livre',
    ];

    public function livreur()
    {
        return $this->belongsTo(User::class, 'livreur_id');
    }
}
