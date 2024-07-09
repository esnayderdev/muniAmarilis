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

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => $message]);
        }
    }
}
