<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coli extends Model
{
    use HasFactory;
    protected $table='colis';

    protected $fillable = [
        'prix',
        'Nb_pieces',
        'designation',
        'poid',
        'echange',
        'type',
        'fragile',
        'tel',
        'nom',
        'address',
        'tel2',
        'gouvernorat',
        'delegation',
        'localite',
        'commentaire',
        'livraison',
    ];
}
