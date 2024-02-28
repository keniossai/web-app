
@extends('layouts.master')

@push('styles')
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />
    {{-- <link href="{{ URL::asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" /> --}}
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
    </style>
@endpush

@section('master-title', '')
@section('master-header-buttons')

@endsection

@section('master-content')
<div class="card">
    <div class="card-header">
        <div class="card-title fs-3 fw-bold">
            Directory Taxonomy
        </div>
        <div class="card-title d-flex justify-content-end">
            <a href="#" class="btn btn-sm btn-primary add-record">
                <span class="svg-icon svg-icon-2">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                    </svg>
                </span>
                Add
            </a>
            &nbsp;
            <a href="#" class="btn btn-sm btn-primary save-directory-taxonomy">
                <span class="svg-icon svg-icon-muted svg-icon-2">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"/>
                            <path d="M17,4 L6,4 C4.79111111,4 4,4.7 4,6 L4,18 C4,19.3 4.79111111,20 6,20 L18,20 C19.2,20 20,19.3 20,18 L20,7.20710678 C20,7.07449854 19.9473216,6.94732158 19.8535534,6.85355339 L17,4 Z M17,11 L7,11 L7,4 L17,4 L17,11 Z" fill="currentColor" fill-rule="nonzero"/>
                            <rect fill="currentColor" opacity="0.3" x="12" y="4" width="3" height="5" rx="0.5"/>
                        </g>
                    </svg>
                </span>
                Save
            </a>
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
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <a href="#" class="link-primary" id="new-directory">New Directory</a>
                                            <a href="#" class="link-primary" id="edit-directory" hidden>Edit Directory</a>
                                        </label>
                                        <select class="form-select form-select-solid required" data-control="select2" id="id_directory_select" data-placeholder="Select a directory" data-allow-clear="true">
                                            <option></option>
                                            @foreach (App\Models\Directory::where('deleted', 0)->orderBy('name')->get() as $directory)
                                                <option value="{{ $directory->id_directory }}">{{ $directory->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <a href="#" tabindex="-1" class="link-primary" id="new-guide">New Guide</a>
                                            <a href="#" tabindex="-1" class="link-primary" id="edit-guide" hidden>Edit Guide</a>
                                        </label>
                                        <select class="form-select form-select-solid required" data-control="select2" id="id_guide_select" data-placeholder="Select a guide" data-allow-clear="true">
                                        </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            {{-- <a href="#" class="link-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_location">New Location</a> --}}
                                            <a href="#" tabindex="-1" class="link-primary" id="new-location" >New Location</a>
                                            <a href="#" tabindex="-1" class="link-primary" id="edit-location" hidden>Edit Location</a>
                                        </label>
                                        <select class="form-select form-select-solid required" data-control="select2" id="id_location_select" data-placeholder="Select a location" data-allow-clear="true">
                                            <option></option>
                                            @foreach (App\Models\Location::where('deleted', 0)->orderBy('name')->get() as $location)
                                                <option value="{{ $location->id_location }}">{{ $location->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <label class="fs-6 fw-semibold form-label mt-3">
                                            <a href="#" tabindex="-1" class="link-primary" id="new-practice">New Practice</a>
                                            <a href="#" tabindex="-1" class="link-primary" id="edit-practice" hidden>Edit Practice</a>
                                        </label>
                                        <select class="form-select form-select-solid required" data-control="select2" id="id_practice_select" data-placeholder="Select a practice" data-allow-clear="true">
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
                </div>
                <div style="text-align:end; padding:5px">
                    <a href="#" class="btn btn-sm btn-success" id="export-taxonomy">
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
                <div id="directory-taxonomy"></div>
            </div>
            <!--end::Card body-->
        </div>
    </div>
    <!--end::Content-->
</div>
@endsection
@push('modals')
    {{-- directory --}}
    <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Directory</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <input id="id_directory" value="" hidden>
                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-1">
                        <div class="col">
                            <div class="fv-row mb-7">
                                <input type="text" name="name" id="directory_name" class="form-control form-control-solid mb-3 mb-lg-0 required" placeholder="Name *" value="" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7">
                                <textarea class="form-control form-control-solid mb-8" rows="3"  name="description" id="directory_description" placeholder="Description"></textarea>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveDirectory()">Save</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="deleteDirectory()"id="delete_section" data-bs-dismiss="modal" hidden>Delete</button>
                </div>
            </div>
        </div>
    </div>

    {{-- guide --}}
    <div class="modal fade" tabindex="-1" id="kt_modal_guide">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Guide</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <input id="id_guide" value="" hidden>
                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-1">
                        <div class="col">
                            <div class="fv-row mb-7">
                                <select class="form-select form-select-solid required" data-control="select2" id="id_directory_guide" data-placeholder="Select a directory" data-allow-clear="true">
                                    <option></option>
                                    @foreach (App\Models\Directory::where('deleted', 0)->orderBy('name')->get() as $directory)
                                        <option value="{{ $directory->id_directory }}">{{ $directory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7">
                                <input type="text" name="name" id="guide_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Name *" value="" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7">
                                <textarea class="form-control form-control-solid mb-8" rows="3"  name="description" id="guide_description" placeholder="Description"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveGuide()">Save</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="deleteGuide()"id="delete_guide" data-bs-dismiss="modal" hidden>Delete</button>
                </div>
            </div>
        </div>
    </div>

    {{-- location --}}
    <div class="modal fade" tabindex="-1" id="kt_modal_location">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Location</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <input id="id_location" value="" hidden>
                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-1">
                        <div class="col">
                            <div class="fv-row mb-7">
                                <input type="text" name="name" id="location_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Name *" value="" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7">
                                <textarea class="form-control form-control-solid mb-8" rows="3"  name="description" id="location_description" placeholder="Description"></textarea>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7">
                                <input type="number" name="latitude" id="location_latitude" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Latitude" value="" />
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7">
                                <input type="number" name="longitude" id="location_longitude" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Longitude" value="" />
                            </div>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="saveLocation()">Save</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="deleteLocation()"id="delete_location" data-bs-dismiss="modal" hidden>Delete</button>
                </div>
            </div>
        </div>
    </div>

    {{-- practice --}}
    <div class="modal fade" tabindex="-1" id="kt_modal_practice">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">Practice</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <input id="id_practice" value="" hidden>
                    <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-1">
                        <div class="col">
                            <div class="fv-row mb-7">
                                <select class="form-select form-select-solid required" data-control="select2" id="id_directory_practice" data-dropdown-parent="#kt_modal_practice" data-placeholder="Select a directory" data-allow-clear="true">
                                    <option></option>
                                    @foreach (App\Models\Directory::where('deleted', 0)->orderBy('name')->get() as $directory)
                                        <option value="{{ $directory->id_directory }}">{{ $directory->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7">
                                <select class="form-select form-select-solid required" data-control="select2" id="id_practice_central_practice" data-dropdown-parent="#kt_modal_practice" data-placeholder="Select a central practice" data-allow-clear="true">
                                    @foreach (App\Models\CentralPractice::where('deleted', 0)->orderBy('name')->get() as $centralpractice)
                                        <option value="{{ $centralpractice->id_central_practice }}">{{ $centralpractice->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="fv-row mb-7">
                                <input type="text" name="name" id="practice_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Name *" value="" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="savePractice()">Save</button>
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="deletePractice()"id="delete_practice" data-bs-dismiss="modal" hidden>Delete</button>
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
        window.taxonomies = "";
        window.urlParams = "";
        window.orderDirectoriesName = [];
        window.orderGuidesName = [];
        window.orderLocationsName = [];
        window.orderPracticesName = [];
        window.centralPractice = "";

        $( document ).ready(function(){
            centralPracticeQty = $('#id_practice_central_practice option').length;
            const queryString = window.location.search;
            urlParams = new URLSearchParams(queryString);
            $('#id_directory_select').on('change', function(){
                searchGrid();
                if($(this).val()){
                    hideShowLabel('new-directory', true, 'edit-directory', false);
                    getGuides($(this).val());
                    getPractices($(this).val());
                    $('#id_location_select').val('').trigger('change');
                } else {
                    hideShowLabel('new-directory', false, 'edit-directory', true);
                    hideShowLabel('new-guide', false, 'edit-guide', true);
                    hideShowLabel('new-practice', false, 'edit-practice', true);
                    $('#id_guide_select').empty();
                    $('#id_practice_select').empty();
                    $('#id_location_select').val('').trigger('change');
                }
            });
            $('#new-directory').on('click', function(){
                $('#id_directory').val('');
                $('#directory_name').val('');
                $('#directory_description').val('');
                hideShowBtnDelete('delete_section', 'new');
                $('#kt_modal_1').modal('show').on('shown.bs.modal', function(){
                    $(this).find('#directory_name').focus();
                });
            });
            $('#edit-directory').on('click', function() {
                if($('#id_directory_select').val())
                {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        method: 'post',
                        data: {
                            'id_directory': $('#id_directory_select').val()
                        },
                        url: '{{ route('get-directory') }}',
                        success:function(response){
                            $('#id_directory').val(response.id_directory);
                            $('#directory_name').val(response.name);
                            $('#directory_description').val(response.description);
                            hideShowBtnDelete('delete_section', 'edit');
                            $('#kt_modal_1').modal('show');
                        },
                        error: function(xhr) {
                            if (xhr.status === 419) {
                                window.location.reload();
                            }
                        },
                    });
                }
            });

            $('#id_guide_select').on('change', function(){
                searchGrid();
                if($(this).val()){
                    hideShowLabel('new-guide', true, 'edit-guide', false);
                } else {
                    hideShowLabel('new-guide', false, 'edit-guide', true);
                }
            });
            $('#new-guide').on('click', function(){
                $("#id_directory_guide option:not(:selected)").prop("disabled", false);
                if($('#id_directory_select').val()){
                    $('#id_directory_guide').val($('#id_directory_select').val()).trigger('change');
                    $("#id_directory_guide option:not(:selected)").prop("disabled", true);
                }
                $('#id_guide').val('');
                $('#guide_name').val('');
                $('#guide_description').val('');
                hideShowBtnDelete('delete_guide', 'new');
                $('#kt_modal_guide').modal('show').on('shown.bs.modal', function(){
                    $(this).find('#guide_name').focus();
                });
            });
            $('#edit-guide').on('click', function() {
                $("#id_directory_guide option:not(:selected)").prop("disabled", false);
                if($('#id_guide_select').val())
                {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        method: 'post',
                        data: {
                            'id_guide': $('#id_guide_select').val()
                        },
                        url: '{{ route('get-guide') }}',
                        success:function(response){
                            $('#id_guide').val(response.id_guide);
                            $('#id_directory_guide').val(response.id_directory).trigger('change');
                            $('#guide_name').val(response.name);
                            $('#guide_description').val(response.description);
                            $("#id_directory_guide option:not(:selected)").prop("disabled", true);
                            hideShowBtnDelete('delete_guide', 'edit');
                            $('#kt_modal_guide').modal('show');
                        },
                        error: function(xhr) {
                            if (xhr.status === 419) {
                                window.location.reload();
                            }
                        },
                    });
                }
            });

            $('#id_location_select').on('change', function(){
                searchGrid();
                if($(this).val()){
                    hideShowLabel('new-location', true, 'edit-location', false);
                } else {
                    hideShowLabel('new-location', false, 'edit-location', true);
                }
            });
            $('#new-location').on('click', function(){
                $('#id_location').val('');
                $('#location_name').val('');
                $('#location_description').val('');
                $('#location_latitude').val('');
                $('#location_longitude').val('');
                hideShowBtnDelete('delete_location', 'new');
                $('#kt_modal_location').modal('show').on('shown.bs.modal', function(){
                    $(this).find('#location_name').focus();
                });
            });
            $('#edit-location').on('click', function() {
                if($('#id_location_select').val())
                {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        method: 'post',
                        data: {
                            'id_location': $('#id_location_select').val()
                        },
                        url: '{{ route('get-location') }}',
                        success:function(response){
                            $('#id_location').val(response.id_location);
                            $('#location_name').val(response.name);
                            $('#location_description').val(response.description);
                            $('#location_latitude').val(response.lat);
                            $('#location_longitude').val(response.long);
                            hideShowBtnDelete('delete_location', 'edit');
                            $('#kt_modal_location').modal('show');
                        },
                        error: function(xhr) {
                            if (xhr.status === 419) {
                                window.location.reload();
                            }
                        },
                    });
                }
            });

            $('#id_practice_select').on('change', function(){
                searchGrid();
                if($(this).val()){
                    hideShowLabel('new-practice', true, 'edit-practice', false);
                } else {
                    hideShowLabel('new-practice', false, 'edit-practice', true);
                }
            });
            $('#new-practice').on('click', function(){
                $("#id_directory_practice option:not(:selected)").prop("disabled", false);
                $('#id_directory_practice').val('').trigger('change');

                if($('#id_directory_select').val()){
                    $('#id_directory_practice').val($('#id_directory_select').val()).trigger('change');
                    $("#id_directory_practice option:not(:selected)").prop("disabled", true);
                }
                $('#id_practice').val('');
                $('#id_practice_central_practice').val('').trigger('change');
                $('#practice_name').val('');
                hideShowBtnDelete('delete_practice', 'new');
                // getCentralPractice();
                $('#kt_modal_practice').modal('show').on('shown.bs.modal', function(){
                    $(this).find('#practice_name').focus();
                });
            });
            $('#edit-practice').on('click', function() {
                if($('#id_practice_select').val())
                {
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        method: 'post',
                        data: {
                            'id_practice': $('#id_practice_select').val()
                        },
                        url: '{{ route('get-practice') }}',
                        success:function(response){
                            $('#id_practice').val(response.id_practice);
                            $('#id_directory_practice').val(response.id_directory).trigger('change');
                            $("#id_directory_practice option:not(:selected)");
                            $('#id_practice_central_practice').val(response.id_central_practice).trigger('change');
                            $('#practice_name').val(response.name);
                            hideShowBtnDelete('delete_practice', 'edit');
                            // getCentralPractice(response.id_central_practice);
                            $('#kt_modal_practice').modal('show');
                        },
                        error: function(xhr) {
                            if (xhr.status === 419) {
                                window.location.reload();
                            }
                        },
                    });
                }
            });

            taxonomies = {!! $taxonomies !!};
            directories = {!! $directories !!};
            guides = {!! $guides !!};
            locations = {!! $locations !!};
            practices = {!! $practices !!};
            var ids_taxonomy = [];
            var locationSelect = false;

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
            // grid taxonomy
            $("#directory-taxonomy").jsGrid({
                width: "100%",
                height: "auto",
                filtering: false,
                inserting: false,
                editing: true,
                sorting: true,
                paging: true,
                autoload: true,
                pageSize: 20,
                data: taxonomies,

                fields: [
                    { name: "id_directory", title: "Directory", type: "select", items: directories, valueField: "id_directory", textField: "name", width: 150, align: 'left', valueType: "string",
                        editTemplate: function(value) {
                            var guidesField = this._grid.fields[1];
                            var practicesField = this._grid.fields[3];

                            var $editControl = jsGrid.fields.select.prototype.editTemplate.call(this, value);

                            var changeDirectory = function() {
                                id_directory_selected = $editControl.val();

                                guidesField.items = $.grep(guides, function(guide) {
                                    return guide.id_directory == id_directory_selected || guide.id_guide == '';
                                });

                                $(".guide-edit").empty().append(guidesField.editTemplate());

                                //get practices
                                practicesField.items = $.grep(practices, function(practice) {
                                    return practice.id_directory == id_directory_selected || practice.id_practice == '';
                                });

                                $(".practice-edit").empty().append(practicesField.editTemplate());
                            };

                            $editControl.on("change", changeDirectory);
                            changeDirectory();

                            return $editControl;
                        },
                        itemTemplate: function(item) {
                            return $.grep(directories, function(directory) {
                                return directory.id_directory == item;
                            })[0].name;
                        },
                        sorter: function(id1, id2) {
            	            return orderDirectoriesName[id1].localeCompare(orderDirectoriesName[id2]);
						}
                    },
                    { name: "id_guide", title: "Guide", type: "select", items: guides, valueField: "id_guide", textField: "name", valueType: "string", validate: "required", autosearch: true, width: 150, align: 'left', editcss: "guide-edit",
                        itemTemplate: function(item) {
                            let result = $.grep(guides, function(guide) {
                                return guide.id_guide == item;
                            });

                            if (result.length > 0) {
                                return result[0].name;
                            }
                        },
                        sorter: function(id1, id2) {
                            if(id1 && id2){
                                return orderGuidesName[id1].localeCompare(orderGuidesName[id2]);
                            }
						}
                    },
                    { name: "id_location", title: "Location", type: "select", items: locations, valueField: "id_location", textField: "name", valueType: "string", validate: "required", autosearch: true, width: 150, align: 'left',
                        itemTemplate: function(item) {
                            let result = $.grep(locations, function(location) {
                                return location.id_location == item;
                            });

                            if (result.length > 0) {
                                return result[0].name;
                            }
                        },
                        sorter: function(id1, id2) {
                            if(id1 && id2){
            	                return orderLocationsName[id1].localeCompare(orderLocationsName[id2]);
                            }
						}
                    },
                    { name: "id_practice", title: "Practice", type: "select", items: practices, valueField: "id_practice", textField: "name", valueType: "string", validate: "required", autosearch: true, width: 150, align: 'left',  editcss: "practice-edit",
                        itemTemplate: function(item) {
                            let result = $.grep(practices, function(practice) {
                                return practice.id_practice == item;
                            });

                            if (result.length > 0) {
                                return result[0].name;
                            }
                        },
                        sorter: function(id1, id2) {
                            if(id1 && id2){
            	                return orderPracticesName[id1].localeCompare(orderPracticesName[id2]);
                            }
						}
                    },
                    { name: "id_taxonomy", valueField: "id_taxonomy", width: 0, visible: false},
                    { type: "control"}
                ],

                controller: {
                    loadData: function(filter) {
                        return $.grep(taxonomies, function(item) {
                            return (!filter.id_directory || item.id_directory == filter.id_directory)
                                && (!filter.id_guide || item.id_guide == filter.id_guide)
                                && (!filter.id_location || item.id_location == filter.id_location)
                                && (!filter.id_practice || item.id_practice == filter.id_practice);
                        });

                    },
                    insertItem: function(item){
                        taxonomies.push(item);
                    }
                },
                onItemUpdating: function(args) {
                    var findTaxonomy = taxonomies.filter(function(elemento) {
                        return elemento.id_directory == args.item.id_directory && elemento.id_guide == args.item.id_guide && elemento.id_location == args.item.id_location && elemento.id_practice == args.item.id_practice;
                    });
                    var validated = function(){
                        if(args.previousItem.id_directory != args.item.id_directory || args.previousItem.id_guide != args.item.id_guide || args.previousItem.id_location != args.item.id_location || args.previousItem.id_practice != args.item.id_practice)
                        {
                            return true;
                        } else {
                            return false;
                        }
                    }

                    if(findTaxonomy.length > 0  && validated())
                    {
                        args.cancel = true;
                        errorToastr("Taxonomy already exists");
                    }
                },

                onItemUpdated: function(args){
                    //formatear un valor antes de visualizar en la edicion
                    if(args.item.id_taxonomy != null){
                        args.item.action = 'update';
                        directories.push(args.item);
                    }
                },

                onItemDeleted: function(args){
                    if(args.item.id_taxonomy != null){
                        ids_taxonomy.push(args.item.id_taxonomy);
                    }
                },

                onItemInserting: function(args) {
                    var findTaxonomies = taxonomies.filter(function(elemento) {
                        return elemento.id_directory == args.item.id_directory && elemento.id_guide == args.item.id_guide && elemento.id_location == args.item.id_location && elemento.id_practice == args.item.id_practice
                    });

                    if(findTaxonomies.length > 0)
                    {
                        args.cancel = true;
                        errorToastr("Taxonomy already exists");
                    }
                },

                confirmDeleting: false,
                onItemDeleting: function (args) {
                    if (!args.item.deleteConfirmed) { // custom property for confirmation
                        args.cancel = true; // cancel deleting
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
                                args.item.deleteConfirmed = true;
                                $("#directory-taxonomy").jsGrid("deleteItem", args.item);

                                let index = taxonomies.findIndex(function(elemento) {
                                    return elemento.id_directory == args.item.id_directory && elemento.id_guide == args.item.id_guide && elemento.id_location == args.item.id_location && elemento.id_practice == args.item.id_practice
                                });

                                taxonomies.splice(index,1);

                                $("#directory-taxonomy").jsGrid("refresh");
                            }
                        });
                    }
                },

            });

            $('.save-directory-taxonomy').on('click', function(){
                var filteredData = taxonomies.filter(function (item) {
                    return (item.action == "update" || item.action == "insert");
                });

                if(filteredData.length == 0){
                    errorToastr('No data to save')
                }else{
                    $.ajax({
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        method: 'post',
                        data: {
                                'ids_taxonomy': ids_taxonomy,
                                filteredData
                            },
                        url: '{{ route('save-all-directory-taxonomy') }}',
                        success:function(response){
                            taxonomies.length = 0;
                            taxonomies.push.apply(taxonomies, response.data);
                            successToastr("Successfully saved");
                            $("#directory-taxonomy").jsGrid("loadData");
                            searchGrid();
                        },
                        error: function(xhr) {
                            if (xhr.status === 419) {
                                window.location.reload();
                            }
                        },
                    });
                }
            });

            $('.add-record').on('click', function(){
                if($('#id_directory_select').val() && $('#id_guide_select').val() && $('#id_location_select').val() && $('#id_practice_select').val())
                {
                    insertItemTaxonomy();
                } else {
                    errorToastr('You must select the required data');
                }
            });

            if(urlParams.has('id_directory')){
                $('#id_directory_select').val(urlParams.get('id_directory')).trigger('change');
            }

            if(urlParams.has('id_location')){
                $('#id_location_select').val(urlParams.get('id_location')).trigger('change');
                locationSelect = true;
            }

            $("#export-taxonomy").click(function () {
                var data = $('#directory-taxonomy').jsGrid('option', 'data');
                JSONToCSVConvertor(data, "Report Taxonomy", true);
            });

            $("#id_practice_central_practice").select2({
                createTag: function(params) {
                    var term = $.trim(params.term);
                    if (term === '') {
                        return null;
                    }
                    return {
                        id: term,
                        text: term,
                        newTag: true
                    }
                },
                templateResult: function (data) {
                    var $result = $("<span></span>");
                    $result.text(data.text);
                    if (data.newTag) {
                        $result.append("<strong> (Create) </strong>");
                    }
                    return $result;
                },
                tags: true
            });

            $("#id_practice_central_practice").on('change', function(){
                if($("#id_practice_central_practice").val()){
                    var text = $("#id_practice_central_practice option:selected").text();
                    $('#practice_name').val(text).focus().mouseup(function() {
                        $(this).select();
                    });
                }
            });
        });

        document.addEventListener('keyup', function (e) {
            if (e.keyCode === 9 && $('#id_directory_select').val() && $('#id_guide_select').val() && $('#id_location_select').val() && $('#id_practice_select').val()) {
                insertItemTaxonomy();
            }
        }, false);

        $(document).on('focus', '.form-select-solid', function (e) {
            $(this).closest(".select2-container").siblings('select:enabled').select2('open');
        });

        function insertItemTaxonomy()
        {
            if($('#id_directory_select').val() && $('#id_guide_select').val() && $('#id_location_select').val() && $('#id_practice_select').val())
            {
                $("#directory-taxonomy").jsGrid("insertItem", {
                    id_taxonomy: null,
                    id_directory : $('#id_directory_select').val(),
                    id_guide: $('#id_guide_select').val(),
                    id_location: $('#id_location_select').val(),
                    id_practice: $('#id_practice_select').val(),
                    action: 'insert'
                }).done(function(e) {
                    $('#id_practice_select').val('').trigger('change');
                });
            } else {
                    errorToastr('You must select the required data')
            }
        }

        function hideShowLabel(id_new, status_new, id_edit, status_edit)
        {
            document.getElementById(id_new).hidden = status_new;
            document.getElementById(id_edit).hidden = status_edit;
        }

        function hideShowBtnDelete(id, status)
        {
            let element = document.getElementById(id);
            if(status == 'edit')
            {
                element.removeAttribute("hidden");
            } else
            {
                element.setAttribute("hidden", "hidden");
            }
        }

        function getGuides(id_directory)
        {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {
                    'id_directory': id_directory
                },
                url: '{{ route('get-guides-by-directory') }}',
                success:function(response){
                    $('#id_guide_select').html(response);
                    if(urlParams.has('id_guide')){
                        $('#id_guide_select').val(urlParams.get('id_guide')).trigger('change');
                    }
                    // hideShowLabel('new-guide', false, 'edit-guide', true);
                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                },
            });
        }

        function getPractices(id_directory)
        {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {
                    'id_directory': id_directory
                },
                url: '{{ route('get-practices-by-directory') }}',
                success:function(response){
                    $('#id_practice_select').html(response);
                    if(urlParams.has('id_practice')){
                        $('#id_practice_select').val(urlParams.get('id_practice')).trigger('change');
                    }
                    // hideShowLabel('new-practice', false, 'edit-practice', true);
                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                },
            });
        }

        function createSearchFilter(taxonomies, models, id_select_search, id)
        {
            let ids_item_init = taxonomies.map(function(item){
                return item[id];
            })

            $.grep(models, function(model) {
                return $.inArray(model[id], ids_item_init) > -1;
            }).forEach(function(item){
                var newOption = new Option(item.name, item[id], false, false);
                $('#'+id_select_search).append(newOption);
            });
        }

        function searchGrid() {
            var grid = $("#directory-taxonomy").data('JSGrid');
            grid.search({
                id_directory: $('#id_directory_select').val(),
                id_guide: $('#id_guide_select').val(),
                id_location: $('#id_location_select').val(),
                id_practice: $('#id_practice_select').val(),
            });
        };

        function getCentralPractice()
        {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                url: '{{ route('get-central-practice') }}',
                success:function(response){
                    $('#id_practice_central_practice').html(response);
                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                },
            });
        }

    </script>
    <script>
        function saveDirectory()
        {
            if($('#directory_name').val())
            {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    method: 'post',
                    data: {
                        'id_directory': $('#id_directory').val(),
                        'name': $('#directory_name').val(),
                        'description':  $('#directory_description').val()
                    },
                    url: '{{ route('save-directory') }}',
                    success:function(response){
                        if(response && response.status == 1){
                            errorToastr('Directory already exists')
                        } else {
                            $('#id_directory_select').html(response);
                            $('#id_directory_guide').html(response);
                            $('#id_directory_practice').html(response);
                            $('#kt_modal_1').modal('hide');

                            orderDirectoriesName = [];
                            let selectElement = document.getElementById('id_directory_select');
                            $.each([...selectElement.options], function(_, option) {
                                orderDirectoriesName[option.value] = option.text;
                            });

                            saveUpdateOptionSelects('id_directory_select', 'id_directory', 0, directories);
                            hideShowLabel('new-directory', true, 'edit-directory', false);
                            searchGrid();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 419) {
                            window.location.reload();
                        }
                    },
                });
            }
        }

        function saveGuide()
        {
            if($('#id_directory_guide').val() && $('#guide_name').val())
            {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    method: 'post',
                    data: {
                        'id_guide': $('#id_guide').val(),
                        'id_directory': $('#id_directory_guide').val(),
                        'name': $('#guide_name').val(),
                        'description':  $('#guide_description').val()
                    },
                    url: '{{ route('save-guide') }}',
                    success:function(response){
                        if(response && response.status == 1){
                            errorToastr('Guide already exists')
                        } else {
                            $('#id_guide_select').html(response);
                            $('#kt_modal_guide').modal('hide');
                            let selectElement = document.getElementById('id_guide_select');
                            $.each([...selectElement.options], function(_, option) {
                                orderGuidesName[option.value] = option.text;
                            });

                            saveUpdateOptionSelects('id_guide_select', 'id_guide', 1, guides, $('#id_directory_guide').val());
                            hideShowLabel('new-guide', true, 'edit-guide', false);
                            searchGrid();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 419) {
                            window.location.reload();
                        }
                    },
                });
            }
        }

        function saveLocation()
        {
            if($('#location_name').val())
            {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    method: 'post',
                    data: {
                        'id_location': $('#id_location').val(),
                        'name': $('#location_name').val(),
                        'description': $('#location_description').val(),
                        'lat': $('#location_latitude').val(),
                        'long': $('#location_longitude').val(),
                        'id_guide': $('#id_guide_select').val()
                    },
                    url: '{{ route('save-location') }}',
                    success:function(response){
                        if(response && response.status == 1){
                            errorToastr('Location already exists')
                        } else {
                            $('#id_location_select').html(response);
                            $('#kt_modal_location').modal('hide');

                            orderLocationsName = [];
                            let selectElement = document.getElementById('id_location_select');
                            $.each([...selectElement.options], function(_, option) {
                                orderLocationsName[option.value] = option.text;
                            });
                            saveUpdateOptionSelects('id_location_select', 'id_location', 2, locations);
                            hideShowLabel('new-location', true, 'edit-location', false);
                            searchGrid();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 419) {
                            window.location.reload();
                        }
                    },
                });
            }
        }

        function savePractice()
        {
            if($('#id_directory_practice').val() && $('#practice_name').val())
            {
                $.ajax({
                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    method: 'post',
                    data: {
                        'id_practice': $('#id_practice').val(),
                        'name': $('#practice_name').val(),
                        'id_directory': $('#id_directory_practice').val(),
                        'id_central_practice': $('#id_practice_central_practice').val(),
                    },
                    url: '{{ route('save-practice') }}',
                    success:function(response){
                        if(response && response.status == 1){
                            errorToastr('Practice already exists')
                        } else {
                            $('#id_practice_select').html(response);
                            $('#kt_modal_practice').modal('hide');

                            let selectElement = document.getElementById('id_practice_select');
                            $.each([...selectElement.options], function(_, option) {
                                orderPracticesName[option.value] = option.text;
                            });

                            hideShowLabel('new-practice', true, 'edit-practice', false);
                            saveUpdateOptionSelects('id_practice_select', 'id_practice', 3, practices, $('#id_directory_practice').val());
                            searchGrid();
                            if($('#id_practice_central_practice').val() == $("#id_practice_central_practice option:selected").text()){
                                getCentralPractice()
                            }
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 419) {
                            window.location.reload();
                        }
                    },
                });
            }
        }

        function saveUpdateOptionSelects(id_select, id_item, column, model, id_extern)
        {
            let id = $("#"+id_select+" option:selected").val();
            let text = $("#"+id_select+" option:selected").text();

            var grid = $("#directory-taxonomy").jsGrid("option", "fields")[column].items;

            var itemIndex = grid.findIndex(x => x[id_item] == id);
            if(itemIndex == -1)
            {
                if(column == 1 || column == 3){
                    grid.push({
                        [id_item]: id,
                        id_directory: id_extern,
                        name: text
                    });
                } else {
                    grid.push({
                        [id_item]: id,
                        name: text
                    });
                }
            } else{
                grid[itemIndex] = {
                    ...grid[itemIndex],
                    name: text
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

            $("#directory-taxonomy").jsGrid("refresh");
        }

        function deleteDirectory()
        {
            if($('#id_directory').val())
            {
                Swal.fire({
                    html: 'Are you sure you want to delete this directory?',
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
                            data: {'id_directory' : $('#id_directory').val()},
                            url: "{{ route('delete-directory') }}",
                            success:function(response){
                                successToastr('Directory removed successfully');
                            },
                            error: function(xhr) {
                                if (xhr.status === 419) {
                                    window.location.reload();
                                }
                            },
                        }).then(function () {
                            window.location.reload();
                        });
                    }
                });
            }

        }

        function deleteGuide()
        {
            if($('#id_guide').val())
            {
                Swal.fire({
                    html: 'Are you sure you want to delete this guide?',
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
                            data: {'id_guide' : $('#id_guide').val()},
                            url: "{{ route('delete-guide') }}",
                            success:function(response){
                                successToastr('Guide removed successfully');
                            },
                            error: function(xhr) {
                                if (xhr.status === 419) {
                                    window.location.reload();
                                }
                            },
                        }).then(function () {
                            window.location.reload();
                        });
                    }
                });
            }
        }

        function deleteLocation()
        {
            if($('#id_location').val())
            {
                Swal.fire({
                    html: 'Are you sure you want to delete this location?',
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
                            data: {'id_location' : $('#id_location').val()},
                            url: "{{ route('delete-location') }}",
                            success:function(response){
                                successToastr('Location removed successfully');
                            },
                            error: function(xhr) {
                                if (xhr.status === 419) {
                                    window.location.reload();
                                }
                            },
                        }).then(function () {
                            window.location.reload();
                        });
                    }
                });
            }
        }

        function deletePractice()
        {
            if($('#id_practice').val())
            {
                Swal.fire({
                    html: 'Are you sure you want to delete this practice?',
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
                            data: {'id_practice' : $('#id_practice').val()},
                            url: "{{ route('delete-practice') }}",
                            success:function(response){
                                successToastr('Practice removed successfully');
                            },
                            error: function(xhr) {
                                if (xhr.status === 419) {
                                    window.location.reload();
                                }
                            },
                        }).then(function () {
                            window.location.reload();
                        });
                    }
                });
            }
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
                        case "id_taxonomy":
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
                        case "id_taxonomy":
                            let newNameItem = 'undefined';
                            if(arrData[i][index]){
                                newNameItem = arrData[i][index];
                            }
                            nameItem = newNameItem;
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
    {{-- <script src="{{ URL::asset('assets/plugins/global/plugins.bundle.js') }}"></script> --}}
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>

@endpush
