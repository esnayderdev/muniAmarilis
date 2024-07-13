<x-modal name="create-activity" :show="$errors->any()" focusable>
    <form method="post" action="{{ route('admin.activities.store') }}" class="p-6">
        @csrf
        <input type="hidden" id="project_id" name="project_id">

        <div>
            <x-input-label for="nombre" :value="__('Nombre')" />
            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')"
                required autofocus autocomplete="nombre" />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>

        <div class="mt-4 flex w-full gap-2">
            <div class="w-1/2">
                <x-input-label for="fecha_inicio" :value="__('Fecha de inicio')" />
                <x-text-input id="fecha_inicio" class="block mt-1 w-full" type="date" name="fecha_inicio"
                    :value="old('fecha_inicio')" required autofocus autocomplete="fecha_inicio" />
                <x-input-error :messages="$errors->get('fecha_inicio')" class="mt-2" />
            </div>
            <div class="w-1/2">
                <x-input-label for="fecha_fin" :value="__('Fecha de inicio')" />
                <x-text-input id="fecha_fin" class="block mt-1 w-full" type="date" name="fecha_fin" :value="old('fecha_fin')"
                    required autofocus autocomplete="fecha_fin" />
                <x-input-error :messages="$errors->get('fecha_fin')" class="mt-2" />
            </div>
        </div>

        <div class="mt-4 flex w-full gap-2">
            <div class="w-1/2">
                <x-input-label for="estado" :value="__('Estado')" />
                <select name="estado" id="estado" required
                    class="mt-1 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm w-full">
                    <option value="">Seleccione un estado</option>
                    @foreach ($estados_actividad as $estado)
                        <option value="{{ $estado }}" {{ old('estado') == $estado ? 'selected' : '' }}>
                            {{ $estado }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('estado')" class="mt-2" />
            </div>

            <div class="w-1/2">
                <x-input-label for="manager_id" :value="__('Encargado')" />
                <select name="manager_id" id="manager_id" required
                    class="mt-1 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm w-full">
                    <option value="">Seleccione un encargado</option>
                    @foreach ($encargados as $encargado)
                        <option value="{{ $encargado->id }}"
                            {{ old('manager_id') == $encargado->id ? 'selected' : '' }}>
                            {{ $encargado->name }}
                        </option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('manager_id')" class="mt-2" />
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <x-secondary-button x-on:click="$dispatch('close')">
                {{ __('Cancelar') }}
            </x-secondary-button>

            <x-primary-button class="ms-3">
                {{ __('Guardar') }}
            </x-primary-button>
        </div>
    </form>
</x-modal>
