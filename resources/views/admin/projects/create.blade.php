<x-app-layout>

    @if (session('success'))
        <div class="fixed top-24 right-10 bg-green-400 text-black shadow-md rounded-md p-3 z-50 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col items-center justify-center mx-auto md:px-32 sm:px-12 lg:px-40 xl:px-80 py-12">
        <div class="w-full bg-white shadow-lg rounded-lg p-6 mt-6 overflow-hidden border border-gray-500">
            <form method="POST" action="{{ route('admin.projects.store') }}" class="flex flex-col">
                @csrf
                <div>
                    <x-input-label for="nombre" :value="__('Nombre')" />
                    <x-text-input id="nombre" class="block mt-1 w-full" type="text" name="nombre" :value="old('nombre')"
                        required autofocus autocomplete="nombre" />
                    <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="tipo" :value="__('Tipo')" />
                    <select name="tipo" id="tipo" required
                        class="mt-1 border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-md shadow-sm w-full">
                        <option value="">Seleccione una tipo</option>
                        @foreach ($tipos as $tipo)
                            <option value="{{ $tipo }}" {{ old('tipo') == $tipo ? 'selected' : '' }}>
                                {{ $tipo }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mt-4">
                    <x-input-label for="descripcion" :value="__('Descripcion')" />
                    <textarea class="block mt-1 w-full text-gray-700 border-gray-300 rounded-md focus:border-green-500 focus:ring-green-500"
                        name="descripcion" id="descripcion" cols="30" rows="2">{{ old('descripcion') }}</textarea>
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="presupuesto" :value="__('Presupuesto')" />
                    <x-text-input id="presupuesto" class="block mt-1 w-full" type="text" name="presupuesto"
                        :value="old('presupuesto')" required autofocus autocomplete="presupuesto" />
                    <x-input-error :messages="$errors->get('presupuesto')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="ms-4">
                        {{ __('Guardar') }}
                    </x-primary-button>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
