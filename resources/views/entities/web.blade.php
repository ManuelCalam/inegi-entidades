<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Document</title>

        <link rel="stylesheet" href="{{ asset('css/entities.css') }}">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    </head>

    <body>
        <div class="container">

            <h1>Gestión de Entidades Federativas</h1>

            {{-- <p><a href="{{ route('municipalities.web') }}">Ir a Municipios</a></p> --}}

            <form action="{{ route('entities.web') }}" method="GET" style="margin-top: 30px;">
                <div class="form-group">
                    <label for="search">Buscar entidad por nombre</label>

                    <!-- Agrupador de la barra de búsqueda -->
                    <div class="search-bar-group">
                        <div class="input-with-icon">
                            <i class="fa-solid fa-magnifying-glass"></i>
                            <input type="text" id="search" name="search" value="{{ request('search') }}" placeholder="Ej. Jalisco" autocomplete="off">
                        </div>
                        <button type="submit" class="search-btn">Buscar</button>
                    </div>
                </div>
            </form>

            <br>

            @if (session('success'))
                <div class="success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('searchError'))
                <div class="error">
                    {{ session('searchError') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="error">
                    {{-- <strong>Se encontraron los siguientes errores:</strong> --}}

                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            

            <form action="{{ $entity ? route('entities.web.update', $entity) : route('entities.web.store') }}" method="POST">

                @csrf

                @if ($entity)
                    @method('PUT')
                @endif

                {{-- <div class="form-group">
                    <label for="id">ID</label>
                    <input type="text" id="id" value="{{ $entity?->id ?? '' }}" disabled>
                </div> --}}

                <div class="row">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $entity?->name) }}">
                    </div>

                    <div class="form-group">
                        <label for="key">Clave</label>

                        <input type="text" id="key" name="key" value="{{ old('key', $entity?->key) }}">
                    </div>

                </div>

                <div class="form-group">
                    <label for="regional_center">Centro regional</label>

                    <select id="regional_center" name="regional_center">
                        <option value="">Selecciona una región</option>

                        @foreach ($regionalCenters as $regionalCenter)
                            <option value="{{ $regionalCenter }}" @selected( old( 'regional_center', $entity?->regional_center ) === $regionalCenter)>
                                {{ $regionalCenter }}
                            </option>
                        @endforeach

                    </select>
                </div>

                {{-- Entidades Colindantes --}}
                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <label>Entidades colindantes</label>
                        <button type="button" class="openModal"
                                onclick="openModal(event, 'neighbors', {{ $entity ? $entity->id : 'null' }})">+</button>
                    </div>

                    {{-- Lista visual con botón de eliminación --}}
                    <ul id="bordering_entities_list" class="relation-list">
                        @php
                            $currentNeighbors = old('bordering_entities', $entity ? $entity->neighbors : []);
                        @endphp

                        @foreach ($currentNeighbors as $neighbor)
                            @php
                                $id = is_object($neighbor) ? $neighbor->id : $neighbor;
                                $name = is_object($neighbor) ? $neighbor->name : $neighbor;
                            @endphp
                            <li data-id="{{ $id }}">
                                <span>{{ $name }}</span>
                                <button type="button" class="btn-remove" onclick="removeItem('neighbors', {{ $id }}, {{ $entity ? $entity->id : 'null' }})">&times;</button>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Select oculto para enviar los datos al servidor en la acción principal --}}
                    <select id="bordering_entities" name="bordering_entities[]" multiple style="display: none;">
                        @foreach ($currentNeighbors as $neighbor)
                            @php $id = is_object($neighbor) ? $neighbor->id : $neighbor; @endphp
                            <option value="{{ $id }}" selected></option>
                        @endforeach
                    </select>
                </div>

                {{-- Tipos de Vegetación --}}
                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <label>Tipos de vegetación</label>
                        <button type="button" class="openModal" 
                                onclick="openModal(event, 'vegetation', {{ $entity ? $entity->id : 'null' }})">+</button>
                    </div>

                    {{-- Lista visual con botón de eliminación --}}
                    <ul id="vegetation_types_list" class="relation-list">
                        @php
                            $currentVegetations = old('vegetation_types', $entity ? $entity->vegetationTypes : []);
                        @endphp

                        @foreach ($currentVegetations as $vegetation)
                            @php
                                $id = is_object($vegetation) ? $vegetation->id : $vegetation;
                                $name = is_object($vegetation) ? $vegetation->name : $vegetation;
                            @endphp
                            <li data-id="{{ $id }}">
                                <span>{{ $name }}</span>
                                <button type="button" class="btn-remove" onclick="removeItem('vegetation', {{ $id }}, {{ $entity ? $entity->id : 'null' }})">&times;</button>
                            </li>
                        @endforeach
                    </ul>

                    {{-- Select oculto para enviar los datos al servidor en la acción principal --}}
                    <select id="vegetation_types" name="vegetation_types[]" multiple style="display: none;">
                        @foreach ($currentVegetations as $vegetation)
                            @php $id = is_object($vegetation) ? $vegetation->id : $vegetation; @endphp
                            <option value="{{ $id }}" selected></option>
                        @endforeach
                    </select>
                </div>

                <div class="buttons">
                    @if ($entity)
                        <button type="submit">
                          Actualizar  <i class="fa-solid fa-pen"></i> 
                        </button>
                    @else
                        <button type="submit">
                           Agregar <i class="fa-solid fa-plus"></i> 
                        </button>
                    @endif

                    <a href="{{ route('entities.web') }}" class="button-link">
                       Limpiar <i class="fa-solid fa-rotate-left"></i> 
                    </a>
                </div>

            </form>



            @if ($entity)
            <form action="{{ route('entities.web.destroy', $entity) }}" method="POST" style="margin-top: 10px;">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn-danger">
                   Eliminar <i class="fa-solid fa-trash-can"></i> 
                </button>    
            </form>

            @endif
            
            {{-- <h2 style="margin-top: 40px;">Entidades registradas</h2>

            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Clave</th>
                        <th>Centro regional</th>
                        <th>Entidades colindantes</th>
                        <th>Vegetación</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($entities as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->key }}</td>
                        <td>{{ $item->regional_center }}</td>
                        <td>{{ $item->neighbors->pluck('name')->implode(', ') }}</td>
                        <td>{{ $item->vegetationTypes->pluck('name')->implode(', ') }}</td>
                    </tr>

                    @empty
                        <tr>
                            <td colspan="6">No hay entidades registradas.</td>
                        </tr>
                    @endforelse

                </tbody>
            </table> --}}
        </div>

        <div id="assignModalOverlay" class="modal-overlay" style="display: none;">
            <div class="modal-content">
                <h3 id="modalTitle">Cargando...</h3>
                
                <div id="optionsContainer">
                </div>

                <div class="modal-actions">
                    <button type="button" onclick="submitSelection()">Agregar Seleccionados</button>
                    <button type="button" class="btn-danger" onclick="closeModal()">Cancelar</button>
                </div>
            </div>
        </div>

        <script src="{{ asset('js/entities.js') }}"></script>
    </body>
</html>