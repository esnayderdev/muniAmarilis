<?php

namespace App\Http\Controllers;

use App\Models\Deliverable;
use Illuminate\Http\Request;

class DeliverableController extends Controller
{
    public function update(Request $request, $id)
    {
        $deliverable = Deliverable::findOrFail($id);

        $request->validate([
            'estado' => 'nullable|boolean',
            'fecha_entrega' => 'nullable|date',
        ]);

        if ($request->has('estado')) {
            $deliverable->estado = $request->input('estado');
            $message = 'Estado de entregable actualizado';
        }

        if ($request->has('fecha_entrega')) {
            $deliverable->fecha_entrega = $request->input('fecha_entrega');
            $message = 'Fecha de entrega actualizado';
        }

        $deliverable->save();

        $deliverable->activity->checkAndUpdateStatus();
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
            'fecha_entrega' => 'required|date',
            'estado' => 'nullable',
            'activity_id' => 'required|exists:activities,id',
        ], [
            'activity_id.exists' => 'El campo :attribute no existe',
            'activity_id.required' => 'El campo :attribute es obligatorio',
            'fecha_entrega.required' => 'El campo :attribute es obligatorio',
            'fecha_entrega.date' => 'El campo :attribute debe ser una fecha válida',
            'nombre.required' => 'El campo :attribute es obligatorio',
            'descripcion.required' => 'El campo :attribute es obligatorio',
        ]);

        $deliverable = Deliverable::create([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'fecha_entrega' => $request->input('fecha_entrega'),
            'estado' => $request->input('estado') === null ? 0 : 1,
            'activity_id' => $request->input('activity_id'),
        ]);

        return redirect()->route('manager.index')->with('success', 'Entregable creado correctamente');
    }
}
