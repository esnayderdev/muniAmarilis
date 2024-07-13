<table class="w-full text-sm text-left rtl:text-right text-gray-800 border border-gray-400">
    <thead class="text-xs text-gray-100 uppercase bg-gray-500">
        <tr>
            <th scope="col" class="px-6 py-3">
                Proyecto
            </th>
            <th scope="col" class="px-6 py-3">
                Actividad
            </th>
            <th scope="col" class="px-6 py-3">
                Fecha inicio
            </th>
            <th scope="col" class="px-6 py-3">
                Fecha fin
            </th>
            <th scope="col" class="px-6 py-3">
                Estado
            </th>
            <th scope="col" class="px-6 py-3">
                Accion
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse ($activities as $activity)
            <tr class="bg-white hover:bg-gray-200">
                <td class="px-6 py-4 bg-gray-700 text-white">
                    {{ $activity->project->nombre }}
                </td>
                <td class="px-6 py-4">
                    {{ $activity->nombre }}
                </td>
                <td class="px-6 py-4">
                    {{ $activity->fecha_inicio_formatted }}
                </td>

                <td class="px-6 py-4">
                    {{ $activity->fecha_fin_formatted }}
                </td>
                <td class="px-6 py-4 flex items-center">
                    <div
                        class="h-3 w-3 rounded-full me-2 @if ($activity->estado == 'retrasado') bg-red-400  @elseif ($activity->estado == 'en progreso') bg-yellow-400 @else  bg-green-400 @endif ">
                    </div>
                    <span>{{ $activity->estado }}</span>
                </td>
                <td class="px-6 py-4">
                    <button x-data="{ activityId: {{ $activity->id }} }"
                        x-on:click.prevent="$dispatch('open-modal', { id: 'create-deliverable', activityId: activityId })"
                        class="cursor-pointer font-medium bg-orange-600 text-gray-100 px-3 py-1 rounded-md hover:no-underline hover:bg-orange-700">Añadir
                        entregable</button>
                </td>
            </tr>
            <tr class="deliberable-row bg-gray-100" data-activity-id="{{ $activity->id }}">
                <td colspan="6" class="p-4">
                    <table
                        class="w-full text-sm text-left rtl:text-right text-gray-800 border border-gray-400 ">
                        <thead class="text-xs text-gray-100 uppercase bg-orange-700">
                            <tr>
                                <th scope="col" class="px-6 py-1">Entregable</th>
                                <th scope="col" class="px-6 py-1">Descripcion</th>
                                <th scope="col" class="px-6 py-1">Fecha de entrega</th>
                                <th scope="col" class="px-6 py-1">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($activity->deliverables as $deliverable)
                                <tr class="border border-gray-300 bg-white">
                                    <td class="px-6 py-3">{{ $deliverable->nombre }}</td>
                                    <td class="px-6 py-3">{{ $deliverable->descripcion }}</td>
                                    <td class="px-6 py-3">
                                        <input type="date" name="fecha_entrega"
                                            value="{{ $deliverable->fecha_entrega }}"
                                            onchange="submitDateForm(event, {{ $deliverable->id }})"
                                            placeholder="Selecciona una fecha"
                                            class="border border-orange-400 rounded-md py-0 px-3 w-2/3 focus:border-green-500">
                                    </td>
                                    <td class="px-6 py-3">
                                        <form
                                            action="{{ route('manager.deliverable.update', $deliverable->id) }}"
                                            method="post" class="update-deliverable-form"
                                            id="update-deliverable-form-{{ $deliverable->id }}">
                                            @csrf
                                            @method('PUT')
                                            <input type="checkbox" name="estado"
                                                id="estado-{{ $deliverable->id }}"
                                                class="rounded border-gray-500 text-green-600 shadow-sm w-5 h-5"
                                                {{ $deliverable->estado == 1 ? 'checked' : '' }}
                                                onchange="submitDeliverableForm(event, {{ $deliverable->id }})">
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border border-gray-600 text-gray-700 hover:bg-gray-50">
                                    <td class="w-4 p-4" colspan="4">
                                        <div class="text-center">
                                            No hay entregables registrados
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </td>
            </tr>
        @empty
            <tr class="bg-white border border-gray-600 text-gray-700 hover:bg-gray-50">
                <td class="w-4 p-4" colspan="6">
                    <div class="text-center">
                        No hay actividades registrados
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@include('manager.partials.modals.deliverable-create')