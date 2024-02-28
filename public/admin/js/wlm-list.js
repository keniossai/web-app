"use strict";
var searchUrl = document.getElementById('search-url').getAttribute('data-url');
var filterUrl = document.getElementById('filter-url').getAttribute('data-url');
var updateStatusCUrl = document.getElementById('update-status-c-url').getAttribute('data-url');
var exportTasksWlmUrl = document.getElementById('export-tasks-wlm-url').getAttribute('data-url');
/**
 * This function gets all params from url and initialize all filters below
 */
function initialFilter() {
    function formatValues(string) {
        let stringArray = string.split(",");
        return stringArray.map(Number);
    }

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);

    let urlClient = urlParams.get('ids_client');
    let idsClient = urlClient ? formatValues(urlClient) : [];
    updateFilter(tasksGraph, clients, "ids_client", "id_client", idsClient);

    let urlSc = urlParams.get('ids_senior_consultant');
    let idsSc = urlSc ? formatValues(urlSc) : [];
    updateFilter(tasksGraph, scs, "ids_senior_consultant", "id_senior_consultant", idsSc);

    let urlDirectory = urlParams.get('ids_directory');
    let idsDirectory = urlDirectory ? formatValues(urlDirectory) : [];
    updateFilter(tasksGraph, directories, "ids_directory", "id_directory", idsDirectory);

    let urlCoord = urlParams.get('ids_coordinator');
    let idsCoordinator = urlCoord ? formatValues(urlCoord) : [];
    updateFilter(tasksGraph, coordinators, "ids_coordinator", "id_coordinator", idsCoordinator);

    let urlGuide = urlParams.get('ids_guide');
    let idsGuide = urlGuide ? formatValues(urlGuide) : [];
    updateFilter(tasksGraph, guides, "ids_guide", "id_guide", idsGuide);

    let urlOwner = urlParams.get('ids_owner');
    let idsOwner = urlOwner ? formatValues(urlOwner) : [];
    updateFilter(tasksGraph, owners, "ids_owner", "owner", idsOwner);

    let urlConsultant = urlParams.get('ids_consultant');
    let idsConsultant = urlConsultant ? formatValues(urlConsultant) : [];
    updateFilter(tasksGraph, consultants, "ids_consultant", "id_consultant", idsConsultant);

    let urlstatusConsultant = urlParams.get('ids_consultant_status');
    let idsstatusConsultant = urlstatusConsultant ? formatValues(urlstatusConsultant) : [];
    updateFilter(tasksGraph, statusConsultant, "ids_consultant_status", "id_consultant_status", idsstatusConsultant);

    let urlLds = urlParams.get('ids_lds');
    let idsLds = urlLds ? formatValues(urlLds) : [];
    updateFilter(tasksGraph, lds, "ids_lds", "id_lds", idsLds);

    let urlLocation = urlParams.get('ids_location');
    let idsLocation = urlLocation ? formatValues(urlLocation) : [];
    updateFilter(tasksGraph, locations, "ids_location", "location_id", idsLocation);

    let urlMonth = urlParams.get('months');
    let idsMonth = urlMonth ? urlMonth.split(",") : [];
    updateDeadlineFilter(tasksGraph, months, "months", "deadline", idsMonth);

    let urlMonthAD = urlParams.get('ids_months_ad');
    let idsMonthAD = urlMonthAD ? urlMonthAD.split(",") : [];
    updateDeadlineFilter(tasksGraph, monthsAD, "ids_months_ad", "agreed_deadline", idsMonthAD);
}

function updateFilter(tasks, models, id_updated, id_filter, lds) {
    $('#' + id_updated).empty();
    let ids_filtered = tasks.map(function (item) {//filter tasks by id
        return item[id_filter];
    });

    $.grep(models, function (model) {//we look for if it exists in the array
        return $.inArray(model[id_filter], ids_filtered) > -1;
    }).forEach(function (item) {
        var newOption = new Option(item.name, item[id_filter], false, false);
        $('#' + id_updated).append(newOption);
    });

    if ([lds].length > 0) {
        $('#' + id_updated).val(lds);
    }
}

function updateDeadlineFilter(tasks, models, id_updated, id_filter, lds) {
    $('#' + id_updated).empty();
    let dates = tasks.map(function (item) {
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

function sortBy(column) {
    const params = getOrderBy();
    const currentOrder = params.order;
    const currentColumn = params.sortBy;

    updateUrlParams('sortBy', column);

    let appyOrder = '';
    let icon = '';
    if ((currentOrder && currentOrder == 'ASC') && currentColumn == column) {
        appyOrder = 'DESC';
        icon = '<i class="las la-angle-down"></i>';
    } else {
        appyOrder = 'ASC';
        icon = '<i class="las la-angle-up"></i>';
    }

    updateUrlParams('order', appyOrder);

    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'post',
        data: {
            'ids_client': $('#ids_client').val(),
            'ids_directory': $('#ids_directory').val(),
            'ids_senior_consultant': $('#ids_senior_consultant').val(),
            'ids_coordinator': $('#ids_coordinator').val(),
            'year': $('#year').val(),
            'deadline': $('#deadline').val(),
            'ids_guide': $('#ids_guide').val(),
            'ids_consultant': $('#ids_consultant').val(),
            'months': $('#months').val(),
            'ids_status': $('#ids_status').val(),
            'ids_consultant_status': $('#ids_consultant_status').val(),
            'ids_owner': $('#ids_owner').val(),
            'ids_lds': $('#ids_lds').val(),
            'ids_location': $('#ids_location').val(),
            'ids_months_ad': $('#ids_months_ad').val(),
            'sortBy': column,
            'order': appyOrder,
        },
        url: filterUrl,
        success: function (response) {
            $('#items-tasks').html(response.view);
            $('#pagination').html(response.pagination);
            $('#items-tasks').each(function () {
                var link = $(this);
                link.find('[data-bs-toggle="tooltip"]').tooltip();
            });
            clear = false;
        },
        error: function (xhr) {
            if (xhr.status === 419) {
                window.location.reload();
            }
        },
    }).then(function () {
        var sortSpans = document.querySelectorAll("#tasks-header span[id^='sort-']");
        for (var i = 0; i < sortSpans.length; i++) {
            sortSpans[i].innerHTML = "";
        }
        $('#sort-' + column).html(icon);
    });
}

function searchTasks() {
    loadingOverlay.style.display = 'flex';
    const params = getOrderBy();
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'post',
        data: {
            'ids_client': $('#ids_client').val(),
            'ids_directory': $('#ids_directory').val(),
            'ids_senior_consultant': $('#ids_senior_consultant').val(),
            'ids_coordinator': $('#ids_coordinator').val(),
            'year': $('#year').val(),
            'deadline': $('#deadline').val(),
            'ids_guide': $('#ids_guide').val(),
            'ids_consultant': $('#ids_consultant').val(),
            'ids_consultant_status': $('#ids_consultant_status').val(),
            'months': $('#months').val(),
            'ids_status': $('#ids_status').val(),
            'ids_owner': $('#ids_owner').val(),
            'ids_lds': $('#ids_lds').val(),
            'ids_location': $('#ids_location').val(),
            'ids_months_ad': $('#ids_months_ad').val(),
            'sortBy': params.sortBy,
            'order': params.order
        },
        url: searchUrl,
        success: function (response) {
            $('#items-tasks').html(response.view);
            $('#pagination').html(response.pagination);
            $('#items-tasks').each(function () {
                var link = $(this);
                link.find('[data-bs-toggle="tooltip"]').tooltip();
            });
            var spanElement = document.getElementById("total-tasks");
            spanElement.textContent = response.totalTasks;

            tasksGraph.length = 0;
            tasksGraph.push.apply(tasksGraph, response.tasksGraph);
            clear = false;
        },
        error: function (xhr) {
            if (xhr.status === 419) {
                window.location.reload();
            }
        },

    }).then(function () {
        filterGraph();
        loadingOverlay.style.display = 'none';
        updateAllFilter(tasksGraph);
    });
}

function updateAllFilter(tasks) {
    if ($("#ids_client").val().length <= 0) {
        updateFilter(tasks, clients, "ids_client", "id_client");
    }

    if ($("#ids_directory").val().length <= 0) {
        updateFilter(tasks, directories, "ids_directory", "id_directory");
    }

    if ($("#ids_senior_consultant").val().length <= 0) {
        updateFilter(tasks, scs, "ids_senior_consultant", "id_senior_consultant");
    }

    if ($("#ids_coordinator").val().length <= 0) {
        updateFilter(tasks, coordinators, "ids_coordinator", "id_coordinator");
    }

    if ($("#ids_guide").val().length <= 0) {
        updateFilter(tasks, guides, "ids_guide", "id_guide");
    }

    if ($("#ids_consultant").val().length <= 0) {
        updateFilter(tasks, consultants, "ids_consultant", "id_consultant");
    }

    if ($("#ids_consultant_status").val().length <= 0) {
        updateFilter(tasks, statusConsultant, "ids_consultant_status", "id_consultant_status");
    }

    if ($("#ids_owner").val().length <= 0) {
        updateFilter(tasks, owners, "ids_owner", "owner");
    }

    if ($("#ids_lds").val().length <= 0) {
        updateFilter(tasks, lds, "ids_lds", "id_lds");
    }

    if ($("#ids_location").val().length <= 0) {
        updateFilter(tasks, locations, "ids_location", "id_location");
    }

    if ($("#months").val().length <= 0) {
        updateDeadlineFilter(tasks, months, "months", "deadline");
    }

    if ($("#ids_months_ad").val().length <= 0) {
        updateDeadlineFilter(tasks, monthsAD, "ids_months_ad", "agreed_deadline");
    }
}

function fetchData(page = 1) {
    const currentUrl = window.location.href;
    let filters = currentUrl.split('?')[1];

    $.get('/wlm?page=' + page + '&' + filters, function (data) {
        $('#items-tasks').html(data.view);
        $('#pagination').html(data.pagination);

        $('#items-tasks').each(function () {
            var link = $(this); // get the link element inside each items-tasks element
            link.find('[data-bs-toggle="tooltip"]').tooltip(); // enable the tooltip plugin for the corresponding a element
        });

    });
}

function updateUrlParams(filter, values) {
    const url = new URL(window.location.href);
    url.searchParams.set([filter], values);
    window.history.replaceState(null, null, url.href);
}

function initializeGraph() {
    var ctx = document.getElementById('kt_chartjs_2');
    var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif');
    const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    const data = {
        labels: labels,
        datasets: datasets
    };
    const config = {
        type: 'line',
        data: data,
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Count of Practice by Month and Senior Consultant'
                },
                legend: {
                    onClick: function (evt, legendItem, legend) {
                        const index = legendItem.datasetIndex;
                        const ci = legend.chart;
                        var names = [];
                        Chart.defaults.plugins.legend.onClick.call(this, evt, legendItem, this);
                        legend.chart.data.datasets.forEach((d, i) => {
                            if (ci.isDatasetVisible(i)) {
                                names.push(d.label);
                            }
                        })
                        filterGridFromGraphBySC(names);
                    },
                },

            },
            scales: {
                y: {
                    title: {
                        display: true,
                        text: 'Count of Practice'
                    }
                }
            },
            responsive: true,
            onClick: (evt, activeElements, chart) => {
                chart.config.data.datasets.map(dataset => {
                    dataset.backgroundColor = dataset.backgroundColor.substr(0, 7);
                    dataset.borderColor = dataset.borderColor.substr(0, 7);
                });
                chart.update();
                var names = [];
                if (activeElements[0]) {
                    let dataIndex = activeElements[0].index;
                    let datasetIndex = activeElements[0].datasetIndex;
                    let userName = evt.chart.data.datasets[datasetIndex].label;
                    let month = evt.chart.data.labels[dataIndex];
                    names.push(userName);
                    chart.config.data.datasets.map(dataset => {
                        if (dataset.label != userName) {
                            dataset.backgroundColor = (dataset.backgroundColor + '40');
                            dataset.borderColor = (dataset.borderColor + '40');
                        }
                    });
                    chart.update();
                    filterGridFromGraph(names, month);
                } else {
                    const ci = evt.chart;
                    evt.chart.data.datasets.forEach((d, i) => {
                        if (ci.isDatasetVisible(i)) {
                            names.push(d.label);
                        }
                    });

                    filterGridFromGraph(names, '');
                }
            }
        },
        defaults: {
            global: {
                defaultFont: fontFamily
            }
        }
    };

    myChart = new Chart(ctx, config);
    filterGraph();
}

function filterGridFromGraphBySC(names) {
    clear = true;
    loadingOverlay.style.display = 'flex';
    var ids_sc = scUsers.filter(function (sc) {
        if ($.inArray(sc.name, names) > -1) {
            return sc;
        }
    }).map(sc => sc.id_senior_consultant);

    const isUnassignedPresent = names.find(item => item === "Unassigned") !== undefined;
    if (isUnassignedPresent) {
        ids_sc.push(-1);
    }

    $('#ids_senior_consultant').val(ids_sc).trigger('change');
    const params = getOrderBy();
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'post',
        data: {
            'ids_client': $('#ids_client').val(),
            'ids_directory': $('#ids_directory').val(),
            'ids_senior_consultant': ids_sc,
            'ids_coordinator': $('#ids_coordinator').val(),
            'year': $('#year').val(),
            'ids_guide': $('#ids_guide').val(),
            'ids_consultant': $('#ids_consultant').val(),
            'ids_consultant_status': $('#ids_consultant_status').val(),
            'months': $('#months').val(),
            'ids_status': $('#ids_status').val(),
            'ids_owner': $('#ids_owner').val(),
            'ids_lds': $('#ids_lds').val(),
            'ids_location': $('#ids_location').val(),
            'ids_months_ad': $('#ids_months_ad').val(),
            'sortBy': params.sortBy,
            'order': params.order
        },
        url: searchUrl,
        success: function (response) {
            $('#items-tasks').html(response.view);
            $('#pagination').html(response.pagination);
            $('#items-tasks').each(function () {
                var link = $(this);
                link.find('[data-bs-toggle="tooltip"]').tooltip();
            });
            var spanElement = document.getElementById("total-tasks");
            spanElement.textContent = response.totalTasks;
        },
        error: function (xhr) {
            if (xhr.status === 419) {
                window.location.reload();
            }
        },
    }).then(function (response) {
        clear = false;
        loadingOverlay.style.display = 'none';
        updateAllFilter(response.tasksGraph);
    });
}

function filterGridFromGraph(names, monthName) {
    clear = true;
    loadingOverlay.style.display = 'flex';
    var ids_sc = scUsers.filter(function (sc) {
        if ($.inArray(sc.name, names) > -1) {
            return sc;
        }
    }).map(sc => sc.id_senior_consultant);

    $('#ids_senior_consultant').val(ids_sc).trigger('change');

    var months = [];
    var currentMonths = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
    if (monthName) {
        months = [moment().month(monthName).format("M").padStart(2, '0')];
        $('#months').val(months).trigger('change');
    } else {
        $('#months').val(currentMonths).trigger('change');
    }
    const params = getOrderBy();
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'post',
        data: {
            'ids_client': $('#ids_client').val(),
            'ids_directory': $('#ids_directory').val(),
            'ids_senior_consultant': ids_sc,
            'ids_coordinator': $('#ids_coordinator').val(),
            'year': $('#year').val(),
            'ids_guide': $('#ids_guide').val(),
            'ids_consultant': $('#ids_consultant').val(),
            'ids_consultant_status': $('#ids_consultant_status').val(),
            'months': months,
            'ids_status': $('#ids_status').val(),
            'ids_owner': $('#ids_owner').val(),
            'ids_lds': $('#ids_lds').val(),
            'ids_location': $('#ids_location').val(),
            'ids_months_ad': $('#ids_months_ad').val(),
            'sortBy': params.sortBy,
            'order': params.order
        },
        url: searchUrl,
        success: function (response) {
            $('#items-tasks').html(response.view);
            $('#pagination').html(response.pagination);
            $('#items-tasks').each(function () {
                var link = $(this);
                link.find('[data-bs-toggle="tooltip"]').tooltip();
            });
            var spanElement = document.getElementById("total-tasks");
            spanElement.textContent = response.totalTasks;
        },
        error: function (xhr) {
            if (xhr.status === 419) {
                window.location.reload();
            }
        },
    }).then(function (response) {
        clear = false;
        loadingOverlay.style.display = 'none';
        updateAllFilter(response.tasksGraph);
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

function openPopup(id, status) {
    var description = document.getElementById("description");
    var message = document.getElementById("message");
    description.classList.remove("error");
    message.style.display = "none";

    var currentSpan = document.getElementById("current-status");
    while (currentSpan.firstChild) {
        currentSpan.removeChild(currentSpan.firstChild);
    }

    var parentElement = document.getElementById("current-status");
    var newSpan = document.createElement("span");
    if (status) {
        let name = window.translations[status];
        newSpan.innerHTML = name;
    } else {
        newSpan.innerHTML = 'New';
    }
    parentElement.appendChild(newSpan);
    let nextStatus = getNextStatus(status);

    if (nextStatus) {
        $("#id_status").val(nextStatus.id_status).trigger('change');
    } else {
        let id_status = statusConsultant.find(statusC => statusC.name === status).id_status;
        $("#id_status").val(id_status).trigger('change');
    }
    $('#id_task').val(id);
    $('#description').val('');
    $('#kt_modal_stacked_1').modal('show').on('shown.bs.modal', function () {
        $('#description').focus();
    });

    //estop editing on all edit boxes
    editFn.reset();

}

function closePopup(button) {
    var popup = $(button).closest(".popup");
    popup.hide();
}

/**
 * This function updates all status changes on the app, either by clicking on the status or changin
 * description
 */
function updateStatusC() {
    //var description = document.getElementById("description");
    var message = document.getElementById("message");
    var id_task = $('#id_task').val();
    var id_status = $('#id_status').val();
    var description = $('#description').val();


    var idBtn = document.querySelector("#status_id");
    idBtn.setAttribute("data-kt-indicator", "on");
    idBtn.disabled = true;
    //Save to server
    $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        method: 'post',
        data: {
            'id_task': id_task,
            'id_status': id_status,
            'description': description
        },
        url: updateStatusCUrl,
        success: function (response) {
            let id = 'td-' + id_task;
            var link = $('#' + id);
            //server return a new HTML a replaces the whole buton and popup window
            link.html($.parseHTML(response.html));
            link.find('[data-bs-toggle="tooltip"]').tooltip();
            idBtn.removeAttribute("data-kt-indicator");
            idBtn.disabled = false;
            //We update the description box of the sub
            $("#row-description-" + id_task).attr('task-status', response.data.status_c);
            $("#row-description-" + id_task).attr('task-description', response.data.status_description);
            $("#row-description-" + id_task + ' .ctext').text(response.data.status_description);

            // This update input checkbox
            if (response.data.status_c === 'referees_filed') {
                $(`#row-checkbox-${id_task}`).prop('checked', true);
            } else {
                $(`#row-checkbox-${id_task}`).prop('checked', false);
            }
            toastr.success('Status updated successfully');
        },
        error: function (xhr) {
            if (xhr.status === 419) {
                window.location.reload();
            }
            toastr.error('There was an error updating the status, try again.');
        },
    }).then(function () {
        $('#kt_modal_stacked_1').modal('hide');
    });
    // } else {
    //     description.classList.add("error");
    //     message.style.display = "block";
    // }
}

function getNextStatus(currentName) {
    let currentStatus = statusConsultant.find(status => status.name === currentName);
    let currentIndex = statusConsultant.indexOf(currentStatus);
    let nextStatus = statusConsultant[currentIndex + 1];
    return nextStatus;
}

function filterGraph() {
    var groupArrayObject = tasksGraph.reduce((group, arr) => {
        const { sc_name } = arr;
        group[sc_name] = group[sc_name] ?? [];
        group[sc_name].push(arr);
        return group;
    }, {});

    datasets.length = 0;
    // filtered
    let taskFiltered = Object.entries(groupArrayObject);
    taskFiltered.forEach(group => {
        group[0] = group[0];
    });

    taskFiltered.forEach(function (a, i) {
        let usersFiltered = scUsers.filter(function (user) {
            return user.name == a[0];
        });

        var months = [{ month: '01' }, { month: '02' }, { month: '03' }, { month: '04' }, { month: '05' }, { month: '06' }, { month: '07' }, { month: '08' }, { month: '09' }, { month: '10' }, { month: '11' }, { month: '12' }];
        var data = [];

        months.forEach(element => {
            let filteredTasks = a[1].filter(function (task) {
                if (task.deadline) {
                    let date = moment(task.deadline).format("MM");
                    return date.indexOf(element.month) > -1;
                }
            })
            data.push(filteredTasks.length);
        });

        var randomColor = colorsHex[i + 1];
        let name = '';
        if (usersFiltered.length > 0) {
            name = usersFiltered[0].name;
        } else {
            name = 'Unassigned';
        }

        datasets.push({
            label: name,
            data: data,
            borderColor: randomColor,
            backgroundColor: randomColor,
        });
    });

    datasets.sort(function (a, b) {
        var nameA = a.label.toUpperCase();
        var nameB = b.label.toUpperCase();
        if (nameA < nameB) {
            return -1;
        }
        if (nameA > nameB) {
            return 1;
        }

        return 0;
    });

    myChart.update();
}

function exportToExcel() {
    var idBtn = document.querySelector("#export-task");
    idBtn.setAttribute("data-kt-indicator", "on");
    const searchParams = new URLSearchParams(window.location.search);
    $.ajax({
        url: exportTasksWlmUrl,
        type: 'GET',
        data: {
            ids_client: searchParams.get('ids_client'),
            ids_directory: searchParams.get('ids_directory'),
            ids_guide: searchParams.get('ids_guide'),
            ids_senior_consultant: searchParams.get('ids_senior_consultant'),
            ids_status: searchParams.get('ids_status'),
            year: searchParams.get('year'),
            deadline: searchParams.get('deadline'),
            ids_coordinator: searchParams.get('ids_coordinator'),
            ids_consultant: searchParams.get('ids_consultant'),
            months: searchParams.get('months'),
            ids_owner: searchParams.get('ids_owner'),
            ids_lds: searchParams.get('ids_lds'),
            ids_months_ad: searchParams.get('ids_months_ad'),
            'sortBy': searchParams.get('sortBy'),
            'order': searchParams.get('order')
        },
        xhrFields: {
            responseType: 'blob'
        },
        success: function (data) {
            var a = document.createElement('a');
            var url = window.URL.createObjectURL(data);
            a.href = url;
            a.download = 'Submissions.xlsx';
            document.body.append(a);
            a.click();
            a.remove();
            window.URL.revokeObjectURL(url);
            idBtn.removeAttribute("data-kt-indicator");
        },
        error: function (xhr) {
            if (xhr.status === 419) {
                window.location.reload();
            }
        },
    });
}

function getColors() {
    colorsHex = [
        '',
        '#F50404',
        '#F5D404',
        '#5FF504',
        '#04A8F5',
        '#9204F5',
        '#FF5722',
        '#F5049D',
        '#7B1FA2',
        '#827717',
        '#04F592',
        '#04F5E6',
        '#78909C',
        '#FFB6C1',
        '#5D4037',
        '#00695C',
        '#9E9D24',
        '#FFA500',
        '#9400D3',
        '#880E4F',
        '#008000',
        '#311B92',
        '#87CEFA',
        '#01579B',
        '#740202',
        '#967A26',
        '#FF6F00',
        '#BF360C',
        '#3E2723',
        '#FFFF00',
        '#CC33FF',
        '#82877E',
        '#6633FF',
        '#CCFF33',
        '#FF33FF',
        '#999900',
        '#40FF00',
        '#FF0040',
        '#045FB4',
        '#B40404',
        '#886A08',
        '#F7FE2E',
        '#FF8000',
        '#610B0B',
        '#0B243B',
        '#220A29',
        '#2E2E2E',
        '#8904B1',
        '#0404B4',
        '#DF013A',
        '#2EFEF7',
        '#5882FA',
        '#000000',
    ];
}


/**
 * @NEW - This code adds the select functionality to Jquery on this page only it is a plugin
 * ALl this functionality is used to enable the editable descriptions on all subs.
 * */
$.fn.selectText = function () {
    var doc = document;
    var element = this[0];
    if (doc.body.createTextRange) {
        var range = document.body.createTextRange();
        range.moveToElementText(element);
        range.select();
    } else if (window.getSelection) {
        var selection = window.getSelection();
        var range = document.createRange();
        range.selectNodeContents(element);
        selection.removeAllRanges();
        selection.addRange(range);
    }
};

/**
 * This function controls all inline editing of the description column
 */
var editFn = (function () {
    return {
        init: function () {
            $('.cedit').click(this._edit);
            $('.csave').click(this._save);
            $('.ccancel').click(this._cancel);
        },
        /**Reset all edit boxes */
        reset: function () {
            $('.ccancel').click();
        },
        _edit: function () {
            $('.ccancel').click();
            var parent = $(this).parent();
            //validate first current status if NEW, then show status popup
            if (parent.attr('task-status') == 'NEW') {
                openPopup(parent.attr('task-id'), (parent.attr('task-status') == "NEW" ? '' : parent.attr('task-status')));
            } else {
                //Otherwise, enable edit functionality
                $(this).hide();
                parent.find('.cbox').addClass('editable');
                parent.find('.ctext').attr('contenteditable', 'true').selectText();
                parent.find('.csave').show();
                parent.find('.ccancel').show();
            }
        },
        _save: function () {
            var parent = $(this).parent();
            $(this).hide();
            parent.find('.ccancel').hide();
            parent.find('.cbox').removeClass('editable');
            parent.find('.ctext').removeAttr('contenteditable');
            parent.find('.cedit').show();
            /** To get the current id of the status, we have to use this array statusConsultant which include all statuses
             * used fr the filers on the top
             */

            var id_status = statusConsultant.find(statusC => statusC.name === parent.attr('task-status')).id_status
            var id_task = parent.attr('task-id');

            $.ajax({
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {
                    'id_task': id_task,
                    'id_status': id_status,
                    'description': parent.find('.ctext').text()
                },
                url: updateStatusCUrl,
                success: function (response) {
                    parent.find('.cbox').removeClass('editable');
                    parent.find('.ctext').removeAttr('contenteditable');
                    parent.find('.cedit').show();
                    parent.find('.csave').hide();
                    parent.find('.cancel').hide();
                    $("#row-description-" + id_task).attr('task-status', response.data.status_c);
                    $("#row-description-" + id_task).attr('task-description', response.data.status_description);
                    toastr.success('Status updated successfully');
                },
                error: function (xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                    toastr.error('There was an error updating the status, try again.');
                },
            }).then(function () {

            });

        },
        //when false recieved, it will not restore the old description. works when changin desc only.
        _cancel: function () {
            var parent = $(this).parent();
            $(this).hide();
            parent.find('.cbox').removeClass('editable');
            parent.find('.ctext').removeAttr('contenteditable');
            parent.find('.cedit').show();
            parent.find('.csave').hide();
            parent.find('.ctext').text(parent.attr('task-description'));


        }
    }
})();
editFn.init();
