<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'estado',
        'fecha_inicio',
        'fecha_fin',
        'project_id',
        'manager_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function manager()
    {
        return $this->belongsTo(User::class);
    }

    public function deliverables()
    {
        return $this->hasMany(Deliverable::class);
    }

    public function getFechaFinFormattedAttribute()
    {
        return Carbon::parse($this->attributes['fecha_fin'])->format('d-m-Y');
    }
    
    public function getFechaInicioFormattedAttribute()
    {
        return Carbon::parse($this->attributes['fecha_inicio'])->format('d-m-Y');
    }
}
