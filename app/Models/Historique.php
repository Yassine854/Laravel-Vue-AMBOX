<?php

namespace App\Models;

use App\Models\Coli;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Historique extends Model
{
    protected $table='historiques';
    use HasFactory;

    protected $fillable = [
        'etat',
        'information',
        'role',
        'colis_id'
    ];

    public function diagnostic()
    {
        return $this->belongsTo(Coli::class);
    }
}
