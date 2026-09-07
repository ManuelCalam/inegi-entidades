<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Document</title>
</head>
<body>

    <!-- En resources/views/entities/index.blade.php -->
    <div class="header-navigation" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Gestión de Entidades Federativas</h1>
        
        <!-- Botón para ir a Municipios -->
        <a href="{{ route('municipalities.web') }}" class="btn btn-secondary">
            Ir a Municipios &rarr;
        </a>
    </div>

    <main>
        <div class="form-container">
            <form action="">
                <input type="hidden" name="entityId" id="id">
                <input type="text" name="entityName" id="name" placeholder="Nombre">
                <input type="text" name="entityKey" id="key" placeholder="Clave INEGI">
                <button type="button" id="btnAdd" >Agregar</button>
                <button type="button" id="btnSearch">Buscar por ID</button>
                <button type="button" disabled id="btnUpdate">Actualizar</button>
                <button type="button" disabled id="btnDelete">Eliminar</button>
                <button type="button" id="btnClear">Limpiar</button>
                
            </form>
        </div>
        
        <div class="table-container">
            <table class="content">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Clave</th>
                    </tr>
                </thead>
                <tbody id="entities-content-body"></tbody>
            </table>
        </div>
    </main>

    <script src="{{ asset('js/entities.js') }}"></script>
</body>
</html>