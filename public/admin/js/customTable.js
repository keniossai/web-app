"use strict";
var taskItems = tasks;
const itemsPorPagina = 10; // Define cuántos elementos deseas mostrar por página
let paginaActual = 1;
let totalPaginas = Math.ceil(taskItems.length / itemsPorPagina);
const cuerpoTabla = document.getElementById('items-tasks');
const paginacionUl = document.querySelector('.pagination');

function renderizarTabla() {
    cuerpoTabla.innerHTML = '';
    const inicio = (paginaActual - 1) * itemsPorPagina;
    const fin = Math.min(inicio + itemsPorPagina, taskItems.length);
    for (let i = inicio; i < fin; i++) {
        const task = taskItems[i];
        const fila = document.createElement('tr');
        // get images
        let img = task.picture ? "/files/clients/" + task.picture : "/files/clients/ka.png";
        var url = window.location.protocol + "//" + window.location.host + img;
        //format deadlines
        let agreedDeadline = task.agreed_deadline ? new Date(task.agreed_deadline + 'T00:00:00Z').toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric', timeZone: 'UTC' }) : null;
        let dealine = task.deadline ? new Date(task.deadline + 'T00:00:00Z').toLocaleDateString('en-GB', { day: '2-digit', month: '2-digit', year: 'numeric', timeZone: 'UTC' }) : null;
        // Agrega el contenido de la fila aquí
        fila.innerHTML = `
            <td class="min-w-175px">
                <div class="d-flex align-items-center">
                    <div class="me-3">
                        <img src="${url}" class="mh-50px" alt="" />
                    </div>
                    <div class="d-flex justify-content-start flex-column">
                        <a href="#" onClick="redirectTo(${task.id_project}, 'project'); return false;" class="text-dark fw-bold text-hover-primary mb-1 fs-6">${task.project_name}</a>

                        <div class="text-dark fw-bold fs-7">
                            <a href="#" onClick="redirectTo(${task.id_client}, 'client'); return false;">
                                ${task.client_name}
                            </a>
                        </div>
                        <span class="fs-7 text-muted fw-bold">${task.product_type}</span>
                        <div class="text-muted fw-semibold d-block fs-7">
                            <span class="badge" style="color:${task.status_client_color}; background-color: ${convertOpacity(task.status_client_color)};">
                                ${translations[task.status_client]}
                            </span>
                        </div>
                    </div>
                </div>
            </td>
            <td>
                <div class="text-dark fw-bold">
                    <a href="#" onClick="redirectTo(${task.id_task}, 'submission'); return false;">${task.practice_name}</a>
                </div>
                <div class="d-flex gap-2 mb-0">
                    ${task.location_name} (${task.guide_name})
                </div>
                <div class="d-flex gap-2 mb-0">
                    ${task.directory_name}
                </div>
            </td>
            <td>
                <div class="mb-2 fw-bold">
                    <div class="text-${setDeadlineStatus(task, task.agreed_deadline)}">
                        ${agreedDeadline}
                    </div>
                </div>
            </td>
            <td>
                <div class="mb-2 fw-bold">
                    <div class="text-${setDeadlineStatus(task, task.deadline)}"  ${task.confirmed == 1 ? 'data-bs-toggle="tooltip" data-bs-html="true" title="Confirmed" style="text-decoration: underline"' : ''}>
                        ${dealine}
                    </div>
                </div>
            </td>
            <td>${task.owner_name ?? ''}</td>
            <td>
                ${task.sc_name ?? ''}
            </td>
            <td>${task.consultant_name ?? ''}</td>
            <td>${task.lds_name ?? ''}</td>
            <td>${task.coord_name ?? ''}</td>
            <td>
                <span id="td-${task.id_task}">
                    <a id="aPopup-${task.id_task}}" href="#" onclick="openPopup(${task.id_task}, '${task.status_c ? task.status_c : ''}'); return false;" data-bs-toggle="tooltip" data-bs-html="true" title="
                        ${task.status_c ? '<b>' + translations[task.status_c] + ': </b>' + task.status_description : " Create status"}
                    ">
                        <span class="badge" style="
                            ${task.html_color ? ' color:' + task.html_color + '; background: ' + convertOpacity(task.html_color) + '; ' : 'color:#70AD47;  background:' + convertOpacity('#70AD47')}
                        ">
                            ${task.status_c ? translations[task.status_c] : 'New'}
                        </span>
                    </a>
                </span>
            </td>
        `;

        cuerpoTabla.appendChild(fila);
    }

    renderTooltip()
}

function renderizarPaginacion() {
    paginacionUl.innerHTML = '';
    const paginasMostradas = 15;
    const paginaInicio = Math.max(1, paginaActual - Math.floor(paginasMostradas / 2));
    const paginaFin = Math.min(totalPaginas, paginaInicio + paginasMostradas - 1);

    // Botón "Atras" con ícono de Font Awesome
    const btnAtras = document.createElement('li');
    btnAtras.classList.add('page-item');
    btnAtras.innerHTML = `
         <a class="page-link" href="#" aria-label="Atras">
             <span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
         </a>
     `;

    btnAtras.addEventListener('click', (e) => {
        e.preventDefault();
        if (paginaActual > 1) {
            paginaActual--;
            mostrarPagina(paginaActual);
        }
    });

    paginacionUl.appendChild(btnAtras);

    for (let pagina = paginaInicio; pagina <= paginaFin; pagina++) {
        const liElement = document.createElement('li');
        liElement.classList.add('page-item');

        const paginaBtn = document.createElement('a');
        paginaBtn.classList.add('page-link');
        paginaBtn.textContent = pagina;

        if (pagina === paginaActual) {
            liElement.classList.add('active');
        }

        // Agrega un evento de clic para cambiar de página al hacer clic en el botón de la página
        paginaBtn.addEventListener('click', () => {
            paginaActual = pagina;
            mostrarPagina(paginaActual);
        });

        liElement.appendChild(paginaBtn);
        paginacionUl.appendChild(liElement);
    }

    // Botón "Siguiente" con ícono de Font Awesome
    const btnSiguiente = document.createElement('li');
    btnSiguiente.classList.add('page-item');
    btnSiguiente.innerHTML = `
        <a class="page-link" href="#" aria-label="Siguiente">
            <span aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
        </a>
    `;

    btnSiguiente.addEventListener('click', (e) => {
        e.preventDefault();
        if (paginaActual < totalPaginas) {
            paginaActual++;
            mostrarPagina(paginaActual);
        }
    });

    paginacionUl.appendChild(btnSiguiente);
}

function mostrarPagina(pagina) {
    renderizarTabla();
    renderizarPaginacion();
}

function convertOpacity(hexa) {
    var color_hex = hexa;
    var opacidad = 0.2;
    // Convertir el código hexadecimal en componentes RGB
    var rojo = parseInt(color_hex.substring(1, 3), 16);
    var verde = parseInt(color_hex.substring(3, 5), 16);
    var azul = parseInt(color_hex.substring(5, 7), 16);
    // Crear el valor RGBA correspondiente
    var color_rgba = "rgba(" + rojo + ", " + verde + ", " + azul + ", " + opacidad + ")";
    return color_rgba;
}

function setDeadlineStatus(item, date_c) {
    var current_date = new Date();
    var deadline = new Date(date_c);
    var text_color = '';
    var time_diff = Math.floor((deadline.getTime() - current_date.getTime()) / (1000 * 60 * 60 * 24));
    var remaining_three_weeks = time_diff >= 21;
    var remaining_two_weeks = time_diff >= 14;
    var remaining_one_week = time_diff >= 7;
    var less_than_a_week = time_diff < 7;

    if (item.status_c == 'done') {
        text_color = 'success';
    }
    else if (remaining_three_weeks) { //faltando 3 semanas
        text_color = 'dark';
    }
    else if (remaining_two_weeks) { //faltando 2 semanas
        text_color = 'warning';
    }
    else if (remaining_one_week) { //faltando 1 semana
        text_color = 'danger';
    }
    else if (less_than_a_week) { //faltando menos de 1 semana
        if (time_diff < 0) {
            if (item.status_c != 'done') {
                text_color = 'danger';
            }
        }
        else {
            text_color = 'danger';
        }
    }

    return text_color;
}

function renderTooltip() {
    $('#items-tasks').each(function () {
        var link = $(this);
        link.find('[data-bs-toggle="tooltip"]').tooltip();
    });
}


