<x-modal name="create-deliverable" :show="$errors->any()" focusable>
    <form method="post" action="{{ route('manager.deliverables.store') }}" class="p-6">
        @csrf
        <input type="hidden" id="activity_id" name="activity_id">

        <div>
            <x-input-label for="nombre" :value="__('Nombre')" />
            <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')"
                required autofocus autocomplete="nombre" />
            <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
        </div>
        
        <div class="mt-4">
            <x-input-label for="descripcion" :value="__('Descripcion')" />
            <textarea class="block mt-1 w-full text-gray-700 border-gray-300 rounded-md focus:border-green-500 focus:ring-green-500"
                name="descripcion" id="descripcion" cols="30" rows="2">{{ old('descripcion') }}</textarea>
            <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
        </div>

        <div class="mt-4 flex w-full gap-2">
            <div class="w-1/2">
                <x-input-label for="fecha_entrega" :value="__('Fecha de entrega')" />
                <x-text-input id="fecha_entrega" class="block mt-1 w-full" type="date" name="fecha_entrega"
                    :value="old('fecha_entrega')" required autofocus autocomplete="fecha_entrega" />
                <x-input-error :messages="$errors->get('fecha_entrega')" class="mt-2" />
            </div>
            <div class="w-1/2">
                <x-input-label for="estado" :value="__('Estado')" />
                <x-text-input id="estado" class="block mt-1 w-10 h-10" type="checkbox" name="estado"
                    :value="old('estado')" autofocus autocomplete="estado" />
                <x-input-error :messages="$errors->get('estado')" class="mt-2" />
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