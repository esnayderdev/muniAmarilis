<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tipos = [
            'Presupuestado',
            'No Presupuestado',
            'Otro',
            'No Aplica'
        ];

        return view('admin.projects.create', compact('tipos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|unique:projects,nombre',
            'descripcion' => 'nullable|string|max:255',
            'tipo' => 'nullable|string|in:Presupuestado,No Presupuestado,Otro,No Aplica',
            'presupuesto' => 'nullable|numeric',
        ], [
            'nombre.required' => 'El campo :attribute es obligatorio',
            'nombre.unique' => 'El campo :attribute ya existe',
            'presupuesto.numeric' => 'El campo :attribute debe ser numerico',
            'descripcion.max' => 'El campo :attribute no debe ser mayor a :max caracteres',
        ]);
        $datos = $request->all();
        Project::create($datos);
        return redirect()->route('admin.projects.create')->with('success', 'Proyecto creado correctamente');
    }
}
