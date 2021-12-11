<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporteSociDia extends Model
{
    use HasFactory;
    protected $fillable = [
        'idsoci' ,
        'clave' , 
        'name',
        'lastname',
        'email',
        'dni',
        'perfil_id',
        'parentesco_id' ,
        'clase_id', 
        'avatar',
        'clave',
        'horas' ,
        'dia',
     ];
}
