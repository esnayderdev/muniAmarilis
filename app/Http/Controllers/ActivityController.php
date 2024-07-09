<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        
        $query = Activity::query();
        
        if ($search) {
            $query->where('nombre', 'LIKE', "%{$search}%");
        }

        $activities = $query->where('manager_id', auth()->user()->id)->get();

        return view('manager.dashboard', compact('activities'));
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
