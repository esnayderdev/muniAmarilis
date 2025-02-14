<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'activity',
        'estado',
        'fecha_cambio',
        'comentarios'
    ];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }

}
