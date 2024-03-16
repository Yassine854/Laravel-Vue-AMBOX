<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Historique;
use App\Models\User;

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


    public function historiques()
    {
        return $this->hasMany(Historique::class);
    }

    public function expediteur()
    {
        return $this->belongsTo(User::class);
    }
}
