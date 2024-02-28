"use strict";
var updateStatusKUrl = document.getElementById('update-status-kanban-url').getAttribute('data-url');
function updateKanbanTasks(dataTasks, taskscount) {
    var element = '#kt_docs_jkanban_fixed_height';
    var kanbanEl = document.querySelector(element);

    // Get kanban height value
    const kanbanHeight = kanbanEl.getAttribute('data-jkanban-height');

    var requiredFields = ["id_status", "name", "html_color", 'tilte'];
    var newStatusesC = statusesC.map(function (item) {
        var newItem = {};
        requiredFields.forEach(function (campo) {
            newItem[campo] = item[campo];
        });
        return newItem;
    });

    newStatusesC.forEach(element => {
        element.tasks = dataTasks.filter(function (item) {
            return item.status_c == element.name;
        }).map(function (element) {
            return {
                'title': `
                    <div class="card mb-3">
                        <input id="id_task" value="${element.id_task}" hidden>
                        <div class="d-flex flex-stack mb-2">
                            <a class="fs-8 fw-bold text-gray-900" style="text-align:center">
                                ${element.client_name}
                            </a>
                        </div>
                        <div class="d-flex flex-wrapr" style="justify-content: space-between;">
                            <div class="d-flex">
                                ${element.agreed_deadline ? `<span class="fs-8 fw-bold text-${setDeadlineStatus(element, element.agreed_deadline)}" ${element.confirmed == 1 ? 'data-bs-toggle="tooltip" data-bs-html="true" title="Confirmed" style="text-decoration: underline"' : ''}>${formatDate(element.agreed_deadline)}</span>` : ''}
                            </div>
                            <div class="d-flex">
                                ${element.deadline ? `<span class="fs-8 fw-bold text-${setDeadlineStatus(element, element.deadline)}" ${element.confirmed == 1 ? 'data-bs-toggle="tooltip" data-bs-html="true" title="Confirmed" style="text-decoration: underline"' : ''}>${formatDate(element.deadline)}</span>` : ''}
                            </div>
                            <div class="d-flex" style="text-align:end">
                                <span class="ms-1 fs-8 fw-bold">${element.location_name}</span>
                            </div>
                        </div>
                        <div class="d-flex flex-wrapr" style="justify-content: space-between;">
                            <div class="d-flex">
                                <span class="fs-8 fw-bold text-gray-600">${element.directory_name}</span>
                            </div>
                            <div class="d-flex">
                                <span class="ms-1 fs-8 fw-bold text-gray-600">${element.guide_name}</span>
                            </div>
                            <div class="d-flex">
                                <span class="fs-8 fw-bold text-gray-600"> ${element.year}</span>
                            </div>
                        </div>
                        <div class="fs-8 fw-bold mb-2">
                            <a href="#" onClick="redirectToSubmission(${element.id_task})">
                                ${element.practice_name}
                            </a>
                        </div>
                        <div class="d-flex flex-stack flex-wrapr">
                            <div class="symbol-group symbol-hover my-1">
                                <div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Owner: ${element.owner_name}">
                                    <span class="symbol-label bg-primary text-inverse-primary fw-bold fs-8">${getInitialsName(element.owner_name)}</span>
                                </div>
                                <div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Senior Consultant: ${element.sc_name}">
                                    <span class="symbol-label bg-warning text-inverse-warning fw-bold fs-8">${getInitialsName(element.sc_name)}</span>
                                </div>
                                <div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Consultant: ${element.consultant_name}">
                                    <span class="symbol-label bg-info text-inverse-info fw-bold fs-8">${getInitialsName(element.consultant_name)}</span>
                                </div>
                                <div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="LDS: ${element.lds_name}">
                                    <span class="symbol-label bg-success text-inverse-success fw-bold fs-8">${getInitialsName(element.lds_name)}</span>
                                </div>
                                <div class="symbol symbol-25px symbol-circle" data-bs-toggle="tooltip" title="Coordinator: ${element.coord_name}">
                                    <span class="symbol-label bg-danger text-inverse-danger fw-bold fs-8">${getInitialsName(element.coord_name)}</span>
                                </div>
                            </div>
                            <div class="d-flex my-1">
                                <span class="fs-8 badge badge-light-success me-auto">${element.product_type}</span>
                            </div>
                        </div>
                    </div>
                `
            };
        });
    });

    boards = newStatusesC.map(function (element) {
        return {
            'id': element.id_status == 'new' ? element.id_status : element.id_status.toString(),
            'title': element.tilte + ` <span class="fs-6"> (${taskscount.hasOwnProperty(element.name) ? taskscount[element.name] : 0})</span>`,
            'class': element.id_status == 'new' ? 'new-gray' : element.name,
            'item': element.tasks
        };
    });

    boards.map(function (item) {
        kanban.removeBoard(item.id);
    });

    kanban.addBoards(boards);
    const allNewBoards = kanbanEl.querySelectorAll('.kanban-drag');
    allNewBoards.forEach(board => {
        board.style.height = kanbanHeight + 'px';
        board.style.padding = 10 + 'px';
    });

    $('[data-bs-toggle="tooltip"]').tooltip();
}

function fetchData(page = 1) {
    const currentUrl = window.location.href;
    let filters = currentUrl.split('?')[1];
    $.get('/wlm-kanban?page=' + page + '&' + filters, function (data) {
        let result = data.tasks.data;
        updateKanbanTasks(result, data.countByStatus);
        $('#pagination_top, #pagination_footer').html(data.pagination);
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
}

function getOrderBy() {
    let $obj = {}; // Declare $obj as an empty object
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    $obj['sortBy'] = urlParams.get('sortBy');
    $obj['order'] = urlParams.get('order');
    return $obj;
}

function updateStatusTask(submissionId, statusId, el, sibling, source) {
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                .attr('content')
        },
        method: 'post',
        data: {
            'id_task': submissionId,
            'id_status': statusId,
        },
        url: updateStatusKUrl,
        success: function (response) {
            let type = response.status == true ? 'success' : 'error';
            let msg = response.message;
            if (!response.status) {
                msg = 'Check if the user has permission';
                source.insertBefore(el, sibling);
            }
            toastrAlert(type, msg);
        },
        error: function (xhr) {
            if (xhr.status === 419) {
                window.location.reload();
            }
        }
    }).then(function () { });
}

function toastrAlert(type, msg) {
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toastr-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    };
    //type: success error warning
    toastr[type](msg);
}

function createStyles(data) {
    const styleElement = document.createElement('style');
    document.head.appendChild(styleElement);

    data.forEach((status) => {
        const className = status.name; // Usamos el valor 'name' como clase
        const backgroundColor = status.html_color; // Usamos el valor 'html_color' como fondo
        styleElement.innerHTML += `.${className} {
            background: ${backgroundColor};
        }`;
    });
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

function getInitialsName(fullName) {
    if (!fullName)
        return '';

    var words = fullName.split(' ');
    var initials = words.map(function (word) {
        return word.charAt(0); // Obtener la primera letra de cada palabra
    }).join('');
    return initials;
}

function formatDate(date) {
    if (!date)
        return '';

    // Dividir la fecha en partes
    var partesFecha = date.split('-');
    // Obtener las partes de la fecha
    var año = partesFecha[0];
    var mes = partesFecha[1];
    var dia = partesFecha[2];
    // Crear la nueva fecha en formato "dd/mm/aaaa"
    var fechaConvertida = dia + '/' + mes + '/' + año;
    return fechaConvertida;
}

function initialFilter() {
    console.log("working");
    function formatValues(string) {
        let stringArray = string.split(",");
        return stringArray.map(Number);
    }

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    let urlClient = urlParams.get('ids_client');
    let idsClient = urlClient ? formatValues(urlClient) : [];
    updateFilter(tasksFilter, clients, "ids_client", "id_client", idsClient);

    let urlSc = urlParams.get('ids_senior_consultant');
    let idsSc = urlSc ? formatValues(urlSc) : [];
    updateFilter(tasksFilter, scs, "ids_senior_consultant", "id_senior_consultant", idsSc);

    let urlDirectory = urlParams.get('ids_directory');
    let idsDirectory = urlDirectory ? formatValues(urlDirectory) : [];
    updateFilter(tasksFilter, directories, "ids_directory", "id_directory", idsDirectory);

    let urlCoord = urlParams.get('ids_coordinator');
    let idsCoordinator = urlCoord ? formatValues(urlCoord) : [];
    updateFilter(tasksFilter, coordinators, "ids_coordinator", "id_coordinator", idsCoordinator);

    let urlGuide = urlParams.get('ids_guide');
    let idsGuide = urlGuide ? formatValues(urlGuide) : [];
    updateFilter(tasksFilter, guides, "ids_guide", "id_guide", idsGuide);

    let urlOwner = urlParams.get('ids_owner');
    let idsOwner = urlOwner ? formatValues(urlOwner) : [];
    updateFilter(tasksFilter, owners, "ids_owner", "owner", idsOwner);

    let urlLocation = urlParams.get('ids_location');
    let idsLocation = urlLocation ? formatValues(urlLocation) : [];
    updateFilter(tasksFilter, locations, "ids_location", "location_id", idsLocation);
    console.log(idsLocation, locations);

    let urlConsultant = urlParams.get('ids_consultant');
    let idsConsultant = urlConsultant ? formatValues(urlConsultant) : [];
    updateFilter(tasksFilter, consultants, "ids_consultant", "id_consultant", idsConsultant);

    let urlLds = urlParams.get('ids_lds');
    let idsLds = urlLds ? formatValues(urlLds) : [];
    updateFilter(tasksFilter, lds, "ids_lds", "id_lds", idsLds);

    let urlMonth = urlParams.get('months');
    let idsMonth = urlMonth ? urlMonth.split(",") : [];
    updateDeadlineFilter(tasksFilter, months, "months", "deadline", idsMonth);

    let urlMonthAD = urlParams.get('ids_months_ad');
    let idsMonthAD = urlMonthAD ? urlMonthAD.split(",") : [];
    updateDeadlineFilter(tasksFilter, monthsAD, "ids_months_ad", "agreed_deadline", idsMonthAD);
}

function updateFilter(tasksFilter, models, id_updated, id_filter, lds) {
    $('#' + id_updated).empty();
    let ids_filtered = tasksFilter.map(function (item) {//filtrar las task por el id
        return item[id_filter];
    });

    $.grep(models, function (model) {//buscamos si existe en el array
        return $.inArray(model[id_filter], ids_filtered) > -1;
    }).forEach(function (item) {
        var newOption = new Option(item.name, item[id_filter], false, false);
        $('#' + id_updated).append(newOption);
    });

    if ([lds].length > 0) {
        $('#' + id_updated).val(lds);
    }
}

function updateDeadlineFilter(tasksFilter, models, id_updated, id_filter, lds) {
    $('#' + id_updated).empty();
    let dates = tasksFilter.map(function (item) {
        return item[id_filter];
    });
    let ids_filtered = dates.map(function (date) {
        return moment(date).format('MM');
    });

    $.grep(models, function (model) {//buscamos si existe en el array
        return $.inArray(model[id_filter], ids_filtered) > -1;
    }).forEach(function (item) {
        var newOption = new Option(item.name, item[id_filter], false, false);
        $('#' + id_updated).append(newOption);
    });

    if ([lds].length > 0) {
        $('#' + id_updated).val(lds);
    }
}

function updateUrlParams(filter, values) {
    const url = new URL(window.location.href);
    url.searchParams.set([filter], values);
    window.history.replaceState(null, null, url.href);
}

function updateAllFilter(data) {
    if ($("#ids_client").val().length <= 0) {
        updateFilter(data, clients, "ids_client", "id_client");
    }

    if ($("#ids_directory").val().length <= 0) {
        updateFilter(data, directories, "ids_directory", "id_directory");
    }

    if ($("#ids_senior_consultant").val().length <= 0) {
        updateFilter(data, scs, "ids_senior_consultant", "id_senior_consultant");
    }

    if ($("#ids_coordinator").val().length <= 0) {
        updateFilter(data, coordinators, "ids_coordinator", "id_coordinator");
    }

    if ($("#ids_location").val().length <= 0) {
        updateFilter(data, locations, "ids_location", "id_location");
    }

    if ($("#ids_guide").val().length <= 0) {
        updateFilter(data, guides, "ids_guide", "id_guide");
    }

    if ($("#ids_consultant").val().length <= 0) {
        updateFilter(data, consultants, "ids_consultant", "id_consultant");
    }

    if ($("#ids_owner").val().length <= 0) {
        updateFilter(data, owners, "ids_owner", "owner");
    }

    if ($("#ids_lds").val().length <= 0) {
        updateFilter(data, lds, "ids_lds", "id_lds");
    }

    if ($("#months").val().length <= 0) {
        updateDeadlineFilter(data, months, "months", "deadline");
    }

    if ($("#ids_months_ad").val().length <= 0) {
        updateDeadlineFilter(data, monthsAD, "ids_months_ad", "agreed_deadline");
    }
}
