
@extends('layouts.master')

@push('styles')
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />
    {{-- <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css"> --}}
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
            <!--begin::Card body-->
            <div class="card-body pt-2">
                <div class="py-2">
                    <div class="rounded border p-5">
                        <!--begin::Form-->
                        <form class="form" action="#">
                            <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-4">
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" multiple data-control="select2" id="id_client" data-placeholder="Select a client" data-allow-clear="true">
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" multiple data-control="select2" id="id_directory" data-placeholder="Select a directory" data-allow-clear="true">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" multiple data-control="select2" id="id_senior_consultant" data-placeholder="Select a senior consultant" data-allow-clear="true">
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" multiple data-control="select2" id="id_coordinator" data-placeholder="Select a coordinator" data-allow-clear="true">
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-4">
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" data-control="select2" id="year" data-placeholder="Select a year" data-allow-clear="true">
                                            {{-- <option></option> --}}
                                            {{-- <option value="{{ Carbon\Carbon::now()->year }}">{{ Carbon\Carbon::now()->year }}</option> --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" multiple data-control="select2" id="id_guide" data-placeholder="Select a guide" data-allow-clear="true">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" multiple data-control="select2" id="id_consultant" data-placeholder="Select a consultant" data-allow-clear="true">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" multiple data-control="select2" id="month" data-placeholder="Select a month" data-allow-clear="true">
                                            @for ($i = 0; $i <= 11; $i++)
                                                @php
                                                    $date = Carbon\Carbon::createFromFormat('Y-m-d', Carbon\Carbon::now()->format('Y').'-01-01')->addMonths($i);
                                                @endphp
                                               <option value="{{ ($date->format('m')) }}">{{ $date->format('F') }}</option>
                                            @endfor

                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-4">
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" multiple data-control="select2" id="status" data-placeholder="Select a status" data-allow-clear="true">
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" multiple data-control="select2" id="id_owner" data-placeholder="Select an owner" data-allow-clear="true">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="fv-row mb-2">
                                        <select class="form-select form-select-solid" multiple data-control="select2" id="id_lds" data-placeholder="Select a LDS" data-allow-clear="true">
                                            <option></option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
                <canvas id="kt_chartjs_2" class="mh-400px"></canvas>
                <div style="text-align:end; padding:5px; padding-top:50px">
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
                            <a href="#" id="save-allocation" class="btn btn-sm btn-primary update-tasks" style="border-top-left-radius: 0; border-bottom-left-radius: 0">
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
                            <select class="form-select form-select-solid" data-control="select2" id="id_senior_consultant_edit" data-placeholder="Select a senior consultant" data-allow-clear="true" data-dropdown-parent="#kt_modal_1">
                                @foreach (App\Repositories\UsersRepositories::getUsersSC() as $sc)
                                    <option value="{{ $sc->id_senior_consultant }}">{{ $sc->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7">
                            <select class="form-select form-select-solid" data-control="select2" id="id_consultant_edit" data-placeholder="Select a consultant" data-allow-clear="true" data-dropdown-parent="#kt_modal_1">
                                @foreach (App\Repositories\UsersRepositories::getUsersC() as $c)
                                    <option value="{{ $c->id_consultant }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="fv-row mb-7">
                            <select class="form-select form-select-solid" data-control="select2" id="id_lds_edit" data-placeholder="Select a LDS" data-allow-clear="true" data-dropdown-parent="#kt_modal_1">
                                @foreach (App\Repositories\UsersRepositories::getUsersLDS() as $lds)
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

        $( document ).ready(function(){
            directories = {!! $directories !!};
            guides = {!! $guides !!};
            locations = {!! $locations !!};
            practices = {!! $practices !!};
            clients = {!! $clients !!};
            products = {!! $products !!};
            owners = {!! $owners !!};
            years = {!! $years !!};
            scUsers = {!! $scUsers !!};
            cUsers = {!! $cUsers !!};
            lDSUsers = {!! $LDSUsers !!};
            coordUsers = {!! $CoordUsers !!};
            statuses = {!! $statuses !!};

            $('#id_client').on('change', function(){
                searchGrid('client');
                if(!$(this).val()){
                    createSearchFilter(tasks, clients, 'id_client', 'id_client');
                }
            });
            $('#id_senior_consultant').on('change', function(){
                searchGrid('sc');
                if(!$(this).val()){
                    createSearchFilter(tasks, scUsers, 'id_senior_consultant', 'id_senior_consultant');
                }
            });
            $('#id_coordinator').on('change', function(){
                searchGrid('coordinator');
                if(!$(this).val()){
                    createSearchFilter(tasks, coordUsers, 'id_coordinator', 'id_coordinator');
                }
            });
            $('#year').on('change', function(){
                searchGrid('year');
                if(!$(this).val()){
                    createYearFilter(tasks, years, 'year', 'year');
                }
            });
            $('#id_consultant').on('change', function(){
                searchGrid('consultant');
                if(!$(this).val()){
                    createSearchFilter(tasks, cUsers, 'id_consultant', 'id_consultant');
                }
            });
            $('#id_owner').on('change', function(){
                searchGrid('owner');
                if(!$(this).val()){
                    createSearchFilter(tasks, owners, 'id_owner', 'owner');
                }
            });
            $('#id_lds').on('change', function(){
                searchGrid('lds');
                if(!$(this).val()){
                    createSearchFilter(tasks, lDSUsers, 'id_lds', 'id_lds');
                }
            });
            $('#id_directory').on('change', function(){
                searchGrid('directory');
                if(!$(this).val()){
                    createSearchFilter(tasks, directories, 'id_directory', 'id_directory');
                }
            });
            $('#id_guide').on('change', function(){
                searchGrid('guide');
                if(!$(this).val()){
                    createSearchFilter(tasks, guides, 'id_guide', 'id_guide');
                }
            });
            $('#status').on('change', function(){
                searchGrid('status');
                if(!$(this).val()){
                    createSearchFilter(tasks, statuses, 'status', 'id_status');
                }
            });
            $('#month').on('change', function(){
                searchGrid();
            });

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

                                    return (!filter.ids_directory || filter.ids_directory.indexOf(item.id_directory) > -1)
                                        && (!filter.ids_guide ||  filter.ids_guide.indexOf(item.id_guide) > -1)
                                        && (!filter.ids_client || filter.ids_client.indexOf(item.id_client) > -1)
                                        && (!filter.year || item.year.indexOf(filter.year) > -1)
                                        && (!filter.ids_owner || filter.ids_owner.indexOf(item.owner) > -1)
                                        && (!filter.ids_senior_consultant || filter.ids_senior_consultant.indexOf(item.id_senior_consultant) > -1)
                                        && (!filter.ids_consultant || filter.ids_consultant.indexOf(item.id_consultant) > -1)
                                        && (!filter.ids_lds || filter.ids_lds.indexOf(item.id_lds) > -1)
                                        && (!filter.ids_coordinator || filter.ids_coordinator.indexOf(item.id_coordinator) > -1)
                                        && (!filter.ids_statuses || filter.ids_statuses.indexOf(item.id_status) > -1)
                                        && (!filter.months || filter.months.indexOf(date) > -1);
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
                                    tasks.length = 0;
                                    tasks.push.apply(tasks, response);
                                    createSearchFilter(tasks, clients, 'id_client', 'id_client');
                                    createSearchFilter(tasks, directories, 'id_directory', 'id_directory');
                                    createSearchFilter(tasks, guides, 'id_guide', 'id_guide');
                                    createSearchFilter(tasks, owners, 'id_owner', 'owner');
                                    createSearchFilter(tasks, scUsers, 'id_senior_consultant', 'id_senior_consultant');
                                    createSearchFilter(tasks, cUsers, 'id_consultant', 'id_consultant');
                                    createSearchFilter(tasks, lDSUsers, 'id_lds', 'id_lds');
                                    createSearchFilter(tasks, coordUsers, 'id_coordinator', 'id_coordinator');
                                    createSearchFilter(tasks, statuses, 'status', 'id_status');
                                    createYearFilter(tasks, years, 'year', 'year');
                                    d.resolve(response);
                                    on = true;
                                });
                            }
                        return d.promise();
                    },

                    insertItem: function(item){
                        tasks.push(item);
                    }
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
                    { name: "id_client", title: "Client", type: "select", items: clients, valueField: "id_client", textField: "name", width: 150, align: 'left', readOnly: true,

                    },
                    { name: "id_product", title: "Type", type: "select", items: products, valueField: "id_product", textField: "name", width: 150, align: 'left', readOnly: true,
                        itemTemplate: function(item) {
                            return $.grep(products, function(product) {
                                return product.id_product == item;
                            })[0].name;
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
                            return $.grep(guides, function(guide) {
                                return guide.id_guide == item;
                            })[0].name;
                        },
                    },
                    { name: "id_location", title: "Location", type: "select", items: locations, valueField: "id_location", textField: "name", validate: "required", autosearch: true, width: 150, align: 'left', readOnly: true,
                        itemTemplate: function(item) {
                            return $.grep(locations, function(location) {
                                return location.id_location == item;
                            })[0].name;
                        },
                    },
                    { name: "id_practice", title: "Practice", type: "select", items: practices, valueField: "id_practice", textField: "name", validate: "required", autosearch: true, width: 150, align: 'left', readOnly: true,
                        itemTemplate: function(item) {
                            return $.grep(practices, function(practice) {
                                return practice.id_practice == item;
                            })[0].name;
                        },
                    },
                    { name: "deadline", title: "Deadline", type: "text", width: 100, align: "center", readOnly: true,},
                    { name: "owner", title: "Owner", type: "select", items: owners, valueField: "owner", textField: "name", autosearch: true, width: 150, align: 'left', readOnly: true,
                        itemTemplate: function(item) {
                            return $.grep(owners, function(owner) {
                                return owner.owner == item;
                            })[0].name;
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
                    },
                    { name: "id_consultant", title: "Consultant", type: "select", items: cUsers, valueField: "id_consultant", textField: "name", autosearch: true, width: 150, align: 'left',
                    },
                    { name: "id_lds", title: "LDS", type: "select", items: lDSUsers, valueField: "id_lds", textField: "name", autosearch: true, width: 150, align: 'left',
                    },
                    { name: "id_coordinator", title: "Coordinator", type: "select", items: coordUsers, valueField: "id_coordinator", textField: "name", autosearch: true, width: 150, align: 'left',
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
                            $("#submissions").jsGrid("loadData");
                            searchGrid();
                            idBtn.removeAttribute("data-kt-indicator");
                        }
                    });
                }
            });

            getColors();

            var t = setInterval(oneSecondFunction,1000);

            function oneSecondFunction() {
                if(on == true){
                    clearInterval(t);
                    $('#year').val(new Date().getFullYear()).trigger('change');
                }
            }

        });

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

        function createSearchFilter(tasks, models, id_select_search, id)
        {
            let ids_item_init = tasks.map(function(item){//filtrar las task por el id
                return item[id];
            });

            let id_selected = $('#'+id_select_search).val();
            $('#'+id_select_search).empty();

            $.grep(models, function(model) {//buscamos si existe en el array
                return $.inArray(model[id], ids_item_init) > -1;
            }).forEach(function(item){
                var newOption = new Option(item.name, item[id], false, false);
                $('#'+id_select_search).append(newOption);
            });

            $('#'+id_select_search).val(id_selected);
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

        function searchGrid(from)
        {
            grid = $("#submissions").data('JSGrid');

            var year = $('#year').val();
            let ids_sc = $('#id_senior_consultant').val();
            var ids_client = $('#id_client').val();
            var ids_directory = $('#id_directory').val();
            let ids_guide = $('#id_guide').val();
            let ids_owner = $('#id_owner').val();
            let ids_consultant = $('#id_consultant').val();
            let ids_lds = $('#id_lds').val();
            let ids_coordinator = $('#id_coordinator').val();
            let ids_statuses = $('#status').val();
            let ids_month = $('#month').val();

            var searchGrid = {};

            if (ids_client.length > 0) {
                searchGrid.ids_client = ids_client.map(Number);
            }
            if (year.length > 0) {
                searchGrid.year = year;
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

            grid.search(searchGrid);
            filterGraph();
        }

        function filterGraph()
        {
            var tasksData = $("#submissions").jsGrid("option", "data");
            var groupArrayObject = tasksData.reduce((group, arr) => {
                const { id_senior_consultant } = arr;
                group[id_senior_consultant] = group[id_senior_consultant] ?? [];
                group[id_senior_consultant].push(arr);
                return group;
            },{});

            datasets.length = 0;
            // filtered
            let taskFiltered = Object.entries(groupArrayObject);
                taskFiltered.forEach(group => {
                    group[0] = Number(group[0]);
                });

            taskFiltered.forEach(function (a, i) {
                let usersFiltered =  scUsers.filter(function(user) {
                    return user.id_senior_consultant == a[0];
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
                    name = 'No SC Available';
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

        function filterGridFromGraph(names, monthName)
        {
            grid = $("#submissions").data('JSGrid');
            var searchGrid = {};
            var year = $('#year').val();
            var ids_client = $('#id_client').val();
            var ids_directory = $('#id_directory').val();
            let ids_guide = $('#id_guide').val();
            let ids_owner = $('#id_owner').val();
            let ids_consultant = $('#id_consultant').val();
            let ids_lds = $('#id_lds').val();
            let ids_coordinator = $('#id_coordinator').val();
            let ids_statuses = $('#status').val();
            var ids_sc = scUsers.filter(function(sc){
                if($.inArray(sc.name, names) > -1){
                    return sc;
                }
            }).map(sc=>sc.id_senior_consultant);
            if (ids_sc.length > 0) {
                searchGrid.ids_senior_consultant =  ids_sc.map(Number);
            }
            var month = [];
            if(monthName){
                month = [moment().month(monthName).format("M").padStart(2, '0')];
            } else {
                month = $('#month').val();
            }
            if (month.length > 0) {
                searchGrid.months = month;
            }
            if (ids_client.length > 0) {
                searchGrid.ids_client = ids_client.map(Number);
            }
            if (year.length > 0) {
                searchGrid.year = year;
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

            grid.search(searchGrid);
        }

        function filterGridFromGraphBySC(names)
        {
            grid = $("#submissions").data('JSGrid');
            grid.loadData();
            var year = $('#year').val();
            var ids_client = $('#id_client').val();
            var ids_directory = $('#id_directory').val();
            let ids_guide = $('#id_guide').val();
            let ids_owner = $('#id_owner').val();
            let ids_consultant = $('#id_consultant').val();
            let ids_lds = $('#id_lds').val();
            let ids_coordinator = $('#id_coordinator').val();
            let ids_statuses = $('#status').val();
            let ids_month = $('#month').val();
            let ids = Array.from(new Set(grid.data.map((item) => item.id_senior_consultant)));

            var ids_sc = scUsers.filter(function(sc){
                if($.inArray(sc.name, names) > -1 && $.inArray(sc.id_senior_consultant, ids) > -1){
                    return sc;
                }
            }).map(sc=>sc.id_senior_consultant);


            var searchGrid = {};
            if (ids_sc.length > 0) {
                searchGrid.ids_senior_consultant =  ids_sc.map(Number);
            }
            if (ids_client.length > 0) {
                searchGrid.ids_client = ids_client.map(Number);
            }
            if (year.length > 0) {
                searchGrid.year = year;
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

            grid.search(searchGrid);
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
                '#04F592',
                '#04F5E6',
                '#04A8F5',
                '#9204F5',
                '#FF5722',
                '#F5049D',
                '#7B1FA2',
                '#827717',
                '#78909C',
                '#1B5E20',
                '#5D4037',
                '#00695C',
                '#9E9D24',
                '#1A237E',
                '#B71C1C',
                '#880E4F',
                '#4A148C',
                '#311B92',
                '#0D47A1',
                '#01579B',
                '#006064',
                '#F57F17',
                '#FF6F00',
                '#BF360C',
                '#3E2723',
                '#FFFF00',
                '#CC33FF',
                '#6600FF',
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
    <script src="{{ URL::asset('admin/js/jsgrid.min.js') }}"></script>
@endpush
