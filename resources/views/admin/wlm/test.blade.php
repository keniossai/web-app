@extends('layouts.master')

@section('master-title', '')

@push('styles')
    <link href="{{ URL::asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .form-select{
            background-image: none!important;
        }
        .error {
            border: 1px solid red !important;
        }
        .error-message {
            display: none;
            color: red;
        }

    </style>
    <style>
        #loading-overlay {
            top: 50%;
            left: 50%;
            width: 100%;
            height: 100%;
            background-color: rgb(104 104 104 / 31%);
            z-index: 2;
            display: none;
            position: fixed;
            justify-content: center;
            align-items: center;
            transform: translate(-50%, -50%);
        }
        #loading-overlay::before {
            content: "";
            display: flex;
            position: absolute;
            left: 55%;
            width: 60px;
            height: 60px;
            margin: auto;
            border-radius: 50%;
            border: 5px solid rgba(255, 255, 255, 0.5);
            border-top-color: #3ba7e7;
            animation: spinner 1s linear infinite;
            z-index: 3;
        }
        #loading-overlay span {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: absolute;
            top: 56%;
            left: 57%;
            transform: translate(-50%, -50%);
            color: #0088d9;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
        }
        .select2-dropdown {
            z-index: 1;
        }
        @keyframes spinner {
            to {transform: rotate(360deg);}
        }

    </style>

<style>
    .pagination a.page-link {
        cursor: pointer;
    }
</style>
@endpush

@section('master-content')
    <div id="loading-overlay">
        <span>Cargando...</span>
        <div></div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title fs-3 fw-bold">
                Workload Management test
            </div>
            <div class="card-title d-flex justify-content-end">
            </div>
        </div>
        <div class="card-body py-4">
            <canvas id="kt_chartjs_2" class="mh-400px"></canvas>
            <div class="py-2 pt-5">
                <div class="rounded border p-5">
                    <!--begin::Form-->
                    <form class="form">
                        @csrf
                        <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-4">
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_client" name="ids_client[]" data-placeholder="Select a client" data-allow-clear="true">

                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_directory" name="ids_directory[]" data-placeholder="Select a directory" data-allow-clear="true">
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_senior_consultant" name="ids_senior_consultant[]" data-placeholder="Select a senior consultant" data-allow-clear="true">
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_coordinator" name="ids_coordinator[]" data-placeholder="Select a coordinator" data-allow-clear="true">
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
                                    <select class="form-select form-select-solid" data-control="select2" id="year" name="year" data-placeholder="Select a year" data-allow-clear="true">
                                        <option></option>
                                        @foreach (App\Repositories\WlmRepositories::getYearsOfProjects() as $year)
                                            <option value="{{ $year }}" @if($year == (!old('year', []) ?  Carbon\Carbon::now()->addYear()->format('Y') : old('year', []))) selected @endif>{{ $year }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_guide" name="ids_guide[]" data-placeholder="Select a guide" data-allow-clear="true">
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_consultant" name="ids_consultant[]" data-placeholder="Select a consultant" data-allow-clear="true">
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="months" name="months[]" data-placeholder="Select a month" data-allow-clear="true">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-4">
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
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_status" name="ids_status[]" data-placeholder="Select a commercial status" data-allow-clear="true">
                                        @foreach (App\Repositories\WlmRepositories::getClientStatus() as $statusC)
                                            <option value="{{ $statusC->name }}" @if(in_array($statusC->name, $ids_status)) selected @endif>{{ __('babel.'.$statusC->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_owner" name="ids_owner[]" data-placeholder="Select an owner" data-allow-clear="true">
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_lds" name="ids_lds[]" data-placeholder="Select a LDS" data-allow-clear="true">
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_months_ad" name="ids_months_ad[]" data-placeholder="Select agreed deadline month" data-allow-clear="true">
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
        <div class="card-header border-0 pt-6">
            <div class="card-title">
            </div>

            <div class="card-toolbar">
                <span>
                    Submissions
                    {{-- <span id="total-tasks" style="">{{ $tasks->total() }}</span> --}}
                </span>
                &nbsp; &nbsp;
                <a href="#" onclick="exportToExcel(); return false;" id="export-task" class="btn btn-sm btn-primary update-tasks">
                    <span class="svg-icon svg-icon-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="currentColor"></rect>
                            <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="currentColor"></path>
                            <path opacity="0.3" d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="currentColor"></path>
                        </svg>
                    </span>
                    <span class="indicator-label">
                        Export
                    </span>
                    <span class="indicator-progress">
                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                    </span>
                </a>

                <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                    <div class="fw-bold me-5">
                    <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected</div>
                    <button type="button" class="btn btn-sm btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
                </div>
            </div>
        </div>

        <div class="card-body py-4">
            <div class="table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                    <thead id="tasks-header">
                        <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-125px">Info</th>
                            <th class="min-w-125px">Details</th>
                            <th class="min-w-125px">
                                <a href="#" onclick="sortBy('agreed_deadline'); return false;">
                                    Agreed Deadline
                                </a>
                                <span id="sort-agreed_deadline"></span>
                            </th>
                            <th class="min-w-125px">
                                <a href="#" onclick="sortBy('deadline'); return false;">
                                    Directory Deadline
                                </a>
                                <span id="sort-deadline"></span>
                            </th>
                            <th class="min-w-125px">
                                <a href="#" onclick="sortBy('owner'); return false;">
                                    Owner
                                </a>
                                <span id="sort-owner"></span>
                            </th>
                            <th class="min-w-125px">
                                <a href="#" onclick="sortBy('sc'); return false;">
                                    SC
                                </a>
                                <span id="sort-sc"></span>
                            </th>
                            <th class="min-w-125px">
                                <a href="#" onclick="sortBy('consultant'); return false;">
                                    Consultants
                                </a>
                                <span id="sort-consultant"></span>
                            </th>
                            <th class="min-w-125px">
                                <a href="#" onclick="sortBy('lds'); return false;">
                                    LDS
                                </a>
                                <span id="sort-lds"></span>
                            </th>
                            <th class="min-w-125px">
                                <a href="#" onclick="sortBy('coord'); return false;">
                                    Coordinator
                                </a>
                                <span id="sort-coord"></span>
                            </th>
                            <th class="min-w-125px">
                                <a href="#" onclick="sortBy('consultantStatus'); return false;">
                                    Consultant Status
                                </a>
                                <span id="sort-consultantStatus"></span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold" id="items-tasks">
                        {{-- @include('admin.items') --}}
                    </tbody>
                </table>
            </div>
            {{-- <div id="pagination">
                <button id="anterior">Anterior</button>
                <div id="paginas"></div>
                <button id="siguiente">Siguiente</button>
            </div> --}}
            <!-- Ejemplo de uso de estilos de Metronic en tu paginación -->
            <div id="paginacion" class="d-flex justify-content-center mt-5">
                <ul class="pagination">
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Atras">
                            <span aria-hidden="true"><i class="fas fa-chevron-left"></i></span>
                        </a>
                    </li>
                    <!-- Aquí se generará la paginación -->
                    <li class="page-item">
                        <a class="page-link" href="#" aria-label="Siguiente">
                            <span aria-hidden="true"><i class="fas fa-chevron-right"></i></span>
                        </a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
@endsection

@push('modals')
    <div class="modal fade" id="kt_modal_stacked_1" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content rounded">
                <div class="modal-header pb-0 border-0 pt-1 justify-content-end">
                    <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15 ">
                    <form id="kt_modal_new_target_form" class="form" action="#">
                        <input type="text" id="id_task" value="" hidden>
                        <div class="mb-13 text-center">
                            <h1 class="mb-3">Status</h1>
                        </div>
                        <div class="row g-9 mb-8">
                            <div class="col-md-5 fv-row">
                                <div class="bg-light-primary rounded border-primary border border-dashed p-2" >
                                    <div style="text-align: center;" >
                                        <h4 style="margin-top: 4.3px; margin-bottom: 4.3px">
                                          <span class="text-gray-600 fw-bold" style="display: inline-block;" id="current-status">New</span>
                                        </h4>
                                      </div>
								</div>
                            </div>
                            <div class="col-md-1 fv-row" style="padding-left:11px; padding-top:7px">
                                <span class="svg-icon svg-icon-primary svg-icon-2x">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                            <rect fill="currentColor" opacity="0.3" transform="translate(14.000000, 12.000000) rotate(-90.000000) translate(-14.000000, -12.000000) " x="13" y="5" width="2" height="14" rx="1"/>
                                            <rect fill="currentColor" opacity="0.3" x="3" y="3" width="2" height="18" rx="1"/>
                                            <path d="M11.7071032,15.7071045 C11.3165789,16.0976288 10.6834139,16.0976288 10.2928896,15.7071045 C9.90236532,15.3165802 9.90236532,14.6834152 10.2928896,14.2928909 L16.2928896,8.29289093 C16.6714686,7.914312 17.281055,7.90106637 17.675721,8.26284357 L23.675721,13.7628436 C24.08284,14.136036 24.1103429,14.7686034 23.7371505,15.1757223 C23.3639581,15.5828413 22.7313908,15.6103443 22.3242718,15.2371519 L17.0300721,10.3841355 L11.7071032,15.7071045 Z" fill="currentColor" fill-rule="nonzero" transform="translate(16.999999, 11.999997) scale(1, -1) rotate(90.000000) translate(-16.999999, -11.999997) "/>
                                        </g>
                                    </svg>
                                </span>
                            </div>

                            <div class="col-md-6 fv-row">
                                <div class="position-relative d-flex align-items-center">
                                    <select class="form-select form-select-solid" id="id_status" data-control="select2" data-hide-search="true" data-placeholder="Select a Team Member" name="target_assign">
                                        @foreach (App\Models\Status::orderBy('order')->where(['element_type' => 'task', 'status_type' => 'consultant', 'deleted' => 0])->get() as $status)
                                            <option value="{{ $status->id_status }}">{{ __('babel.'.$status->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column mb-8">
                            <textarea class="form-control form-control-solid" rows="3" id="description" placeholder="Description"></textarea>
                            <div class="error-message" id="message">Description is required</div>
                        </div>
                        <div class="text-center">
                            <button type="button" data-bs-dismiss="modal" class="btn btn-light me-3">Close</button>
                            <button type="button" onclick="updateStatusC()" id="status_id" class="btn btn-light-primary">
                                <span class="indicator-label">Save</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')

    <script>
        window.tasks =  {!! $tasks !!};
        window.statusConsultant = {!! $statusConsultant !!};
        window.translations = {!! json_encode(trans('babel')) !!};
        $( document ).ready(function(){
            renderizarTabla();
            renderizarPaginacion();
        });

        //function current used
        function updateStatusC()
        {
            var description = document.getElementById("description");
            var message = document.getElementById("message");
            var idBtn = document.querySelector("#status_id");
                idBtn.setAttribute("data-kt-indicator", "on");
                idBtn.disabled = true;
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {'id_task' : $('#id_task').val(),
                        'id_status': $('#id_status').val(),
                        'description': $('#description').val()},
                url: "{{ route('update-status-c') }}",
                success:function(response){
                    let id = 'td-'+$('#id_task').val();
                    var link = $('#'+id);
                    let item = response.task;
                    link.html(response.view);
                    link.find('[data-bs-toggle="tooltip"]').tooltip();
                    idBtn.removeAttribute("data-kt-indicator");
                    idBtn.disabled = false;

                    // Function to update the status_c and html_color properties
                    function updateSubmission(id, status, color, description) {
                        let submission = tasks.find(function(submission) {
                            return submission.id_task == id;
                        });
                        if (submission) {
                            submission.status_c = status;
                            submission.html_color = color;
                            submission.status_description = description;
                        }
                    }

                    updateSubmission(item.id_task, item.status_c, item.html_color, item.status_description);
                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                },
            }).then(function () {
                $('#kt_modal_stacked_1').modal('hide');
            });
        }

        function redirectTo(id, type)
        {
            var url = "";
            if(type == 'project'){
                url = "{{ route('view-project', ['submissions', 'id' => ':id']) }}".replace(':id', id);
            } else if(type == 'client'){
                url = "{{ route('view-client', ['general', 'id' => ':id']) }}".replace(':id', id);
            } else if(type == 'submission'){
                url = "{{ route('view-submission', ['id' => ':id']) }}".replace(':id', id);
            }
            window.open(url, '_blank');
            /* window.location.href = url; */
        }
        //end function

        function initialFilter()
        {
            filterStatus = false;
            function formatValues(string){
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

            let urlLds = urlParams.get('ids_lds');
            let idsLds = urlLds ? formatValues(urlLds) : [];
            updateFilter(tasksGraph, lds, "ids_lds", "id_lds", idsLds);

            let urlMonth = urlParams.get('months');
            let idsMonth = urlMonth ? urlMonth.split(",") : [];
            updateDeadlineFilter(tasksGraph, months, "months", "deadline", idsMonth);

            let urlMonthAD = urlParams.get('ids_months_ad');
            let idsMonthAD = urlMonthAD ? urlMonthAD.split(",") : [];
            updateDeadlineFilter(tasksGraph, monthsAD, "ids_months_ad", "agreed_deadline", idsMonthAD);
        }

        function updateFilter(tasks, models, id_updated, id_filter, lds)
        {
            $('#'+id_updated).empty();
            let ids_filtered = tasks.map(function(item){//filtrar las task por el id
                return item[id_filter];
            });

            $.grep(models, function(model) {//buscamos si existe en el array
                return $.inArray(model[id_filter], ids_filtered) > -1;
            }).forEach(function(item){
                var newOption = new Option(item.name, item[id_filter], false, false);
                $('#'+id_updated).append(newOption);
            });

            if([lds].length>0){
                $('#'+id_updated).val(lds);
            }
        }

        function updateDeadlineFilter(tasks, models, id_updated, id_filter, lds)
        {
            $('#'+id_updated).empty();
            let dates = tasks.map(function(item){
                return item[id_filter];
            });
            let ids_filtered = dates.map(function(date) {
                return moment(date).format('MM');
            });

            $.grep(models, function(model) {//buscamos si existe en el array
                return $.inArray(model[id_filter], ids_filtered) > -1;
            }).forEach(function(item){
                var newOption = new Option(item.name, item[id_filter], false, false);
                $('#'+id_updated).append(newOption);
            });

            if([lds].length>0){
                $('#'+id_updated).val(lds);
            }
        }

        function sortBy(column)
        {
            const params = getOrderBy();
            const currentOrder = params.order;
            const currentColumn = params.sortBy;

            updateUrlParams('sortBy', column);

            let appyOrder = '';
            let icon = '';
            if((currentOrder && currentOrder == 'ASC') && currentColumn == column){
                appyOrder = 'DESC';
                icon = '<i class="las la-angle-down"></i>';
            } else {
                appyOrder = 'ASC';
                icon = '<i class="las la-angle-up"></i>';
            }

            updateUrlParams('order', appyOrder);

            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {
                    'ids_client': $('#ids_client').val(),
                    'ids_directory': $('#ids_directory').val(),
                    'ids_senior_consultant': $('#ids_senior_consultant').val(),
                    'ids_coordinator': $('#ids_coordinator').val(),
                    'year': $('#year').val(),
                    'ids_guide': $('#ids_guide').val(),
                    'ids_consultant': $('#ids_consultant').val(),
                    'months': $('#months').val(),
                    'ids_status': $('#ids_status').val(),
                    'ids_owner': $('#ids_owner').val(),
                    'ids_lds': $('#ids_lds').val(),
                    'ids_months_ad': $('#ids_months_ad').val(),
                    'sortBy': column,
                    'order': appyOrder,
                },
                url: "{{ route('filter-tasks') }}",
                success:function(response){
                    $('#items-tasks').html(response.view);
                    $('#pagination').html(response.pagination);
                    $('#items-tasks').each(function() {
                        var link = $(this);
                        link.find('[data-bs-toggle="tooltip"]').tooltip();
                    });
                    clear = false;
                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                },
            }).then(function () {
                var sortSpans = document.querySelectorAll("#tasks-header span[id^='sort-']");
                for (var i = 0; i < sortSpans.length; i++) {
                    sortSpans[i].innerHTML = "";
                }
                $('#sort-'+column).html(icon);
            });
        }

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
                    'ids_guide': $('#ids_guide').val(),
                    'ids_consultant': $('#ids_consultant').val(),
                    'months': $('#months').val(),
                    'ids_status': $('#ids_status').val(),
                    'ids_owner': $('#ids_owner').val(),
                    'ids_lds': $('#ids_lds').val(),
                    'ids_months_ad': $('#ids_months_ad').val(),
                    'sortBy': params.sortBy,
                    'order': params.order
                },
                url: "{{ route('search-tasks') }}",
                success:function(response){
                    $('#items-tasks').html(response.view);
                    $('#pagination').html(response.pagination);
                    $('#items-tasks').each(function() {
                        var link = $(this);
                        link.find('[data-bs-toggle="tooltip"]').tooltip();
                    });
                    var spanElement = document.getElementById("total-tasks");
                    spanElement.textContent = response.totalTasks;

                    tasksGraph.length = 0;
                    tasksGraph.push.apply(tasksGraph, response.tasksGraph);
                    clear = false;
                },
                error: function(xhr) {
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

        function updateAllFilter(tasks)
        {
            if($("#ids_client").val().length<=0){
                updateFilter(tasks, clients, "ids_client", "id_client");
            }

            if($("#ids_directory").val().length<=0){
                updateFilter(tasks, directories, "ids_directory", "id_directory");
            }

            if($("#ids_senior_consultant").val().length<=0){
                updateFilter(tasks, scs, "ids_senior_consultant", "id_senior_consultant");
            }

            if($("#ids_coordinator").val().length<=0){
                updateFilter(tasks, coordinators, "ids_coordinator", "id_coordinator");
            }

            if($("#ids_guide").val().length<=0){
                updateFilter(tasks, guides, "ids_guide", "id_guide");
            }

            if($("#ids_consultant").val().length<=0){
                updateFilter(tasks, consultants, "ids_consultant", "id_consultant");
            }

            if($("#ids_owner").val().length<=0){
                updateFilter(tasks, owners, "ids_owner", "owner");
            }

            if($("#ids_lds").val().length<=0){
                updateFilter(tasks, lds, "ids_lds", "id_lds");
            }

            if($("#months").val().length<=0){
                updateDeadlineFilter(tasks, months, "months", "deadline");
            }

            if($("#ids_months_ad").val().length<=0){
                updateDeadlineFilter(tasks, monthsAD, "ids_months_ad", "agreed_deadline");
            }
        }

        function fetchData(page = 1) {
            const currentUrl = window.location.href;
            let filters = currentUrl.split('?')[1];

            $.get('/wlm?page=' + page + '&'+filters, function(data) {
                $('#items-tasks').html(data.view);
                $('#pagination').html(data.pagination);

                $('#items-tasks').each(function() {
                    var link = $(this); // get the link element inside each items-tasks element
                    link.find('[data-bs-toggle="tooltip"]').tooltip(); // enable the tooltip plugin for the corresponding a element
                });

            });
        }

        function updateUrlParams(filter, values)
        {
            const url = new URL(window.location.href);
            url.searchParams.set([filter], values);
            window.history.replaceState(null, null, url.href);
        }

        function initializeGraph()
        {
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
                        chart.config.data.datasets.map(dataset =>{
                            dataset.backgroundColor = dataset.backgroundColor.substr(0,7) ;
                            dataset.borderColor = dataset.borderColor.substr(0,7);
                        });
                        chart.update();
                        var names = [];
                        if(activeElements[0]){
                            let dataIndex = activeElements[0].index;
                            let datasetIndex = activeElements[0].datasetIndex;
                            let userName = evt.chart.data.datasets[datasetIndex].label;
                            let month = evt.chart.data.labels[dataIndex];
                            names.push(userName);
                            chart.config.data.datasets.map(dataset =>{
                                if(dataset.label != userName){
                                    dataset.backgroundColor = (dataset.backgroundColor+'40');
                                    dataset.borderColor =(dataset.borderColor+'40');
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
                defaults:{
                    global: {
                        defaultFont: fontFamily
                    }
                }
            };

            myChart = new Chart(ctx, config);
            filterGraph();
        }

        function filterGridFromGraphBySC(names)
        {
            clear = true;
            loadingOverlay.style.display = 'flex';
            var ids_sc = scUsers.filter(function(sc){
                if($.inArray(sc.name, names) > -1){
                    return sc;
                }
            }).map(sc=>sc.id_senior_consultant);

            const isUnassignedPresent = names.find(item => item === "Unassigned") !== undefined;
            if(isUnassignedPresent){
                ids_sc.push(-1);
            }

            $('#ids_senior_consultant').val(ids_sc).trigger('change');
            const params = getOrderBy();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {
                    'ids_client': $('#ids_client').val(),
                    'ids_directory': $('#ids_directory').val(),
                    'ids_senior_consultant': ids_sc,
                    'ids_coordinator': $('#ids_coordinator').val(),
                    'year': $('#year').val(),
                    'ids_guide': $('#ids_guide').val(),
                    'ids_consultant': $('#ids_consultant').val(),
                    'months': $('#months').val(),
                    'ids_status': $('#ids_status').val(),
                    'ids_owner': $('#ids_owner').val(),
                    'ids_lds': $('#ids_lds').val(),
                    'ids_months_ad': $('#ids_months_ad').val(),
                    'sortBy': params.sortBy,
                    'order': params.order
                },
                url: "{{ route('search-tasks') }}",
                success:function(response){
                    $('#items-tasks').html(response.view);
                    $('#pagination').html(response.pagination);
                    $('#items-tasks').each(function() {
                        var link = $(this);
                        link.find('[data-bs-toggle="tooltip"]').tooltip();
                    });
                    var spanElement = document.getElementById("total-tasks");
                    spanElement.textContent = response.totalTasks;
                },
                error: function(xhr) {
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

        function filterGridFromGraph(names, monthName)
        {
            clear = true;
            loadingOverlay.style.display = 'flex';
            var ids_sc = scUsers.filter(function(sc){
                if($.inArray(sc.name, names) > -1){
                    return sc;
                }
            }).map(sc=>sc.id_senior_consultant);

            $('#ids_senior_consultant').val(ids_sc).trigger('change');

            var months = [];
            var currentMonths = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
            if(monthName){
                months = [moment().month(monthName).format("M").padStart(2, '0')];
                $('#months').val(months).trigger('change');
            } else {
                $('#months').val(currentMonths).trigger('change');
            }
            const params = getOrderBy();
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {
                    'ids_client': $('#ids_client').val(),
                    'ids_directory': $('#ids_directory').val(),
                    'ids_senior_consultant': ids_sc,
                    'ids_coordinator': $('#ids_coordinator').val(),
                    'year': $('#year').val(),
                    'ids_guide': $('#ids_guide').val(),
                    'ids_consultant': $('#ids_consultant').val(),
                    'months': months,
                    'ids_status': $('#ids_status').val(),
                    'ids_owner': $('#ids_owner').val(),
                    'ids_lds': $('#ids_lds').val(),
                    'ids_months_ad': $('#ids_months_ad').val(),
                    'sortBy': params.sortBy,
                    'order': params.order
                },
                url: "{{ route('search-tasks') }}",
                success:function(response){
                    $('#items-tasks').html(response.view);
                    $('#pagination').html(response.pagination);
                    $('#items-tasks').each(function() {
                        var link = $(this);
                        link.find('[data-bs-toggle="tooltip"]').tooltip();
                    });
                    var spanElement = document.getElementById("total-tasks");
                    spanElement.textContent = response.totalTasks;
                },
                error: function(xhr) {
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

        function getOrderBy()
        {
            let $obj = {}; // Declare $obj as an empty object
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            $obj['sortBy'] = urlParams.get('sortBy');
            $obj['order'] = urlParams.get('order');
            return $obj;
        }

        function openPopup(id, status)
        {
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
            if(status){
                let name = window.translations[status];
                newSpan.innerHTML = name;
            } else{
                newSpan.innerHTML = 'New';
            }

            parentElement.appendChild(newSpan);
            let nextStatus = getNextStatus(status);

            if(nextStatus){
                $("#id_status").val(nextStatus.id_status).trigger('change');
            } else {
                let id_status = statusConsultant.find(statusC => statusC.name === status).id_status;
                $("#id_status").val(id_status).trigger('change');
            }
            $('#id_task').val(id);
            $('#description').val('');
            $('#kt_modal_stacked_1').modal('show').on('shown.bs.modal', function(){
                $('#description').focus();
            });

        }

        function closePopup(button) {
            var popup = $(button).closest(".popup");
            popup.hide();
        }



        function getNextStatus(currentName) {
            let currentStatus = statusConsultant.find(status => status.name === currentName);
            let currentIndex = statusConsultant.indexOf(currentStatus);
            let nextStatus = statusConsultant[currentIndex + 1];
            return nextStatus;
        }

        function filterGraph()
        {
            var groupArrayObject = tasksGraph.reduce((group, arr) => {
                const { sc_name } = arr;
                group[sc_name] = group[sc_name] ?? [];
                group[sc_name].push(arr);
                return group;
            },{});

            datasets.length = 0;
            // filtered
            let taskFiltered = Object.entries(groupArrayObject);
                taskFiltered.forEach(group => {
                    group[0] = group[0];
                });

            taskFiltered.forEach(function (a, i) {
                let usersFiltered =  scUsers.filter(function(user) {
                    return user.name == a[0];
                });

                var months = [{month: '01'}, {month: '02'},{month: '03'}, {month: '04'},{month: '05'}, {month: '06'},{month: '07'}, {month: '08'},{month: '09'}, {month: '10'}, {month: '11'}, {month: '12'}];
                var data = [];

                months.forEach(element => {
                    let filteredTasks = a[1].filter(function(task) {
                        if(task.deadline)
                        {
                            date = moment(task.deadline).format("MM");
                            return date.indexOf(element.month) > -1;
                        }
                    })
                    data.push(filteredTasks.length);
                });

                var randomColor = colorsHex[i+1];
                let name = '';
                if(usersFiltered.length>0){
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

            datasets.sort(function(a, b) {
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
                url: "{{ route('export-tasks-wlm') }}",
                type: 'GET',
                data: {
                    ids_client: searchParams.get('ids_client'),
                    ids_directory: searchParams.get('ids_directory'),
                    ids_guide: searchParams.get('ids_guide'),
                    ids_senior_consultant: searchParams.get('ids_senior_consultant'),
                    ids_status: searchParams.get('ids_status'),
                    year: searchParams.get('year'),
                    ids_coordinator: searchParams.get('ids_coordinator'),
                    ids_consultant: searchParams.get('ids_consultant'),
                    months: searchParams.get('months'),
                    ids_owner: searchParams.get('ids_owner'),
                    ids_lds: searchParams.get('ids_lds'),
                    ids_months_ad: searchParams.get('ids_months_ad'),
                    'sortBy':  searchParams.get('sortBy'),
                    'order':  searchParams.get('order')
                },
                xhrFields: {
                    responseType: 'blob'
                },
                success: function(data) {
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
                error: function(xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                },
            });
        }

        function getColors()
        {
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
    </script>
    <script src="{{ URL::asset('admin/js/customTable.js') }}"></script>

@endpush
