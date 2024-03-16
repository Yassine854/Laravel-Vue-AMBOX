<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solde extends Model
{
    use HasFactory;
    protected $table='soldes';

    protected $fillable = [
        'solde',
        'expediteur_id'
    ];


    public function expediteur()
    {
        return $this->belongsTo(User::class);
    }
}
