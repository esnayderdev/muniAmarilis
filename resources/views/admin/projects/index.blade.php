<x-app-layout>
    <div class="hidden fixed top-24 right-10 bg-green-400 text-black shadow-md rounded-md p-3 z-50 text-sm"
        id="mensaje">
    </div>
    
    @if (session('success'))
        <div class="fixed top-24 right-10 bg-green-400 text-black shadow-md rounded-md p-3 z-50 text-sm" id="mensajeStatic">
            {{ session('success') }}
        </div>
    @endif
    <div class="relative overflow-x-auto sm:rounded-lg p-5 m-4">
        <div
            class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-5 md:space-y-0 pb-4 pt-4 px-4  mb-4">
            <div>
                <x-danger-button x-data=""
                    x-on:click.prevent="$dispatch('open-modal', {'id': 'create-project'})">{{ __('Crear nuevo proyecto') }}</x-danger-button>

                @include('admin.projects.partials.modals.project-create')
            </div>
            <div class="flex">
                <form action="{{ route('admin.projects.index') }}" method="GET" class="mb-4 flex" id="formSearch">
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
        @include('admin.projects.partials.table', ['projects' => $projects])
    </div>
    <x-slot name="js">
        <script>
            // Para mostrar y ocultar la tabla de actividades
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

                document.addEventListener('open-modal', event => {
                    const modalId = event.detail.id;
                    const projectId = event.detail.projectId;
                    if (modalId === 'create-activity') {
                        document.getElementById('project_id').value = projectId;
                    }
                });
            });

            // funcion para limpiar el input de busqueda
            function cleanSearch() {
                const formSearch = document.getElementById('formSearch');
                const searchInput = document.getElementById('search');

                searchInput.value = '';
                formSearch.submit();
            }

            // funcion para asignar un encargado
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
                            setTimeout(() => {
                                mensaje.classList.toggle('hidden');
                            }, 2000);
                        } else {
                            // Maneja los errores (puedes personalizar esto según tus necesidades)
                            mensaje.innerHTML = 'Error al asignar un encargado';
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

            // funcion para cambiar estado proyecto
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
                            setTimeout(() => {
                                mensaje.classList.toggle('hidden');
                            }, 2000);
                        } else {
                            // Maneja los errores (puedes personalizar esto según tus necesidades)
                            mensaje.innerHTML = 'Error al asignar un encargado';
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

            // funcion para cambiar la fecha de inicio y fin de una actividad
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

            // funcion para buscar proyectos en tiempo real


            // mostrar modal de añadir actividad

            // mostrar modal de añadir proyecto
        </script>
    </x-slot>
</x-app-layout>
