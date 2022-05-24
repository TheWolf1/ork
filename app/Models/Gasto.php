<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gasto extends Model
{
    use HasFactory;


    protected $fillable = [
        'gastos_cantidad',
        'gastos_description'
    ];
    protected $table = "gastos";
}
