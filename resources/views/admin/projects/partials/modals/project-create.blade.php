<x-modal name="create-project" :show="$errors->hasBag('projectErrors')" focusable errorBag="projectErrors">
    <form method="post" action="{{ route('admin.projects.store') }}" class="p-6">
        @csrf
        <div>
            <x-input-label for="nombre" :value="__('Nombre')" />
            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')" required
                autofocus autocomplete="nombre" />
            <x-input-error :messages="$errors->getBag('projectErrors')->get('nombre')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="tipo" :value="__('Tipo')" />
            <select name="tipo" id="tipo" required
                class="mt-1 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm w-full">
                <option value="">Seleccione un tipo</option>
                @foreach ($tipos as $tipo)
                    <option value="{{ $tipo }}" {{ old('tipo') == $tipo ? 'selected' : '' }}>
                        {{ $tipo }}
                    </option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->getBag('projectErrors')->get('tipo', 'projectErrors')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="descripcion" :value="__('Descripcion')" />
            <textarea class="block mt-1 w-full text-gray-700 border-gray-300 rounded-md focus:border-green-500 focus:ring-green-500"
                name="descripcion" id="descripcion" cols="30" rows="2">{{ old('descripcion') }}</textarea>
            <x-input-error :messages="$errors->getBag('projectErrors')->get('descripcion', 'projectErrors')" class="mt-2" />
        </div>

        <div class="mt-4">
            <x-input-label for="presupuesto" :value="__('Presupuesto')" />
            <x-text-input id="presupuesto" class="block mt-1 w-full" type="text" name="presupuesto" :value="old('presupuesto')"
                required autofocus autocomplete="presupuesto" />
            <x-input-error :messages="$errors->getBag('projectErrors')->get('presupuesto', 'projectErrors')" class="mt-2" />
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
