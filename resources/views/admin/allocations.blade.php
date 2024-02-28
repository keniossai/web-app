
@extends('layouts.master')

@push('styles')
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">

    <style>
        .form-select{
            background-image: none!important;
        }
        .select2-selection__clear{
            right: 1em !important;
        }
        .info-format{
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            line-height: 16px;
            max-height: 32px;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
        .jsgrid-pager{
            float: right;
        }
        .hidden {
            display: none;
        }
        .readonly-field {
            cursor: default;
        }
        .hide-datepicker {
            display: none !important;
        }
    </style>
@endpush

@section('master-title', '')
@section('master-header-buttons')

@endsection

@section('master-content')
<div class="card">
    <div class="card-header">
        <div class="card-title fs-3 fw-bold">
            Allocations
        </div>
        <div class="card-title d-flex justify-content-end">
        </div>
    </div>

    <!--begin::Content-->
    <div class="col-xl-12">
        <div class="card card-flush h-lg-100">
            <div class="card-body pt-2">
                <div class="d-flex flex-wrap justify-content-end my-5">
                    <span class="fs-6 fw-semibold text-gray-700 ms-1 my-2 mx-2">
                        Group By
                    </span>
                    <div class="d-flex flex-wrap my-1">
                        <div class="m-0">
                            <select name="status" data-control="select2" data-hide-search="true" id="group_by" data-placeholder="Select group by" class="form-select form-select-solid form-select-sm border-body fw-bold w-200px">
                                <option value=""></option>
                                <option value="id_senior_consultant">Senior consultant</option>
                                <option value="id_consultant">Consultant</option>
                                <option value="id_lds">LDS</option>
                                <option value="id_coordinator">Coordinator</option>
                                <option value="owner">Owner</option>
                            </select>

                        </div>
                    </div>
                </div>
                <canvas id="kt_chartjs_2" class="mh-400px"></canvas>
                <div class="py-2 pt-5">
                    <div class="rounded border p-5">
                        <form class="form" action="#">
                            <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-4">
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" data-control="select2" id="id_client" data-close-on-select="true" data-placeholder="Client" data-allow-clear="true" multiple="multiple">
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" data-control="select2" id="id_directory" data-close-on-select="true" data-placeholder="Directory" data-allow-clear="true" multiple="multiple">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" data-control="select2" id="id_senior_consultant" data-close-on-select="true"  data-placeholder="Senior consultant" data-allow-clear="true" multiple="multiple">
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" data-control="select2" id="id_coordinator" data-close-on-select="true" data-placeholder="Coordinator" data-allow-clear="true" multiple="multiple">
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-4">
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" data-control="select2" id="deadline" data-placeholder="Deadline year" data-allow-clear="true">
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" data-control="select2" id="id_guide" data-close-on-select="true" data-placeholder="Guide" data-allow-clear="true" multiple="multiple">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" data-control="select2" id="id_consultant" data-close-on-select="true" data-placeholder="Consultant" data-allow-clear="true" multiple="multiple">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" data-control="select2" id="month" data-close-on-select="true" data-placeholder="Deadline month" data-allow-clear="true" multiple="multiple">
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-4">
                            <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" data-control="select2" id="year" data-placeholder="Guide year" data-allow-clear="true">   
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" data-control="select2" id="id_location" data-close-on-select="true" data-placeholder="Location" data-allow-clear="true" multiple="multiple">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" data-control="select2" id="id_owner" data-close-on-select="true" data-placeholder="Owner" data-allow-clear="true" multiple="multiple">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" data-control="select2" id="id_lds" data-close-on-select="true" data-placeholder="LDS" data-allow-clear="true" multiple="multiple">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" data-control="select2" id="status" data-close-on-select="true" data-placeholder="Status" data-allow-clear="true" multiple="multiple">
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" multiple data-control="select2" id="id_months_ad" name="ids_months_ad[]" data-placeholder="Agreed deadline month" data-allow-clear="true">
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
                    </div>
                </div>
                <div style="text-align:end; padding:5px; padding-top:50px">
                    <span>
                        Submissions
                        <span id="total-tasks" style=""></span>
                    </span>
                    &nbsp; &nbsp;
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm btn-edit disabled" id="edit-data">
                            <span class="svg-icon svg-icon-g svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24"/>
                                        <path d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) "/>
                                        <rect fill="currentColor" opacity="0.3" x="5" y="20" width="15" height="2" rx="1"/>
                                    </g>
                                </svg>
                            </span>
                            Edit
                        </button>
                        <div class="menu menu-column menu-gray-600 menu-state-bg fw-semibold w-auto" data-kt-menu="true">
                            <a href="#" id="save-allocation" class="btn btn-sm btn-primary update-tasks" style="border-top-left-radius: 0; border-bottom-left-radius: 0; border-top-right-radius: 0; border-bottom-right-radius: 0">
                                <span class="svg-icon svg-icon-muted svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                            <path d="M17,4 L6,4 C4.79111111,4 4,4.7 4,6 L4,18 C4,19.3 4.79111111,20 6,20 L18,20 C19.2,20 20,19.3 20,18 L20,7.20710678 C20,7.07449854 19.9473216,6.94732158 19.8535534,6.85355339 L17,4 Z M17,11 L7,11 L7,4 L17,4 L17,11 Z" fill="currentColor" fill-rule="nonzero"/>
                                            <rect fill="currentColor" opacity="0.3" x="12" y="4" width="3" height="5" rx="0.5"/>
                                        </g>
                                    </svg>
                                </span>
                                <span class="indicator-label">
                                    Save
                                </span>
                                <span class="indicator-progress">
                                    Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            </a>
                        </div>
                        <div class="menu menu-column menu-gray-600 menu-state-bg fw-semibold w-50px" data-kt-menu="true">
                            <button type="button" class="btn btn-primary btn-sm" style="border-top-left-radius: 0; border-bottom-left-radius: 0" data-kt-menu-trigger="click" data-kt-menu-placement="right-start">
                                <span class="svg-icon svg-icon-primary svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                            <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999) "/>
                                        </g>
                                    </svg>
                                </span>
                                <div class="menu-sub menu-sub-dropdown p-3 ">
                                    <div class="menu-item">
                                        <a href="#" class="menu-link px-1 py-3" id="export-submissions">
                                            <span class="svg-icon svg-icon-2">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="#009ef7"></rect>
                                                    <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="#009ef7"></path>
                                                    <path opacity="0.3" d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="#009ef7"></path>
                                                </svg>
                                            </span>
                                            Export CSV
                                        </a>
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
                <div id="submissions"></div>
            </div>
            <!--end::Card body-->
        </div>
    </div>
    <!--end::Content-->
</div>
@endsection
@push('modals')
    <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Edit</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="col">
                        <div class="fv-row mb-7">
                            @php
                                $filteredSc = array_filter(json_decode($scUsers), function($item) use ($ids_user) {
                                    if (!App\Repositories\UsersRepositories::isAdmin()) {
                                        return $ids_user->contains($item->id_senior_consultant);
                                    } else {
                                        return $item;
                                    }
                                });
                            @endphp
                            <select class="form-select form-select-solid" data-control="select2" id="id_senior_consultant_edit" data-placeholder="Select a senior consultant" data-allow-clear="true" data-dropdown-parent="#kt_modal_1">
                                @foreach($filteredSc as $sc)
                                    <option value="{{ $sc->id_senior_consultant }}">{{ $sc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7">
                            @php
                                $filteredC = array_filter(json_decode($cUsers), function($item) use ($ids_user) {
                                    if (!App\Repositories\UsersRepositories::isAdmin()) {
                                        return $ids_user->contains($item->id_consultant);
                                    } else {
                                        return $item;
                                    }
                                });
                            @endphp
                            <select class="form-select form-select-solid" data-control="select2" id="id_consultant_edit" data-placeholder="Select a consultant" data-allow-clear="true" data-dropdown-parent="#kt_modal_1">
                                @foreach ($filteredC as $c)
                                    <option value="{{ $c->id_consultant }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7">
                            @php
                                $filteredLds = array_filter(json_decode($LDSUsers), function($item) use ($ids_user) {
                                    if (!App\Repositories\UsersRepositories::isAdmin()) {
                                        return $ids_user->contains($item->id_lds);
                                    } else {
                                        return $item;
                                    }
                                });
                            @endphp
                            <select class="form-select form-select-solid" data-control="select2" id="id_lds_edit" data-placeholder="Select a LDS" data-allow-clear="true" data-dropdown-parent="#kt_modal_1">
                                @foreach ($filteredLds as $lds)
                                    <option value="{{ $lds->id_lds }}">{{ $lds->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7">
                            <select class="form-select form-select-solid" data-control="select2" id="id_coordinator_edit" data-placeholder="Select a coordinator" data-allow-clear="true" data-dropdown-parent="#kt_modal_1">
                                @foreach (App\Repositories\UsersRepositories::getUsersCoord() as $coord)
                                    <option value="{{ $coord->id_coordinator }}">{{ $coord->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="text-center pt-15">
                        <button type="button" class="btn btn-primary" onclick="applyChangesTasks()">
                            <span class="indicator-label">Apply</span>
                        </button>
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        window.directories = "";
        window.guides = "";
        window.locations = "";
        window.practices = "";
        window.tasks = [];
        window.statuses = "";
        window.clients = "";
        window.products = "";
        window.owners = "";
        window.years = "";
        window.deadlines = "";
        window.scUsers = "";
        window.cUsers = "";
        window.lDSUsers = "";
        window.coordUsers = "";
        window.orderDirectoriesName = [];
        window.orderGuidesName = [];
        window.orderLocationsName = [];
        window.orderPracticesName = [];
        window.centralPractice = "";
        window.datasets = [];
        window.myChart;
        window.colorsHex = [];
        window.chartTitle = "";
        window.months = [];
        window.monthsAD = [];

        $( document ).ready(function(){
            var isAdmin = {!! json_encode(App\Repositories\UsersRepositories::isAdmin()) !!};
            var ids_user = {!! $ids_user !!}
            directories = {!! $directories !!};
            guides = {!! $guides !!};
            locations = {!! $locations !!};
            practices = {!! $practices !!};
            clients = {!! $clients !!};
            products = {!! $products !!};
            owners = {!! $owners !!};
            years = {!! $years !!};
            deadlines = {!! $deadlines !!};
            scUsers = {!! $scUsers !!};
            cUsers = {!! $cUsers !!};
            lDSUsers = {!! $LDSUsers !!};

            if(!isAdmin){
                scUsers.forEach((user, index) => {
                    if (!ids_user.includes(user.id_senior_consultant) && index != 0) {
                        user.disabled = true;
                    } else if(ids_user.length == 0){
                        user.disabled = true;
                    }
                });
                cUsers.forEach((user, index) => {
                    if (!ids_user.includes(user.id_consultant) && index != 0) {
                        user.disabled = true;
                    } else if(ids_user.length == 0){
                        user.disabled = true;
                    }
                });

                lDSUsers.forEach((user, index) => {
                    if (!ids_user.includes(user.id_lds) && index != 0) {
                        user.disabled = true;
                    } else if(ids_user.length == 0){
                        user.disabled = true;
                    }
                });
            }

            coordUsers = {!! $CoordUsers !!};
            statuses = {!! $statuses !!};
            var roles = {!! $roles !!};
            var scReadOnly = true;
            var cReadOnly = true;
            var ldsReadOnly = true;
            var coordReadOnly = true;
            roles.forEach(function(role) {
                switch (role) {
                    case 'client_owner':
                        scReadOnly = false;
                        cReadOnly = false;
                        ldsReadOnly = false;
                        break;
                    case 'senior_consultant':
                        cReadOnly = false;
                        ldsReadOnly = false;
                        break;
                    case 'head_of_coordination':
                        coordReadOnly = false;
                        break;
                    case 'admin':
                        scReadOnly = false;
                        cReadOnly = false;
                        ldsReadOnly = false;
                        coordReadOnly = false;
                        break;
                    case 'lds':
                        cReadOnly = false;
                        ldsReadOnly = false;
                        break;
                }
            });

            for (let i = 0; i <= 11; i++) {
                let date = moment().startOf('year').add(i, 'months');
                let monthNumber = date.format('MM');
                let monthName = date.format('MMMM');
                months.push({ deadline: monthNumber, name: monthName });
                monthsAD.push({ agreed_deadline: monthNumber, name: monthName });
            }

            $('#id_senior_consultant_edit').prop('disabled', scReadOnly);
            $('#id_consultant_edit').prop('disabled', cReadOnly);
            $('#id_lds_edit').prop('disabled', ldsReadOnly);
            $('#id_coordinator_edit').prop('disabled', coordReadOnly);

            filteringMode('id_client', 'ids_client');
            filteringMode('id_senior_consultant', 'ids_senior_consultant');
            filteringMode('id_coordinator', 'ids_coordinator');
            filteringMode('id_directory', 'ids_directory');
            filteringMode('id_guide', 'ids_guide');
            filteringMode('id_consultant', 'ids_consultant');
            filteringMode('id_location', 'ids_location');
            filteringMode('id_owner', 'ids_owner');
            filteringMode('id_lds', 'ids_lds');
            filteringMode('month', 'ids_month');
            filteringMode('deadline', 'deadline');
            filteringMode('year', 'year');
            filteringMode('status', 'ids_status');
            filteringMode('id_months_ad', 'ids_months_ad');

            $("#group_by").on('change', function(e){
                e.preventDefault();
                if($(this).val()){
                    updateUrlParams('groupBy', $(this).val());
                    filterGraph($(this).val());
                }
            })

            $('#edit-data').on('click', function(e){
                e.preventDefault();
                $('#id_senior_consultant_edit').val('').trigger('change');
                $('#id_consultant_edit').val('').trigger('change');
                $('#id_lds_edit').val('').trigger('change');
                $('#id_coordinator_edit').val('').trigger('change');
                $('#kt_modal_1').modal('show');
            });

            var MyDateField = function(config) {
                jsGrid.Field.call(this, config);
            };

            MyDateField.prototype = new jsGrid.Field({
                sorter: function(date1, date2) {
                    return new Date(date1) - new Date(date2);
                },

                itemTemplate: function (value) {
                    if(value){
                        if (value.toLowerCase().indexOf("Date") == -1) {
                            return moment(new Date(value).toISOString()).utc().format('DD/MM/YYYY');
                        } else {
                            value = new Date(parseInt(value.substr(6)));
                            dt = new Date(value);//.toDateString();
                            var yr = dt.getFullYear();
                            //getMonth starts with Jan as month '0' - adding 1 to month for correct display
                            var month = dt.getMonth() + 1;
                            month = month < 10 ? '0' + month : month;
                            //var month = dt.getMonth() < 10 ? '0' + dt.getMonth() : dt.getMonth();
                            var day = dt.getDate() < 10 ? '0' + dt.getDate() : dt.getDate();
                            newDate = month + '/' + day + '/' + yr;
                            //return dt;
                            return newDate;
                        }
                    }

                },
                insertTemplate: function(value) {
                    return this._insertPicker = $("<input>").datepicker({ defaultDate: new Date(), readOnly: true });
                },
                editTemplate: function(value) {
                    let date = value;
                    if(value){
                        date = moment(new Date(value).toISOString()).utc().format('DD/MM/YYYY');
                    }
                    var input = $("<input>").datepicker({
                        dateFormat: 'dd/mm/yy',
                        beforeShow: function(input, inst) {
                            inst.dpDiv.addClass("hide-datepicker");
                        }
                    }).datepicker("setDate", date).prop("readonly", true);

                    input.on("focus", function() {
                        $(this).blur();
                    });

                    this._editPicker = input;
                    return input;

                    // return this._editPicker = $("<input>").datepicker({ dateFormat: 'dd/mm/yy'}).datepicker("setDate", date);
                },
                insertValue: function() {
                    return this._insertPicker.datepicker("getDate").toISOString();
                },
                editValue: function() {
                    if(this._editPicker.datepicker("getDate")){
                        return moment(this._editPicker.datepicker("getDate").toISOString()).utc().format('YYYY-MM-DD');
                    }  else {
                        return "";
                    }
                }
            });

            jsGrid.fields.myDateField = MyDateField;

            var ctx = document.getElementById('kt_chartjs_2');
            // Define fonts
            var fontFamily = KTUtil.getCssVariableValue('--bs-font-sans-serif');
            // Chart labels
            const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            // Chart data
            const data = {
                labels: labels,
                datasets: datasets
            };

            // Chart config
            const config = {
                type: 'line',
                data: data,
                options: {
                    plugins: {
                        title: {
                            display: true,
                            text: chartTitle
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
                        }

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
            var on = false;
            // grid tasks
            $("#submissions").jsGrid({
                width: "100%",
                height: "auto",
                filtering: false,
                inserting: false,
                editing: true,
                sorting: true,
                paging: true,
                autoload: true,
                pageSize: 20,

                controller: {
                    loadData: function(filter) {
                        var d = $.Deferred();
                           if(tasks.length>0){
                                return $.grep(tasks, function(item) {
                                    var date = null;
                                    if(item.deadline){
                                        date = moment(item.deadline).format("MM");
                                    }
                                    var agreedDate = null;
                                    if(item.agreed_deadline){
                                        agreedDate = moment(item.agreed_deadline).format("MM");
                                    }

                                    return (!filter.ids_directory || filter.ids_directory.indexOf(item.id_directory) > -1)
                                        && (!filter.ids_guide ||  filter.ids_guide.indexOf(item.id_guide) > -1)
                                        && (!filter.ids_location ||  filter.ids_location.indexOf(item.id_location) > -1)
                                        && (!filter.ids_client || filter.ids_client.indexOf(item.id_client) > -1)
                                        && (!filter.deadline || item.deadline.indexOf(filter.deadline) > -1)
                                        && (!filter.year || item.year.indexOf(filter.year) > -1)
                                        && (!filter.ids_owner || filter.ids_owner.indexOf(item.owner) > -1)
                                        && (!filter.ids_senior_consultant || filter.ids_senior_consultant.indexOf(item.id_senior_consultant) > -1)
                                        && (!filter.ids_consultant || filter.ids_consultant.indexOf(item.id_consultant) > -1)
                                        && (!filter.ids_lds || filter.ids_lds.indexOf(item.id_lds) > -1)
                                        && (!filter.ids_coordinator || filter.ids_coordinator.indexOf(item.id_coordinator) > -1)
                                        && (!filter.ids_statuses || filter.ids_statuses.indexOf(item.id_status) > -1)
                                        && (!filter.months || filter.months.indexOf(date) > -1)
                                        && (!filter.ids_months_ad || filter.ids_months_ad.indexOf(agreedDate) > -1);
                                });
                            } else {
                            
                                $.ajax({
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                    type: "GET",
                                    url: "{{ route('get-tasks-from-allocation') }}",
                                    data: "",
                                    contentType: "application/json; charset=utf-8",
                                    dataType: "json"
                                }).done(function(response) {
                                    response.sort(function(a, b) {
                                        return a.id_practice - b.id_practice;
                                    });
                                    tasks.length = 0;
                                    tasks.push.apply(tasks, response);
                                    const filteredGuides = guides.filter((item, index, self) =>
                                        index === self.findIndex((t) => t.name === item.name)
                                    );
                                    createSearchFilter(tasks, clients, 'id_client', 'id_client');
                                    createSearchFilter(tasks, directories, 'id_directory', 'id_directory');
                                    createSearchFilter(tasks, filteredGuides, 'id_guide', 'id_guide');
                                    createSearchFilter(tasks, owners, 'id_owner', 'owner');
                                    createSearchFilter(tasks, scUsers, 'id_senior_consultant', 'id_senior_consultant');
                                    createSearchFilter(tasks, cUsers, 'id_consultant', 'id_consultant');
                                    createSearchFilter(tasks, lDSUsers, 'id_lds', 'id_lds');
                                    createSearchFilter(tasks, coordUsers, 'id_coordinator', 'id_coordinator');
                                    createSearchFilter(tasks, statuses, 'status', 'id_status');
                                    createYearFilter(tasks, years, 'year', 'year');
                                    createYearFilter(tasks, deadlines, 'deadline', 'deadline');
                                    createSearchFilter(tasks, locations, 'id_location', 'id_location');
                                    updateDeadlineFilter(tasks, months, 'month', 'deadline');
                                    updateDeadlineFilter(tasks, monthsAD, 'id_months_ad', 'agreed_deadline');
                                    d.resolve(response);

                                    on = true;
                                });
                            }
                        return d.promise();
                    },

                    insertItem: function(item){
                        tasks.push(item);
                    },
                },

                fields: [
                    {
                        headerTemplate: function() {
                            return $("<input>").attr("type", "checkbox").attr("id", "selectAllCheckbox")
                        },
                        itemTemplate: function(_, item) {
                            return $("<input>").attr("type", "checkbox").attr("class", "singleCheckbox")
                                    .prop("checked", $.inArray(item, selectedItems) > -1)
                                    .on("click", function (event) {
                                        $(this).is(":checked") ? (selectItem(item), enableDisableBtn(false)) : (unselectItem(item), enableDisableBtn(true));
                                        event.stopPropagation();
                                    });
                        },
                        sorting: false,
                        align: "center",
                        width: 30
                    },
                    { name: "id_status", title: "Status", type: "select", items: statuses, valueField: "id_status", textField: "name", width: 100, align: 'left', readOnly: true,
                        itemTemplate: function(value, item) {
                            return $.grep(statuses, function(o) {
                                return o.id_status == value;
                            })[0].name;
                        }
                    },
                    { name: "id_client", title: "Client", type: "select", items: clients, valueField: "id_client", textField: "name", width: 150, align: 'left', readOnly: true,  sorting: true

                    },
                    { name: "id_product", title: "Type", type: "select", items: products, valueField: "id_product", textField: "name", width: 150, align: 'left', readOnly: true,
                        itemTemplate: function(item) {
                            let result = $.grep(products, function(product) {
                                return product.id_product == item;
                            });
                            if (result.length > 0) {
                                return result[0].name;
                            }
                        },
                    },
                    { name: "id_directory", title: "Directory", type: "select", items: directories, valueField: "id_directory", textField: "name", width: 150, align: 'left', readOnly: true,
                        itemTemplate: function(item) {
                            return $.grep(directories, function(directory) {
                                return directory.id_directory == item;
                            })[0].name;
                        },
                    },
                    { name: "year", title: "Year", type: "select", items: years, valueField: "year", textField: "name", width: 100, align: 'right', readOnly: true,},
                    { name: "id_guide", title: "Guide", type: "select", items: guides, valueField: "id_guide", textField: "name", validate: "required", autosearch: true, width: 150, align: 'left', readOnly: true,
                        itemTemplate: function(item) {
                            let result = $.grep(guides, function(guide) {
                                return guide.id_guide == item;
                            });

                            if (result.length > 0) {
                                return result[0].name;
                            }
                        },
                    },
                    { name: "id_location", title: "Location", type: "select", items: locations, valueField: "id_location", textField: "name", validate: "required", autosearch: true, width: 150, align: 'left', readOnly: true,
                        itemTemplate: function(item) {
                            let result = $.grep(locations, function(location) {
                                return location.id_location == item;
                            });

                            if (result.length > 0) {
                                return result[0].name;
                            }
                        },
                    },
                    { name: "id_practice", title: "Practice", type: "select", items: practices, valueField: "id_practice", textField: "name", validate: "required", autosearch: true, width: 150, align: 'left', readOnly: true,
                        itemTemplate: function(item) {
                            return $.grep(practices, function(practice) {
                                return practice.id_practice == item;
                            })[0].name;
                        },
                    },
                    { name: "agreed_deadline", title: "Agreed Deadline", type: "myDateField", width: 100, align: "center", readOnly: true},
                    { name: "deadline", title: "Directory Deadline", type: "myDateField", width: 100, align: "center", readOnly: true},
                    {
                        name: 'confirmed', type: "checkbox", title: "Confirmed", sorting: true, align: "center", width: 80, autosearch: false, editing: false,
                    },
                    { name: "owner", title: "Owner", type: "select", items: owners, valueField: "owner", textField: "name", autosearch: true, width: 150, align: 'left', readOnly: true,
                        itemTemplate: function(item) {
                            let result = $.grep(owners, function(owner) {
                                return owner.owner == item;
                            });

                            if (result.length > 0) {
                                return result[0].name;
                            }
                        },
                    },
                    { name: "id_senior_consultant", title: "SC", type: "select", items: scUsers, valueField: "id_senior_consultant", textField: "name", autosearch: true, width: 150, align: 'left',
                        itemTemplate: function(item) {
                            let result = $.grep(scUsers, function(sc) {
                                return sc.id_senior_consultant == item;
                            });
                            if (result.length > 0) {
                                return result[0].name;
                            }
                        },
                        editTemplate: function(value, item) {
                            let $select = $("<select>");

                            $.each(scUsers, function(i, sc) {
                                let $option = $("<option>").attr("value", sc.id_senior_consultant).text(sc.name);
                                if (value == sc.id_senior_consultant) {
                                    $option.attr("selected", "selected");
                                }
                                if (sc.disabled) {
                                    $option.addClass("hidden"); // ocultar la opción en lugar de deshabilitarla
                                }
                                $select.append($option);
                            });
                            $select.prop("disabled", scReadOnly);
                            this.editControl = $select; // Asigna $select a la propiedad editControl

                            return $select;
                        }

                    },
                    { name: "id_consultant", title: "Consultant", type: "select", items: cUsers, valueField: "id_consultant", textField: "name", autosearch: true, width: 150, align: 'left',
                        itemTemplate: function(item) {
                            let result = $.grep(cUsers, function(c) {
                                return c.id_consultant == item;
                            });

                            if (result.length > 0) {
                                return result[0].name;
                            }
                        },
                        editTemplate: function(value, item) {
                            let $select = $("<select>");
                            $.each(cUsers, function(i, c) {
                                let $option = $("<option>").attr("value", c.id_consultant).text(c.name);
                                if (value == c.id_consultant) {
                                    $option.attr("selected", "selected");
                                }
                                if (c.disabled) {
                                    $option.addClass("hidden"); // ocultar la opción en lugar de deshabilitarla
                                }
                                $select.append($option);
                            });

                            $select.prop("disabled", cReadOnly);
                            this.editControl = $select; // Asigna $select a la propiedad editControl
                            return $select;
                        },
                        // editValue: function($editControl, item) {
                        //     var selectedValue = this.editControl.val();
                        //     return selectedValue;
                        // },
                    },
                    { name: "id_lds", title: "LDS", type: "select", items: lDSUsers, valueField: "id_lds", textField: "name", autosearch: true, width: 150, align: 'left',
                        itemTemplate: function(item) {
                            let result = $.grep(lDSUsers, function(lds) {
                                return lds.id_lds == item;
                            });

                            if (result.length > 0) {
                                return result[0].name;
                            }
                        },
                        editTemplate: function(value, item) {
                            let $select = $("<select>");
                            $.each(lDSUsers, function(i, lds) {
                                let $option = $("<option>").attr("value", lds.id_lds).text(lds.name);
                                if (value == lds.id_lds) {
                                    $option.attr("selected", "selected");
                                }
                                if (lds.disabled) {
                                    $option.addClass("hidden"); // ocultar la opción en lugar de deshabilitarla
                                }
                                $select.append($option);
                            });
                            $select.prop("disabled", ldsReadOnly);
                            this.editControl = $select; // Asigna $select a la propiedad editControl
                            return $select;
                        },
                        // editValue: function($editControl, item) {
                        //     var selectedValue = this.editControl.val();
                        //     return selectedValue;
                        // },
                    },
                    { name: "id_coordinator", title: "Coordinator", type: "select", items: coordUsers, valueField: "id_coordinator", textField: "name", autosearch: true, width: 150, align: 'left', readOnly:coordReadOnly,
                        itemTemplate: function(item) {
                            let result = $.grep(coordUsers, function(coord) {
                                return coord.id_coordinator == item;
                            });

                            if (result.length > 0) {
                                return result[0].name;
                            }
                        },
                    },
                    { name: "id_task", valueField: "id_task", width: 0, visible: false},
                    { type: "control", deleteButton: false}
                ],

                onItemUpdated: function(args){
                    //formatear un valor antes de visualizar en la edicion
                    if(args.item.id_task != null){
                        args.item.action = 'update';
                    }
                },
                onRefreshed: function(grid) {
                    if (grid.grid._sortField) {
                        let sortBy = grid.grid._sortField.valueField;
                        if(grid.grid._sortField.valueField == undefined){
                            sortBy = grid.grid._sortField.name;
                        }
                        updateUrlParams('sortBy', sortBy);
                        updateUrlParams('order', grid.grid._sortOrder);
                    }
                }
            });

            //Start select checkbox functionality
            var selectedItems = [];
            var selectItem = function(item) {
                item.check = true;
                selectedItems.push(item);
            };
            var unselectItem = function(item) {
                item.check = false;
                selectedItems = $.grep(selectedItems, function(i) {
                    return i !== item;
                });
            };

            $("#selectAllCheckbox").click(function() {
                var grid = $("#submissions").jsGrid("option", "data");

                if(this.checked) { // check select status
                    $('.singleCheckbox').each(function() {
                        this.checked = true;
                    });

                    grid.map(function(item) {
                        selectItem(item);
                    });
                    enableDisableBtn(false);
                }else {
                    $('.singleCheckbox').each(function() {
                        this.checked = false;
                    });

                    grid.map(function(item) {
                        unselectItem(item);
                    });
                    enableDisableBtn(true);
                }
            });

            $('.update-tasks').on('click', function(e){
                e.preventDefault();

                var filteredData = tasks.filter(function (item) {
                    return (item.action == "update");
                }).map(function(item){
                    return {
                        'id_task': item.id_task,
                        'id_senior_consultant': item.id_senior_consultant,
                        'id_consultant': item.id_consultant,
                        'id_lds': item.id_lds,
                        'id_coordinator': item.id_coordinator
                    };
                });

                if(filteredData.length == 0){
                    toastrAlert("warning", 'No data to save')
                }else{
                    var idBtn = document.querySelector("#save-allocation");
                    idBtn.setAttribute("data-kt-indicator", "on");
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        method: 'post',
                        data: JSON.stringify({filteredData:filteredData}),
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        traditional: true,
                        url: '{{ route('update-submissions') }}',
                        success:function(response){
                            toastrAlert("success", "Successfully updated");
                            tasks.length = 0;
                            tasks.push.apply(tasks, response.data);
                            $("#selectAllCheckbox").prop("checked", false);
                            $('#edit-data').addClass('disabled');
                            $("#submissions").jsGrid("loadData");
                            searchGrid();
                            idBtn.removeAttribute("data-kt-indicator");
                        },
                        error: function(xhr) {
                            if (xhr.status === 419) {
                                window.location.reload();
                            }
                        },
                    });
                }
            });

            $('.clear-filters').on('click', function(e){
                e.preventDefault();
                $('#id_client').val('').trigger('change');
                $('#id_directory').val('').trigger('change');
                $('#id_senior_consultant').val('').trigger('change');
                $('#id_coordinator').val('').trigger('change');
                $('#id_guide').val('').trigger('change');
                $('#id_consultant').val('').trigger('change');
                $('#year').val('').trigger('change');
                $('#month').val('').trigger('change');
                $('#id_months_ad').val('').trigger('change');
                $('#id_owner').val('').trigger('change');
                $('#id_lds').val('').trigger('change');
                $('#id_location').val('').trigger('change');
                updateUrlParams('ids_client', '');
                updateUrlParams('ids_directory', '');
                updateUrlParams('ids_senior_consultant', '');
                updateUrlParams('ids_coordinator', '');
                updateUrlParams('ids_guide', '');
                updateUrlParams('ids_consultant', '');
                updateUrlParams('year', '');
                updateUrlParams('ids_month', '');
                updateUrlParams('ids_owner', '');
                updateUrlParams('ids_lds', '');
                updateUrlParams('ids_location', '');
                updateUrlParams('ids_months_ad', '');
                searchGrid();
            });

            //Export table
            $("#export-submissions").click(function (e) {
                e.preventDefault();
                var data = $('#submissions').jsGrid('option', 'data');
                JSONToCSVConvertor(data, "Submissions", true);
            });


            getColors();
            var t = setInterval(oneSecondFunction,1000);
            function oneSecondFunction() {
                if(on == true){
                    clearInterval(t);
                    searchGrid('', 'initial');
                }
            }
        });


        function initialFilter()
        {
            function formatValues(string){
                let stringArray = string.split(",");
                return stringArray.map(Number);
            }

            var grid = $("#submissions").data('JSGrid');
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);

            let urlClient = urlParams.get('ids_client');
            let ids_client = urlClient ? formatValues(urlClient) : [];

            let urlSc = urlParams.get('ids_senior_consultant');
            let ids_sc = urlSc ? formatValues(urlSc) : [];

            let urlDirectory = urlParams.get('ids_directory');
            let ids_directory = urlDirectory ? formatValues(urlDirectory) : [];

            let urlGuide = urlParams.get('ids_guide');
            let ids_guide = urlGuide ? formatValues(urlGuide) : [];

            let urlOwner = urlParams.get('ids_owner');
            let ids_owner = urlOwner ? formatValues(urlOwner) : [];

            let urlConsultant = urlParams.get('ids_consultant');
            let ids_consultant = urlConsultant ? formatValues(urlConsultant) : [];

            let urlLds = urlParams.get('ids_lds');
            let ids_lds = urlLds ? formatValues(urlLds) : [];

            let urlCoord = urlParams.get('ids_coordinator');
            let ids_coordinator = urlCoord ? formatValues(urlCoord) : [];

            let urlStatus = urlParams.get('ids_status');
            let ids_status = urlStatus ? formatValues(urlStatus) : [1, 2, 3];

            let urlMonth = urlParams.get('ids_month');
            let ids_month = urlMonth ? urlMonth.split(",") : [];

            let urlDeadline = urlParams.get('deadline') ?? new Date().getFullYear();
            let deadline = urlDeadline;

            //let urlYear = urlParams.get('year') ?? new Date().getFullYear() + 1;
            let year = ""

            let urlLocation = urlParams.get('ids_location');
            let ids_location = urlLocation ? formatValues(urlLocation) : [];

            let urlMonthAD = urlParams.get('ids_months_ad');
            let idsMonthAD = urlMonthAD ? urlMonthAD.split(",") : [];

            const params = getOrderBy();
            let sortBy = params.sortBy ? params.sortBy  : 'agreed_deadline';
            updateUrlParams('sortBy', sortBy);

            let order = params.order ? params.order : 'asc';
            updateUrlParams('order', order);

            let urlGroupBy = urlParams.get('groupBy');
            let groupBy = urlGroupBy ? urlGroupBy : 'id_senior_consultant';
            updateUrlParams('groupBy', groupBy);

            updateUrlParams('year', year);

            updateUrlParams('deadline', deadline);

            $("#group_by").val(groupBy).trigger('change');
            $('#deadline').val(deadline).trigger('change');
            $('#year').val(year).trigger('change');
            $('#id_client').val(ids_client).trigger('change');
            $('#id_senior_consultant').val(ids_sc).trigger('change');
            $('#id_coordinator').val(ids_coordinator).trigger('change');
            $('#id_consultant').val(ids_consultant).trigger('change');
            $('#id_owner').val(ids_owner).trigger('change');
            $('#id_lds').val(ids_lds).trigger('change');
            $('#id_directory').val(ids_directory).trigger('change');
            $('#id_guide').val(ids_guide).trigger('change');
            $('#status').val(ids_status).trigger('change');
            $('#month').val(ids_month).trigger('change');
            $('#id_location').val(ids_location).trigger('change');
            $('#id_months_ad').val(idsMonthAD).trigger('change');

            var fields = {
                year : year,
                deadline : deadline,
                ids_sc : ids_sc,
                ids_client :ids_client,
                ids_directory : ids_directory,
                ids_guide : ids_guide,
                ids_owner : ids_owner,
                ids_consultant : ids_consultant,
                ids_lds : ids_lds,
                ids_coordinator : ids_coordinator,
                ids_statuses : ids_status,
                ids_month : ids_month,
                groupBy : groupBy,
                ids_location: ids_location,
                ids_months_ad : idsMonthAD,
            };

            return fields;
        }

        function updateUrlParams(filter, values)
        {
            const url = new URL(window.location.href);
            url.searchParams.set([filter], values);
            window.history.replaceState(null, null, url.href);
        }

        function applyChangesTasks()
        {
            var grid = $("#submissions").jsGrid("option", "data");
            var filteredData = grid.filter(function (item) {
                return (item.check == true);
            });
            if(filteredData.length == 0){
                toastrAlert("error", 'Select the rows to edit');
                return;
            }

            if(!$('#id_senior_consultant_edit').val() && !$('#id_consultant_edit').val() && !$('#id_lds_edit').val() && !$('#id_coordinator_edit').val())
            {
                toastrAlert("error", 'Select the one data to apply');
                return;
            }

            tasks.filter(function (item) {
                return (item.check == true);
            }).map(function(element){
                if($('#id_senior_consultant_edit').val()){
                    element.id_senior_consultant = parseInt($('#id_senior_consultant_edit').val());
                }
                if($('#id_consultant_edit').val()){
                    element.id_consultant = parseInt($('#id_consultant_edit').val());
                }
                if($('#id_lds_edit').val()){
                    element.id_lds = parseInt($('#id_lds_edit').val());
                }
                if($('#id_coordinator_edit').val()){
                    element.id_coordinator = parseInt($('#id_coordinator_edit').val());
                }
                element.action = 'update';
            });

            grid.map(function(element){
                if(element.check == true){
                    if($('#id_senior_consultant_edit').val()){
                        element.id_senior_consultant = parseInt($('#id_senior_consultant_edit').val());
                    }
                    if($('#id_consultant_edit').val()){
                        element.id_consultant = parseInt($('#id_consultant_edit').val());
                    }
                    if($('#id_lds_edit').val()){
                        element.id_lds = parseInt($('#id_lds_edit').val());
                    }
                    if($('#id_coordinator_edit').val()){
                        element.id_coordinator = parseInt($('#id_coordinator_edit').val());
                    }
                    element.action = 'update';
                }
            });

            $("#submissions").jsGrid("refresh");
            $('#kt_modal_1').modal('hide');
        }

        function createSearchFilter(data, models, id_select_search, id)
        {
            let ids_item_init = data.map(function(item){//filtrar las task por el id
                return item[id];
            });

            let id_selected = $('#'+id_select_search).val();

            $('#'+id_select_search).empty();

            if(id_select_search == 'id_owner' || id_select_search == 'id_senior_consultant' || id_select_search == 'id_consultant' || id_select_search == 'id_lds' || id_select_search == 'id_coordinator'){
                var blank = new Option('Blank', 0, false, false);
                $('#'+id_select_search).append(blank);
            }

            $.grep(models, function(model) {//buscamos si existe en el array
                return $.inArray(model[id], ids_item_init) > -1;
            }).forEach(function(item){
                var newOption = new Option(item.name, item[id], false, false);
                $('#'+id_select_search).append(newOption);
            });

            $('#'+id_select_search).val(id_selected);
        }
        function updateDeadlineFilter(data, models, id_updated, id_filter, ids)
        {
            $('#'+id_updated).empty();
            let dates = data.map(function(item){
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

            if([ids].length>0){
                $('#'+id_updated).val(ids);
            }
        }

        function createYearFilter(tasks, models, id_select_search, id)
        {
            let id_selected = $('#'+id_select_search).val();
            $('#'+id_select_search).empty();

            models.forEach(function(item){
                var newOption = new Option(item.name, item[id], false, false);
                $('#'+id_select_search).append(newOption);
            });

            $('#'+id_select_search).val(id_selected);
        }

        function searchGrid(names, from, monthName, isGraph)
        {
            var grid = $("#submissions").data('JSGrid');
            grid.loadData();

            var year = "";
            var deadline = "";
            var ids_sc = "";
            var ids_client = "";
            var ids_directory = "";
            var ids_guide = "";
            var ids_owner = "";
            var ids_consultant = "";
            var ids_lds = "";
            var ids_coordinator = "";
            var ids_statuses = "";
            var ids_month = "";
            var groupBy = "";
            var ids_months_ad = "";

            if(from && from == 'initial'){
                fields = initialFilter();
                year = fields.year;
                deadline = fields.deadline;
                ids_sc = fields.ids_sc;
                ids_client = fields.ids_client;
                ids_directory = fields.ids_directory;
                ids_guide = fields.ids_guide;
                ids_owner = fields.ids_owner;
                ids_consultant = fields.ids_consultant;
                ids_lds = fields.ids_lds;
                ids_coordinator = fields.ids_coordinator;
                ids_statuses = fields.ids_statuses;
                ids_month = fields.ids_month;
                groupBy = fields.groupBy;
                ids_location = fields.ids_location;
                ids_months_ad = fields.ids_months_ad;
            } else {
                year = $('#year').val();
                deadline = $('#deadline').val();
                ids_sc = $('#id_senior_consultant').val();
                ids_client = $('#id_client').val();
                ids_directory = $('#id_directory').val();
                ids_guide = $('#id_guide').val();
                ids_owner = $('#id_owner').val();
                ids_consultant = $('#id_consultant').val();
                ids_lds = $('#id_lds').val();
                ids_coordinator = $('#id_coordinator').val();
                ids_statuses = $('#status').val();
                ids_month = $('#month').val();
                groupBy = $('#group_by').val();
                ids_location = $('#id_location').val();
                ids_months_ad = $('#id_months_ad').val();
            }

            if(from && from == 'userNames'){//filtro desde las leyendas
                if(groupBy == 'id_senior_consultant'){
                    ids_sc = scUsers.filter(function(sc){
                        if($.inArray(sc.name, names) > -1){
                            return sc;
                        }
                    }).map(sc=>sc.id_senior_consultant);

                    if($.inArray('Unassigned', names) > -1){
                        ids_sc.push(0);
                    }

                    $('#id_senior_consultant').val(ids_sc).trigger('change');
                    updateUrlParams('ids_senior_consultant', ids_sc);
                }

                if(groupBy == 'id_consultant'){
                    ids_consultant = cUsers.filter(function(c){
                        if($.inArray(c.name, names) > -1){
                            return c;
                        }
                    }).map(c=>c.id_consultant);

                    if($.inArray('Unassigned', names) > -1){
                        ids_consultant.push(0);
                    }

                    $('#id_consultant').val(ids_consultant).trigger('change');
                    updateUrlParams('ids_consultant', ids_consultant);
                }

                if(groupBy == 'id_lds'){
                    ids_lds = lDSUsers.filter(function(lds){
                        if($.inArray(lds.name, names) > -1){
                            return lds;
                        }
                    }).map(lds=>lds.id_lds);

                    if($.inArray('Unassigned', names) > -1){
                        ids_lds.push(0);
                    }

                    $('#id_lds').val(ids_lds).trigger('change');
                    updateUrlParams('ids_lds', ids_lds);
                }

                if(groupBy == 'id_coordinator'){
                    ids_coordinator = coordUsers.filter(function(coord){
                        if($.inArray(coord.name, names) > -1){
                            return coord;
                        }
                    }).map(coord=>coord.id_coordinator);

                    if($.inArray('Unassigned', names) > -1){
                        ids_coordinator.push(0);
                    }

                    $('#id_coordinator').val(ids_coordinator).trigger('change');
                    updateUrlParams('ids_coordinator', ids_coordinator);
                }

                if(groupBy == 'owner'){
                    ids_owner = owners.filter(function(ow){
                        if($.inArray(ow.name, names) > -1){
                            return ow;
                        }
                    }).map(ow=>ow.owner);

                    if($.inArray('Unassigned', names) > -1){
                        ids_owner.push(0);
                    }

                    $('#id_owner').val(ids_owner).trigger('change');
                    updateUrlParams('ids_owner', ids_owner);
                }

            }

            if(isGraph){ //filtro la grafica por mes
                let currentMonths = ['01', '02', '03', '04', '05', '06', '07', '08', '09', '10', '11', '12'];
                ids_month = currentMonths;
                if(monthName){
                    ids_month = [moment().month(monthName).format("M").padStart(2, '0')];
                    $('#month').val(ids_month).trigger('change');
                } else {
                    $('#month').val(currentMonths).trigger('change');
                }
            }

            var searchGrid = {};

            if (ids_client.length > 0) {
                searchGrid.ids_client = ids_client.map(Number);
            }
            if (year > 0) {
                searchGrid.year = year;
            }
            if (deadline > 0) {
                searchGrid.deadline = deadline;
            }
            if (ids_directory.length > 0) {
                searchGrid.ids_directory =  ids_directory.map(Number);
            }
            if (ids_guide.length > 0) {
                searchGrid.ids_guide =  ids_guide.map(Number);
            }
            if (ids_owner.length > 0) {
                searchGrid.ids_owner =  ids_owner.map(Number);
            }
            if (ids_sc.length > 0) {
                searchGrid.ids_senior_consultant =  ids_sc.map(Number);
            }
            if (ids_consultant.length > 0) {
                searchGrid.ids_consultant =  ids_consultant.map(Number);
            }
            if (ids_lds.length > 0) {
                searchGrid.ids_lds =  ids_lds.map(Number);
            }
            if (ids_coordinator.length > 0) {
                searchGrid.ids_coordinator =  ids_coordinator.map(Number);
            }
            if (ids_statuses.length > 0) {
                searchGrid.ids_statuses = ids_statuses.map(Number);
            }
            if (ids_month.length > 0) {
                searchGrid.months = ids_month;
            }
            if (ids_location.length > 0) {
                searchGrid.ids_location = ids_location.map(Number);
            }
            if (ids_months_ad.length > 0) {
                searchGrid.ids_months_ad = ids_months_ad;
            }

            const params = getOrderBy();
            grid.search(searchGrid);
            grid.sort({ field: params.sortBy, order: params.order });

            if(!from || from == 'initial'){
                filterGraph(groupBy);
            }
            updateQtyTask(grid);
            updateAllFilter(grid.data);
        }

        function filterGridFromGraph(names, monthName)
        {
            searchGrid(names, 'userNames', monthName, true)
        }

        function filterGridFromGraphBySC(names)
        {
            searchGrid(names, 'userNames');
        }

        function filterGraph(group_by)
        {
            var tasksData = $("#submissions").jsGrid("option", "data");
            var groupArrayObject = tasksData.reduce((group, arr) => {
                const value = arr[group_by];
                group[value] = group[value] ?? [];
                group[value].push(arr);
                return group;
            },{});

            datasets.length = 0;

            // filtered
            let taskFiltered = Object.entries(groupArrayObject);
                taskFiltered.forEach(group => {
                    group[0] = Number(group[0]);
                });

            taskFiltered.forEach(function (a, i) {
                let usersFiltered = [];
                if(group_by == 'id_senior_consultant'){
                    usersFiltered = scUsers.filter(function(user) {
                        return user[group_by] == a[0];
                    });
                    updateChartTitle("Senior Consultant");
                }

                if(group_by == 'id_coordinator'){
                    usersFiltered = coordUsers.filter(function(user) {
                        return user[group_by] == a[0];
                    });
                    updateChartTitle("Coordinator");
                }

                if(group_by == 'id_consultant'){
                    usersFiltered = cUsers.filter(function(user) {
                        return user[group_by] == a[0];
                    });
                    updateChartTitle("Consultant");
                }

                if(group_by == 'owner'){
                    usersFiltered = owners.filter(function(user) {
                        return user[group_by] == a[0];
                    });
                    updateChartTitle("Owner");

                }

                if(group_by == 'id_lds'){
                    usersFiltered = lDSUsers.filter(function(user) {
                        return user[group_by] == a[0];
                    });
                    updateChartTitle("LDS");
                }

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

                if(usersFiltered && usersFiltered.length>0 && usersFiltered[0][group_by]){
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

            myChart.update();
        }

        function updateAllFilter(data)
        {
            if($("#id_client").val().length<=0){
                createSearchFilter(data, clients, 'id_client', 'id_client');
            }
            if($("#id_directory").val().length<=0){
                createSearchFilter(data, directories, 'id_directory', 'id_directory');
            }
            if($("#id_senior_consultant").val().length<=0){
                createSearchFilter(data, scUsers, 'id_senior_consultant', 'id_senior_consultant');
            }
            if($("#id_coordinator").val().length<=0){
                createSearchFilter(data, coordUsers, 'id_coordinator', 'id_coordinator');
            }
            if($("#id_guide").val().length<=0){
                createSearchFilter(data, guides, 'id_guide', 'id_guide');
            }
            if($("#id_consultant").val().length<=0){
                createSearchFilter(data, cUsers, 'id_consultant', 'id_consultant');
            }
            if($("#month").val().length<=0){
                updateDeadlineFilter(data, months, "month", "deadline");
            }
            if($("#id_owner").val().length<=0){
                createSearchFilter(data, owners, 'id_owner', 'owner');
            }
            if($("#id_lds").val().length<=0){
                createSearchFilter(data, lDSUsers, 'id_lds', 'id_lds');
            }
            if($("#id_location").val().length<=0){
                createSearchFilter(data, locations, 'id_location', 'id_location');
            }
            if($("#id_months_ad").val().length<=0){
                updateDeadlineFilter(data, monthsAD, "id_months_ad", "agreed_deadline");
            }
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

        function updateQtyTask(grid)
        {
            var filteredRecords = grid.data.length;
            var spanElement = document.getElementById("total-tasks");
            spanElement.textContent = filteredRecords;
        }

        function updateChartTitle(name)
        {
            chartTitle = name;
            return myChart.options.plugins.title.text = 'Count of Practice by Month and ' + chartTitle;
        }

        function filteringMode(id_select, id_url, value)
        {
            var isAllClear = false;

            $('#'+id_select).on('select2:select', function (e) {
                var selectedValues = $(this).val();
                if(selectedValues.length>0){
                    isAllClear = false;
                }
                if(!isAllClear){
                    $('#'+id_select).val($(this).val());
                    searchGrid();
                }
                updateUrlParams(id_url, $(this).val());
            });

            $('#'+id_select).on('select2:unselect', function (e) {
                if(!isAllClear){
                    searchGrid();
                    updateUrlParams(id_url, $(this).val());
                    isAllClear = false;
                }
            });


            $('#'+id_select).on('select2:clear', function (e) {
                isAllClear = true;
                updateUrlParams(id_url, "");
                searchGrid();
            });
        }

    </script>
    <script>
        function enableDisableBtn(status){
            if(status == true){
                var grid = $("#submissions").jsGrid("option", "data");
                var filteredData = grid.filter(function (item) {
                    return (item.check == true);
                });

                if(filteredData.length == 0){
                    $('#edit-data').addClass('disabled');
                }
            } else {
                let edit = document.getElementById("edit-data");
                    edit.classList.remove("disabled");
            }
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

        function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
            //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
            var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;

            var CSV = '';
            //Set Report title in first row or line

            CSV += ReportTitle + '\r\n';

            //This condition will generate the Label/Header
            if (ShowLabel) {
                var row = "";
                //This loop will extract the label from 1st index of on array
                for (var index in arrData[0]) {
                    //Now convert each value to string and comma-seprated
                    var nameTitle = "";

                    switch (index) {
                        case "id_task":
                            nameTitle = "Id";
                            break;
                        case "id_status":
                            nameTitle = "Status";
                            break;
                        case "id_client":
                            nameTitle = "Client";
                            break;
                        case "id_directory":
                            nameTitle = "Directory";
                            break;
                        case "year":
                            nameTitle = "Year";
                            break;
                        case "id_guide":
                            nameTitle = "Guide";
                            break;
                        case "id_location":
                            nameTitle = "Location";
                            break;
                        case "id_practice":
                            nameTitle = "Practice";
                            break;
                        case "id_product":
                            nameTitle = "Product";
                            break;
                        case "agreed_deadline":
                            nameTitle = "Agreed deadline";
                            break;
                        case "deadline":
                            nameTitle = "Directory Deadline";
                            break;
                        case "confirmed":
                            nameTitle = "Confirmed";
                            break;
                        case "owner":
                            nameTitle = "Owner";
                            break;
                        case "id_senior_consultant":
                            nameTitle = "Senior Consultant";
                            break;
                        case "id_consultant":
                            nameTitle = "consultant";
                            break;
                        case "id_lds":
                            nameTitle = "LDS";
                            break;
                        case "id_coordinator":
                            nameTitle = "Coordinator";
                            break;
                    }
                    if(nameTitle){
                        row += nameTitle + ',';
                    }
                }
                row = row.slice(0, -1);

                //append Label row with line break
                CSV += row + '\r\n';
            }

            //1st loop is to extract each row
            for (var i = 0; i < arrData.length; i++) {
                var row = "";

                //2nd loop will extract each column and convert it in string comma-seprated
                for (var index in arrData[i]) {
                    var idItem = arrData[i][index];
                    var nameItem = "";
                    switch (index) {
                        case "id_task":
                            let newNameItem = 'undefined';
                            if(arrData[i][index]){
                                newNameItem = arrData[i][index];
                            }
                            nameItem = newNameItem;
                            break;

                        case "id_status":
                            nameItem = idItem ? (idItem == null ? "" : (statuses.find(x=>x.id_status == idItem) || {}).name) : 'undefined';
                            break;

                        case "id_client":
                            nameItem = (idItem == null ? "" : clients.find(x => x.id_client == idItem).name).replace(/"/g, '""');
                            break;

                        case "id_directory":
                            nameItem = (idItem == null ? "" : directories.find(x => x.id_directory == idItem).name).replace(/"/g, '""');
                            break;
                        case "year":
                            nameItem = idItem;
                            break;

                        case "id_guide":
                            nameItem = (idItem == null ? "" : guides.find(x => x.id_guide == idItem).name).replace(/"/g, '""');
                            break;

                        case "id_location":
                            nameItem = (idItem == null ? "" : locations.find(x => x.id_location == idItem).name).replace(/"/g, '""');
                            break;

                        case "id_practice":
                            nameItem = (idItem == null ? "" : practices.find(x => x.id_practice == idItem).name).replace(/"/g, '""');
                            break;

                        case "id_product":
                            nameItem = (idItem == null ? "" :  products.find(x => x.id_product == idItem).name).replace(/"/g, '""');
                            break;
                        case "agreed_deadline":
                            let newAgreedDeadlineItem = 'undefined';
                            if (arrData[i][index]) {
                                newAgreedDeadlineItem = arrData[i][index];
                            }
                            nameItem = newAgreedDeadlineItem;
                            break;
                        case "deadline":
                            let newDeadlineItem = 'undefined';
                            if (arrData[i][index]) {
                                newDeadlineItem = arrData[i][index];
                            }
                            nameItem = newDeadlineItem;
                            break;
                        case "confirmed":
                            let newConfirmedItem = 'undefined';
                            if (arrData[i][index]) {
                                newConfirmedItem = arrData[i][index] == 1 ? "TRUE" : "FALSE";
                            }
                            nameItem = newConfirmedItem;
                            break;
                        case "owner":
                            let newOwItem = idItem ? (idItem == null ? "" : (owners.find(x=>x.owner == idItem) || {}).name) : 'undefined';
                            nameItem = newOwItem;
                            break;
                        case "id_senior_consultant":
                            let newSCItem = idItem ? (idItem == null ? "" : (scUsers.find(x=>x.id_senior_consultant == idItem) || {}).name) : 'undefined';
                            nameItem = newSCItem;
                            break;
                        case "id_consultant":
                            let newCItem = idItem ? (idItem == null ? "" : (cUsers.find(x=>x.id_consultant == idItem) || {}).name) : 'undefined';
                            nameItem = newCItem;
                            break;
                        case "id_lds":
                            let newLdsItem = idItem ? (idItem == null ? "" : (lDSUsers.find(x=>x.id_lds == idItem) || {}).name) : 'undefined';
                            nameItem = newLdsItem;
                            break;
                        case "id_coordinator":
                            let newCoordItem = idItem ? (idItem == null ? "" : (coordUsers.find(x=>x.id_coordinator == idItem) || {}).name) : 'undefined';
                            nameItem = newCoordItem;
                            break;
                    }

                    if(nameItem && nameItem != "undefined"){
                        row += '"' + nameItem + '",';
                    }
                    else if(nameItem == "undefined")
                        row += '"",';
                }

                row.slice(0, row.length - 1);

                //add a line break after each row
                CSV += row + '\r\n';
            }

            if (CSV == '') {
                alert("Invalid data");
                return;
            }

            //Generate a file name
            var fileName = "";
            //this will remove the blank-spaces from the title and replace it with an underscore
            fileName += ReportTitle.replace(/ /g, "_");
            //Initialize file format you want csv or xls
            var uri = 'data:text/csv;charset=utf-8,\uFEFF' + encodeURIComponent(CSV); // Adding UTF-8 BOM character
            //this trick will generate a temp <a /> tag
            var link = document.createElement("a");
            link.href = uri;
            //set the visibility hidden so it will not effect on your web-layout
            link.style = "visibility:hidden";
            link.download = fileName + ".csv";
            //this part will append the anchor tag and remove it after automatic click
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

    </script>
    <script src="{{ URL::asset('admin/js/jsgrid.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@endpush
