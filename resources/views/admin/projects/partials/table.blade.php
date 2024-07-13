<table class="w-full text-sm text-left rtl:text-right text-gray-800 border border-gray-400">
    <thead class="text-xs text-gray-100 uppercase bg-gray-500 ">
        <tr>
            <th scope="col" class="px-6 py-3">
                Nombre
            </th>
            <th scope="col" class="px-6 py-3">
                Descripcion
            </th>
            <th scope="col" class="px-6 py-3">
                Tipo
            </th>
            <th scope="col" class="px-6 py-3">
                Presupuesto
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
        @forelse ($projects as $project)
            <tr class="bg-white hover:bg-gray-200">
                <td class="px-6 py-4">
                    {{ $project->nombre }}
                </td>
                <td class="px-6 py-4">
                    {{ $project->descripcion }}
                </td>

                <td class="px-6 py-4">
                    {{ $project->tipo }}

                </td>
                <td class="px-6 py-4">
                    S/. {{ $project->presupuesto }}
                </td>

                <td class="px-6 py-4">
                    <div class="flex items-center">
                        <form action="{{ route('admin.projects.update', $project->id) }}" method="post"
                            class="update-project-form w-full" id="update-project-form-{{ $project->id }}">
                            @csrf
                            @method('PUT')
                            <select name="estado_proyecto"
                                class="border border-green-400 rounded-md py-0 px-3 w-full focus:border-green-500"
                                onchange="submitFormProject(event, {{ $project->id }})">
                                @foreach ($estados_proyecto as $estado)
                                    <option value="{{ $estado }}"
                                        {{ $estado == $project->estado ? 'selected' : '' }}>
                                        {{ $estado }}
                                    </option>
                                @endforeach
                            </select>
                        </form>

                    </div>
                </td>

                <td class="px-6 py-4 flex gap-2">
                    <button x-data="{ projectId: {{ $project->id }} }"
                        x-on:click.prevent="$dispatch('open-modal', { id: 'create-activity', projectId: projectId })"
                        class="cursor-pointer font-medium bg-lime-700 text-gray-100 px-3 py-1 rounded-md hover:no-underline hover:bg-lime-600">Añadir
                        actividad</button>

                    <button data-project-id="{{ $project->id }}"
                        class="cursor-pointer font-medium bg-green-600 text-gray-100 px-3 py-1 rounded-md hover:no-underline hover:bg-green-700">Ver
                        actividades</button>
                </td>
            </tr>
            <tr class="activity-row hidden bg-gray-100" data-project-id="{{ $project->id }}">
                <td colspan="6" class="p-4">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-800 border border-gray-400 ">
                        <thead class="text-xs text-gray-100 uppercase bg-green-700">
                            <tr>
                                <th scope="col" class="px-6 py-1">Nombre</th>
                                <th scope="col" class="px-6 py-1">Estado</th>
                                <th scope="col" class="px-6 py-1">Fecha de Inicio</th>
                                <th scope="col" class="px-6 py-1">Fecha de Fin</th>
                                <th scope="col" class="px-6 py-1">Encargado</th>
                                <th scope="col" class="px-6 py-1">Accion</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($project->activities as $activity)
                                <tr class="border border-gray-300 bg-white">
                                    <td class="px-6 py-2">{{ $activity->nombre }}</td>
                                    <td class="px-6 py-2 flex items-center">
                                        <div
                                            class="h-3 w-3 rounded-full me-2 @if ($activity->estado == 'retrasado') bg-red-400  @elseif ($activity->estado == 'en progreso') bg-yellow-400 @else  bg-green-400 @endif ">
                                        </div>
                                        <span>
                                            {{ $activity->estado }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-2">
                                        <input type="date" name="fecha_inicio" value="{{ $activity->fecha_inicio }}"
                                            onchange="submitDateForm(event, {{ $activity->id }}, 'fecha_inicio')"
                                            placeholder="Selecciona una fecha"
                                            class="border border-green-400 rounded-md py-0 px-3 w-full focus:border-green-500">
                                    </td>
                                    <td class="px-6 py-2">
                                        <input type="date" name="fecha_fin" value="{{ $activity->fecha_fin }}"
                                            onchange="submitDateForm(event, {{ $activity->id }}, 'fecha_fin')"
                                            placeholder="Selecciona una fecha"
                                            class="border border-green-400 rounded-md py-0 px-3 w-full focus:border-green-500">
                                    </td>
                                    <td class="px-6 py-2">
                                        <form action="{{ route('admin.activities.update', $activity->id) }}"
                                            method="post" class="update-activity-form"
                                            id="update-activity-form-{{ $activity->id }}">
                                            @csrf
                                            @method('PUT')
                                            <select name="manager_id"
                                                class="border border-green-400 rounded-md py-0 px-3 w-full focus:border-green-500"
                                                onchange="submitForm(event, {{ $activity->id }})">
                                                <option value="">sin encargado</option>
                                                @foreach ($encargados as $encargado)
                                                    <option value="{{ $encargado->id }}"
                                                        {{ $encargado->id == $activity->manager_id ? 'selected' : '' }}>
                                                        {{ $encargado->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </td>
                                    <td class="px-6 py-2">
                                        <button
                                            class="cursor-pointer font-medium bg-sky-600 text-gray-100 px-3 py-1 rounded-md hover:no-underline hover:bg-sky-700">Ver
                                            detalles</button>
                                    </td>
                                </tr>
                            @empty
                                <tr class="bg-white border border-gray-600 text-gray-700  hover:bg-gray-50">
                                    <td class="w-4 p-4" colspan="6">
                                        <div class="text-center">
                                            No hay actividades registradas
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </td>
            </tr>
        @empty
            <tr class="bg-white border border-gray-600 text-gray-700  hover:bg-gray-50">
                <td class="w-4 p-4" colspan="6">
                    <div class="text-center">
                        No hay proyectos registrados
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@include('admin.projects.partials.modals.activity-create')
