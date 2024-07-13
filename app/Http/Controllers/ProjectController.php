<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
  
    public function index(Request $request)
    {
        $search = $request->input('search');

        $estados_proyecto = [
            "no confirmado",
            "confirmado",
            "terminado"
        ];
       
        $estados_actividad = [
            "en progreso",
            "completado",
            "retrasado"
        ];

        $encargados = User::where('usertype', 'encargado')->get();
        
        $tipos = [
            'Intereses públicos',
            'Gestion Interna',
            'Otro',
        ];

        $query = Project::query();

        if ($search) {
            $query->where('nombre', 'LIKE', "%{$search}%");
        }

        $projects = $query->get();


        return view('admin.projects.index', compact('projects', 'encargados', 'estados_proyecto', 'tipos', 'estados_actividad'));
    }

    public function create()
    {
        $tipos = [
            'Intereses públicos',
            'Gestion Interna',
            'Otro',
        ];

        return view('admin.projects.create', compact('tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|unique:projects,nombre',
            'descripcion' => 'nullable|string|max:255',
            'tipo' => 'nullable|string',
            'presupuesto' => 'nullable|numeric',
        ], [
            'nombre.required' => 'El campo :attribute es obligatorio',
            'nombre.unique' => 'El campo :attribute ya existe',
            'presupuesto.numeric' => 'El campo :attribute debe ser numerico',
            'descripcion.max' => 'El campo :attribute no debe ser mayor a :max caracteres',
        ]);
        $datos = $request->all();
        $proyecto = Project::create($datos);
        
        // $activities_default = [
        //     'Analisis de mercado',
        //     'Cotización',
        //     'Proforma',
        //     'Licitacion',
        //     'Entrega de proyecto',
        // ];
    
        // $activities = array_map(function ($activity) use ($proyecto) {
        //     return ['nombre' => $activity, 'project_id' => $proyecto->id];
        // }, $this->activities_default);

        // $proyecto->activities()->createMany($activities);

        return redirect()->route('admin.projects.index')->with('success', 'Proyecto creado correctamente');
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
