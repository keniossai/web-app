@extends('layouts.master')

@section('master-title', '')

@push('styles')
    <link href="{{ URL::asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('admin/css/wlm-list.css') }}" rel="stylesheet" type="text/css" />
    <style>
        /*This code is used for the dynamic description update box*/
        .cbox {
        position: relative;
        width: 180px;
        }
        .editable {
        border-color: #bd0f18;
        box-shadow: inset 0 0 10px #555;
        background: #f2f2f2;
        }

        .ctext {
        outline: none;
        padding: 2px;
        }

        .cedit, .csave {
        display: float;
        position: absolute;
        bottom: -25px;
        right: 0px;
        padding: 2px 15px;
        border-top-right-radius: 2px;
        border-bottom-left-radius: 10px;
        text-align: center;
        cursor: pointer;
        }

        .cedit {
        background: #557a11;
        color: #f0f0f0;
        opacity: 0;
        transition: opacity .2s ease-in-out;
        }

        .csave {
        display: none;
        background: #bd0f18;
        color: #f0f0f0;
        }

        .ccancel {
            display: none;
            position: absolute;
            bottom: -25px;
            left: 0px;
            padding: 2px 5px;
            border-top-left-radius: 2px;
            border-bottom-right-radius: 10px;
            text-align: center;
            cursor: pointer;
            background: #48494a;
            color: #f0f0f0;


        }

        .cbox:hover .cedit {
        opacity: 1;
        }

        </style>

<style>
    input {
    padding: 0;
    height: initial;
    width: initial;
    margin-bottom: 0;
    display: none;
    cursor: pointer;
    }

    label {
    position: relative;
    cursor: pointer;
    }

    label:before {
    content:'';
    -webkit-appearance: none;
    background-color: transparent;
    border: 2px solid #0079bf;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05), inset 0px -15px 10px -12px rgba(0, 0, 0, 0.05);
    padding: 10px;
    display: inline-block;
    position: relative;
    vertical-align: middle;
    cursor: pointer;
    margin-right: 5px;
    }
    input:checked + label:after {
    content: '';
    display: block;
    position: absolute;
    top: 2px;
    left: 9px;
    width: 6px;
    height: 14px;
    border: solid #0079bf;
    border-width: 0 2px 2px 0;
    transform: rotate(45deg);
    }

</style>
@endpush

@section('master-content')
    <div id="loading-overlay">
        <span>Updating...</span>
        <div></div>
    </div>
    <div class="card">
        <div class="card-header">
            <div class="card-title fs-3 fw-bold">
                Workload Management
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
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_client" name="ids_client[]" data-placeholder="Client" data-allow-clear="true">

                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_directory" name="ids_directory[]" data-placeholder="Directory" data-allow-clear="true">
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
                                        @foreach (App\Repositories\WlmRepositories::getDeadlineYearsOfProjects() as $year)
                                            <option value="{{ $year }}" @if($year == (!old('year', []) ?  Carbon\Carbon::now()->format('Y') : old('year', []))) selected @endif>{{ $year }}</option>
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
                                            <option value="{{ $year }}">{{ $year }}</option>
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
                                        @foreach (collect($tasks->items())->sort()->pluck("lds_name")->unique()->toArray() as $lds)
                                                    <option value="{{ $lds }}" >{{ $lds }}</option>
                                            @endforeach
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
                            <div class="fv-row mb-2">
                                    <select class="form-select form-select-solid" multiple data-control="select2" id="ids_consultant_status" name="ids_consultant_status[]" data-placeholder="Consultant status" data-allow-clear="true">

                                    </select>
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
                    <span id="total-tasks" style="" > {{ $tasks->total() }}</span>
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
                            <th class="min-w-135px">
                                <a href="#" onclick="sortBy('deadline'); return false;">
                                    Directory Deadline
                                </a>
                                <span id="sort-deadline"></span>
                            </th>
                            <th class="min-w-125px">
                                <a href="#" onclick="sortBy('owner'); return false;">
                                    Team
                                </a>
                                <span id="sort-owner"></span>
                            </th>
                            <th class="min-w-125px" style="display: none;">
                                <a href="#" onclick="sortBy('sc'); return false;">
                                    SC
                                </a>
                                <span id="sort-sc"></span>
                            </th>
                            <th class="min-w-125px" style="display: none;">
                                <a href="#" onclick="sortBy('consultant'); return false;">
                                    Consultants
                                </a>
                                <span id="sort-consultant"></span>
                            </th>
                            <th class="min-w-125px" style="display: none;">
                                <a href="#" onclick="sortBy('lds'); return false;">
                                    LDS
                                </a>
                                <span id="sort-lds"></span>
                            </th>
                            <th class="min-w-125px" style="display: none;">
                                <a href="#" onclick="sortBy('coord'); return false;">
                                    Coordinator
                                </a>
                                <span id="sort-coord"></span>
                            </th>
                            <th class="min-w-125px">
                                <a href="#" onclick="sortBy('consultantStatus'); return false;">
                                    C Status
                                </a>
                                <span id="sort-consultantStatus"></span>
                            </th>
                            <th class="min-w-90px">
                                Ref filed
                            </th>
                            <th class="min-w-125px">Description</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 fw-semibold" id="items-tasks">
                        @include('admin.items')
                    </tbody>
                </table>
            </div>
            <div class="Page navigation example" id="pagination">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
    <div id="search-url" data-url="{{ route('search-tasks') }}"></div>
    <div id="filter-url" data-url="{{ route('filter-tasks') }}"></div>
    <div id="update-status-c-url" data-url="{{ route('update-status-c') }}"></div>
    <div id="export-tasks-wlm-url" data-url="{{ route('export-tasks-wlm') }}"></div>
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
            if (!window.year) {
                window.year = {!! json_encode(App\Repositories\WlmRepositories::getYearsOfProjects()) !!};
            }
            if (!window.deadline) {
                window.deadline = {!! json_encode(App\Repositories\WlmRepositories::getDeadlineYearsOfProjects()) !!};
            }
            if (!window.locations) {
                window.locations = {!! json_encode($allLocations) !!};
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
            if (!window.statusClients) {
                window.statusClients = {!! json_encode(App\Repositories\StatusRepositories::getStatusForClient()) !!};
            }
            if (!window.statusConsultant) {
                window.statusConsultant = {!! json_encode(App\Repositories\StatusRepositories::getStatusConsultant()) !!}
            }
            if (!window.translations) {
                window.translations = {!! json_encode(trans('babel')) !!};
            }
            window.loadingOverlay = document.getElementById('loading-overlay');
            // comment - renders the items in filter dropdown
        </script>
    @endonce
    <script>
        window.statusConsultant = {!! $statusConsultant !!};
        window.datasets = [];
        window.scUsers = {!! $scUsers !!};
        window.colorsHex = [];
        window.tasksGraph = {!! $tasksGraph !!};
        window.clear = false;
        window.months = [];
        window.monthsAD = [];
        window.myChart = "";
        $( document ).ready(function(){
            updateUrlParams('sortBy','deadline');
            updateUrlParams('order','ASC');
            updateUrlParams('ids_status', $('#ids_status').val());
            updateUrlParams('deadline', $('#deadline').val());

            getColors();
            initializeGraph();

            $('#pagination').on('click', '.pagination a', function(e) {
                e.preventDefault();
                var url = $(this).attr('href');
                var page = url.substring(url.lastIndexOf('page=') + 5);
                fetchData(page);
            });

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
            $('#deadline').on('change', function(){
                updateUrlParams('deadline', $(this).val());
                if(!clear){
                   searchTasks();
                }
            });
            $('#year').on('change', function(){
                updateUrlParams('year', $(this).val());
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
            // comment - this makes the filter update table
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
            let statusConsultS = true;
            $('#ids_consultant_status').on('change', function(){
                updateUrlParams('ids_consultant_status', $(this).val());
                if($(this).val().length>0){
                    searchTasks();
                    statusConsultS = true;
                }else if($(this).val().length == 0 && statusConsultS){
                    if(!clear){
                        searchTasks();
                    }
                    statusConsultS = false;
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

            $('.clear-filters').on('click', function(e){
                e.preventDefault();
                clear = true;
                $('#ids_client').val('').trigger('change');
                $('#ids_directory').val('').trigger('change');
                $('#ids_senior_consultant').val('').trigger('change');
                $('#ids_coordinator').val('').trigger('change');
                $('#ids_guide').val('').trigger('change');
                $('#ids_consultant_status').val('').trigger('change');
                $('#ids_consultant').val('').trigger('change');
                $('#months').val('').trigger('change');
                $('#ids_status').val('').trigger('change');
                $('#ids_owner').val('').trigger('change');
                $('#ids_location').val('').trigger('change');
                $('#ids_lds').val('').trigger('change');
                $('#ids_months_ad').val('').trigger('change');
                searchTasks();
            });
            const params = getOrderBy();
            const currentOrder = params.order;
            const currentSortBy = params.sortBy;

            if(currentOrder){
                let icon = '';
                if(currentOrder == 'ASC'){
                    icon = '<i class="las la-angle-up"></i>';
                } else {
                    icon = '<i class="las la-angle-down"></i>';
                }

                $('#sort-'+currentSortBy).html(icon);
            }
            const description = document.getElementById("description");
            const saveButton = document.getElementById("status_id");

            description.addEventListener("keydown", function(event) {
                if (event.key === "Tab") {
                    event.preventDefault();
                    saveButton.focus();
                }
            });

            for (let i = 0; i <= 11; i++) {
                let date = moment().startOf('year').add(i, 'months');
                let monthNumber = date.format('MM');
                let monthName = date.format('MMMM');
                months.push({ deadline: monthNumber, name: monthName });
                monthsAD.push({ agreed_deadline: monthNumber, name: monthName });
            }

            initialFilter();
            // $('.btn-show').on('click', function(){
            //     console.log($(this).val());
            //     console.log(this.id);
            //     const subtable = document.querySelector('[data-kt-docs-datatable-subtable="subtable_template_'+this.id+'"]');
            //     if($(this).val() == 1){
            //         subtable.classList.remove('d-none');
            //         $('.btn-show-plus-'+this.id).hide();
            //         $('.btn-show-less-'+this.id).show();
            //         $('.btn-show').val(0);
            //     } else {
            //         subtable.classList.add('d-none');
            //         $('.btn-show-less-'+this.id).hide();
            //         $('.btn-show-plus-'+this.id).show();
            //         $('.btn-show').val(1);
            //     }
            // });
        });


    </script>
    <script src="{{ URL::asset('admin/js/wlm-list.js') }}"></script>
@endpush
