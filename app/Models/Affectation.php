<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Coli;
use App\Models\User;

class Affectation extends Model
{
    use HasFactory;
    protected $table='affectations';


    public function colis()
    {
        return $this->belongsTo(Coli::class);
    }

    public function livreur()
    {
        return $this->belongsTo(User::class);
    }
}
