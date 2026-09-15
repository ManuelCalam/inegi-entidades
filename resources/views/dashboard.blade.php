<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Menú Principal') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="{{ asset('css/entities.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body{
            padding: 0;
        }

        .welcome-text {
            margin-bottom: 25px;
        }

        .welcome-text h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin: 0 0 6px 0;
        }

        .welcome-text p {
            color: #6b7280;
            margin: 0;
            font-size: 0.95rem;
        }

        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 24px;
        }

        .menu-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e5e7eb;
            text-decoration: none;
            color: inherit;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .menu-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header-icon {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .icon-box {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .icon-fire {
            background-color: #ffe5d9;
            color: #d9480f;
        }

        .icon-entity {
            background-color: #e7f5ff;
            color: #1971c2;
        }

        .menu-card h3 {
            margin: 0 0 10px 0;
            font-size: 1.25rem;
            font-weight: 600;
            color: #111827;
        }

        .menu-card p {
            color: #6b7280;
            font-size: 0.9rem;
            line-height: 1.4;
            margin: 0;
        }
    </style>

    @include('components.alerts')

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <!-- Encabezado Interno de Bienvenida -->
                <section class="welcome-text">
                    <h3>Sistema de Incendios</h3>
                    <p>Hola, <strong>{{ auth()->user()->name }}</strong>. Selecciona una opción del menú para administrar la información del sistema.</p>
                </section>

                <!-- Grid de Tarjetas / Menú Principal -->
                <div class="cards-grid">
                    
                    <!-- Tarjeta 1: Gestión de Incendios -->
                    <a href="{{ route('fires.index') }}" class="menu-card">
                        <div>
                            <div class="card-header-icon">
                                <div class="icon-box icon-fire">
                                    <i class="fa-solid fa-fire-flame-curved"></i>
                                </div>
                            </div>
                            <h3>Gestión de Incendios</h3>
                            <p>Registra, actualiza y consulta el estado de los incendios reportados, duraciones y niveles de control.</p>
                        </div>
                    </a>

                    <!-- Tarjeta 2: Entidades Federativas -->
                    <a href="{{ route('entities.web') }}" class="menu-card">
                        <div>
                            <div class="card-header-icon">
                                <div class="icon-box icon-entity">
                                    <i class="fa-solid fa-map-location-dot"></i>
                                </div>
                            </div>
                            <h3>Entidades</h3>
                            <p>Administra el catálogo de entidades federativas, sus tipos de vegetación y su centro regional.</p>
                        </div>
                    </a>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>