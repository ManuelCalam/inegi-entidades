<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        <title>Gestión de Municipios</title>
    </head>

    <body>
        <div
            class="header-navigation"
            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">

            <h1>Gestión de Municipios</h1>

            <a href="{{ route('entities.web') }}" class="btn btn-secondary"> &larr; Ir a Entidades</a>
        </div>


        <main>
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-container">

            <form
                action="{{ isset($municipality)
                    ? route('municipalities.web.update', $municipality)
                    : route('municipalities.web.store') }}"
                method="POST"
            >
                @csrf
                @isset($municipality)
                    @method('PUT')
                @endisset

                <input type="hidden" name="id" id="id" value="{{ $municipality->id ?? '' }}">

                <input type="text" name="name" id="name" placeholder="Nombre del municipio" value="{{ old('name', $municipality->name ?? '') }}" required>

                <input type="text" name="key" id="key" placeholder="Clave INEGI" value="{{ old('key', $municipality->key ?? '') }}" required>

                <select name="entity_id" id="entity_id" required>
                    <option value="">Selecciona la entidad federativa</option>

                    @foreach($entities as $entity)

                        <option value="{{ $entity->id }}"
                            @selected(
                                old(
                                    'entity_id',
                                    $municipality->entity_id ?? ''
                                ) == $entity->id
                            )
                        >
                            {{ $entity->name }}
                        </option>

                    @endforeach

                </select>



                @isset($municipality)
                    <button type="submit" id="btnUpdate"> Actualizar </button>

                @else
                    <button type="submit" id="btnAdd">Agregar</button>
                @endisset

            </form>



            @isset($municipality)

                <form
                    action="{{ route('municipalities.web.destroy', $municipality) }}"
                    method="POST"
                    style="display: inline;"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" id="btnDelete">Eliminar</button>
                </form>

                <a href="{{ route('municipalities.web') }}" class="btn btn-secondary" id="btnClear">Cancelar</a>

            @else
                <a href="{{ route('municipalities.web') }}" class="btn btn-secondary" id="btnClear"> Limpiar </a>

            @endisset



            <form action="{{ route('municipalities.web') }}" method="GET" style="margin-top: 10px;">
                <input type="number" name="search" placeholder="ID del municipio" min="1" value="{{ request('search') }}">

                <button type="submit" id="btnSearch">Buscar por ID</button>
            </form>

        </div>
            <div class="table-container">
                <table class="content">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Entidad</th>
                            <th>Clave</th>
                            <th>Nombre del municipio</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($municipalities as $municipalityRow)
                            <tr>
                                <td>{{ $municipalityRow->id }}</td>
                                <td>{{ $municipalityRow->entity->name ?? 'N/A' }}</td>
                                <td>{{ $municipalityRow->key }}</td>
                                <td>{{ $municipalityRow->name }}</td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="4"> No hay municipios registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </main>
    </body>
</html>
