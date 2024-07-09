<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use Illuminate\Http\Request;

class ActivityController extends Controller
{
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
        }

        if ($request->has('fecha_inicio')) {
            $actividad->fecha_inicio = $request->input('fecha_inicio');
        }

        if ($request->has('fecha_fin')) {
            $actividad->fecha_fin = $request->input('fecha_fin');
        }

        $actividad->save();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Datos actualizados correctamente']);
        }
    }
}
