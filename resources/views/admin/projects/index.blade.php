<x-app-layout>
    <div class="hidden fixed top-24 right-10 bg-green-400 text-black shadow-md rounded-md p-3 z-50 text-sm"
        id="mensaje">

    </div>
    <div class="relative overflow-x-auto sm:rounded-lg p-5 m-4">
        <div
            class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-5 md:space-y-0 pb-4 pt-4 px-4  mb-4">
            <div>
                {{-- <x-dropdown align="left" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium  border-gray-400 rounded-lg  bg-gray-50 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>Seleccione un tipo</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Salir') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown> --}}
            </div>
            <div class="relative ">
                <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="text" id="table-search-users"
                    class="block p-2 ps-10 text-sm text-gray-900 border border-gray-400 rounded-lg w-80 bg-gray-50 focus:ring-green-500 focus:border-green-500 "
                    placeholder="Buscar por nombre">
            </div>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-800 border border-gray-400">
            <thead class="text-xs text-gray-100 uppercase bg-gray-500">
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
                                    class="update-project-form" id="update-project-form-{{ $project->id }}">
                                    @csrf
                                    @method('PUT')
                                    <select name="estado_proyecto"
                                        class="border border-green-400 rounded-md py-0 px-3 w-full focus:border-green-500"
                                        onchange="submitFormProject(event, {{ $project->id }})">
                                        <option value="">Asigna un encargado</option>
                                        @foreach ($estados_proyecto as $estado)
                                            <option value="{{ $estado }}"
                                                {{ $estado == $project->estado ? 'selected' : '' }}>
                                                <div
                                                    class="h-2.5 w-2.5 rounded-full me-2 @if ($estado == 'no confirmado') bg-red-400  @elseif ($estado == 'confirmado') bg-yellow-400 @else  bg-green-400 @endif ">
                                                </div> {{ $estado }}
                                            </option>
                                        @endforeach
                                    </select>
                                </form>

                            </div>
                        </td>

                        <td class="px-6 py-4">
                            <button data-project-id="{{ $project->id }}"
                                class="cursor-pointer font-medium bg-green-600 text-gray-100 px-3 py-1 rounded-md hover:no-underline hover:bg-green-700">Ver
                                actividades</button>
                        </td>
                    </tr>
                    <tr class="activity-row hidden bg-gray-100" data-project-id="{{ $project->id }}">
                        <td colspan="6" class="p-4">
                            <table
                                class="w-10/12 text-sm text-left rtl:text-right text-gray-800 border border-gray-400 ">
                                <thead class="text-xs text-gray-100 uppercase bg-green-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-1">Nombre de Actividad</th>
                                        <th scope="col" class="px-6 py-1">Estado</th>
                                        <th scope="col" class="px-6 py-1">Fecha de Inicio</th>
                                        <th scope="col" class="px-6 py-1">Fecha de Fin</th>
                                        <th scope="col" class="px-6 py-1">Encargado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($project->activities as $activity)
                                        <tr class="border-b border-gray-300">
                                            <td class="px-6 py-2">{{ $activity->nombre }}</td>
                                            <td class="px-6 py-2">{{ $activity->estado }}</td>
                                            <td class="px-6 py-2">
                                                <input type="date" name="fecha_inicio"
                                                    value="{{ $activity->fecha_inicio }}"
                                                    onchange="submitDateForm(event, {{ $activity->id }}, 'fecha_inicio')"
                                                    placeholder="Selecciona una fecha"
                                                    class="border border-green-400 rounded-md py-0 px-3 w-full focus:border-green-500">
                                            </td>
                                            <td class="px-6 py-2">
                                                <input type="date" name="fecha_fin"
                                                    value="{{ $activity->fecha_fin }}"
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
                                                        <option value="">Asigna un encargado</option>
                                                        @foreach ($encargados as $encargado)
                                                            <option value="{{ $encargado->id }}"
                                                                {{ $encargado->id == $activity->manager_id ? 'selected' : '' }}>
                                                                {{ $encargado->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border-b text-gray-700  hover:bg-gray-50">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                No hay proyectos registrados
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <x-slot name="js">
        {{-- Script para mostrar y ocultar la tabla de actividades --}}
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const buttons = document.querySelectorAll('button[data-project-id]');

                buttons.forEach(btn => {
                    btn.addEventListener('click', function() {
                        const projectId = this.getAttribute('data-project-id');
                        const activityRow = document.querySelector(
                            `.activity-row[data-project-id="${projectId}"]`);

                        if (activityRow) {
                            activityRow.classList.toggle('hidden');
                        }
                    });
                });
            });
        </script>

        {{-- Script para asignar un encargado --}}
        <script>
            function submitForm(event, activityId) {
                event.preventDefault(); // Evitar que la página se recargue
                const form = document.getElementById(`update-activity-form-${activityId}`);
                const mensaje = document.getElementById('mensaje');
                const formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': formData.get('_token'),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Muestra una notificación de éxito (puedes personalizar esto según tus necesidades)
                            mensaje.innerHTML = data.message;
                            mensaje.classList.toggle('hidden');
                        } else {
                            // Maneja los errores (puedes personalizar esto según tus necesidades)
                            mensaje.innerHTML = 'Error al asignar un encargado';
                            mensaje.classList.toggle('hidden');
                            mensaje.classList.add('bg-red-400')
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        </script>

        {{-- Script para cambiar estado proyecto --}}
        <script>
            function submitFormProject(event, projectId) {
                event.preventDefault(); // Evitar que la página se recargue
                const form = document.getElementById(`update-project-form-${projectId}`);
                const mensaje = document.getElementById('mensaje');
                const formData = new FormData(form);

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': formData.get('_token'),
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Muestra una notificación de éxito (puedes personalizar esto según tus necesidades)
                            mensaje.innerHTML = data.message;
                            mensaje.classList.toggle('hidden');
                        } else {
                            // Maneja los errores (puedes personalizar esto según tus necesidades)
                            mensaje.innerHTML = 'Error al asignar un encargado';
                            mensaje.classList.toggle('hidden');
                            mensaje.classList.add('bg-red-400')
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        </script>

        {{-- Script para cambiar la fecha de inicio y fin de una actividad --}}
        <script>
            function submitDateForm(event, activityId, dateType) {
                event.preventDefault(); // Evitar el envío tradicional del formulario

                const input = event.target;
                const formData = new FormData();
                formData.append(dateType, input.value);
                formData.append('_method', 'PUT');
                formData.append('_token', '{{ csrf_token() }}');

                fetch(`/admin/activities/${activityId}`, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Muestra una notificación de éxito (puedes personalizar esto según tus necesidades)
                            mensaje.innerHTML = data.message;
                            mensaje.classList.toggle('hidden');
                        } else {
                            // Maneja los errores (puedes personalizar esto según tus necesidades)
                            mensaje.innerHTML = 'Error al actualizar fecha';
                            mensaje.classList.toggle('hidden');
                            mensaje.classList.add('bg-red-400')
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        </script>

    </x-slot>
</x-app-layout>
