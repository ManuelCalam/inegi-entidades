<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>

        <link rel="stylesheet" href="{{ asset('css/entities.css') }}">
    </head>

    <body>
        <div class="container">

            <h1>Gestión de Entidades Federativas</h1>

            <p><a href="{{ route('municipalities.web') }}">Ir a Municipios</a></p>

            <form action="{{ route('entities.web') }}" method="GET" style="margin-top: 30px;">
                <div class="form-group">
                    <label for="search">Buscar entidad por nombre</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}">
                </div>

                <div class="buttons">
                    <button type="submit">Buscar</button>
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

                <div class="form-group">
                    <label for="id">ID</label>
                    <input type="text" id="id" value="{{ $entity?->id ?? '' }}" disabled>
                </div>

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

                <div class="form-group">
                    <label for="bordering_entities">Entidades colindantes</label>
                    <select id="bordering_entities" name="bordering_entities[]" multiple>
                        @foreach ($entities as $item)
                            <option value="{{ $item->name }}" @selected( in_array( $item->name, old( 'bordering_entities', $entity?->bordering_entities ?? [])))>
                                {{ $item->name }}
                            </option>

                        @endforeach
                    </select>

                </div>

                <div class="form-group">
                    <label for="vegetation_types">Tipos de vegetación</label>

                    <select id="vegetation_types" name="vegetation_types[]" multiple>
                        @php
                            $selectedVegetations = old('vegetation_types', $entity ? $entity->vegetationTypes->pluck('id')->toArray() : []);
                        @endphp

                        @foreach ($vegetationTypes as $vegetationType)
                            <option value="{{ $vegetationType->id }}" @selected(in_array($vegetationType->id, $selectedVegetations))>
                                {{ $vegetationType->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="buttons">
                    @if ($entity)
                        <button type="submit">Actualizar</button>
                    @else
                        <button type="submit">Agregar</button>
                    @endif

                    <a href="{{ route('entities.web') }}" class="button-link">Limpiar</a>
                </div>

            </form>



            @if ($entity)
            <form action="{{ route('entities.web.destroy', $entity) }}" method="POST" style="margin-top: 10px;">
                @csrf
                @method('DELETE')

                <button type="submit">Eliminar</button>
            </form>

            @endif
                <h2 style="margin-top: 40px;">Entidades registradas</h2>

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
                            <td>{{ implode(', ', $item->bordering_entities ?? []) }}</td>
                            <td>{{ $item->vegetationTypes->pluck('name')->implode(', ') }}</td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6">No hay entidades registradas.</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </body>
</html>