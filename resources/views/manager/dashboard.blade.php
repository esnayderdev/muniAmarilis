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
                            placeholder="Buscar por nombre de actividad">
                    </div>
                    <button type="submit" class="bg-green-600 text-white rounded-md p-2 ml-2">Buscar</button>
                </form>
                <div class="mb-4">
                    <button type="button" class="bg-gray-600 text-white rounded-md p-2 ml-2"
                        onclick="cleanSearch()">Limpiar</button>
                </div>
            </div>
        </div>
        @include('manager.partials.table')

    </div>

    <x-slot name="js">
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                document.addEventListener('open-modal', event => {
                    const modalId = event.detail.id;
                    const activityId = event.detail.activityId;
                    if (modalId === 'create-deliverable') {
                        document.getElementById('activity_id').value = activityId;
                    }
                });
            });

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
