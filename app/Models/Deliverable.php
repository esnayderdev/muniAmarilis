<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deliverable extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_entrega',
        'activity_id'
    ];

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

}
