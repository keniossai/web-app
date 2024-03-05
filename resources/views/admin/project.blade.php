@extends('layouts.master')

@section('master-title', '')

@push('styles')
    <link href="{{ URL::asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
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
    </style>
@endpush

@section('master-header-buttons')
@endsection

@section('master-content')
    @if ($view == 'create' || $view == 'edit')
        @include('partials.create-project')
    @elseif (isset($project))

        @include('partials.project-header')
        <!--begin::submissions-->
        <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bold"></div>
                @if ($isView == false)
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end pt-5">
                                <a href="mailto:directory@kiddaitken.com?subject=Project assistance: @if(isset($project)) {{ $project->name }} @endif&body=I need assistance with the following project: {{ request()->url() }}%0APlease help with the following: " class="btn btn-sm btn-primary">
                                    <span class="svg-icon svg-icon-primary svg-icon-1x">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3" d="M10 4H21C21.6 4 22 4.4 22 5V7H10V4Z" fill="currentColor"/>
                                            <path d="M9.2 3H3C2.4 3 2 3.4 2 4V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V7C22 6.4 21.6 6 21 6H12L10.4 3.60001C10.2 3.20001 9.7 3 9.2 3Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                    Directory Request
                                </a>
                                &nbsp;
                                <a href="#" id="copy-submission" class="btn btn-sm btn-primary disabled copy-submission">
                                    <span class="svg-icon svg-icon-primary svg-icon-1x">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <rect x="0" y="0" width="24" height="24"/>
                                                <path d="M6,9 L6,15 C6,16.6568542 7.34314575,18 9,18 L15,18 L15,18.8181818 C15,20.2324881 14.2324881,21 12.8181818,21 L5.18181818,21 C3.76751186,21 3,20.2324881 3,18.8181818 L3,11.1818182 C3,9.76751186 3.76751186,9 5.18181818,9 L6,9 Z" fill="currentColor" fill-rule="nonzero"/>
                                                <path d="M10.1818182,4 L17.8181818,4 C19.2324881,4 20,4.76751186 20,6.18181818 L20,13.8181818 C20,15.2324881 19.2324881,16 17.8181818,16 L10.1818182,16 C8.76751186,16 8,15.2324881 8,13.8181818 L8,6.18181818 C8,4.76751186 8.76751186,4 10.1818182,4 Z" fill="currentColor" opacity="0.3"/>
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="indicator-label">
                                        Template
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </a>
                                &nbsp;
                                <a href="#" class="btn btn-sm btn-primary add-record">
                                    <span class="svg-icon svg-icon-1x">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                            <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                        </svg>
                                    </span>
                                    Add
                                </a>
                                &nbsp;
                                <a href="#" id="save-submission" class="btn btn-sm btn-primary save-submissions">
                                    <span class="svg-icon svg-icon-muted svg-icon-1x">
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
                        </div>
                    </div>
                @elseif (App\Repositories\UsersRepositories::isAllowed('read-project'))
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end pt-5">
                                <a href="{{ route('read-project',  ['submissions', 'id' => $project->id_project]) }}" class="btn btn-sm btn-facebook" style="color:white">
                                    Edit Submissions
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            @if (isset($project))
                <div class="card-body pt-2">
                    <div class="py-2">
                        <div class="rounded border p-5">
                            <form class="form pt-2" action="#" id="submission-form">
                                <input id="id_product" value="{{ $project->id_product }}" hidden>
                                <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-4">
                                    <div class="col">
                                        <div class="fv-row mb-7">
                                            @php
                                                $ids_directory = App\Models\Taxonomy::where(['deleted' => 0])->pluck('id_directory');
                                            @endphp
                                            <select class="form-select form-select-solid required" data-control="select2" id="id_directory_select" data-placeholder="Select a directory" data-allow-clear="true" required>
                                                <option></option>
                                                @foreach (App\Models\Directory::whereIn('id_directory', $ids_directory)->where('deleted', 0)->orderBy('name')->get() as $directory)
                                                    <option value="{{ $directory->id_directory }}">{{ $directory->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="fv-row mb-7">
                                            <select class="form-select form-select-solid required" data-control="select2" id="id_guide_select" data-placeholder="Select a guide" data-allow-clear="true">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="fv-row mb-7">
                                            <select class="form-select form-select-solid required" data-control="select2" id="id_location_select" data-placeholder="Select a location" data-allow-clear="true">
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col">
                                        <div class="fv-row mb-7">
                                            <select class="form-select form-select-solid required" data-control="select2" id="id_practice_select" data-placeholder="Select a practice" data-allow-clear="true">
                                            </select>
                                        </div>
                                    </div>
                                    @if (App\Models\Role::where('code', 'admin')->first()->id_role == Auth::user()->id_role && $isView == false)
                                        <label class="fs-6 fw-semibold form-label">
                                            <a href="{{ route('directory-taxonomy') }}" tabindex="-1" class="link-primary" id="url-edit-taxonomy" target="_blank">Edit Taxonomy</a>
                                            <a href="#" tabindex="-1"><i class="las la-eraser fs-3 text-danger clear-url"></i></a>
                                            <a href="#">
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" id="spinner_loading" hidden></span>
                                                <i class="las la-redo-alt fs-3 text-info refresh-taxonomy" id="icon_refresh"></i>
                                            </a>
                                        </label>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>

                    <div style="text-align:end; padding:5px">
                        <span>
                            Submissions
                            <span id="total-tasks" style="">{{ $tasksCount }}</span>
                        </span>
                        &nbsp; &nbsp;
                        <div class="btn-group">
                            @if ($view != 'view')
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
                            @endif
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
                    <div id="submission"></div>
                </div>
            @endif
        </div>
    @endif
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
                    <input id="id_directory" value="" hidden>
                    <div class="col">
                        <div class="mb-7">
                            <input class="form-control form-control-solid" placeholder="Agreed Deadline" id="agreed_deadline" name="agreed_deadline" data-dropdown-parent="#kt_modal_1"/>
                        </div>
                    </div>
                    <div class="col">
                        <div class="mb-7">
                            <input class="form-control form-control-solid" placeholder="Directory Deadline" id="kt_datepicker_10" name="deadline" data-dropdown-parent="#kt_modal_1"/>
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-1">
                        <div class="col">
                            <div class="fv-row mb-7">
                                <select class="form-select form-select-solid" data-control="select2" id="id_product_edit" data-placeholder="Select a Product" data-allow-clear="true" data-dropdown-parent="#kt_modal_1">
                                    <option></option>
                                    @foreach (App\Models\Product::orderBy('name')->get() as $product)
                                        <option value="{{ $product->id_product }}">{{ $product->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-1">
                        <div class="col">
                            @if (isset($project))
                                <div class="fv-row mb-7">
                                    <input class="form-control form-control-solid" value="" id="contacts_name" name="contacts_name" />
                                </div>

                            @endif
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-1">
                        <div class="col">
                            <div class="fv-row mb-7">
                                <select class="form-select form-select-solid" data-control="select2" id="id_statuses" data-placeholder="Select a Status" data-allow-clear="true" data-dropdown-parent="#kt_modal_1">
                                    <option></option>
                                    @foreach (App\Repositories\StatusRepositories::getStatusForClient() as $status)
                                        <option value="{{ $status->id_status }}">{{ $status->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-1">
                        <div class="col">
                            <textarea id="description-status" name="description" placeholder="Comment" class="form-control form-control-solid h-100px" hidden></textarea>
                        </div>
                    </div>
                    <div class="text-center pt-15">
                        <button type="button" class="btn btn-primary" onclick="updateDataSelected()">
                            <span class="indicator-label">Apply</span>
                        </button>
                        <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" id="kt_modal_select_project">
        <div class="modal-dialog modal-dialog-centered mw-500px">
            <div class="modal-content">
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <div class="text-center mb-13 pt-5">
                        <div class="text-muted fw-semibold fs-5">
                            Use a previous client project as a template to import all submissions.
                        </div>
                    </div>
                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-1">
                        <div class="col">
                            <div class="fv-row mb-7">
                                @if (isset($project))
                                    <select class="form-select form-select-solid" data-control="select2" id="id_project_select" data-placeholder="Select a project" data-allow-clear="true" data-dropdown-parent="#kt_modal_select_project">
                                        <option></option>
                                        @foreach (App\Models\Project::where('id_client', $project->id_client)->where('id_project',  '!=', $project->id_project)->where('deleted', 0)->get() as $item)
                                            <option value="{{ $item->id_project }}">{{ $item->year }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="text-center pt-15">
                        <button type="button" class="btn btn-primary" onclick="getSubmission()">
                            <span class="indicator-label">Get Submissions</span>
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
        window.urlParams = "";
        window.directories = "";
        window.guides = "";
        window.locations = "";
        window.practices = "";
        window.products = "";
        window.tasks = "";
        window.taxonomies = "";
        window.contacts = "";
        window.statusesClient = "";

        window.orderDirectoriesName = [];
        window.orderGuidesName = [];
        window.orderLocationsName = [];
        window.orderPracticesName = [];

        window.rfsh_id_directory = "";
        window.rfsh_id_guide = "";
        window.rfsh_id_location = "";
        window.rfsh_id_practice = "";

        $( document ).ready(function(){
            var isEditing = true;
            const queryString = window.location.search;
            urlParams = new URLSearchParams(queryString);
            $("#agreed_deadline").flatpickr();
            $("#kt_datepicker_10").flatpickr();

            @if (isset($project) && App\Models\Project::where(['id_client' => $project->id_client, 'deleted' => 0])->where('id_project',  '!=', $project->id_project)->get()->count() > 0 && $project->task->where('deleted', 0)->count() == 0)
                let btnActDis = document.getElementById("copy-submission");
                if(btnActDis){
                    btnActDis.classList.remove("disabled");
                }
            @endif

            @if (isset($isView) && $isView == true)
                isEditing = false;
            @endif

            $('#id_directory_select').on('change', function(){
                $('#id_location_select').val('').trigger('change');
                createFilterTaxonomy(document.getElementById('url-edit-taxonomy'), 'id_directory', $(this).val());
                updateUrlParams();
                searchGrid();
                if($(this).val()){
                    getGuides($(this).val());
                } else {
                    $('#id_guide_select').empty().trigger('change');
                    $('#id_practice_select').empty().trigger('change');
                }
            });

            $('#id_guide_select').on('change', function(){
                $('#id_location_select').val('').trigger('change');
                $('#id_practice_select').val('').trigger('change');
                createFilterTaxonomy(document.getElementById('url-edit-taxonomy'), 'id_guide', $(this).val());
                updateUrlParams();
                if($(this).val()){
                    searchGrid();
                    getLocations($(this).val());
                }
            });

            $('#id_location_select').on('change', function(){
                $('#id_practice_select').val('').trigger('change');
                createFilterTaxonomy(document.getElementById('url-edit-taxonomy'), 'id_location', $(this).val());
                updateUrlParams();
                searchGrid();
                if($(this).val()){
                    getPractices($(this).val());
                }
            });

            $('#id_practice_select').on('change', function(){
                createFilterTaxonomy(document.getElementById('url-edit-taxonomy'), 'id_practice', $(this).val());
                updateUrlParams();
                searchGrid();
            });

            $(document).on('focus', '.form-select-solid', function (e) {
                if(!$('#id_practice_select').val()){
                    $(this).closest(".select2-container").siblings('select:enabled').select2('open');
                }
            });

            @if(isset($project))
                directories = {!! $directories !!};
                guides = {!! $guides !!};
                locations = {!! $locations !!};
                practices = {!! $practices !!};
                products = {!! $products !!};
                tasks = {!! $tasks !!};
                $.each(tasks, function(index, obj) {
                    if (obj.ids_contact) { // Verificar si ids_contact existe y no está vacío
                        var idsArray = obj.ids_contact.split(',').map(function(id) {// Dividir la cadena por comas y convertir los valores a números
                            return parseInt(id.trim(), 10); // Parsear a números enteros
                        });
                        obj.ids_contact = idsArray;
                    }
                });
                taxonomies = {!! $taxonomies !!};
                contacts = {!! $contacts !!};
                statusesClient = {!! $statusClient !!};

                $.each(directories, function(_, directory) {
                    orderDirectoriesName[directory.id_directory] = directory.name;
                });

                $.each(guides, function(_, guide) {
                    orderGuidesName[guide.id_guide] = guide.name;
                });

                $.each(locations, function(_, location) {
                    orderLocationsName[location.id_location] = location.name;
                });

                $.each(practices, function(_, practice) {
                    orderPracticesName[practice.id_practice] = practice.name;
                });

                var ids_submission = [];
                var id_directory_selected = '';
                var id_guide_selected = '';
                var id_location_selected = '';

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
                                var test = moment.utc(value, 'YYYY/MM/DD');
                                //this transformation is moving the days
                                //return moment(new Date(value).toISOString()).format('YYYY-MM-DD');
                                return test.format('DD/MM/YYYY');
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
                        return this._insertPicker = $("<input>").datepicker({ defaultDate: new Date() });
                    },
                    /**@CHANGE: Changed date formatting to avoid susbstraction of dates. */
                    editTemplate: function(value) {
                        let date = value;
                        if(value){
                            var test = moment.utc(value, 'YYYY/MM/DD');
                                //this transformation is moving the days
                                //return moment(new Date(value).toISOString()).format('DD/MM/YYYY');
                            date = test.format('DD/MM/YYYY');
                        }

                        return this._editPicker = $("<input>").datepicker({ dateFormat: 'dd/mm/yy'}).datepicker("setDate", date);
                    },
                    insertValue: function() {
                        return this._insertPicker.datepicker("getDate").toISOString();
                    },
                    editValue: function() {
                        if(this._editPicker.datepicker("getDate")){
                            return moment(this._editPicker.datepicker("getDate").toISOString()).format('YYYY-MM-DD');
                        }  else {
                            return "";
                        }
                    }
                });

                jsGrid.fields.myDateField = MyDateField;
                // grid taxonomy
                $("#submission").jsGrid({
                    width: "100%",
                    height: "auto",
                    filtering: false,
                    inserting: false,
                    editing: isEditing,
                    sorting: true,
                    paging: true,
                    autoload: true,
                    pageSize: 17,
                    data: tasks,
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
                            visible: isEditing,
                            width: 30
                        },
                        { name: "id_status", title: "Status", type: "select", items: statusesClient, valueField: "id_status", textField: "name", validate: "required", width: 150, align: 'left',
                            itemTemplate: function(value, item) {
                                return $.grep(statusesClient, function(o) {
                                    return o.id_status == value;
                                })[0].name;
                            }
                        },
                        { name: "id_product", title: "Product", type: "select", items: products, valueField: "id_product", textField: "name",  validate: "required", width: 150, align: 'left',
                            itemTemplate: function(item) {
                                return $.grep(products, function(product) {
                                    return product.id_product == item;
                                })[0].name;
                            },
                        },
                        { name: "id_directory", title: "Directory", type: "select", items: directories, valueField: "id_directory", textField: "name", validate: "required", autosearch: true, width: 150, align: 'left',
                            itemTemplate: function(item) {
                                return $.grep(directories, function(directory) {
                                    return directory.id_directory == item;
                                })[0].name;
                            },
                            editTemplate: function(value) {
                                var guidesField = this._grid.fields[4];
                                var $editControl = jsGrid.fields.select.prototype.editTemplate.call(this, value);

                                var changeDirectory = function() {
                                    id_directory_selected = $editControl.val();

                                    let ids_guide = $.grep(taxonomies, function(item) {
                                        return item.id_directory == id_directory_selected;
                                    }).map(function(item){
                                        return item.id_guide;
                                    });

                                    guidesField.items = $.grep(guides, function(guide) {
                                        return $.inArray(guide.id_guide, ids_guide) > -1 || guide.id_guide == '';
                                    });

                                    $(".guide-edit").empty().append(guidesField.editTemplate());
                                };

                                $editControl.on("change", changeDirectory);
                                changeDirectory();

                                return $editControl;
                            },
                            sorter: function(id1, id2) {
                                return orderDirectoriesName[id1].localeCompare(orderDirectoriesName[id2]);
                            }
                        },
                        { name: "id_guide", title: "Guide", type: "select", items: guides, valueField: "id_guide", textField: "name", validate: "required", autosearch: true, width: 150, align: 'left', editcss: "guide-edit",
                            editTemplate: function(value) {
                                var locationsField = this._grid.fields[5];
                                var $editControl = jsGrid.fields.select.prototype.editTemplate.call(this, value);

                                var changeGuide = function() {
                                    id_guide_selected = $editControl.val();

                                    let ids_location = $.grep(taxonomies, function(item) {
                                        return item.id_directory == id_directory_selected && item.id_guide == id_guide_selected;
                                    }).map(function(item){
                                        return item.id_location;
                                    });

                                    locationsField.items = $.grep(locations, function(location) {
                                        return $.inArray(location.id_location, ids_location) > -1 || location.id_location == '';
                                    });

                                    $(".location-edit").empty().append(locationsField.editTemplate());
                                };

                                $editControl.on("change", changeGuide);
                                changeGuide();

                                return $editControl;
                            },

                            itemTemplate: function(item) {
                                return $.grep(guides, function(guide) {
                                    return guide.id_guide == item;
                                })[0].name;
                            },
                            sorter: function(id1, id2) {
                                return orderGuidesName[id1].localeCompare(orderGuidesName[id2]);
                            }
                        },
                        { name: "id_location", title: "Location", type: "select", items: locations, valueField: "id_location", textField: "name", validate: "required", autosearch: true, width: 150, align: 'left', editcss: "location-edit",
                            editTemplate: function(value) {
                                var practicesField = this._grid.fields[6];
                                var $editControl = jsGrid.fields.select.prototype.editTemplate.call(this, value);

                                var changeLocation = function() {
                                    id_location_selected = $editControl.val();

                                    let ids_practice = $.grep(taxonomies, function(item) {
                                        return item.id_directory == id_directory_selected && item.id_guide == id_guide_selected && item.id_location == id_location_selected;
                                    }).map(function(item){
                                        return item.id_practice;
                                    });

                                    practicesField.items = $.grep(practices, function(practice) {
                                        return $.inArray(practice.id_practice, ids_practice) > -1 || practice.id_practice == '';
                                    });

                                    $(".practice-edit").empty().append(practicesField.editTemplate());
                                };

                                $editControl.on("change", changeLocation);
                                changeLocation();

                                return $editControl;
                            },

                            itemTemplate: function(item) {
                                return $.grep(locations, function(location) {
                                    return location.id_location == item;
                                })[0].name;
                            },
                            sorter: function(id1, id2) {
                                return orderLocationsName[id1].localeCompare(orderLocationsName[id2]);
                            }
                        },
                        { name: "id_practice", title: "Practice", type: "select", items: practices, valueField: "id_practice", textField: "name", validate: "required", autosearch: true, width: 150, align: 'left', editcss: "practice-edit",
                            editTemplate: function(value, item) {
                                var $editControl = jsGrid.fields.select.prototype.editTemplate.call(this, value);
                                var id_directory = this._grid.fields[3].editControl[0].value;
                                var id_guide = this._grid.fields[4].editControl[0].value;
                                var id_location = this._grid.fields[5].editControl[0].value;
                                var grid = this._grid;
                                //this function is called everytime the practices gets changes on edit mode.
                                var changePractice = function() {
                                    id_practice = $editControl.val();
                                    if(id_practice){

                                        $.ajax({
                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                            method: 'post',
                                            data: {
                                                'id_project' : $('#id_project').val(),
                                                'year' : $('#project_year').val(),
                                                'id_directory': id_directory,
                                                'id_guide': id_guide,
                                                'id_location': id_location,
                                                'id_practice':id_practice
                                            },
                                            url: "{{ route('get-dealine-directory') }}",
                                            success:function(response){
                                                let deadline = "";
                                                if(response.length>0){
                                                    deadline = response[0].deadline;
                                                }

                                                var date;
                                                //updates deadline of the practice if changes, if its not changes it updates it anyways.
                                                if(deadline){
                                                    var test = moment.utc(deadline, 'YYYY/MM/DD');
                                                    date = test.format('DD/MM/YYYY');
                                                }
                                                var $datepicker = grid.option("fields")[8]._editPicker;
                                                $datepicker.datepicker();
                                                if(date){
                                                    $datepicker.datepicker('setDate', date);
                                                }
                                            },
                                            error: function(xhr) {
                                                if (xhr.status === 419) {
                                                    window.location.reload();
                                                }
                                            }
                                        });
                                    }
                                };

                                $editControl.on("change", changePractice);
                                changePractice();

                                return $editControl;
                            },
                            itemTemplate: function(item) {
                                return $.grep(practices, function(practice) {
                                    return practice.id_practice == item;
                                })[0].name;
                            },
                            sorter: function(id1, id2) {
                                return orderPracticesName[id1].localeCompare(orderPracticesName[id2]);
                            }
                        },
                        { name: "agreed_deadline", title: "Agreed Deadline", type: "myDateField", width: 100, align: "center"},
                        { name: "deadline", title: "Directory Deadline", type: "myDateField", width: 100, align: "center"},
                        {
                            name: 'confirmed', type: "checkbox", title: "Confirmed", sorting: true, align: "center", width: 80, autosearch: false, editing: false,
                        },
                        { name: "contact_names", title: "Firm Contact", type: "text", width: 150, align: 'left', readOnly: true,
                        },
                        { name: "ids_contact", visible: false,
                        },
                        { name: "id_task", valueField: "id_task", width: 0, visible: false},
                        { type: "control", visible: isEditing}
                    ],

                    controller: {
                        loadData: function(filter) {
                            let filterItem = $.grep(tasks, function(item) {
                                    return (!filter.id_product || item.id_product == filter.id_product)
                                        && (!filter.id_directory || item.id_directory == filter.id_directory)
                                        && (!filter.id_guide || item.id_guide == filter.id_guide)
                                        && (!filter.id_location || item.id_location == filter.id_location)
                                        && (!filter.id_practice || item.id_practice == filter.id_practice);
                            });
                            return filterItem;
                        },

                        insertItem: function(item){
                            tasks.push(item);
                        }
                    },
                    invalidNotify: function(args) {
                        var messages = $.map(args.errors, function(error) {
                            let msg;
                            switch (error.field.name) {
                                case 'id_status':
                                        msg = 'Status '+error.message+'<br>';
                                    break;
                                case 'id_product':
                                        msg = 'Product '+error.message+'<br>';
                                    break;
                                case 'id_directory':
                                        msg = 'Directory '+error.message+'<br>';
                                    break;
                                case 'id_guide':
                                        msg = 'Guide '+error.message+'<br>';
                                    break;
                                case 'id_location':
                                        msg = 'Location '+error.message+'<br>';
                                    break;
                                case 'id_practice':
                                        msg = 'Practice '+error.message+'<br>';
                                    break;
                            }
                            return msg;
                        });
                        toastrAlert('error',messages);
                    },

                    onItemUpdating: function(args) {
                        var findTasks = tasks.filter(function(elemento) {
                            return elemento.id_directory == args.item.id_directory && elemento.id_guide == args.item.id_guide && elemento.id_location == args.item.id_location && elemento.id_practice == args.item.id_practice
                        });
                        var validated = function(){
                            if(args.previousItem.id_directory != args.item.id_directory || args.previousItem.id_guide != args.item.id_guide || args.previousItem.id_location != args.item.id_location || args.previousItem.id_practice != args.item.id_practice)
                            {
                                return true;
                            } else {
                                return false;
                            }
                        }

                        if(findTasks.length > 0  && validated())
                        {
                            args.cancel = true;
                            errorToastr("Submission already exists");
                        }
                    },
                    onItemUpdated: function(args){
                        //formatear un valor antes de visualizar en la edicion
                        if(args.item.id_task != null){
                            args.item.action = 'update';
                        }
                        if(args.item.id_status){
                            args.item.description = 'updated status from grid';
                        }
                    },

                    onItemDeleted: function(args){
                        if(args.item.id_task != null){
                            ids_submission.push(args.item.id_task);
                        }
                    },

                    onItemInserting: function(args) {
                        var findTasks = tasks.filter(function(elemento) {
                            return elemento.id_directory == args.item.id_directory && elemento.id_guide == args.item.id_guide && elemento.id_location == args.item.id_location && elemento.id_practice == args.item.id_practice
                        });

                        if(findTasks.length > 0)
                        {
                            args.cancel = true;
                            errorToastr("Submission already exists");
                        }
                    },

                    confirmDeleting: false,
                    onItemDeleting: function (args) {
                        if (!args.item.deleteConfirmed) { // custom property for confirmation
                            args.cancel = true; // cancel deleting
                            Swal.fire({
                                html: 'Are you sure you want to delete this submission?',
                                icon: "warning",
                                buttonsStyling: false,
                                showCancelButton: true,
                                confirmButtonText: "Yes, got it!",
                                cancelButtonText: 'No, cancel it',
                                customClass: {
                                    confirmButton: "btn btn-primary",
                                    cancelButton: 'btn btn-danger'
                                }
                            }).then(function(result) {
                                if (result.value) {
                                    args.item.deleteConfirmed = true;
                                    $("#submission").jsGrid("deleteItem", args.item);

                                    let index = tasks.findIndex(function(elemento) {
                                        return elemento.id_directory == args.item.id_directory && elemento.id_guide == args.item.id_guide && elemento.id_location == args.item.id_location && elemento.id_practice == args.item.id_practice
                                    });

                                    tasks.splice(index,1);

                                    $("#submission").jsGrid("refresh");
                                }
                            });
                        }
                    },
                });
            @endif

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
                var grid = $("#submission").jsGrid("option", "data");
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

            $('#edit-data').on('click', function(e){
                e.preventDefault();
                $('#kt_datepicker_10').val('');
                $('#agreed_deadline').val('');
                $('#id_product_edit').val('').trigger('change');
                $('#id_statuses').val('').trigger('change');
                $('.descriptionEdit').hide();
                $('#description-status').val('');
                $('#contacts_name').val('');
                $('#kt_modal_1').modal('show');
            });
            //End select checkbox functionality

            $('#id_statuses').on('change', function(e){
                let status = document.getElementById('description-status');
                status.removeAttribute("hidden");
                if(!$(this).val()){
                    status.setAttribute("hidden", "hidden");
                }
            });

            $('.save-submissions').on('click', function(e){
                e.preventDefault();
                var filteredData = tasks.filter(function (item) {
                    return (item.action == "update" || item.action == "insert");
                });

                if(filteredData.length == 0 && ids_submission.length == 0){
                    errorToastr('No data to save')
                }else{
                    var idBtn = document.querySelector("#save-submission");
                    idBtn.setAttribute("data-kt-indicator", "on");

                    var newdata = {
                        ids_submission: ids_submission,
                        year: $('#project_year').val(),
                        id_project: $('#id_project').val(),
                        name: $('#project_name').val(),
                        filteredData: filteredData,
                    }

                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        method: 'post',
                        data: JSON.stringify(newdata),
                        contentType: "application/json; charset=utf-8",
                        dataType: "json",
                        traditional: true,
                        url: '{{ route('save-update-submissions') }}',
                        success:function(response){
                            successToastr("Successfully saved");
                            tasks.length = 0;
                            tasks.push.apply(tasks, response.data);
                            $.each(tasks, function(index, obj) {
                                if (obj.ids_contact) { // Verificar si ids_contact existe y no está vacío
                                    var idsArray = obj.ids_contact.split(',').map(function(id) {// Dividir la cadena por comas y convertir los valores a números
                                        return parseInt(id.trim(), 10); // Parsear a números enteros
                                    });
                                    obj.ids_contact = idsArray;
                                }
                            });
                            ids_submission.length = 0;
                            $("#selectAllCheckbox").prop("checked", false);
                            $('#edit-data').addClass('disabled');
                            $("#submission").jsGrid("loadData");
                            searchGrid();
                            idBtn.removeAttribute("data-kt-indicator");
                            $('#copy-submission').addClass('disabled');
                        },
                        error: function(xhr) {
                            if (xhr.status === 419) {
                                window.location.reload();
                            }
                        }
                    });
                }
            });

            $('.add-record').on('click', function(e){
                e.preventDefault();
                insertItemSubmission();
            });

            document.addEventListener('keyup', function (e) {
                if (e.keyCode === 9 && $('#id_directory_select').val() && $('#id_guide_select').val() && $('#id_location_select').val() && $('#id_practice_select').val()) {
                    insertItemSubmission();
                }
            }, false);

            $('#id_client').on('change', function(){
                $('#project_name').val($("#id_client :selected").text()+' '+$("#year :selected").text());
                var ownerSelect = $('#id_client option:selected').attr('owner');
                $('#owner').val(ownerSelect).trigger('change');
            });
            $('#year').on('change', function(){
                $('#project_name').val($("#id_client :selected").text()+' '+$("#year :selected").text());
            });

            $('.clear-url').on('click', function(e){
                e.preventDefault();
                var currenturl = location.href.split('?')[0];
                window.history.replaceState(null, null, currenturl);

                //clear filter edit taxonomy
                let queryString = document.getElementById('url-edit-taxonomy').href;
                let urlString = queryString.split('?')[0];

                var a = document.getElementById('url-edit-taxonomy');
                    a.href = urlString.toString();
            });

            if(urlParams.has('id_directory')){
                $('#id_directory_select').val(urlParams.get('id_directory')).trigger('change');
            }

            $("#export-submissions").click(function (e) {
                e.preventDefault();
                var data = $('#submission').jsGrid('option', 'data');
                JSONToCSVConvertor(data, "Report Submissions", true);
            });

            $('.refresh-taxonomy').on('click', function(e){
                e.preventDefault();
                let spinner = document.getElementById('spinner_loading');
                spinner.removeAttribute("hidden");

                let refresh = document.getElementById('icon_refresh');
                refresh.setAttribute("hidden", "hidden");

                rfsh_id_guide = $('#id_guide_select').val();
                rfsh_id_location = $('#id_location_select').val();
                getCatalogTaxonomies($('#id_directory_select').val());
            });

            $('.copy-submission').on('click', function(e){
                e.preventDefault();
                $('#kt_modal_select_project').modal('show');
            });

            if($("#idClient").val() && $("#idClient").val().length>0){
                $('#id_client').val($("#idClient").val()).trigger('change');
            }

            var form = document.querySelector('#kt_modal_1');
            var nameContacts = "";
            if(contacts){
                nameContacts = contacts.filter(function(contact) {
                    return contact.name !== '';
                }).map(function(contact) {
                    return contact.name;
                });
            }


            var tags = new Tagify(form.querySelector('[name="contacts_name"]'), {
                whitelist: nameContacts,
                maxTags: 5,
                placeholder: "Select a Firm Contact",
                enforceWhitelist: true,
                dropdown: {
                    maxItems: 10,           // <- mixumum allowed rendered suggestions
                    enabled: 0,             // <- show suggestions on focus
                    closeOnSelect: false    // <- do not hide the suggestions dropdown once an item has been selected
                }
            });
            tags.on("change", function(){
                // Revalidate the field when an option is chosen
                // validator.revalidateField('tags');
            });


        });

        function enableDisableBtn(status){
            if(status == true){
                var grid = $("#submission").jsGrid("option", "data");
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

        /**adds a new record to the javascript table below */
        function insertItemSubmission(){
            //if it is view mode only or edit mode
            @if (isset($isView) && $isView == false)
                //validate for some reason if all filters hace data selected.
                if($('#id_directory_select').val() && $('#id_guide_select').val() && $('#id_location_select').val() && $('#id_practice_select').val()){
                    //gets ID of the default "pending" status from global status array
                    let statusTask = statusesClient.filter(function(status){
                        return (status.name == 'Pending');
                    })[0];
                    //retrieve dealine from deadline package if any.
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        method: 'post',
                        data: {
                            'id_project' : $('#id_project').val(),
                            'year' : $('#project_year').val(),
                            'id_directory': $('#id_directory_select').val(),
                            'id_guide': $('#id_guide_select').val(),
                            'id_location': $('#id_location_select').val(),
                            'id_practice': $('#id_practice_select').val()
                        },
                        url: "{{ route('get-dealine-directory') }}",
                        success:function(response){
                            var deadline = "";
                            var confirmed = 0;
                            if(response.length>0){
                                deadline = response[0].deadline;
                                confirmed = response[0].confirmed;
                            }

                            $("#submission").jsGrid("insertItem", {
                                id_task: null,
                                id_project : parseInt($('#id_project').val()),
                                id_product: parseInt($('#id_product').val()),
                                id_directory: parseInt($('#id_directory_select').val()),
                                id_guide: parseInt($('#id_guide_select').val()),
                                id_location: parseInt($('#id_location_select').val()),
                                id_practice: parseInt($('#id_practice_select').val()),
                                name: $('#project_name').val(),
                                deadline: deadline,
                                agreed_deadline: deadline,
                                confirmed:confirmed,
                                id_status: statusTask.id_status,
                                description: 'Status default when insert record',
                                action: 'insert'
                            }).done(function(e) {
                                $('#id_practice_select').val('').trigger('change');
                                $(".select2-select").select2({closeOnSelect:false});
                                $("#id_practice_select").select2("open");
                            });
                        },
                        error: function(xhr) {
                            if (xhr.status === 419) {
                                window.location.reload();
                            }
                        }
                    });


                } else {
                        errorToastr('You must select the required data')
                }
            @endif
        }

        function createSearchFilter(tasks, models, id_select_search, id)
        {
            let ids_item_init = tasks.map(function(item){
                return item[id];
            })

            $.grep(models, function(model) {
                return $.inArray(model[id], ids_item_init) > -1;
            }).forEach(function(item){
                var newOption = new Option(item.name, item[id], false, false);
                $('#'+id_select_search).append(newOption);
            });
        }

        function createFilterTaxonomy(url, id_extern, setValue)
        {
            if(url != null){
                var newUrl = new URL(url.href);
                var search_params = newUrl.searchParams;
                search_params.set(id_extern, setValue);
                newUrl.search = search_params.toString();

                var a = url;
                    a.href = newUrl.toString();
            }
        }

        function updateUrlParams()
        {
            if(document.getElementById('url-edit-taxonomy') != null){
                let queryString = document.getElementById('url-edit-taxonomy').href;
                let paramString = queryString.split('?')[1];
                var currenturl = location.href.split('?')[0];

                var newUrl = currenturl+"?"+paramString;
                window.history.replaceState(null, null, newUrl)
            }
        }

        function updateDataSelected()
        {
            var grid = $("#submission").jsGrid("option", "data");
            var filteredData = grid.filter(function (item) {
                return (item.check == true);
            });
            if(filteredData.length == 0){
                errorToastr('Select the rows to edit');
                return;
            }

            tasks.filter(function (item) {
                return (item.check == true);
            }).map(function(element){
                if($('#id_product_edit').val()){
                    element.id_product = $('#id_product_edit').val();
                }
                if($('#agreed_deadline').val()){
                    element.agreed_deadline = $('#agreed_deadline').val();
                }
                if($('#kt_datepicker_10').val()){
                    element.deadline = $('#kt_datepicker_10').val();
                }
                if (getContactsValues() && (Array.isArray(getContactsValues().ids) && getContactsValues().ids.length != 0 && typeof getContactsValues().names == 'string' && getContactsValues().names.trim() != '')) {
                    element.ids_contact = getContactsValues().ids;
                    element.contact_names = getContactsValues().names;
                }

                if($('#id_statuses').val()){
                    element.id_status = $('#id_statuses').val();
                }
                if($('#description-status').val()){
                    element.description = $('#description-status').val();
                }
                element.action = 'update';
                // element.check = false;
            });

            grid.map(function(element){
                if(element.check == true){
                    if($('#id_product_edit').val()){
                        element.id_product = $('#id_product_edit').val();
                    }
                    if($('#agreed_deadline').val()){
                        element.agreed_deadline = $('#agreed_deadline').val();
                    }
                    if($('#kt_datepicker_10').val()){
                        element.deadline = $('#kt_datepicker_10').val();
                    }
                    if (getContactsValues() && (Array.isArray(getContactsValues().ids) && getContactsValues().ids.length != 0 && typeof getContactsValues().names == 'string' && getContactsValues().names.trim() != '')) {
                        element.ids_contact = getContactsValues().ids;
                        element.contact_names = getContactsValues().names;
                    }
                    if($('#id_statuses').val()){
                        element.id_status = $('#id_statuses').val();
                    }
                    if($('#description-status').val()){
                        element.description = $('#description-status').val();
                    }
                    element.action = 'update';
                    // element.check = false;
                }

            })

            $("#submission").jsGrid("refresh");
            $('#kt_modal_1').modal('hide');
        }

        function searchGrid() {
            var grid = $("#submission").data('JSGrid');
            grid.search({
                id_directory: $('#id_directory_select').val(),
                id_guide: $('#id_guide_select').val(),
                id_location: $('#id_location_select').val(),
                id_practice: $('#id_practice_select').val(),
            });

            var filteredRecords = grid.data.length;
            var spanElement = document.getElementById("total-tasks");
            spanElement.textContent = filteredRecords;
        };

        function getSubmission()
        {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {
                        'id_project' : $('#id_project_select').val(),
                        'id_project_current' : $('#id_project').val(),
                    },
                url: "{{ route('get-submission') }}",
                success:function(response){
                    tasks.length = 0;
                    tasks.push.apply(tasks, response);
                    $("#submission").jsGrid("loadData");
                    $('#kt_modal_select_project').modal('hide');
                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                }
            }).then(function () {
            });
        }

        function getContactsValues()
        {
            if($('#contacts_name').val()){
                var dataArray = JSON.parse($('#contacts_name').val());
                var valueids = [];
                var obj = [];
                var valuesName = dataArray.map(function(obj) {
                    let findContact = $.grep(contacts, function(objeto) {
                        return objeto.name == obj.value;
                    });
                    if (findContact.length > 0) {
                        valueids.push(findContact[0].id_contact);
                    }
                    return obj.value;
                });
                obj['names'] = valuesName.join(", ");
                obj['ids'] = valueids;
                return obj;
            }
        }

    </script>
    <script>
        function getCatalogTaxonomies(id_directory_select)
        {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                url: '{{ route('get-catalog-taxonomies') }}',
                success:function(response){

                    directories.length = 0;
                    directories.push.apply(directories, response.directories);

                    guides.length = 0;
                    guides.push.apply(guides, response.guides);

                    locations.length = 0;
                    locations.push.apply(locations, response.locations);

                    practices.length = 0;
                    practices.push.apply(practices, response.practices);

                    taxonomies.length = 0;
                    taxonomies.push.apply(taxonomies, response.taxonomies);

                    getDirectories(id_directory_select);
                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                }
            });
        }
        function getDirectories(id_directory)
        {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                url: '{{ route('get-directories-from-taxonomy') }}',
                success:function(response){
                    $('#id_directory_select').html(response);
                    $('#id_directory_select').val(id_directory).trigger('change');

                    saveUpdateOptionSelects('id_directory', 3, directories);
                    saveUpdateOptionSelects('id_guide', 4, guides);
                    saveUpdateOptionSelects('id_location', 5, locations);
                    saveUpdateOptionSelects('id_practice', 6, practices);

                    $.each(directories, function(_, directory) {
                        orderDirectoriesName[directory.id_directory] = directory.name;
                    });

                    $.each(guides, function(_, guide) {
                        orderGuidesName[guide.id_guide] = guide.name;
                    });

                    $.each(locations, function(_, location) {
                        orderLocationsName[location.id_location] = location.name;
                    });

                    $.each(practices, function(_, practice) {
                        orderPracticesName[practice.id_practice] = practice.name;
                    });

                    let spinner = document.getElementById('spinner_loading');
                    spinner.setAttribute("hidden", "hidden");

                    let refresh = document.getElementById('icon_refresh');
                    refresh.removeAttribute("hidden");

                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                }
            });
        }

        function getGuides(id_directory)
        {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {
                    'id_directory': id_directory
                },
                url: '{{ route('get-guides-from-taxonomy') }}',
                success:function(response){
                    $('#id_guide_select').html(response);
                    if(urlParams.has('id_guide')){
                        $('#id_guide_select').val(urlParams.get('id_guide')).trigger('change');
                    }
                    if(rfsh_id_guide)
                    {
                        $('#id_guide_select').val(rfsh_id_guide).trigger('change');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                }
            });
        }

        function getLocations(id_guide)
        {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {
                    'id_directory': $('#id_directory_select').val(),
                    'id_guide': id_guide
                },
                url: '{{ route('get-locations-from-taxonomy') }}',
                success:function(response){
                    $('#id_location_select').html(response);
                    if(urlParams.has('id_location')){
                        $('#id_location_select').val(urlParams.get('id_location')).trigger('change');
                    }
                    if(rfsh_id_location)
                    {
                        $('#id_location_select').val(rfsh_id_location).trigger('change');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                }
            });
        }

        function getPractices(id_location)
        {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {
                    'id_directory': $('#id_directory_select').val(),
                    'id_guide': $('#id_guide_select').val(),
                    'id_location': id_location
                },
                url: '{{ route('get-practices-from-taxonomy') }}',
                success:function(response){
                    $('#id_practice_select').html(response);
                    if(urlParams.has('id_practice')){
                        $('#id_practice_select').val(urlParams.get('id_practice')).trigger('change');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                }
            });
        }

        function deleteProject(id_project)
        {
            Swal.fire({
                html: 'Are you sure you want to delete this project?',
                icon: "warning",
                buttonsStyling: false,
                showCancelButton: true,
                confirmButtonText: "Yes, got it!",
                cancelButtonText: 'No, cancel it',
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: 'btn btn-danger'
                }
            }).then(function(result) {
                if (result.value) {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        method: 'post',
                        data: {'id_project' : id_project},
                        url: "{{ route('delete-project') }}",
                        success:function(response){
                            successToastr('Project removed successfully');
                        },
                        error: function(xhr) {
                            if (xhr.status === 419) {
                                window.location.reload();
                            }
                        }
                    }).then(function () {
                        window.location.href = "{{ route('projects') }}";
                    });
                }
            });
        }

        function saveUpdateOptionSelects(id_item, column, model, id_extern)
        {
            var grid = $("#submission").jsGrid("option", "fields")[column].items;
            // b diff a
            let resultA = grid.filter(elm => !model.map(elm => JSON.stringify(elm)).includes(JSON.stringify(elm)));

            // a diff b
            let resultB = model.filter(elm => !grid.map(elm => JSON.stringify(elm)).includes(JSON.stringify(elm)));

            // show merge
            var result = [...resultA, ...resultB];
            if(result.length>0){
                let id = result[0][id_item];
                let text = result[0].name;

                var itemIndex = grid.findIndex(x => x[id_item] == id);

                if(itemIndex == -1)
                {

                    if(column == 4 || column == 6){
                        let id_ext = result[0].id_directory;
                        grid.push({
                            [id_item]: id,
                            id_directory: id_ext,
                            name: text
                        });
                    } else {
                        grid.push({
                            [id_item]: id,
                            name: text
                        });
                    }
                }
            }


            const mergeByProperty = (model, grid, prop) => {
                grid.forEach(sourceElement => {
                    let targetElement = model.find(targetElement => {
                        return sourceElement[prop] === targetElement[prop];
                    })
                    targetElement ? Object.assign(targetElement, sourceElement) : model.push(sourceElement);
                })
            }

            mergeByProperty(model, grid, [id_item]);

            $("#submission").jsGrid("refresh");
        }

        function successToastr(msg){
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
            toastr.success(msg);
        }

        function errorToastr(msg){
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
            toastr.error(msg);
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
                        case "id_directory":
                            nameTitle = "Directory";
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
                            nameTitle = "Agreed Deadline";
                            break;
                        case "deadline":
                            nameTitle = "Directory Deadline";
                            break;
                        case "confirmed":
                            nameTitle = "Confirmed";
                            break;
                        case "contact_names":
                            nameTitle = "Firm Contact";
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
                            nameItem = idItem ? (idItem == null ? "" : (statusesClient.find(x=>x.id_status == idItem) || {}).name) : 'undefined';
                            break;

                        case "id_directory":
                            nameItem = directories.find(x => x.id_directory == idItem).name;
                            break;

                        case "id_guide":
                            nameItem = guides.find(x => x.id_guide == idItem).name;
                            break;

                        case "id_location":
                            nameItem = locations.find(x => x.id_location == idItem).name;
                            break;

                        case "id_practice":
                            nameItem = practices.find(x => x.id_practice == idItem).name;
                            break;

                        case "id_product":
                            nameItem = products.find(x => x.id_product == idItem).name;
                            break;

                        case "agreed_deadline":
                            let newADeadlineItem = 'undefined';
                            if (arrData[i][index]) {
                                newADeadlineItem = arrData[i][index];
                            }
                            nameItem = newADeadlineItem;
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

                        case "contact_names":
                            let newContactNames = 'undefined';
                            if (arrData[i][index]) {
                                newContactNames = arrData[i][index];
                            }
                            nameItem = newContactNames;
                            break;
                    }

                    if(nameItem && nameItem != "undefined")
                        row += '"' + nameItem + '",';
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
            // var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);
            var uri = 'data:text/csv;charset=utf-8,\uFEFF' + encodeURIComponent(CSV);

            // Now the little tricky part.
            // you can use either>> window.open(uri);
            // but this will not work in some browsers
            // or you will not get the correct file extension

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
    </script>
    {{-- <script src="{{ URL::asset('assets/plugins/global/plugins.bundle.js') }}"></script> --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
@endpush
