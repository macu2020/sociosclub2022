<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Socio extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'lastname',
        'email',
        'dni',
        'perfil_id',
        'parentesco_id' ,
        'clase_id', 
        'avatar',
        'placa',
        'clave'
     ];
}
