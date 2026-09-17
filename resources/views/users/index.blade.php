<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Gestión de Usuarios') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('components.alerts')

    <div class="py-8">
        <br>


        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <!-- FORMULARIO DE REGISTRO -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                    <i class="fa-solid"></i> Registrar Nuevo Usuario
                </h3>

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <!-- Nombre -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre Completo</label>
                            <input type="text" name="name" value="{{ old('name') }}" required 
                                   class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm @error('name') is-invalid @enderror">
                            @error('name')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Correo Electrónico -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Correo Electrónico</label>
                            <input type="email" name="email" value="{{ old('email') }}" required 
                                   class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm @error('email') is-invalid @enderror">
                            @error('email')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Selección de Rol -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rol de Usuario</label>
                            <select name="role" required class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm @error('role') is-invalid @enderror">
                                <option value="" disabled {{ old('role') ? '' : 'selected' }}>Selecciona un rol...</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="capturista" {{ old('role') == 'capturista' ? 'selected' : '' }}>Capturista</option>
                            </select>
                            @error('role')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1" for="entity_id">Entidad</label>
                            <select name="entity_id" id="entity_id" class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                                @forelse($entities as $entity)
                                    @if ($loop->first)
                                        <option value="">Selecciona una entidad</option>
                                    @endif
                                    <option value="{{ $entity->id }}" 
                                        {{ old('entity_id') == $entity->id ? 'selected' : '' }}>
                                        {{ $entity->name }}
                                    </option>
                                @empty
                                    <option value="" disabled>No hay entidades registradas</option>
                                @endforelse
                            </select>
                        </div>

                        <!-- Contraseña -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Contraseña</label>
                            <input type="password" name="password" required 
                                   class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm @error('password') is-invalid @enderror">
                            @error('password')
                                <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" required 
                                   class="w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 rounded-md shadow-sm">
                        </div>
                    </div>

                    <div class="mt-4 flex justify-end gap-2">
                        <button type="submit" style="background-color: rgb(0, 149, 199);" class="px-4 py-2 text-white rounded-md text-sm font-semibold">
                            Guardar Usuario <i class="fa-solid fa-plus mr-1"></i> 
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <br>
</x-app-layout>