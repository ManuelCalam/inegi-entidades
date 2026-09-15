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
                    <i class="fa-solid fa-user-plus mr-2"></i> Registrar Nuevo Usuario
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
                        <button type="reset" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-md text-sm font-semibold">
                            <i class="fa-solid fa-eraser mr-1"></i> Limpiar
                        </button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md text-sm font-semibold">
                            <i class="fa-solid fa-floppy-disk mr-1"></i> Guardar Usuario
                        </button>
                    </div>
                </form>
            </div>

            <!-- TABLA DE USUARIOS REGISTRADOS -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4">
                    <i class="fa-solid fa-users mr-2"></i> Usuarios del Sistema
                </h3>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Nombre</th>
                                <th class="px-4 py-3">Correo</th>
                                <th class="px-4 py-3">Rol</th>
                                <th class="px-4 py-3">Fecha de Registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                                    <td class="px-4 py-3 font-medium text-gray-900 dark:text-white">{{ $user->id }}</td>
                                    <td class="px-4 py-3">{{ $user->name }}</td>
                                    <td class="px-4 py-3">{{ $user->email }}</td>
                                    <td class="px-4 py-3">
                                        {{-- Muestra los roles asignados mediante Spatie --}}
                                        @forelse($user->getRoleNames() as $role)
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $role === 'admin' ? 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300' : 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' }}">
                                                {{ ucfirst($role) }}
                                            </span>
                                        @empty
                                            <span class="text-gray-400 italic">Sin Rol</span>
                                        @endforelse
                                    </td>
                                    <td class="px-4 py-3">{{ $user->created_at?->format('d/m/Y H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-4 py-3 text-center text-gray-500">No hay usuarios registrados.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>