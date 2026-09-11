document.addEventListener('DOMContentLoaded', function () {

    // Elementos de selects dinámicos
    const entitySelect = document.getElementById('entity_id');
    const municipalitySelect = document.getElementById('municipality_id');
    const vegetationSelect = document.getElementById('vegetation_type_id');
    const fireKeyInput = document.getElementById('fire_key');

    // Elementos de Inputs de fechas
    const startDateInput = document.getElementById('start_date');
    const extinctionDateInput = document.getElementById('extinction_date');
    const durationDaysInput = document.getElementById('duration_days');

    // Elementos de Inputs de porcentaje
    const controlInput = document.getElementById('control_percentage');
    const extinctionInput = document.getElementById('extinction_percentage');

    // Input de fecha y hora de reporte
    const reportedAtInput = document.getElementById('reported_at');



    // Carga de elementos al seleccionar la entidad
    async function loadEntityData(entityId, selectedMunicipalityId = null, selectedVegetationTypeId = null) {
        if (!entityId) {
            resetSelect(municipalitySelect, 'Selecciona un municipio');
            resetSelect(vegetationSelect, 'Selecciona un tipo de vegetación');
            fireKeyInput.value = '';
            return;
        }

        try {
            const promises = [
                fetchMunicipalities(entityId, selectedMunicipalityId),
                fetchVegetationTypes(entityId, selectedVegetationTypeId)
            ];

            if (!window.selectedMunicipalityId && !window.selectedVegetationTypeId) {
                promises.push(fetchFireKey(entityId));
            }

            await Promise.all(promises);
        } catch (error) {
            console.error('Error al obtener los datos de la entidad:', error);
        }
    }

    async function fetchMunicipalities(entityId, selectedId = null) {
        resetSelect(municipalitySelect, 'Cargando municipios...');
        
        const response = await fetch(`/fires/${entityId}/municipalities`);
        const data = await response.json();

        resetSelect(municipalitySelect, 'Selecciona un municipio');
        data.forEach(item => {
            const option = new Option(item.name, item.id);
            if (selectedId && String(item.id) === String(selectedId)) {
                option.selected = true;
            }
            municipalitySelect.add(option);
        });
    }

    async function fetchVegetationTypes(entityId, selectedId = null) {
        resetSelect(vegetationSelect, 'Cargando vegetación...');

        const response = await fetch(`/fires/${entityId}/vegetation-types`);
        const data = await response.json();

        resetSelect(vegetationSelect, 'Selecciona un tipo de vegetación');
        data.forEach(item => {
            const option = new Option(item.name, item.id);
            if (selectedId && String(item.id) === String(selectedId)) {
                option.selected = true;
            }
            vegetationSelect.add(option);
        });
    }

    async function fetchFireKey(entityId) {
        fireKeyInput.value = 'Generando clave...';

        const response = await fetch(`/fires/${entityId}/generate-fire-key`);
        const data = await response.json();

        fireKeyInput.value = data.fire_key;
    }

    function resetSelect(selectElement, defaultText) {
        selectElement.innerHTML = `<option value="">${defaultText}</option>`;
    }

    entitySelect.addEventListener('change', function () {
        loadEntityData(this.value);
    });

    if (entitySelect.value) {
        const savedMuni = window.selectedMunicipalityId || null;
        const savedVeg = window.selectedVegetationTypeId || null;
        loadEntityData(entitySelect.value, savedMuni, savedVeg);
    }




    // Validaciones en las fechas
    if (!startDateInput.value) {
        extinctionDateInput.disabled = true;
    }

    function calculateDuration() {
        if (startDateInput.value && extinctionDateInput.value) {
            const start = new Date(startDateInput.value);
            const extinction = new Date(extinctionDateInput.value);

            const diffTime = extinction - start;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (diffDays >= 0) {
                // Sumamos 1 para que el mismo día cuente como 1 día entero
                durationDaysInput.value = diffDays + 1; 
            } else {
                durationDaysInput.value = 0;
            }
        } else {
            durationDaysInput.value = '';
        }
    }

    startDateInput.addEventListener('change', function () {
        const startDateValue = this.value;

        if (startDateValue) {
            extinctionDateInput.disabled = false;
            extinctionDateInput.min = startDateValue;

            if (extinctionDateInput.value && extinctionDateInput.value < startDateValue) {
                extinctionDateInput.value = '';
            }
        } else {
            extinctionDateInput.disabled = true;
            extinctionDateInput.value = '';
            extinctionDateInput.removeAttribute('min');
        }

        calculateDuration();
    });

    extinctionDateInput.addEventListener('change', calculateDuration);




    function validatePercentages() {
        if (controlInput.value === '' || controlInput.value === null) {
            extinctionInput.disabled = true;
            extinctionInput.value = ''; 
        } else {
            extinctionInput.disabled = false;
        }

        let controlVal = parseFloat(controlInput.value) || 0;
        let extinctionVal = parseFloat(extinctionInput.value) || 0;

        if (controlVal < 0) controlInput.value = 0;
        if (controlVal > 100) controlInput.value = 100;

        if (extinctionVal < 0) extinctionInput.value = 0;
        if (extinctionVal > 100) extinctionInput.value = 100;

        controlVal = parseFloat(controlInput.value) || 0;
        extinctionVal = parseFloat(extinctionInput.value) || 0;

        controlInput.max = 100 - extinctionVal;
        extinctionInput.max = 100 - controlVal;

        if (controlVal + extinctionVal > 100) {
            if (document.activeElement === controlInput) {
                controlInput.value = 100 - extinctionVal;
            } else if (document.activeElement === extinctionInput) {
                extinctionInput.value = 100 - controlVal;
            }
        }
    }

    controlInput.addEventListener('input', validatePercentages);
    extinctionInput.addEventListener('input', validatePercentages);

    validatePercentages();




    if (reportedAtInput && !reportedAtInput.value) {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');

        reportedAtInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
    }


});