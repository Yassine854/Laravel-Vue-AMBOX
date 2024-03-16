<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement_expediteur extends Model
{
    use HasFactory;

    protected $table='paiement_expediteur';

    protected $fillable = [
        'montant',
        'expediteur_id'
    ];


    public function expediteur()
    {
        return $this->belongsTo(User::class);
    }
}
