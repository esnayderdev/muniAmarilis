<?php

namespace App\Models;

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
        return $this->belongsToMany(Project::class);
    }

    public function manager()
    {
        return $this->belongsToMany(User::class);
    }

    public function deliverable()
    {
        return $this->hasMany(Deliverable::class);
    }
}
