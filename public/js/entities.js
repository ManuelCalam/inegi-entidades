let currentType = null;
let currentEntityId = null;

const getCsrfToken = () => document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');


window.openModal = async function (event, type, entityId = null) {
    if (event) {
        event.preventDefault();
    }

    currentType = type;
    currentEntityId = (!entityId || entityId === 'null') ? null : entityId;

    const overlay = document.getElementById('assignModalOverlay');
    const container = document.getElementById('optionsContainer');
    const title = document.getElementById('modalTitle');

    title.innerText = type === 'neighbors' 
        ? 'Agregar Entidades Colindantes' 
        : 'Agregar Tipos de Vegetación';

    container.innerHTML = '<p>Cargando opciones...</p>';
    overlay.style.display = 'flex';

    let endpoint;
    if (currentEntityId) {
        endpoint = type === 'neighbors'
            ? `/api/entities/${currentEntityId}/available-neighbors`
            : `/api/entities/${currentEntityId}/available-vegetation`;
    } else {
        endpoint = type === 'neighbors'
            ? `/api/entities`
            : `/api/vegetation-types`;
    }

    try {
        const response = await fetch(endpoint, {
            headers: {
                'Accept': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            }
        });

        if (!response.ok) throw new Error('Error al consultar las opciones.');

        let data = await response.json();

        if (!currentEntityId) {
            const targetSelectId = type === 'neighbors' ? 'bordering_entities' : 'vegetation_types';
            const select = document.getElementById(targetSelectId);
            
            if (select) {
                const selectedValues = Array.from(select.options).map(opt => String(opt.value));
                data = data.filter(item => !selectedValues.includes(String(item.id)));
            }
        }

        if (!Array.isArray(data) || data.length === 0) {
            container.innerHTML = '<p>No hay elementos disponibles para agregar.</p>';
            return;
        }

        container.innerHTML = data.map(item => `
            <div style="display: flex; align-items: center; justify-content: flex-start; width: 100%; margin: 4px 0; padding: 4px 0;">
                <label style="display: flex; align-items: center; gap: 10px; margin: 0; padding: 0; width: 100%; text-align: left; cursor: pointer; font-weight: normal;">
                    <input type="checkbox" name="selected_ids[]" value="${item.id}" data-name="${item.name}" style="margin: 0; padding: 0; width: 16px; height: 16px; flex-shrink: 0;">
                    <span style="margin: 0; padding: 0; line-height: 1;">${item.name}</span>
                </label>
            </div>
        `).join('');

    } catch (error) {
        console.error(error);
        container.innerHTML = '<p style="color:red;">Error al cargar las opciones.</p>';
    }
};


window.closeModal = function () {
    const overlay = document.getElementById('assignModalOverlay');
    if (overlay) {
        overlay.style.display = 'none';
    }
};


window.submitSelection = async function () {
        console.log('SUBMIT SELECTION: solo UI, NO BD');


    const checkedInputs = Array.from(
        document.querySelectorAll('input[name="selected_ids[]"]:checked')
    );

    if (checkedInputs.length === 0) {
        window.closeModal();
        return;
    }

    const isNeighbors = currentType === 'neighbors';

    const targetSelectId = isNeighbors
        ? 'bordering_entities'
        : 'vegetation_types';

    const targetListId = isNeighbors
        ? 'bordering_entities_list'
        : 'vegetation_types_list';

    const selectedItems = checkedInputs.map(input => ({
        id: input.value,
        name: input.getAttribute('data-name')
    }));

    appendItemsUI(
        targetSelectId,
        targetListId,
        selectedItems,
        currentType,
        currentEntityId
    );

    window.closeModal();
};


window.removeItem = function (type, itemId, entityId = null) {
    const targetSelectId = type === 'neighbors'
        ? 'bordering_entities'
        : 'vegetation_types';

    const targetListId = type === 'neighbors'
        ? 'bordering_entities_list'
        : 'vegetation_types_list';

    removeFromDOM(targetSelectId, targetListId, itemId);
};

function removeFromDOM(selectId, listId, itemId) {
    const select = document.getElementById(selectId);
    const list = document.getElementById(listId);

    if (select) {
        const option = select.querySelector(`option[value="${itemId}"]`);
        if (option) option.remove();
    }

    if (list) {
        const li = list.querySelector(`li[data-id="${itemId}"]`);
        if (li) li.remove();
    }
}


function appendItemsUI(selectId, listId, items, type, entityId) {
    const select = document.getElementById(selectId);
    const list = document.getElementById(listId);

    items.forEach(item => {
        if (list && !list.querySelector(`li[data-id="${item.id}"]`)) {
            const li = document.createElement('li');
            li.setAttribute('data-id', item.id);
            li.innerHTML = `
                <span>${item.name}</span>
                <button type="button" class="btn-remove" onclick="removeItem('${type}', ${item.id}, ${entityId ? entityId : 'null'})">&times;</button>
            `;
            list.appendChild(li);
        }

        if (select && !select.querySelector(`option[value="${item.id}"]`)) {
            const option = document.createElement('option');
            option.value = item.id;
            option.selected = true;
            select.appendChild(option);
        }
    });
}


function updateFullUI(selectId, listId, items, type, entityId) {
    const select = document.getElementById(selectId);
    const list = document.getElementById(listId);

    if (select) select.innerHTML = '';
    if (list) list.innerHTML = '';

    items.forEach(item => {
        if (list) {
            const li = document.createElement('li');
            li.setAttribute('data-id', item.id);
            li.innerHTML = `
                <span>${item.name}</span>
                <button type="button" class="btn-remove" onclick="removeItem('${type}', ${item.id}, ${entityId ? entityId : 'null'})">&times;</button>
            `;
            list.appendChild(li);
        }

        if (select) {
            const option = document.createElement('option');
            option.value = item.id;
            option.selected = true;
            select.appendChild(option);
        }
    });
}