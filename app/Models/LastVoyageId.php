<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LastVoyageId extends Model
{
    protected $table='last_voyage_id';
    use HasFactory;
    protected $fillable = [
        'last_id'
    ];
}
