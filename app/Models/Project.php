<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'tipo',
        'presupuesto',
        'estado'
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }
}
