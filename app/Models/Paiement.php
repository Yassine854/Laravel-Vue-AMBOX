<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paiement extends Model
{
    use HasFactory;
    protected $table='paiement';

    protected $fillable = [
        'livraison',
        'expedition',
        'colis_id',
        'expediteur_id'
    ];

    public function colis()
    {
        return $this->belongsTo(Coli::class);
    }

    public function expediteur()
    {
        return $this->belongsTo(User::class);
    }
}
