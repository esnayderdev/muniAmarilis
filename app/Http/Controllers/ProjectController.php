<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public $activities_default = [
        'Analisis de mercado',
        'Cotización',
        'Proformacion',
        'Licitacion',
        'Entrega de proyecto',
    ];

    public function index()
    {
        $encargados = User::where('usertype', 'encargado')->get();
        $estados_proyecto = [
            "no confirmado",
            "confirmado",
            "terminado"
        ];
        $projects = Project::all();
        return view('admin.projects.index', compact('projects', 'encargados', 'estados_proyecto'));
    }

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
        $proyecto = Project::create($datos);

        $activities = array_map(function ($activity) use ($proyecto) {
            return ['nombre' => $activity, 'project_id' => $proyecto->id];
        }, $this->activities_default);

        $proyecto->activities()->createMany($activities);

        return redirect()->route('admin.projects.create')->with('success', 'Proyecto creado correctamente');
    }

    public function update(Request $request, $id)
    {
        $proyecto = Project::findOrFail($id);
        $proyecto->estado = $request->input('estado_proyecto');

        $proyecto->save();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Datos actualizados correctamente']);
        }
    }
}
