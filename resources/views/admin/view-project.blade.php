

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
    </style>
@endpush

@section('master-content')
    <!--begin::Navbar-->
    <div class="card mb-9">
        <div class="card-body pt-9 pb-0">
            <!--begin::Details-->
            <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                <!--begin::Image-->
                <div class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                    <img class="mw-50px mw-lg-100px" src="{{ $project->client->getPicture() }}" alt="image" />
                </div>
                <!--end::Image-->
                <!--begin::Wrapper-->
                <div class="flex-grow-1">
                    <!--begin::Head-->
                    <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                        <!--begin::Details-->
                        <div class="d-flex flex-column">
                            <!--begin::Status-->
                            <div class="d-flex align-items-center mb-1">
                                <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">
                                    {{ $project->name ?? '' }}
                                </a>
                                <span class="badge badge-light-success me-auto">In Progress</span>
                            </div>
                            <!--end::Status-->
                            <!--begin::Description-->
                            <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-400">
                                {{ App\Models\Client::find($project->id_client)->name ?? ''}}
                            </div>
                            <!--end::Description-->
                        </div>
                        <!--end::Details-->
                        <!--begin::Actions-->
                        <div class="d-flex mb-4">
                            <a href="{{ route('read-project', ['id' => $project->id_project]) }}" class="btn btn-sm btn-facebook" style="color:white">
                                Edit
                            </a>
                            &nbsp;
                            <a href="#" onclick="deleteProject('{{ $project->id_project }}')" class="btn btn-sm btn-danger">Delete</a>
                        </div>
                        <!--end::Actions-->
                    </div>
                    <!--end::Head-->
                    <!--begin::Info-->
                    <div class="d-flex flex-wrap justify-content-start">
                        <!--begin::Stats-->
                        <div class="d-flex flex-wrap">
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <div class="fs-4 fw-bold">
                                        {{  $project->year ?? '' }}
                                    </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="fw-semibold fs-6 text-gray-400">Year</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="fs-4 fw-bold">
                                        @php
                                            $timezone = Auth::user()->timezone;
                                            $date = Carbon\Carbon::parse($project->created_at, isset($timezone) ? $timezone : 'UTC');
                                        @endphp

                                        {{ $date->isoFormat('MMMM Do YYYY') }}
                                    </div>
                                </div>
                                <!--begin::Label-->
                                <div class="fw-semibold fs-6 text-gray-400">Created At</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                            <!--begin::Stat-->
                            <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                <!--begin::Number-->
                                <div class="d-flex align-items-center">
                                    <div class="fs-4 fw-bold">
                                        {{ App\Models\User::find($project->owner)->name ?? ''}}
                                    </div>
                                </div>
                                <!--end::Number-->
                                <!--begin::Label-->
                                <div class="fw-semibold fs-6 text-gray-400">Owner</div>
                                <!--end::Label-->
                            </div>
                            <!--end::Stat-->
                        </div>
                        <!--end::Stats-->
                        <!--begin::Users-->
                        <div class="symbol-group symbol-hover mb-3">
                            <!--begin::User-->
                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Alan Warden">
                                <span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
                            </div>
                            <!--end::User-->
                            <!--begin::User-->
                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Susan Redwood">
                                <span class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
                            </div>
                            <!--end::User-->
                            <!--begin::User-->
                            <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Perry Matthew">
                                <span class="symbol-label bg-info text-inverse-info fw-bold">P</span>
                            </div>
                            <!--end::User-->
                        </div>
                        <!--end::Users-->
                    </div>
                    <!--end::Info-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Details-->
            <div class="separator"></div>
            <!--begin::Nav-->
            <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                <!--begin::Nav item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6 section-project submissions active" onclick="showSection('submissions'); return false;" href="#">Submissions</a>
                </li>
                <!--end::Nav item-->
                <!--begin::Nav item-->
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6 section-project pro" onclick="showSection('pro'); return false;" href="#">In progress</a>
                </li>


                <!--end::Nav item-->
            </ul>
            <!--end::Nav-->
        </div>
    </div>
    <!--end::Navbar-->
    <!--begin::Card-->
    <div class="card" id="submissions">
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title fs-3 fw-bold">Submissions</div>
            @if ($isView == false)
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-end pt-3">
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
                            <a href="#" class="btn btn-sm btn-primary save-submissions">
                                <span class="svg-icon svg-icon-muted svg-icon-1x">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24"/>
                                            <path d="M17,4 L6,4 C4.79111111,4 4,4.7 4,6 L4,18 C4,19.3 4.79111111,20 6,20 L18,20 C19.2,20 20,19.3 20,18 L20,7.20710678 C20,7.07449854 19.9473216,6.94732158 19.8535534,6.85355339 L17,4 Z M17,11 L7,11 L7,4 L17,4 L17,11 Z" fill="currentColor" fill-rule="nonzero"/>
                                            <rect fill="currentColor" opacity="0.3" x="12" y="4" width="3" height="5" rx="0.5"/>
                                        </g>
                                    </svg>
                                </span>
                                Save Submissions
                            </a>
                        </div>
                    </div>
                </div>
            @endif
            <!--end::Card title-->
        </div>
        <!--end::Card header-->
        @if (isset($project))
            <!--begin::Card body-->
            <div class="card-body pt-5">
                <div class="pb-2">
                    <div class="rounded border p-5">
                        <div class="fv-row mb-3">
                            <label class="fs-6 fw-bold form-label mt-1">
                                Search filters
                            </label>
                        </div>
                        <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-4">
                            <div class="col">
                                <div class="fv-row mb-7">
                                    <select class="form-select form-select-solid" data-control="select2" id="id_directory_search" data-placeholder="Search a directory" data-allow-clear="true" required>

                                        <option selected></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-7">
                                    <select class="form-select form-select-solid" data-control="select2" id="id_guide_search" data-placeholder="Search a guide" data-allow-clear="true" required>
                                        <option selected></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-7">
                                    <select class="form-select form-select-solid" data-control="select2" id="id_location_search" data-placeholder="Search a location" data-allow-clear="true" required>
                                        <option selected></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="fv-row mb-7">
                                    <select class="form-select form-select-solid" data-control="select2" id="id_practice_search" data-placeholder="Search a practice" data-allow-clear="true" required>
                                        <option selected></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="text-align:end; padding:5px">
                    <a href="#" class="btn btn-sm btn-success" id="export-submissions">
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="currentColor"></rect>
                                <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="currentColor"></path>
                                <path opacity="0.3" d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="currentColor"></path>
                            </svg>
                        </span>
                        Export CSV
                    </a>
                </div>
                <!--end::Form-->
                <div id="submission"></div>
            </div>
            <!--end::Card body-->
        @endif
    </div>
    <div class="card" id="progress" hidden>
        <!--begin::Card header-->
        <div class="card-header">
            <!--begin::Card title-->
            <div class="card-title fs-3 fw-bold">Progress</div>

        </div>

    </div>
    <!--end::Card-->
@endsection

@push('scripts')
    <script>
        window.urlParams = "";
        window.directories = "";
        window.guides = "";
        window.locations = "";
        window.practices = "";
        window.products = "";
        window.tasks = "";

        window.rfsh_id_directory = "";
        window.rfsh_id_guide = "";
        window.rfsh_id_location = "";
        window.rfsh_id_practice = "";

        $( document ).ready(function(){
            var isEditing = true;
            const queryString = window.location.search;
            urlParams = new URLSearchParams(queryString);

            @if (isset($isView) && $isView == true)
                $(".form-select-solid").prop("disabled", true);
                const inputs = document.querySelectorAll('input.form-control-solid');
                inputs.forEach(input => input.disabled = true);
                const textarea = document.querySelectorAll('textarea.form-control-solid');
                textarea.forEach(input => input.disabled = true);
                const radios = document.querySelectorAll('input.form-check-input');
                radios.forEach(input => input.disabled = true);
                isEditing = false;
                $("#id_directory_search").prop("disabled", false);
                $("#id_guide_search").prop("disabled", false);
                $("#id_location_search").prop("disabled", false);
                $("#id_practice_search").prop("disabled", false);
            @endif

            $('#id_directory_select').on('change', function(){
                $('#id_location_select').val('').trigger('change');
                $('#id_directory_search').val('').trigger('change');
                createFilterTaxonomy(document.getElementById('url-edit-taxonomy'), 'id_directory', $(this).val());
                updateUrlParams();
                if($(this).val()){
                    getGuides($(this).val());
                } else {
                    $('#id_guide_select').empty();
                    $('#id_practice_select').empty();
                }
            });

            $('#id_guide_select').on('change', function(){
                $('#id_location_select').val('').trigger('change');
                $('#id_practice_select').val('').trigger('change');
                createFilterTaxonomy(document.getElementById('url-edit-taxonomy'), 'id_guide', $(this).val());
                updateUrlParams();
                if($(this).val()){
                    getLocations($(this).val());
                }
            });

            $('#id_location_select').on('change', function(){
                $('#id_practice_select').val('').trigger('change');
                createFilterTaxonomy(document.getElementById('url-edit-taxonomy'), 'id_location', $(this).val());
                updateUrlParams();
                if($(this).val()){
                    getPractices($(this).val());
                }
            });

            $('#id_practice_select').on('change', function(){
                createFilterTaxonomy(document.getElementById('url-edit-taxonomy'), 'id_practice', $(this).val());
                updateUrlParams();
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
                // var tasks = {!! $tasks !!};
                // var directories = {!! $directories !!};
                // var guides = {!! $guides !!};
                // var locations = {!! $locations !!};
                // var practices = {!! $practices !!};
                // var products = {!! $products !!};
                var taxonomies = {!! $taxonomies !!};

                var ids_submission = [];
                var id_directory_selected = '';
                var id_guide_selected = '';
                var id_location_selected = '';

                createSearchFilter(tasks, directories, 'id_directory_search', 'id_directory');
                createSearchFilter(tasks, guides, 'id_guide_search', 'id_guide');
                createSearchFilter(tasks, locations, 'id_location_search', 'id_location');
                createSearchFilter(tasks, practices, 'id_practice_search', 'id_practice');

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
                                return moment(new Date(value).toISOString()).utc().format('MM/DD/YYYY');
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
                    editTemplate: function(value) {
                        let date = value;
                        if(value){
                            date = moment(new Date(value).toISOString()).utc().format('MM/DD/YYYY');
                        }
                        // return this._editPicker = $("<input>").datepicker().datepicker("setDate", moment(new Date(date).toISOString()).utc().format('MM/DD/YYYY'));
                        return this._editPicker = $("<input>").datepicker().datepicker("setDate", date);
                    },
                    insertValue: function() {
                        return this._insertPicker.datepicker("getDate").toISOString();
                    },
                    editValue: function() {
                        return moment(this._editPicker.datepicker("getDate").toISOString()).utc().format('YYYY-MM-DD');
                    }
                });

                jsGrid.fields.myDateField = MyDateField;

                // grid taxonomy
                $("#submission").jsGrid({
                    width: "100%",
                    height: "400px",
                    filtering: false,
                    inserting: false,
                    editing: isEditing,
                    sorting: true,
                    paging: true,
                    autoload: true,
                    data: tasks,

                    fields: [
                        { name: "id_product", title: "Product", type: "select", items: products, valueField: "id_product", textField: "name", valueType: "string",  validate: "required", width: 150, align: 'left'},
                        { name: "id_directory", title: "Directory", type: "select", items: directories, valueField: "id_directory", textField: "name", valueType: "string", validate: "required", autosearch: true, width: 150, align: 'left',
                            editTemplate: function(value) {
                                var guidesField = this._grid.fields[2];
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
                            }
                        },
                        { name: "id_guide", title: "Guide", type: "select", items: guides, valueField: "id_guide", textField: "name", valueType: "string", validate: "required", autosearch: true, width: 150, align: 'left', editcss: "guide-edit",
                            editTemplate: function(value) {
                                var locationsField = this._grid.fields[3];
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
                        },
                        { name: "id_location", title: "Location", type: "select", items: locations, valueField: "id_location", textField: "name", valueType: "string", validate: "required", autosearch: true, width: 150, align: 'left', editcss: "location-edit",
                            editTemplate: function(value) {
                                var practicesField = this._grid.fields[4];
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
                        },
                        { name: "id_practice", title: "Practice", type: "select", items: practices, valueField: "id_practice", textField: "name", valueType: "string", validate: "required", autosearch: true, width: 150, align: 'left', editcss: "practice-edit",
                            itemTemplate: function(item) {
                                return $.grep(practices, function(practice) {
                                    return practice.id_practice == item;
                                })[0].name;
                            }
                        },
                        { name: "deadline", title: "Deadline", type: "myDateField", width: 100, align: "center"},
                        { name: "id_task", valueField: "id_task", width: 0, visible: false},
                        { type: "control"}
                    ],

                    controller: {
                        loadData: function(filter) {
                            let filterItem = $.grep(tasks, function(item) {
                                return (!filter.id_product || item.id_product.indexOf(filter.id_product) > -1)
                                    && (!filter.id_directory || item.id_directory.indexOf(filter.id_directory) > -1)
                                    && (!filter.id_guide || item.id_guide.indexOf(filter.id_guide) > -1)
                                    && (!filter.id_location || item.id_location.indexOf(filter.id_location) > -1)
                                    && (!filter.id_practice || item.id_practice.indexOf(filter.id_practice) > -1);
                            });

                            return filterItem;
                        },

                        insertItem: function(item){
                            tasks.push(item);
                        }
                    },

                    onItemUpdated: function(args){
                        //formatear un valor antes de visualizar en la edicion
                        if(args.item.id_task != null){
                            args.item.action = 'update';
                        }
                    },

                    onItemDeleted: function(args){
                        if(args.item.id_task != null){
                            ids_submission.push(args.item.id_task);
                        }
                    },
                });
            @endif

            $('.save-submissions').on('click', function(e){
                e.preventDefault();
                var data = $("#submission").jsGrid("option", "data");
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    method: 'post',
                    data:{
                            'ids_submission': ids_submission,
                            'year': $('#year').val(),
                            'id_project': $('#id_project').val(),
                            'name': $('#project_name').val(),
                            data
                        },
                    url: '{{ route('save-update-submissions') }}',
                    success:function(response){
                        successToastr("Successfully saved");
                        tasks.length = 0;
                        tasks.push.apply(tasks, response.data);
                    },
                    error: function(xhr) {
                        if (xhr.status === 419) {
                            window.location.reload();
                        }
                    }
                });
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

            $('#id_directory_search').on('change', function(){
                var grid = $("#submission").data('JSGrid');
                grid.search({
                    id_directory: $(this).val(),
                }).done(function() {
                    $('#id_guide_search').empty().trigger('change');
                    $("#id_guide_search").prepend("<option selected></option>");

                    // let guides = [];
                    // @if (isset($guides))
                    //     guides = {!! $guides !!};
                    // @endif

                    createSearchFilter(grid.data, guides, 'id_guide_search', 'id_guide');
                });
            });

            $('#id_guide_search').on('change', function(){
                var grid = $("#submission").data('JSGrid');
                grid.search({
                    id_directory: $('#id_directory_search').val(),
                    id_guide: $(this).val(),
                }).done(function() {

                    $('#id_location_search').empty().trigger('change');
                    $("#id_location_search").prepend("<option selected></option>");

                    // let locations = [];
                    // @if (isset($locations))
                    //     locations = {!! $locations !!};
                    // @endif

                    createSearchFilter(grid.data, locations, 'id_location_search', 'id_location');
                });
            });

            $('#id_location_search').on('change', function(){
                var grid = $("#submission").data('JSGrid');
                grid.search({
                    id_directory: $('#id_directory_search').val(),
                    id_guide: $('#id_guide_search').val(),
                    id_location: $(this).val(),
                }).done(function() {

                    $('#id_practice_search').empty();
                    $("#id_practice_search").prepend("<option selected></option>");

                    // let practices = [];
                    // @if (isset($practices))
                    //     practices = {!! $practices !!};
                    // @endif

                    createSearchFilter(grid.data, practices, 'id_practice_search', 'id_practice');
                });
            });

            $('#id_practice_search').on('change', function(){
                var grid = $("#submission").data('JSGrid');
                grid.search({
                    id_directory: $('#id_directory_search').val(),
                    id_guide: $('#id_guide_search').val(),
                    id_location: $('#id_location_search').val(),
                    id_practice: $(this).val(),
                }).done(function() {
                });
            });

            $('#id_client').on('change', function(){
                $('#project_name').val($("#id_client :selected").text()+' '+$("#year :selected").text());
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

            $("#export-submissions").click(function () {
                var data = $('#submission').jsGrid('option', 'data');
                JSONToCSVConvertor(data, "Report Submissions", true);
            });

            $('.refresh-taxonomy').on('click', function(e){
                e.preventDefault();
                rfsh_id_guide = $('#id_guide_select').val();
                rfsh_id_location = $('#id_location_select').val();
                getDirectories($('#id_directory_select').val());

                getCatalogTaxonomies();

            });

        });

        function showSection(id)
        {
            var section = document.querySelectorAll('.section-project');

            section.forEach(item => {
                item.classList.remove('active');
            });

            if(id == 'submissions'){
                let submissions = document.getElementById('submissions');
                submissions.removeAttribute("hidden");
                $('.submissions').addClass('active');

                let element2 = document.getElementById('progress');
                element2.setAttribute("hidden", "hidden");

            } else {
                let element2 = document.getElementById('progress');
                element2.removeAttribute("hidden");
                $('.pro').addClass('active');

                let submissions = document.getElementById('submissions');
                submissions.setAttribute("hidden", "hidden");
            }
        }

        function insertItemSubmission()
        {
            if($('#id_directory_select').val() && $('#id_guide_select').val() && $('#id_location_select').val() && $('#id_practice_select').val())
            {
                $("#submission").jsGrid("insertItem", {
                    id_task: null,
                    id_project : $('#id_project').val(),
                    id_product: $('#id_product').val(),
                    id_directory: $('#id_directory_select').val(),
                    id_guide: $('#id_guide_select').val(),
                    id_location: $('#id_location_select').val(),
                    id_practice: $('#id_practice_select').val(),
                    name: $('#project_name').val(),
                    action: 'insert'
                }).done(function(e) {
                    $('#id_practice_select').val('').trigger('change');
                    var grid = $("#submission").data('JSGrid');

                    $('#id_directory_search').empty();
                    $("#id_directory_search").prepend("<option selected></option>");
                    $('#id_guide_search').empty();
                    $("#id_guide_search").prepend("<option selected></option>");
                    $('#id_location_search').empty();
                    $("#id_location_search").prepend("<option selected></option>");
                    $('#id_practice_search').empty();
                    $("#id_practice_search").prepend("<option selected></option>");

                    // let directories = [];
                    // @if (isset($directories))
                    //     directories = {!! $directories !!};
                    // @endif

                    // let guides = [];
                    // @if (isset($guides))
                    //     guides = {!! $guides !!};
                    // @endif

                    // let locations = [];
                    // @if (isset($locations))
                    //     locations = {!! $locations !!};
                    // @endif

                    // let practices = [];
                    // @if (isset($practices))
                    //     practices = {!! $practices !!};
                    // @endif

                    createSearchFilter(tasks, directories, 'id_directory_search', 'id_directory');
                    createSearchFilter(tasks, guides, 'id_guide_search', 'id_guide');
                    createSearchFilter(tasks, locations, 'id_location_search', 'id_location');
                    createSearchFilter(tasks, practices, 'id_practice_search', 'id_practice');

                    $(".select2-select").select2({closeOnSelect:false});
                    $("#id_practice_select").select2("open");
                    $("#submission").jsGrid("refresh");
                });
            } else {
                    errorToastr('You must select the required data')
            }
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
            var newUrl = new URL(url.href);
            var search_params = newUrl.searchParams;
            search_params.set(id_extern, setValue);
            newUrl.search = search_params.toString();

            var a = url;
                a.href = newUrl.toString();
        }

        function updateUrlParams()
        {
            let queryString = document.getElementById('url-edit-taxonomy').href;
            let paramString = queryString.split('?')[1];
            var currenturl = location.href.split('?')[0];

            var newUrl = currenturl+"?"+paramString;
            window.history.replaceState(null, null, newUrl)
        }

    </script>
    <script>
        function getCatalogTaxonomies()
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
                        case "deadline":
                            nameTitle = "Deadline";
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
                            nameItem = arrData[i][index];
                            break;

                        case "id_directory":
                            nameItem = directories.find(x => x.id_directory === idItem).name;
                            break;

                        case "id_guide":
                            nameItem = guides.find(x => x.id_guide === idItem).name;
                            break;

                        case "id_location":
                            nameItem = locations.find(x => x.id_location === idItem).name;
                            break;

                        case "id_practice":
                            nameItem = practices.find(x => x.id_practice === idItem).name;
                            break;

                        case "id_product":
                            nameItem = products.find(x => x.id_product === idItem).name;
                            break;

                        case "deadline":
                            let newDeadlineItem = 'undefined';
                            if (arrData[i][index]) {
                                newDeadlineItem = arrData[i][index];
                            }
                            nameItem = newDeadlineItem;
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
            var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);

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
    </script>

    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
@endpush
