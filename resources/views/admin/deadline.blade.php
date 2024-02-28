@extends('layouts.master')

@section('master-title', '')

@push('styles')
    <link href="{{ URL::asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.css" />
    <link type="text/css" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid-theme.min.css" />
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <style>
        .form-select {
            background-image: none !important;
        }

        .select2-selection__clear {
            right: 1em !important;
        }

        .info-format {
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
    @if ($view == 'create' || $view == 'edit-header')
        {{-- form deadline h --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bold">
                    @if (isset($deadlineheader))
                        Edit
                    @else
                        Create
                    @endif
                </div>
                <div class="card-title d-flex justify-content-end">
                    @if (isset($deadlineheader))
                        <button type="submit" form="deadline-header-form" class="btn btn-sm btn-primary">
                            Save
                        </button>
                        &nbsp;
                    @else
                        <button type="submit" form="deadline-header-form" class="btn btn-sm btn-primary">
                            Create
                        </button>
                        &nbsp;
                    @endif

                    <a href="javascript:history.back()" class="btn btn-sm btn-secondary">Cancel</a>
                    &nbsp;

                    @if (isset($deadlineheader))
                        <a href="#" onclick="deleteDeadline('{{ $deadlineheader->id_deadline_header }}')"
                            class="btn btn-sm btn-danger">Delete</a>
                    @endif
                </div>
            </div>
            <form class="form" method="POST" id="deadline-header-form" action="{{ route('save-deadline-header') }}">
                @csrf
                <div class="card-body p-9">
                    <input name="id_deadline_header" value="{{ $deadlineheader->id_deadline_header ?? '' }}" hidden>
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3 required">Directory</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <select class="form-select form-select-solid" data-control="select2" name="id_directory"
                                data-placeholder="Select a directory" data-allow-clear="true" required>
                                <option></option>
                                @foreach (App\Models\Directory::where('deleted', 0)->orderBy('name')->get() as $directory)
                                    <option value="{{ $directory->id_directory }}"
                                        @if (old('id_directory', $deadlineheader->id_directory ?? '') == $directory->id_directory) selected @endif>{{ $directory->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3 required">Year</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <select class="form-select form-select-solid" data-control="select2" id="year"
                                name="year" data-placeholder="Select a year" data-allow-clear="true" required>
                                <option></option>
                                @for ($i = Carbon\Carbon::now()->subYear(2)->year; $i <= Carbon\Carbon::now()->addYear(2)->year; $i++)
                                    <option value="{{ $i }}" @if (old('year', $deadlineheader->year ?? '') == $i) selected @endif>
                                        {{ $i }}</option>
                                @endfor
                            </select>

                        </div>
                    </div>
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Description</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <textarea name="description" class="form-control form-control-solid h-100px">{{ old('description', $deadlineheader->description ?? '') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    @if (isset($deadlineheader))
                        <button type="submit" form="deadline-header-form" class="btn btn-sm btn-primary">
                            Save
                        </button>
                        &nbsp;
                    @else
                        <button type="submit" form="deadline-header-form" class="btn btn-sm btn-primary">
                            Create
                        </button>
                        &nbsp;
                    @endif

                    <a href="javascript:history.back()" class="btn btn-sm btn-secondary">Cancel</a>
                    &nbsp;

                    @if (isset($deadlineheader))
                        <a href="#" onclick="deleteDeadline('{{ $deadlineheader->id_deadline_header }}')"
                            class="btn btn-sm btn-danger">Delete</a>
                    @endif
                </div>
            </form>
        </div>
    @elseif (isset($deadlineheader))
        {{-- header deadline --}}
        <input id="id_deadline_header" name="id_deadline_header" value="{{ $deadlineheader->id_deadline_header ?? '' }}" hidden>
        <div class="card mb-5">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <div class="d-flex flex-column col-6">
                                <div class="d-flex align-items-center mb-1">
                                    <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">
                                        {{ $deadlineheader->directory->name }}
                                    </a>
                                    <span class="badge badge-light-success me-auto">In Progress</span>
                                </div>
                                <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-400">
                                    {{ $deadlineheader->description }}
                                </div>
                            </div>
                            <!--begin::Actions-->
                            <div class="d-flex mb-2 col-6 justify-content-end">
                                @if (App\Repositories\UsersRepositories::isAllowed('edit-deadline'))
                                    <a href="{{ route('read-deadlineheader', ['edit-header', 'id' => $deadlineheader->id_deadline_header]) }}" class="btn btn-sm btn-facebook" style="color:white">
                                        Edit deadline header
                                    </a>
                                @endif
                                &nbsp;
                                @if (App\Repositories\UsersRepositories::isAllowed('delete-deadline'))
                                    <a href="#" onclick="deleteDeadline('{{ $deadlineheader->id_deadline_header }}')" class="btn btn-sm btn-danger">Delete deadline package</a>
                                @endif
                            </div>
                            <!--end::Actions-->
                        </div>
                        <div class="d-flex flex-wrap justify-content-start">
                            <div class="d-flex flex-wrap">
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-4 fw-bold">
                                            {{ $deadlineheader->year }}
                                            <input id="deadline_year" value="{{ $deadlineheader->year }}" hidden>
                                        </div>
                                    </div>
                                    <div class="fw-semibold fs-6 text-gray-400">Year</div>
                                </div>
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-4 fw-bold">
                                            @php
                                                $timezone = Auth::user()->timezone;
                                                $date = Carbon\Carbon::parse($deadlineheader->created_at, isset($timezone) ? $timezone : 'UTC');
                                            @endphp

                                            {{ $date->isoFormat('MMMM Do YYYY') }}
                                        </div>
                                    </div>
                                    <div class="fw-semibold fs-6 text-gray-400">Created At</div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
                <!--end::Details-->
                <div class="separator"></div>
                {{-- menu sections --}}
                <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                    <li class="nav-item">
                        <a class="nav-link text-active-primary py-5 me-6 section-project active" href="#">Deadlines</a>
                    </li>

                </ul>
            </div>
        </div>
        <!--begin::deadline-->
        <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bold">
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-end pt-5">
                            @if (isset($view) && $view == 'view')
                                <a href="{{ route('read-deadlineheader', ['edit', 'id' => $deadlineheader->id_deadline_header]) }}" class="btn btn-sm btn-facebook" style="color:white">
                                    Edit deadline package
                                </a>
                            @endif
                            &nbsp;
                            <div class="menu menu-rounded menu-column menu-text-light fw-semibold w-auto" data-kt-menu="true">
                                <div class="menu-item p-0" @if (isset($view) && $view == 'view') data-kt-menu-trigger="none"  @else data-kt-menu-trigger="click"  @endif  data-kt-menu-placement="right-start">
                                    <a href="#" class="menu-link btn btn-sm btn-danger disabled" id="indicator-overwrite">
                                        <span class="menu-icon">
                                            <span class="svg-icon svg-icon-primary svg-icon-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <rect x="0" y="0" width="24" height="24" />
                                                        <path d="M11.1669899,4.49941818 L2.82535718,19.5143571 C2.557144,19.9971408 2.7310878,20.6059441 3.21387153,20.8741573 C3.36242953,20.9566895 3.52957021,21 3.69951446,21 L21.2169432,21 C21.7692279,21 22.2169432,20.5522847 22.2169432,20 C22.2169432,19.8159952 22.1661743,19.6355579 22.070225,19.47855 L12.894429,4.4636111 C12.6064401,3.99235656 11.9909517,3.84379039 11.5196972,4.13177928 C11.3723594,4.22181902 11.2508468,4.34847583 11.1669899,4.49941818 Z" fill="currentColor" opacity="0.3" />
                                                        <rect fill="currentColor" x="11" y="9" width="2" height="7" rx="1" />
                                                        <rect fill="currentColor" x="11" y="17" width="2" height="2" rx="1" />
                                                    </g>
                                                </svg>
                                            </span>
                                        </span>
                                        <span class="indicator-label">
                                            Overwrite
                                        </span>
                                        <span class="indicator-progress">
                                            Please wait...
                                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                        </span>
                                        &nbsp;
                                        <span class="svg-icon svg-icon-primary svg-icon-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                    <polygon points="0 0 24 0 24 24 0 24" />
                                                    <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                                        fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999) " />
                                                </g>
                                            </svg>
                                        </span>
                                    </a>
                                    <div class="menu-sub menu-sub-dropdown p-5 menu-state-bg">
                                        <div class="menu-item">
                                            <a href="#" class="menu-link px-1 py-3" id="update-deadline-submission-today">
                                                <span class="menu-title">Updated Today</span>
                                            </a>
                                        </div>

                                        <div class="menu-item ">
                                            <a href="#" class="menu-link px-1 py-3" id="update-deadline-submission">
                                                <span class="menu-title">All</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            &nbsp;
                            @if (App\Repositories\UsersRepositories::isAllowed('save-deadline'))
                                <button type="button" class="btn btn-sm btn-primary disabled" id="save-deadline">
                                    <span class="svg-icon svg-icon-muted svg-icon-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                <path d="M17,4 L6,4 C4.79111111,4 4,4.7 4,6 L4,18 C4,19.3 4.79111111,20 6,20 L18,20 C19.2,20 20,19.3 20,18 L20,7.20710678 C20,7.07449854 19.9473216,6.94732158 19.8535534,6.85355339 L17,4 Z M17,11 L7,11 L7,4 L17,4 L17,11 Z" fill="currentColor" fill-rule="nonzero" />
                                                <rect fill="currentColor" opacity="0.3" x="12" y="4" width="3" height="5" rx="0.5" />
                                            </g>
                                        </svg>
                                    </span>
                                    <span class="indicator-label">
                                        Save
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait... <span
                                            class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body pt-2">
                <div class="py-2">
                    <div class="rounded border p-5">
                        <form class="form pt-2" action="#" id="submission-form">
                            <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-4">
                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <select class="form-select form-select-solid required" data-control="select2" id="id_guide_select" data-placeholder="Select a guide" data-allow-clear="true">
                                            <option></option>
                                            @foreach (json_decode($guides, true) as $guide)
                                                <option value="{{ $guide['id_guide'] }}">{{ $guide['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <select class="form-select form-select-solid required" data-control="select2" id="id_location_select" data-placeholder="Select a location" data-allow-clear="true">
                                            <option></option>
                                            @foreach (json_decode($locations, true) as $location)
                                                <option value="{{ $location['id_location'] }}">{{ $location['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="fv-row mb-7">
                                        <select class="form-select form-select-solid required" data-control="select2" id="id_practice_select" data-placeholder="Select a practice" data-allow-clear="true">
                                            <option></option>
                                            @foreach (json_decode($practices, true) as $practice)
                                                <option value="{{ $practice['id_practice'] }}">{{ $practice['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <div style="text-align:end; padding:5px; float: right;">
                    <div class="btn-group">
                        <button type="button" class="btn btn-primary btn-sm btn-edit disabled" id="edit-data">
                            <span class="svg-icon svg-icon-g svg-icon-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                        <rect x="0" y="0" width="24" height="24" />
                                        <path
                                            d="M8,17.9148182 L8,5.96685884 C8,5.56391781 8.16211443,5.17792052 8.44982609,4.89581508 L10.965708,2.42895648 C11.5426798,1.86322723 12.4640974,1.85620921 13.0496196,2.41308426 L15.5337377,4.77566479 C15.8314604,5.0588212 16,5.45170806 16,5.86258077 L16,17.9148182 C16,18.7432453 15.3284271,19.4148182 14.5,19.4148182 L9.5,19.4148182 C8.67157288,19.4148182 8,18.7432453 8,17.9148182 Z"
                                            fill="currentColor" fill-rule="nonzero"
                                            transform="translate(12.000000, 10.707409) rotate(-135.000000) translate(-12.000000, -10.707409) " />
                                        <rect fill="currentColor" opacity="0.3" x="5" y="20" width="15" height="2" rx="1" />
                                    </g>
                                </svg>
                            </span>
                            Edit
                        </button>
                        <div class="menu menu-column menu-gray-600 menu-state-bg fw-semibold w-50px" data-kt-menu="true">
                            <button type="button" class="btn btn-primary btn-sm"
                                style="border-top-left-radius: 0; border-bottom-left-radius: 0"
                                data-kt-menu-trigger="click" data-kt-menu-placement="right-start">
                                <span class="svg-icon svg-icon-primary svg-icon-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                            <polygon points="0 0 24 0 24 24 0 24" />
                                            <path
                                                d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                                fill="currentColor" fill-rule="nonzero"
                                                transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999) " />
                                        </g>
                                    </svg>
                                </span>
                                <div class="menu-sub menu-sub-dropdown p-3 ">
                                    <div class="menu-item">
                                        <a href="#" class="menu-link px-1 py-3" id="export-deadline">
                                            <span class="svg-icon svg-icon-2">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="#009ef7"></rect>
                                                    <path
                                                        d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z"
                                                        fill="#009ef7"></path>
                                                    <path opacity="0.3"
                                                        d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z"
                                                        fill="#009ef7"></path>
                                                </svg>
                                            </span>
                                            Export CSV
                                        </a>
                                    </div>
                                    <div class="menu-item">
                                        @if (App\Repositories\UsersRepositories::isAllowed('import-file-deadline') && (isset($view) && $view != 'view'))
                                            <a href="#" class="menu-link px-1 py-3 " id="import-file">
                                                <span class="svg-icon svg-icon-primary svg-icon-2">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                            fill-rule="evenodd">
                                                            <rect x="0" y="0" width="24"
                                                                height="24" />
                                                            <rect fill="#009ef7" opacity="0.3"
                                                                transform="translate(12.000000, 7.000000) rotate(-180.000000) translate(-12.000000, -7.000000) "
                                                                x="11" y="1" width="2"
                                                                height="12" rx="1" />
                                                            <path
                                                                d="M17,8 C16.4477153,8 16,7.55228475 16,7 C16,6.44771525 16.4477153,6 17,6 L18,6 C20.209139,6 22,7.790861 22,10 L22,18 C22,20.209139 20.209139,22 18,22 L6,22 C3.790861,22 2,20.209139 2,18 L2,9.99305689 C2,7.7839179 3.790861,5.99305689 6,5.99305689 L7.00000482,5.99305689 C7.55228957,5.99305689 8.00000482,6.44077214 8.00000482,6.99305689 C8.00000482,7.54534164 7.55228957,7.99305689 7.00000482,7.99305689 L6,7.99305689 C4.8954305,7.99305689 4,8.88848739 4,9.99305689 L4,18 C4,19.1045695 4.8954305,20 6,20 L18,20 C19.1045695,20 20,19.1045695 20,18 L20,10 C20,8.8954305 19.1045695,8 18,8 L17,8 Z"
                                                                fill="#009ef7" fill-rule="nonzero" opacity="0.3" />
                                                            <path
                                                                d="M14.2928932,10.2928932 C14.6834175,9.90236893 15.3165825,9.90236893 15.7071068,10.2928932 C16.0976311,10.6834175 16.0976311,11.3165825 15.7071068,11.7071068 L12.7071068,14.7071068 C12.3165825,15.0976311 11.6834175,15.0976311 11.2928932,14.7071068 L8.29289322,11.7071068 C7.90236893,11.3165825 7.90236893,10.6834175 8.29289322,10.2928932 C8.68341751,9.90236893 9.31658249,9.90236893 9.70710678,10.2928932 L12,12.5857864 L14.2928932,10.2928932 Z"
                                                                fill="#009ef7" fill-rule="nonzero" />
                                                        </g>
                                                    </svg>
                                                </span>
                                                <span class="menu-title">Import CSV</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>

                <div style="margin-top:18px;">
                    <span class="badge badge-square badge-primary badge-ms" id="deadlineTotal"></span> Saved
                    &nbsp; &nbsp;
                    <span class="badge badge-square badge-primary badge-ms" id="deadlinesNew"></span> New
                </div>
                <div id="deadlines"></div>
            </div>
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
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-1"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <input id="id_directory" value="" hidden>
                    <div class="col">
                        <div class="mb-7">
                            <input class="form-control form-control-solid" placeholder="Deadline" id="deadline"
                                name="deadline" data-dropdown-parent="#kt_modal_1" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="d-flex fw-semibold h-100">
                            <div class="form-check form-check-custom form-check-solid me-9">
                                <input class="form-check-input" type="checkbox" value="" id="confirmed" />
                                <label class="form-check-label ms-3" for="confirmed">Confirmed</label>
                            </div>
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

    <div class="modal fade" tabindex="-1" id="upload-file">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">File upload</h3>
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                        aria-label="Close">
                        <span class="svg-icon svg-icon-1"></span>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="card h-100 flex-center bg-light-primary border-primary border border-dashed p-8">
                        <span class="svg-icon svg-icon-primary svg-icon-2x">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <polygon points="0 0 24 0 24 24 0 24" />
                                    <path
                                        d="M5.85714286,2 L13.7364114,2 C14.0910962,2 14.4343066,2.12568431 14.7051108,2.35473959 L19.4686994,6.3839416 C19.8056532,6.66894833 20,7.08787823 20,7.52920201 L20,20.0833333 C20,21.8738751 19.9795521,22 18.1428571,22 L5.85714286,22 C4.02044787,22 4,21.8738751 4,20.0833333 L4,3.91666667 C4,2.12612489 4.02044787,2 5.85714286,2 Z"
                                        fill="currentColor" fill-rule="nonzero" opacity="0.3" />
                                    <path
                                        d="M8.95128003,13.8153448 L10.9077535,13.8153448 L10.9077535,15.8230161 C10.9077535,16.0991584 11.1316112,16.3230161 11.4077535,16.3230161 L12.4310522,16.3230161 C12.7071946,16.3230161 12.9310522,16.0991584 12.9310522,15.8230161 L12.9310522,13.8153448 L14.8875257,13.8153448 C15.1636681,13.8153448 15.3875257,13.5914871 15.3875257,13.3153448 C15.3875257,13.1970331 15.345572,13.0825545 15.2691225,12.9922598 L12.3009997,9.48659872 C12.1225648,9.27584861 11.8070681,9.24965194 11.596318,9.42808682 C11.5752308,9.44594059 11.5556598,9.46551156 11.5378061,9.48659872 L8.56968321,12.9922598 C8.39124833,13.2030099 8.417445,13.5185067 8.62819511,13.6969416 C8.71848979,13.773391 8.8329684,13.8153448 8.95128003,13.8153448 Z"
                                        fill="currentColor" />
                                </g>
                            </svg>
                        </span>
                        <input type="file" id="file_upload" name="file_upload" hidden />
                        <label for="file_upload" class="btn text-gray-600 text-hover-primary fs-5 fw-bold mb-2">Choose
                            file</label>
                        {{-- <div class="fs-7 fw-semibold text-gray-400">Drag and drop files here</div> --}}
                    </div>
                    <!--end::Card-->
                    <div class="dropzone-items wm-200px pt-3">
                        <div class="dropzone-item">
                            <!--begin::File-->
                            <div class="dropzone-file">
                                <span id="file-chosen-deadline" class="form-text text-muted"></span>
                            </div>
                            <!--end::File-->
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="fileUpload()" id="uploadFile">
                        <span class="indicator-label">
                            Upload
                        </span>
                        <span class="indicator-progress">
                            Please wait... <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            window.guides = "";
            window.locations = "";
            window.practices = "";
            window.deadlines = "";
            window.orderGuidesName = [];
            window.orderLocationsName = [];
            window.orderPracticesName = [];

            var isEditing = true;
            @if (isset($view) && $view == 'view')
                isEditing = false;
            @endif
            $("#deadline").flatpickr();

            @if (isset($deadlineheader))
                guides = {!! $guides !!};
                locations = {!! $locations !!};
                practices = {!! $practices !!};
                deadlines = {!! $deadlines !!};

                $.each(guides, function(_, guide) {
                    orderGuidesName[guide.id_guide] = guide.name;
                });

                $.each(locations, function(_, location) {
                    orderLocationsName[location.id_location] = location.name;
                });

                $.each(practices, function(_, practice) {
                    orderPracticesName[practice.id_practice] = practice.name;
                });

                countNewTotalDeadlines(deadlines);

                var ids_deadline = [];

                var MyDateField = function(config) {
                    jsGrid.Field.call(this, config);
                };

                MyDateField.prototype = new jsGrid.Field({
                    sorter: function(date1, date2) {
                        return new Date(date1) - new Date(date2);
                    },

                    itemTemplate: function(value) {
                        if (value) {
                            if (value.toLowerCase().indexOf("Date") == -1) {
                                return moment(new Date(value).toISOString()).utc().format('DD/MM/YYYY');
                            } else {
                                value = new Date(parseInt(value.substr(6)));
                                dt = new Date(value); //.toDateString();
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
                        return this._insertPicker = $("<input>").datepicker({
                            defaultDate: new Date()
                        });
                    },
                    editTemplate: function(value) {
                        let date = value;
                        if (value) {
                            date = moment(new Date(value).toISOString()).utc().format('DD/MM/YYYY');
                        }
                        return this._editPicker = $("<input>").datepicker({ dateFormat: 'dd/mm/yy'}).datepicker("setDate", date);
                    },
                    insertValue: function() {
                        return this._insertPicker.datepicker("getDate").toISOString();
                    },
                    editValue: function() {
                        if (this._editPicker.datepicker("getDate")) {
                            return moment(this._editPicker.datepicker("getDate").toISOString()).utc()
                                .format('YYYY-MM-DD');
                        } else {
                            return "";
                        }
                    }
                });

                jsGrid.fields.myDateField = MyDateField;

                // grid deadlines
                $("#deadlines").jsGrid({
                    width: "100%",
                    height: "auto",
                    filtering: false,
                    inserting: false,
                    editing: isEditing,
                    sorting: true,
                    paging: true,
                    autoload: true,
                    pageSize: 17,
                    data: deadlines,

                    fields: [{
                            headerTemplate: function() {
                                return $("<input>").attr("type", "checkbox").attr("id",
                                    "selectAllCheckbox")
                            },
                            itemTemplate: function(_, item) {
                                return $("<input>").attr("type", "checkbox").attr("class",
                                        "singleCheckbox")
                                    .prop("checked", $.inArray(item, selectedItems) > -1)
                                    .on("click", function(event) {
                                        $(this).is(":checked") ? (selectItem(item),
                                            enableDisableBtn(false)) : (unselectItem(item),
                                            enableDisableBtn(true));
                                        event.stopPropagation();
                                    });
                            },
                            sorting: false, align: "center", width: 30, visible: isEditing
                        },
                        {
                            name: "id_guide", title: "Guide", type: "select", items: guides, valueField: "id_guide", textField: "name", validate: "required", autosearch: true, width: 150,  align: 'left',
                            itemTemplate: function(item) {
                                let result = $.grep(guides, function(guide) {
                                    return guide.id_guide == item;
                                });

                                if (result.length > 0) {
                                    return result[0].name;
                                }
                            },
                            sorter: function(id1, id2) {
                                return orderGuidesName[id1].localeCompare(orderGuidesName[id2]);
                            }
                        },
                        {
                            name: "id_location", title: "Location", type: "select", items: locations, valueField: "id_location", textField: "name", validate: "required", autosearch: true, width: 150, align: 'left',
                            itemTemplate: function(item) {
                                let result =$.grep(locations, function(location) {
                                    return location.id_location == item;
                                });

                                if (result.length > 0) {
                                    return result[0].name;
                                }
                            },
                            sorter: function(id1, id2) {
                                return orderLocationsName[id1].localeCompare(orderLocationsName[id2]);
                            }
                        },
                        {
                            name: "id_practice", title: "Practice", type: "select", items: practices, valueField: "id_practice", textField: "name", validate: "required", autosearch: true, width: 150, align: 'left',
                            itemTemplate: function(item) {
                                let result = $.grep(practices, function(practice) {
                                    return practice.id_practice == item;
                                });

                                if (result.length > 0) {
                                    return result[0].name;
                                }
                            },
                            sorter: function(id1, id2) {
                                return orderPracticesName[id1].localeCompare(orderPracticesName[id2]);
                            }
                        },
                        {
                            name: "deadline", title: "Deadline", type: "myDateField", width: 100, align: "center"
                        },
                        {
                            name: 'confirmed', type: "checkbox", title: "Confirmed", sorting: true, align: "center", width: 70
                        },
                        {
                            name: "id_deadline", valueField: "id_deadline", width: 0, visible: false
                        },
                        {
                            type: "control",  visible: isEditing
                        }
                    ],

                    controller: {
                        loadData: function(filter) {
                            return $.grep(deadlines, function(item) {
                                return (!filter.id_guide || item.id_guide == filter.id_guide)
                                    && (!filter.id_location || item.id_location == filter.id_location)
                                    && (!filter.id_practice || item.id_practice == filter.id_practice);
                            });
                        },
                    },

                    onItemUpdating: function(args) {
                        var findDeadline = deadlines.filter(function(elemento) {
                            return elemento.id_guide == args.item.id_guide && elemento.id_location == args.item.id_location && elemento.id_practice == args.item.id_practice;
                        });
                        var validated = function(){
                            if(args.previousItem.id_guide != args.item.id_guide || args.previousItem.id_location != args.item.id_location || args.previousItem.id_practice != args.item.id_practice)
                            {
                                return true;
                            } else {
                                return false;
                            }
                        }

                        if(findDeadline.length > 0  && validated())
                        {
                            args.cancel = true;
                            toastrAlert("Submission already exists", "error");
                        }
                    },

                    onItemUpdated: function(args) {
                        //formatear un valor antes de visualizar en la edicion
                        if (args.item.id_deadline != null) {
                            args.item.action = 'update';
                        }
                    },

                    onItemDeleted: function(args) {
                        if (args.item.id_deadline != null) {
                            ids_deadline.push(args.item.id_deadline);
                        }
                    },

                    // confirmDeleting: false,
                    confirmDeleting: false,
                    onItemDeleting: function(args) {
                        if (!args.item.deleteConfirmed) { // custom property for confirmation
                            args.cancel = true; // cancel deleting
                            Swal.fire({
                                html: 'Are you sure you want to delete this deadline?',
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
                                    $("#deadlines").jsGrid("deleteItem", args.item);
                                    let index = deadlines.findIndex(function(elemento) {
                                        return elemento.id_guide == args.item
                                            .id_guide && elemento.id_location == args
                                            .item.id_location && elemento.id_practice ==
                                            args.item.id_practice
                                    });

                                    deadlines.splice(index, 1);

                                    $("#deadlines").jsGrid("refresh");
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
                var grid = $("#deadlines").jsGrid("option", "data");
                if (this.checked) { // check select status
                    $('.singleCheckbox').each(function() {
                        this.checked = true;
                    });

                    grid.map(function(item) {
                        selectItem(item);
                    });
                    enableDisableBtn(false);
                } else {
                    $('.singleCheckbox').each(function() {
                        this.checked = false;
                    });

                    grid.map(function(item) {
                        unselectItem(item);
                    });
                    enableDisableBtn(true);
                }
            });

            $('#edit-data').on('click', function(e) {
                e.preventDefault();
                $('#deadline').val('');
                $('#id_product_edit').val('').trigger('change');
                $('#kt_modal_1').modal('show');
            });
            //End select checkbox functionality

            $('#save-deadline').on('click', function(e) {
                e.preventDefault();

                var saveDeadline = document.querySelector("#save-deadline");

                var filteredData = deadlines.filter(function(item) {
                    return (item.id_deadline == null || item.action == "update");
                });
                if (filteredData.length == 0 && ids_deadline.length == 0) {
                    toastrAlert('There is no new deadlines', 'warning');
                    return;
                }

                saveDeadline.setAttribute("data-kt-indicator", "on");

                var newdata = {
                    ids_deadline: ids_deadline,
                    id_deadline_header: $('#id_deadline_header').val(),
                    filteredData: filteredData,
                }

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'post',
                    data: JSON.stringify(newdata),
                    contentType: "application/json; charset=utf-8",
                    dataType: "json",
                    traditional: true,
                    url: '{{ route('save-deadline') }}',
                    success: function(response) {
                        toastrAlert("Successfully saved", 'success');
                        deadlines.length = 0;
                        deadlines.push.apply(deadlines, response.data);
                        $("#selectAllCheckbox").prop("checked", false);
                        $('#edit-data').addClass('disabled');
                        $("#deadlines").jsGrid("loadData");
                    },
                    error: function(xhr) {
                        if (xhr.status === 419) {
                            window.location.reload();
                        }
                    },
                }).then(function() {
                    // disable indicator after success
                    saveDeadline.removeAttribute("data-kt-indicator");
                    countNewTotalDeadlines(deadlines);
                    searchGrid($('#id_guide_select').val(), $('#id_location_select').val(), $('#id_practice_select').val())
                });
            });

            $("#export-deadline").click(function(e) {
                e.preventDefault();
                var data = $('#deadlines').jsGrid('option', 'data');
                var filteredData = data.filter(function(item) {
                    return (item.id_deadline != null);
                });
                if (filteredData.length == 0) {
                    toastrAlert('You must save deadlines before exporting', 'warning');
                    return;
                }
                JSONToCSVConvertor(filteredData, "Report Deadline", true);
            });

            $('#id_guide_select').on('change', function() {
                $('#id_location_select').val('').trigger('change');
                $('#id_practice_select').val('').trigger('change');
                searchGrid($(this).val(), $('#id_location_select').val(), $('#id_practice_select').val());
            });

            $('#id_location_select').on('change', function() {
                $('#id_practice_select').val('').trigger('change');
                searchGrid($('#id_guide_select').val(), $(this).val(), $('#id_practice_select').val());
            });

            $('#id_practice_select').on('change', function() {
                searchGrid($('#id_guide_select').val(), $('#id_location_select').val(), $(this).val())
            });

            $(document).on('focus', '.form-select-solid', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            });

            var searchGrid = function(id_guide, id_location, id_practice) {
                var grid = $("#deadlines").data('JSGrid');
                grid.search({
                    id_guide: id_guide,
                    id_location: id_location,
                    id_practice: id_practice,
                });

                updateAllFilter(grid.data);
            };

            $('#import-file').on('click', function(e) {
                e.preventDefault();
                $('#file_upload').val('');
                let fileChosen = document.getElementById('file-chosen-deadline');
                fileChosen.textContent = "";
                $('#upload-file').modal('show');
            });
            const currentBtn = document.getElementById('file_upload');
            const fileChosen = document.getElementById('file-chosen-deadline');
            currentBtn.addEventListener('change', function() {
                fileChosen.textContent = this.files[0].name;
            });

            $('#update-deadline-submission').on('click', function(e) {
                e.preventDefault();
                var statusDeadline = false;
                var saveDeadline = document.querySelector("#indicator-overwrite");

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'post',
                    data: {
                        'id_deadline_header': $('#id_deadline_header').val()
                    },
                    url: "{{ route('get-deadlines-by-header') }}",
                    success: function(response) {
                        if (response == 0) {
                            statusDeadline = false;
                            toastrAlert("No set or confirmed deadlines", 'warning');
                        } else {
                            statusDeadline = true;
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 419) {
                            window.location.reload();
                        }
                    },
                }).then(function(response) {
                    if (statusDeadline) {
                        Swal.fire({
                            html: 'By selecting "Yes", all confirmed deadlines on this page will overwrite all submission deadlines.',
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
                                saveDeadline.setAttribute("data-kt-indicator", "on");
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    method: 'post',
                                    data: {
                                        'id_deadline_header': $('#id_deadline_header').val()
                                    },
                                    url: "{{ route('update-deadline-submission') }}",
                                    success: function(response) {
                                        let type = response.status == true ? 'success' : 'error';
                                        toastrAlert(response.message, type)
                                        saveDeadline.removeAttribute("data-kt-indicator");
                                    },
                                    error: function(xhr) {
                                        if (xhr.status === 419) {
                                            window.location.reload();
                                        }
                                    }
                                }).then(function() {});
                            }
                        });
                    }
                });
            });

            $('#update-deadline-submission-today').on('click', function(e) {
                e.preventDefault();
                var statusDeadline = false;
                var saveDeadline = document.querySelector("#indicator-overwrite");

                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    method: 'post',
                    data: {
                        'id_deadline_header': $('#id_deadline_header').val()
                    },
                    url: "{{ route('get-deadlines-by-header') }}",
                    success: function(response) {
                        if (response == 0) {
                            statusDeadline = false;
                            toastrAlert("No set or confirmed deadlines", 'warning');
                        } else {
                            statusDeadline = true;
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 419) {
                            window.location.reload();
                        }
                    },
                }).then(function(response) {
                    if (statusDeadline) {
                        Swal.fire({
                            html: 'By selecting "Yes", all confirmed deadlines on this today will overwrite all submission deadlines.',
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
                                saveDeadline.setAttribute("data-kt-indicator", "on");
                                $.ajax({
                                    headers: {
                                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                    },
                                    method: 'post',
                                    data: {
                                        'id_deadline_header': $('#id_deadline_header').val()
                                    },
                                    url: "{{ route('update-deadline-submission-today') }}",
                                    success: function(response) {
                                        let type = response.status == true ? 'success' : 'error';
                                        toastrAlert(response.message, type)
                                        saveDeadline.removeAttribute("data-kt-indicator");
                                    },
                                    error: function(xhr) {
                                        if (xhr.status === 419) {
                                            window.location.reload();
                                        }
                                    }
                                }).then(function() {});
                            }
                        });
                    }
                });
            });

            let btnSave = document.getElementById("save-deadline");
            if(btnSave && isEditing){
                btnSave.classList.remove("disabled");
            }

        });
    </script>
    <script>
         function updateAllFilter(tasks)
        {
            if(!$("#id_guide_select").val()){
                updateFilter(tasks, guides, "id_guide_select", "id_guide");
            }
            if(!$("#id_location_select").val()){
                updateFilter(tasks, locations, "id_location_select", "id_location");
            }
            if(!$("#id_practice_select").val()){
                updateFilter(tasks, practices, "id_practice_select", "id_practice");
            }
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

        function countNewTotalDeadlines(deadlines) {
            var newDeadlines = deadlines.filter(function(item) {
                return (item.id_deadline == null);
            }).length;
            var currentDeadlines = deadlines.filter(function(item) {
                return (item.id_deadline != null);
            }).length;

            $('#deadlinesNew').text(newDeadlines);
            $('#deadlineTotal').text(currentDeadlines);

            if (currentDeadlines == 0) {
                $('#update-deadline-submission').addClass('disabled');
                $('#indicator-overwrite').addClass('disabled');
            } else {
                let deadlineSubmissionBtn = document.getElementById("update-deadline-submission");
                deadlineSubmissionBtn.classList.remove("disabled");

                let overwrite = document.getElementById("indicator-overwrite");
                overwrite.classList.remove("disabled");
            }
        }

        function fileUpload() {
            var file = document.getElementById('file_upload').files[0];
            if (!file) {
                toastrAlert("Choose file", "warning");
                return;
            }

            var uploadLoading = document.querySelector("#uploadFile");
            uploadLoading.setAttribute("data-kt-indicator", "on");

            var formData = new FormData();
            formData.append('file', file);

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'post',
                dataType: 'json',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                url: '{{ route('import-file-deadline') }}',
                success: function(response) {
                    if (response.status == true) {
                        toastrAlert(response.message, "success");
                        $('#upload-file').modal('hide');
                        window.location.reload();
                    } else {
                        toastrAlert(response.message, "error");
                    }

                    uploadLoading.removeAttribute("data-kt-indicator");

                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                },
            });
        }

        function updateDataSelected() {
            var grid = $("#deadlines").jsGrid("option", "data");
            var filteredData = grid.filter(function(item) {
                return (item.check == true);
            });
            if (filteredData.length == 0) {
                toastrAlert('Select the rows to edit', 'warning');
                return;
            }

            deadlines.filter(function(item) {
                return (item.check == true);
            }).map(function(element) {
                if ($("#confirmed").is(":checked")) {
                    element.confirmed = $("#confirmed").is(":checked");
                }
                if ($('#deadline').val()) {
                    element.deadline = $('#deadline').val();
                }
                element.action = 'update';
                // element.check = false;
            });

            grid.map(function(element) {
                if (element.check == true) {
                    if ($("#confirmed").is(":checked")) {
                        element.confirmed = $("#confirmed").is(":checked");
                    }
                    if ($('#deadline').val()) {
                        element.deadline = $('#deadline').val();
                    }
                    element.action = 'update';
                    // element.check = false;
                }
            });

            $("#deadlines").jsGrid("refresh");
            $('#kt_modal_1').modal('hide');
        }

        function deleteDeadline(id_deadline_header) {
            Swal.fire({
                html: 'Are you sure you want to delete this deadline?',
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
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        method: 'post',
                        data: {
                            'id_deadline_header': id_deadline_header
                        },
                        url: "{{ route('delete-deadline') }}",
                        success: function(response) {
                            successToastr('Dealine removed successfully');
                        },
                        error: function(xhr) {
                            if (xhr.status === 419) {
                                window.location.reload();
                            }
                        }
                    }).then(function() {
                        window.location.href = "{{ route('deadlines') }}";
                    });
                }
            });
        }

        function enableDisableBtn(status) {
            if (status == true) {
                var grid = $("#deadlines").jsGrid("option", "data");
                var filteredData = grid.filter(function(item) {
                    return (item.check == true);
                });

                if (filteredData.length == 0) {
                    $('#edit-data').addClass('disabled');
                }
            } else {
                let edit = document.getElementById("edit-data");
                @if ($view != 'view')
                    edit.classList.remove("disabled");
                @endif
            }
        }

        function toastrAlert(msg, type) {
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

        function JSONToCSVConvertor(JSONData, ReportTitle, ShowLabel) {
            //If JSONData is not an object then JSON.parse will parse the JSON string in an Object
            var arrData = typeof JSONData != 'object' ? JSON.parse(JSONData) : JSONData;

            var CSV = '';
            //Set Report title in first row or line

            // CSV += ReportTitle + '\r\n';

            //This condition will generate the Label/Header
            if (ShowLabel) {
                var row = "";
                //This loop will extract the label from 1st index of on array
                for (var index in arrData[0]) {
                    //Now convert each value to string and comma-seprated
                    var nameTitle = "";
                    switch (index) {
                        case "id_deadline":
                            nameTitle = "Id";
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
                        case "deadline":
                            nameTitle = "Deadline";
                            break;
                        case "confirmed":
                            nameTitle = "Confirmed";
                            break;
                    }
                    if (nameTitle) {
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
                        case "id_deadline":
                            let newIdItem = 'undefined';
                            if (arrData[i][index]) {
                                newIdItem = arrData[i][index];
                            }
                            nameItem = newIdItem;
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

                        case "deadline":
                            let newDeadlineItem = 'undefined';
                            if (arrData[i][index]) {
                                newDeadlineItem = arrData[i][index];
                            }
                            nameItem = newDeadlineItem;
                            break;

                        case "confirmed":
                            nameItem = arrData[i][index] == 1 ? "TRUE" : "FALSE";
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
    <script src="{{ URL::asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
@endpush
