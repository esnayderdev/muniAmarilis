<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        Activity::actualizarEstados(); // Actualiza el estado de las actividades a 'retrasado' si se ha pasado de la fecha fin

        $query = Activity::query();

        if ($search) {
            $query->where('nombre', 'LIKE', "%{$search}%");
        }

        $activities = $query->where('manager_id', auth()->user()->id)->paginate(5);

        return view('manager.dashboard', compact('activities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|unique:activities,nombre',
            'estado' => 'required|string',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date|after:fecha_inicio',
            'project_id' => 'required|exists:projects,id',
            'manager_id' => 'nullable|exists:users,id',
        ], [
            'nombre.required' => 'El campo :attribute es obligatorio',
            'nombre.unique' => 'El campo :attribute ya existe',
            'estado.required' => 'El campo :attribute es obligatorio',
            'project_id.required' => 'El campo :attribute es obligatorio',
            'manager_id.exists' => 'El campo :attribute no existe',
            'project_id.exists' => 'El campo :attribute no existe',
            'fecha_fin.after' => 'La fecha fin debe ser posterior a la fecha inicio',
        ], [], 'activityErrors');

        $actividad = new Activity();
        $actividad->nombre = $request->input('nombre');
        $actividad->estado = $request->input('estado');
        $actividad->manager_id = $request->input('manager_id');
        $actividad->project_id = $request->input('project_id');
        $actividad->fecha_inicio = $request->input('fecha_inicio');
        $actividad->fecha_fin = $request->input('fecha_fin');
        $actividad->save();

        return redirect()->route('admin.projects.index')->with('success', 'Actividad creada correctamente');
    }

    public function update(Request $request, $id)
    {
        $actividad = Activity::findOrFail($id);

        $request->validate([
            'manager_id' => 'nullable|exists:users,id',
            'fecha_inicio' => 'nullable|date',
            'fecha_fin' => 'nullable|date',
        ]);

        if ($request->has('manager_id')) {
            $actividad->manager_id = $request->input('manager_id');
            $message = 'Encargado de actividad actualizado';
        }

        if ($request->has('fecha_inicio')) {
            $actividad->fecha_inicio = $request->input('fecha_inicio');
            $message = 'Fecha de inicio de actividad actualizado';
        }

        if ($request->has('fecha_fin')) {
            $actividad->fecha_fin = $request->input('fecha_fin');
            $message = 'Fecha de fin de actividad actualizado';
        }

        $actividad->save();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
    }
}
