<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Gestión de Incendios</title>

        <link rel="stylesheet" href="{{ asset('css/entities.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>

    <body>
        <div class="container">

            <h1>Gestión de Incendios</h1>

            <form action="{{ route('fires.index') }}" method="GET" style="margin-top: 30px;">
                <div class="form-group">
                    <div class="search-bar-group">
                        <div class="input-with-icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input 
                                type="text" 
                                id="search" 
                                name="search" 
                                placeholder="Buscar por Clave del incendio..." 
                                value="{{ request('search') }}"
                                autocomplete="off"
                            >
                        </div>
                        <button type="submit" class="search-btn">Buscar</button>
                    </div>
                </div>
            </form>

            <!-- Agrega esto justo antes del <form action="..."> -->
            @if ($errors->any())
                <div style="background-color: #f8d7da; color: #721c24; padding: 12px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #f5c6cb;">
                    <strong>Por favor corrige los siguientes errores:</strong>
                    <ul style="margin-top: 8px; margin-bottom: 0; padding-left: 20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <br>

            <form action="{{ isset($fire) ? route('fires.update', $fire->id) : route('fires.store') }}" method="POST">
                @csrf

                @if(isset($fire))
                    @method('PUT')
                @endif
                
                <div class="row">
                    <div class="form-group" style="flex: 7">
                        <label for="fire_key">Clave del incendio</label>
                        <input 
                            type="text" 
                            id="fire_key" 
                            name="fire_key" 
                            value="{{ old('fire_key', $fire->fire_key ?? '') }}" 
                            readonly 
                            placeholder="Se generará automáticamente"> 
                        </div>

                    <div class="form-group" style="flex: 3;">
                        <label for="reported_at">Fecha y hora de reporte</label>
                        <input 
                            type="datetime-local" 
                            id="reported_at" 
                            name="reported_at"
                            value="{{ old('reported_at', isset($fire->reported_at) ? \Carbon\Carbon::parse($fire->reported_at)->format('Y-m-d\TH:i') : '') }}">
                    </div>
                </div>
                
                {{-- Lista de entidades recibida directamente del controlador --}}
                <div class="form-group">
                    <label for="entity_id">Entidad federativa</label>
                    <select id="entity_id" name="entity_id">
                        @forelse($entities as $entity)
                            @if ($loop->first)
                                <option value="">Selecciona una entidad</option>
                            @endif
                            <option value="{{ $entity->id }}" 
                                {{ old('entity_id', $fire->entity_id ?? '') == $entity->id ? 'selected' : '' }}>
                                {{ $entity->name }}
                            </option>
                        @empty
                            <option value="" disabled>No hay entidades registradas</option>
                        @endforelse
                    </select>
                </div>

                <!-- Municipio -->
                <div class="form-group">
                    <label for="municipality_id">Municipio</label>
                    <select id="municipality_id" name="municipality_id">
                        <option value="">Selecciona un municipio</option>
                    </select>
                </div>

                <!-- Estado del incendio -->
                <div class="form-group">
                    <label for="fire_status">Estado del incendio</label>
                    <select id="fire_status" name="fire_status">
                        <option value="">Selecciona el estado</option>
                        <option value="Activo" {{ old('fire_status', $fire->fire_status ?? '') == 'Activo' ? 'selected' : '' }}>Activo</option>
                        <option value="Controlado" {{ old('fire_status', $fire->fire_status ?? '') == 'Controlado' ? 'selected' : '' }}>Controlado</option>
                        <option value="Liquidado" {{ old('fire_status', $fire->fire_status ?? '') == 'Liquidado' ? 'selected' : '' }}>Liquidado</option>
                    </select>
                </div>
                
                {{-- Fechas y días de duración --}}
                <div class="row">
                    <div class="form-group">
                        <label for="start_date">Fecha de inicio</label>
                        <input 
                            type="date" 
                            id="start_date" 
                            name="start_date" 
                            value="{{ old('start_date', isset($fire->start_date) ? \Carbon\Carbon::parse($fire->start_date)->format('Y-m-d') : '') }}">                    
                    </div>

                    <div class="form-group">
                        <label for="extinction_date">Fecha de liquidación</label>
                        <input 
                            type="date" 
                            id="extinction_date" 
                            name="extinction_date" 
                            value="{{ old('extinction_date', isset($fire->extinction_date) ? \Carbon\Carbon::parse($fire->extinction_date)->format('Y-m-d') : '') }}">                    
                        </div>

                    <div class="form-group">
                        <label for="duration_days">Días de duración</label>
                        <input 
                            type="number" 
                            id="duration_days" 
                            name="duration_days" 
                            value="{{ old('duration_days', $fire->duration_days ?? '') }}" 
                            placeholder="0">                    
                    </div>
                </div>

                <!-- Porcentajes -->
                <div class="row">
                    <div class="form-group">
                        <label for="control_percentage">Porcentaje de control (%)</label>
                        <input 
                            type="number" 
                            id="control_percentage" 
                            name="control_percentage" 
                            value="{{ old('control_percentage', $fire->control_percentage ?? '') }}" 
                            min="0" 
                            max="100" 
                            placeholder="0 - 100">                    
                    </div>

                    <div class="form-group">
                        <label for="extinction_percentage">Porcentaje de liquidación (%)</label>
                        <input 
                            type="number" 
                            id="extinction_percentage" 
                            name="extinction_percentage" 
                            value="{{ old('extinction_percentage', $fire->extinction_percentage ?? 0) }}"                            
                            min="0" 
                            max="100" 
                            placeholder="0 - 100">                    
                        </div>
                </div>
                
                {{-- Tipos de vegetación --}}
                <div class="form-group">
                    <label for="vegetation_type_id">Tipo de vegetación</label>
                    <select id="vegetation_type_id" name="vegetation_type_id">
                        <option value="">Selecciona un tipo de vegetación</option>
                    </select>
                </div>

                <!-- Botones de Acción -->
                <div class="buttons">
                    @if(isset($fire))
                        <button type="submit">
                            Actualizar <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    @else
                        <button type="submit">
                            Guardar <i class="fa-solid fa-plus"></i>
                        </button>
                    @endif

                    <a href="{{ route('fires.index') }}" class="button-link">
                       Limpiar <i class="fa-solid fa-rotate-left"></i> 
                    </a>
                </div>

            </form>

            @if(isset($fire))
                <form action="{{ route('fires.destroy', $fire->id) }}" method="POST" style="margin-top: 10px;" onsubmit="return confirm('¿Estás seguro de eliminar este registro de incendio?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn-danger">
                        Eliminar <i class="fa-solid fa-trash-can"></i>
                    </button>
                </form>
            @endif

        </div>

        <script>
            window.selectedMunicipalityId = "{{ old('municipality_id', $fire->municipality_id ?? '') }}";
            window.selectedVegetationTypeId = "{{ old('vegetation_type_id', $fire->vegetation_type_id ?? '') }}";
        </script>
        <script src="{{ asset('js/fires.js') }}"></script>
    </body>

</html>