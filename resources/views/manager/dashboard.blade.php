<x-app-layout>
    <div class="hidden fixed top-24 right-10 bg-green-400 text-black shadow-md rounded-md p-3 z-50 text-sm"
        id="mensaje">
    </div>
    <div class="relative overflow-x-auto sm:rounded-lg p-5 m-4">
        <div
            class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-5 md:space-y-0 pb-4 pt-4 px-4  mb-4">
            <div></div>
            <div class="flex">
                <form action="{{ route('manager.index') }}" method="GET" class="mb-4 flex" id="formSearch">
                    <div class="relative ">
                        <div
                            class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" value="{{ request('search') }}" name="search" id="search"
                            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-400 rounded-lg w-80 bg-gray-50 focus:ring-green-500 focus:border-green-500 "
                            placeholder="Buscar por nombre del proyecto">
                    </div>
                    <button type="submit" class="bg-green-600 text-white rounded-md p-2 ml-2">Buscar</button>
                </form>
                <div class="mb-4">
                    <button type="button" class="bg-gray-600 text-white rounded-md p-2 ml-2"
                        onclick="cleanSearch()">Limpiar</button>
                </div>
            </div>
        </div>
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
                            <button data-activity-id="{{ $activity->id }}"
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
                                    @foreach ($activity->deliverables as $deliverable)
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
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                    </tr>
                @empty
                    <tr class="bg-white border border-gray-600 text-gray-700 hover:bg-gray-50">
                        <td class="w-4 p-4" colspan="6">
                            <div class="text-center">
                                No hay proyectos registrados
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <x-slot name="js">
        {{-- Script para actualizar estado de entregable --}}
        <script>
            function cleanSearch() {
                const formSearch = document.getElementById('formSearch');
                const searchInput = document.getElementById('search');

                searchInput.value = '';
                formSearch.submit();
            }

            function submitDeliverableForm(event, deliverableId) {
                event.preventDefault(); // Evitar el envío tradicional del formulario
                const mensaje = document.getElementById('mensaje');
                const form = document.getElementById(`update-deliverable-form-${deliverableId}`);
                const formData = new FormData(form);
                formData.set('estado', form.estado.checked ? 1 : 0);

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': formData.get('_token')
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Muestra una notificación de éxito (puedes personalizar esto según tus necesidades)
                            mensaje.innerHTML = data.message;
                            mensaje.classList.toggle('hidden');
                            setTimeout(() => {
                                mensaje.classList.toggle('hidden');
                            }, 2000);
                        } else {
                            // Maneja los errores (puedes personalizar esto según tus necesidades)
                            mensaje.innerHTML = 'Error al actualizar estado de entregable';
                            mensaje.classList.toggle('hidden');
                            mensaje.classList.add('bg-red-400');
                            setTimeout(() => {
                                mensaje.classList.toggle('hidden');
                            }, 2000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        </script>
        <script>
            function submitDateForm(event, deliverableId) {
                event.preventDefault(); // Evitar el envío tradicional del formulario

                const input = event.target;
                const formData = new FormData();
                formData.set('fecha_entrega', input.value);
                formData.append('_method', 'PUT');
                formData.append('_token', '{{ csrf_token() }}');

                fetch(`/manager/deliverables/${deliverableId}`, {
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
                            setTimeout(() => {
                                mensaje.classList.toggle('hidden');
                            }, 2000);
                        } else {
                            // Maneja los errores (puedes personalizar esto según tus necesidades)
                            mensaje.innerHTML = 'Error al actualizar fecha';
                            mensaje.classList.toggle('hidden');
                            mensaje.classList.add('bg-red-400')
                            setTimeout(() => {
                                mensaje.classList.toggle('hidden');
                            }, 2000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            }
        </script>

    </x-slot>
</x-app-layout>
