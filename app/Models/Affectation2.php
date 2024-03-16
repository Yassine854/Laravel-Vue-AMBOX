<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affectation2 extends Model
{
    use HasFactory;
    protected $table='affectations2';


    public function colis()
    {
        return $this->belongsTo(Coli::class);
    }

    public function livreur()
    {
        return $this->belongsTo(User::class);
    }
}
