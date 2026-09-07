document.addEventListener('DOMContentLoaded', () => {
    loadEntities();

    document.getElementById('btnAdd').addEventListener('click', createEntity);
    document.getElementById('btnClear').addEventListener('click', clearForm);
    document.getElementById('btnSearch').addEventListener('click', searchEntity);
    document.getElementById('btnUpdate').addEventListener('click', updateEntity);
    document.getElementById('btnDelete').addEventListener('click', deleteEntity);
});

function loadEntities() {
    fetch('/api/entities')
        .then(response => response.json())
        .then(data => {
            console.log('Datos recibidos', data);
            const tableBody = document.getElementById('entities-content-body');
            
            tableBody.innerHTML = '';

            data.forEach(entity => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${entity.id}</td>
                    <td>${entity.name}</td>
                    <td>${entity.key}</td>
                `;
                tableBody.appendChild(row);
            })
        })
        .catch(error => {
            console.error('Error al cargar las entidades', error);
        });
}

function createEntity() {
    const name = document.getElementById('name').value;
    const key = document.getElementById('key').value;

    fetch('/api/entities', {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            name: name,
            key: key
        })
    })
    .then(async response => {
        const data = await response.json();

        if (!response.ok) {
            throw { status: response.status, data: data}
        }

        return data
    })
    .then (result => {
        console.log('Respuesta del servidor: ', result);
        
        clearForm();
        loadEntities();
    })
    .catch(error => {
        if (error.status === 422) {
            console.error("Errores de validación: ", error.data.errors);

            const messages = Object.values(error.data.errors).flat().join('\n');
            alert(messages);
        } else {
            console.error('Error del servidor', error);
        }
    })
}

function searchEntity(){
    const id = prompt('Ingresa el ID de la entidad a buscar:');

    if(!id) return;

    fetch(`/api/entities/${id}`, {        
        headers: {
            'Accept': 'application/json'
        },
    })
    .then(async response => {
        const data = await response.json();

        if(!response.ok){
            throw {status: response.status, data: data};

        } 

        return data;
    })
    .then(entity => {
        document.getElementById('id').value = entity.id;
        document.getElementById('name').value = entity.name;
        document.getElementById('key').value = entity.key;
        
        document.getElementById('btnUpdate').disabled = false;
        document.getElementById('btnDelete').disabled = false;
        document.getElementById('btnAdd').disabled = true;
        
        document.getElementById('btnClear').textContent = 'Cancelar';
    })
    .catch ( error => {
        if(error.status === 404){
            alert('Entidad no encontrada');
        } else {
            console.error('Error al buscar: ', error);
            alert('Ocurrió un error al realizar la búsqueda.');        
        }
        clearForm();
    })
}

function updateEntity(){
console.log('¡Botón Actualizar presionado!'); // <-- Agrega esto para probar

    const id = document.getElementById('id').value;
    const name = document.getElementById('name').value;
    const key = document.getElementById('key').value;

    if (!id) {
        alert('Primero debes buscar una entidad para poder actualizarla.');
        return;
    }

    fetch(`/api/entities/${id}`, {        
        method: "PUT",
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({
            name: name,
            key: key
        })
    })
    .then(async response => {
        const data = await response.json();

        if(!response.ok){
            throw {status: response.status, data: data};
        }

        return data;
    })
    .then(result => {
        console.log('Respuesta del servidor: ', result);

        loadEntities();
        clearForm();
    })
    .catch(error => {
        if(error.status === 422){
            console.error("Errores de validación: ", error.data.errors);

            const messages = Object.values(error.data.errors).flat().join('\n');
            alert(messages);
        } else {
            console.error('Error del servidor', error);
        }
    })
}

function deleteEntity(){
    const id = document.getElementById('id').value;
    
    if (!id) {
        alert('Primero debes buscar una entidad para poder eliminarla.');
        return;
    }

    if (!confirm(`¿Estás seguro de que deseas eliminar la entidad con ID ${id}?`)) {
        return;
    }

    fetch(`/api/entities/${id}`, {        
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(async response => {
        const data = await response.json();
        
        if(!response.ok) {
            throw {status: response.status, data: data}
        }
         
        return data;
    })
    .then(result => {
        loadEntities();
        clearForm();
    })
    .catch( error => {
        if(error.status === 404){
            alert('La entidad que intentas eliminar ya no existe.');
        }  else {
            console.error('Error del servidor', error);
        }
        clearForm();
    })
}

function clearForm(){
    document.getElementById('id').value = '';
    document.getElementById('name').value = '';
    document.getElementById('key').value = '';

    document.getElementById('btnAdd').disabled = false;
    document.getElementById('btnUpdate').disabled = true;
    document.getElementById('btnDelete').disabled = true;

    document.getElementById('btnClear').textContent = 'Limpiar';
}

