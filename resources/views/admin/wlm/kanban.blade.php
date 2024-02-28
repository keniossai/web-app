@extends('layouts.master')

@section('master-title', '')
@push('styles')
    <link href="{{ URL::asset('assets/plugins/custom/jkanban/jkanban.bundle.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('admin/css/wlm-kanban.css') }}" rel="stylesheet" type="text/css" />
@endpush

@section('master-content')
    <div id="loading-overlay">
        <span>Updating...</span>
        <div></div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title fs-3 fw-bold">
                Kanban
            </div>
            <div class="card-title d-flex justify-content-end">
            </div>
        </div>
        <div class="card-body py-4">
            <div class="py-2 pt-5">
                <div class="rounded border p-5">
                    <!--begin::Form-->
                    <form class="form">
                        @csrf

                        <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-4">
                            @php
                                $statusesArray = App\Models\Status::orderBy('order')->where(['element_type' => 'task', 'status_type' => 'consultant', 'deleted' => 0])->get();
                                $statusesArray->map(function($item){
                                    $item->tilte = __('babel.'.$item->name);
                                })
                            @endphp
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_client" name="ids_client[]" data-placeholder="Client" data-allow-clear="true">
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_directory" name="ids_directory[]" data-placeholder="Cirectory" data-allow-clear="true">
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_senior_consultant" name="ids_senior_consultant[]" data-placeholder="Senior consultant" data-allow-clear="true">
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_coordinator" name="ids_coordinator[]" data-placeholder="Coordinator" data-allow-clear="true">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-4">
                            @php
                                $months = [];
                                if(old('months', [])){
                                    $months = array_map('intval', explode(',', old('months', [])));
                                }
                            @endphp
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" data-control="select2" id="deadline" name="deadline" data-placeholder="Deadline year" data-allow-clear="true">
                                        <option></option>
                                        @foreach (App\Repositories\WlmRepositories::getDeadlineYearsOfProjects() as $deadline)
                                            <option value="{{ $deadline }}" @if($deadline == (!old('deadline', []) ?  Carbon\Carbon::now()->format('Y') : old('deadline', []))) selected @endif>{{ $deadline }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_guide" name="ids_guide[]" data-placeholder="Guide" data-allow-clear="true">
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_consultant" name="ids_consultant[]" data-placeholder="Consultant" data-allow-clear="true">
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="months" name="months[]" data-placeholder="Deadline month" data-allow-clear="true">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-4">
                        <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" data-control="select2" id="year" name="year" data-placeholder="Guide year" data-allow-clear="true">   
                                        <option></option>
                                        @foreach (App\Repositories\WlmRepositories::getYearsOfProjects() as $year)
                                        <option value="{{ $year }}" >{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_location" name="ids_location[]" data-placeholder="Location" data-allow-clear="true">
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_owner" name="ids_owner[]" data-placeholder="Owner" data-allow-clear="true">
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_lds" name="ids_lds[]" data-placeholder="LDS" data-allow-clear="true">
                                    </select>
                                </div>
                            </div>
                            @php
                                $ids_status = [];
                                if(old('ids_status', [])){
                                    $ids_status = explode(',', old('ids_status', []));
                                } else {
                                   $ids_status = explode(',', "confirmed,forecasted,pending");
                                }
                            @endphp
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_status" name="ids_status[]" data-placeholder="Commercial status" data-allow-clear="true">
                                        @foreach (App\Repositories\WlmRepositories::getClientStatus() as $statusC)
                                            <option value="{{ $statusC->name }}" @if(in_array($statusC->name, $ids_status)) selected @endif>{{ __('babel.'.$statusC->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_months_ad" name="ids_months_ad[]" data-placeholder="Agreed deadline month" data-allow-clear="true">
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <a href="#" class="btn btn-link btn-color-primary btn-active-color-primary px-1 clear-filters">
                                    <span class="svg-icon svg-icon-primary svg-icon-2x">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M6,9 L6,15 L10,15 L10,9 L6,9 Z M6.25,7 L19.75,7 C20.9926407,7 22,7.81402773 22,8.81818182 L22,15.1818182 C22,16.1859723 20.9926407,17 19.75,17 L6.25,17 C5.00735931,17 4,16.1859723 4,15.1818182 L4,8.81818182 C4,7.81402773 5.00735931,7 6.25,7 Z" fill="currentColor" fill-rule="nonzero" transform="translate(13.000000, 12.000000) rotate(-45.000000) translate(-13.000000, -12.000000) "/>
                                            </g>
                                        </svg>
                                    </span>
                                    Remove all filters
                                </a>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
            </div>
        </div>


        <div class="card-body" id="kanban_tasks">
            <div class="Page navigation example" id="pagination_top">
                {{ $tasks->links() }}
            </div>
            <br>
            <div id="kt_docs_jkanban_fixed_height" class="kanban-fixed-height" data-jkanban-height="400"></div>
            <div class="Page navigation example" id="pagination_footer">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
    <div id="update-status-kanban-url" data-url="{{ route('update-status-kanban') }}"></div>
    @php
        $statusesArray = $statusesArray->toArray();
    @endphp
@endsection

@push('modals')
@endpush

@push('scripts')
<script src="{{ URL::asset('assets/plugins/custom/jkanban/jkanban.bundle.js') }}"></script>
@once
    <script>
        if (!window.clients) {
            window.clients = {!! json_encode(App\Repositories\ClientsRepositories::getCLientsOfProjects()) !!};
        }
        if (!window.directories) {
            window.directories = {!! json_encode(App\Repositories\DirectoriesRepositories::getCollDirectories()) !!};
        }
        if (!window.scs) {
            window.scs = {!! json_encode(App\Repositories\WlmRepositories::getSCofProjects()) !!};
        }
        if (!window.coordinators) {
            window.coordinators = {!! json_encode(App\Repositories\WlmRepositories::getCoordOfProjects()) !!};
        }
        if (!window.guides) {
            window.guides = {!! json_encode(App\Repositories\WlmRepositories::getGuidesOfProjects()) !!};
        }
        if (!window.consultants) {
            window.consultants = {!! json_encode(App\Repositories\WlmRepositories::getConsultantsOfProjects()) !!};
        }
        if (!window.owners) {
            window.owners = {!! json_encode(App\Repositories\WlmRepositories::getOwnersOfProjects()) !!};
        }
        if (!window.lds) {
            window.lds = {!! json_encode(App\Repositories\WlmRepositories::getLdsOfProjects()) !!};
        }
        if (!window.year) {
            window.year = {!! json_encode(App\Repositories\WlmRepositories::getYearsOfProjects()) !!};
        }
        if (!window.deadline) {
            window.deadline = {!! json_encode(App\Repositories\WlmRepositories::getDeadlineYearsOfProjects()) !!};
        }
        if (!window.locations) {
            window.locations = {!! json_encode($allLocations) !!};
        }
        if (!window.translations) {
            window.translations = {!! json_encode(trans('babel')) !!};
        }
        if (!window.tasksFilter) {
            window.tasksFilter =  {!! $tasksFilter !!};
        }
        window.loadingOverlay = document.getElementById('loading-overlay');
    </script>
@endonce
<script>
    window.statusConsultant = "";
    window.boards = [];
    window.tasks = [];
    window.statusesC = [];
    window.kanban = [];
    window.months = [];
    window.monthsAD = [];
    window.countByStatus =  {!! $countByStatus !!};
    window.clear = false;

    $(document).ready(function() {
        updateUrlParams('sortBy','deadline');
        updateUrlParams('order','ASC');

        var getSub = {!! json_encode($tasks->toArray()) !!};
        tasks = getSub.data;
        statusesC = @json($statusesArray);

        statusesC.unshift({
            "id_status": 'new',
            "name": null,
            "tilte": 'New'
        });

        var requiredFields = ["id_status", "name", "html_color", 'tilte'];
        var newStatusesC = statusesC.map(function(item) {
            var newItem = {};
            requiredFields.forEach(function(campo) {
                newItem[campo] = item[campo];
            });
            return newItem;
        });
        createStyles(statusesC);

        newStatusesC.forEach(element => {
            element.tasks = tasks.filter(function(item) {
                return item.status_c == element.name;
            }).map(function(element) {
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

        boards = newStatusesC.map(function(element) {
            return {
                'id': element.id_status == 'new' ? element.id_status : element.id_status.toString(),
                'title': element.tilte + ` <span class="fs-6">(${countByStatus.hasOwnProperty(element.name) ? countByStatus[element.name] : 0 })</span>`,
                'class': element.id_status == 'new' ? 'new-gray' : element.name,
                'item': element.tasks
            };
        });

        //section  kanban
        var element = '#kt_docs_jkanban_fixed_height';
        var kanbanEl = document.querySelector(element);
        // Get kanban height value
        const kanbanHeight = kanbanEl.getAttribute('data-jkanban-height');
        // Init jKanban
        kanban = new jKanban({
            element: element,
            gutter: '0',
            widthBoard: '300px',
            dragBoards: false,
            boards: boards,

            // Handle item scrolling
            dragEl: function (el, source) {
                document.addEventListener('mousemove', isDragging);
            },

            dragendEl: function (el) {
                document.removeEventListener('mousemove', isDragging);
            },

            dropEl: function (el, target, source, sibling) {
                var statusId = target.parentElement.getAttribute('data-id');//get id board
                var submissionId = el.querySelector('#id_task').value;
                updateStatusTask(submissionId, statusId, el, sibling, source);
                return;
            },
        });
        // Set jKanban height
        const allBoards = kanbanEl.querySelectorAll('.kanban-drag');
        allBoards.forEach(board => {
            board.style.height = kanbanHeight + 'px';
            board.style.padding = 10+'px';
        });

        const isDragging = (e) => {
            const allBoards = kanbanEl.querySelectorAll('.kanban-drag');
            allBoards.forEach(board => {
                // Get inner item element
                const dragItem = board.querySelector('.gu-transit');

                // Stop drag on inactive board
                if (!dragItem) {
                    return;
                }

                // Get jKanban drag container
                const containerRect = board.getBoundingClientRect();

                // Get inner item size
                const itemSize = dragItem.offsetHeight;

                // Get dragging element position
                const dragMirror = document.querySelector('.gu-mirror');
                const mirrorRect = dragMirror.getBoundingClientRect();

                // Calculate drag element vs jKanban container
                const topDiff = mirrorRect.top - containerRect.top;
                const bottomDiff = containerRect.bottom - mirrorRect.bottom;

                // Scroll container
                if (topDiff <= itemSize) {
                    // Scroll up if item at top of container
                    board.scroll({
                        top: board.scrollTop - 3,
                    });
                } else if (bottomDiff <= itemSize) {
                    // Scroll down if item at bottom of container
                    board.scroll({
                        top: board.scrollTop + 3,
                    });
                } else {
                    // Stop scroll if item in middle of container
                    board.scroll({
                        top: board.scrollTop,
                    });
                }
            });
        }

        $('[data-bs-toggle="tooltip"]').tooltip();

        let statusClient = true;
        $('#ids_client').on('change', function(){
            updateUrlParams('ids_client', $(this).val());
            if($(this).val().length>0){
                searchTasks();
                statusClient = true;
            }else if($(this).val().length == 0 && statusClient){
                if(!clear){
                    searchTasks();
                }
                statusClient = false;
            }
        });

        let statusDirectory = true;
        $('#ids_directory').on('change', function(){
            updateUrlParams('ids_directory', $(this).val());
            if($(this).val().length>0){
                searchTasks();
                statusDirectory = true;
            }else if($(this).val().length == 0 && statusDirectory){
                if(!clear){
                    searchTasks();
                }
                statusDirectory = false;
            }
        });
        let statusSC = true;
        $('#ids_senior_consultant').on('change', function(){
            updateUrlParams('ids_senior_consultant', $(this).val());
            if($(this).val().length>0 && !clear){
                searchTasks();
                statusSC = true;
            }else if($(this).val().length == 0 && statusSC){
                if(!clear){
                    searchTasks();
                }
                statusSC = false;
            }
        });
        let statusLocation = true;
            $('#ids_location').on('change', function(){
                updateUrlParams('ids_location', $(this).val());
                if($(this).val().length>0){
                    searchTasks();
                    statusLocation = true;
                }else if($(this).val().length == 0 && statusLocation){
                    if(!clear){
                        searchTasks();
                    }
                    statusLocation = false;
                }
            });
        let statusCoord = true;
        $('#ids_coordinator').on('change', function(){
            updateUrlParams('ids_coordinator', $(this).val());
            if($(this).val().length>0){
                searchTasks();
                statusCoord = true;
            }else if($(this).val().length == 0 && statusCoord){
                if(!clear){
                    searchTasks();
                }
                statusCoord = false;
            }
        });

        $('#year').on('change', function(){
            updateUrlParams('year', $(this).val());
            if(!clear){
                searchTasks();
            }
        });

        $('#deadline').on('change', function(){
            updateUrlParams('deadline', $(this).val());
            if(!clear){
                searchTasks();
            }
        });

        let statusGuide = true;
        $('#ids_guide').on('change', function(){
            updateUrlParams('ids_guide', $(this).val());
            if($(this).val().length>0){
                searchTasks();
                statusGuide = true;
            }else if($(this).val().length == 0 && statusGuide){
                if(!clear){
                    searchTasks();
                }
                statusGuide = false;
            }
        });
        let statusConsult = true;
        $('#ids_consultant').on('change', function(){
            updateUrlParams('ids_consultant', $(this).val());
            if($(this).val().length>0){
                searchTasks();
                statusConsult = true;
            }else if($(this).val().length == 0 && statusConsult){
                if(!clear){
                    searchTasks();
                }
                statusConsult = false;
            }
        });
        let statusMonth = true;
        $('#months').on('change', function(){
            updateUrlParams('months', $(this).val());
            if($(this).val().length>0 && !clear){
                searchTasks();
                statusMonth = true;
            }else if($(this).val().length == 0 && statusMonth){
                if(!clear){
                    searchTasks();
                }
                statusMonth = false;
            }
        });
        let statusSts = true;
        $('#ids_status').on('change', function(){
            updateUrlParams('ids_status', $(this).val());
            if($(this).val().length>0){
                searchTasks();
                statusSts = true;
            }else if($(this).val().length == 0 && statusSts){
                if(!clear){
                    searchTasks();
                }
                statusSts = false;
            }
        });
        let statusOwner = true;
        $('#ids_owner').on('change', function(){
            updateUrlParams('ids_owner', $(this).val());
            if($(this).val().length>0){
                searchTasks();
                statusOwner = true;
            }else if($(this).val().length == 0 && statusOwner){
                if(!clear){
                    searchTasks();
                }
                statusOwner = false;
            }
        });
        let statusLds = true;
        $('#ids_lds').on('change', function(){
            updateUrlParams('ids_lds', $(this).val());
            if($(this).val().length>0){
                searchTasks();
                statusLds = true;
            }else if($(this).val().length == 0 && statusLds){
                if(!clear){
                    searchTasks();
                }
                statusLds = false;
            }
        });

        let agreedDeadline = true;
        $('#ids_months_ad').on('change', function(){
            updateUrlParams('ids_months_ad', $(this).val());
            if($(this).val().length>0){
                searchTasks();
                agreedDeadline = true;
            }else if($(this).val().length == 0 && agreedDeadline){
                if(!clear){
                    searchTasks();
                }
                agreedDeadline = false;
            }
        });

        for (let i = 0; i <= 11; i++) {
            let date = moment().startOf('year').add(i, 'months');
            let monthNumber = date.format('MM');
            let monthName = date.format('MMMM');
            months.push({ deadline: monthNumber, name: monthName });
            monthsAD.push({ agreed_deadline: monthNumber, name: monthName });
        }

        $('.clear-filters').on('click', function(e){
            e.preventDefault();
            clear = true;
            $('#ids_client').val('').trigger('change');
            $('#ids_directory').val('').trigger('change');
            $('#ids_senior_consultant').val('').trigger('change');
            $('#ids_coordinator').val('').trigger('change');
            $('#ids_guide').val('').trigger('change');
            $('#ids_consultant').val('').trigger('change');
            $('#months').val('').trigger('change');
            $('#year').val('').trigger('change');
            $('#ids_status').val('').trigger('change');
            $('#ids_owner').val('').trigger('change');
            $('#ids_lds').val('').trigger('change');
            $('#ids_months_ad').val('').trigger('change');
            searchTasks();
        });

        initialFilter();

        function searchTasks()
        {
            loadingOverlay.style.display = 'flex';
            const params = getOrderBy();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
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
                    'ids_location': $('#ids_location').val(),
                    'ids_owner': $('#ids_owner').val(),
                    'ids_lds': $('#ids_lds').val(),
                    'ids_months_ad': $('#ids_months_ad').val(),
                    'sortBy': params.sortBy,
                    'order': params.order
                },
                url: "{{ route('search-kanban-tasks') }}",
                success:function(response){
                    updateKanbanTasks(response.tasks.data, response.countByStatus);
                    $('#pagination_top, #pagination_footer').html(response.pagination);
                    tasksFilter.length = 0;
                    tasksFilter.push.apply(tasksFilter, response.tasksFilter);
                    clear = false;
                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                },

            }).then(function () {
                loadingOverlay.style.display = 'none';
                updateAllFilter(tasksFilter);
            });
        }

        $('#pagination_top, #pagination_footer').on('click', '.pagination a', function(e) {
            e.preventDefault();
            var url = $(this).attr('href');
            var page = url.substring(url.lastIndexOf('page=') + 5);
            fetchData(page);
        });
    });

    function redirectToSubmission(id)
    {
        var url = "{{ route('view-submission', ['id' => ':id']) }}".replace(':id', id);
        window.location.href = url;
    }
</script>
<script src="{{ URL::asset('admin/js/wlm-kanban.js') . '?f=1' }}"></script>

@endpush
