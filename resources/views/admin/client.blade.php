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
    </style>
@endpush

@section('master-header-buttons')
@endsection

@section('master-content')
    @if ($view == 'create' || $view == 'edit')
        {{-- form deadline h --}}
        <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bold">
                    @if (isset($client))
                        Edit
                    @else
                        Create
                    @endif
                </div>
                <div class="card-title d-flex justify-content-end">
                    @if (isset($client))
                        <button type="submit" form="client-header-form" class="btn btn-sm btn-primary">
                            Save
                        </button>
                        &nbsp;
                    @else
                        <button type="submit" form="client-header-form" class="btn btn-sm btn-primary">
                            Create
                        </button>
                        &nbsp;
                    @endif

                    <a href="javascript:history.back()" class="btn btn-sm btn-secondary">Cancel</a>
                    &nbsp;

                    @if (isset($client))
                        <a href="#" onclick="deleteClient('{{ $client->id_client }}')" class="btn btn-sm btn-danger">Delete</a>
                    @endif
                </div>
            </div>
            <form class="form" method="POST" enctype="multipart/form-data" id="client-header-form" action="{{ route('save-client') }}">
                @csrf
                <div class="card-body p-9">
                    <input name="id_client" value="{{ $client->id_client ?? ''}}" hidden>
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Picture</div>
                        </div>
                        <div class="col-lg-8">
                            <div class="image-input image-input-outline" data-kt-image-input="true" style="background-image: url({{ URL::asset('files/clients/blank.png') }})">
                                <div class="image-input-wrapper w-125px h-125px bgi-position-center" style="background-size: 100%; background-image: url({{ isset($client) ? $client->getPicture() : URL::asset('files/clients/blank.png') }})"></div>
                                <label class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="change" data-bs-toggle="tooltip" title="Change avatar">
                                    <i class="bi bi-pencil-fill fs-7"></i>
                                    <input type="file" name="picture" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="avatar_remove" />
                                </label>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow" data-kt-image-input-action="cancel" data-bs-toggle="tooltip" title="Cancel avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                                <span class="btn btn-icon btn-circle btn-active-color-primary w-25px h-25px bg-white shadow"  onclick="removePicture('{{ $client->id_client ?? '' }}')" data-kt-image-input-action="remove" data-bs-toggle="tooltip" title="Remove avatar">
                                    <i class="bi bi-x fs-2"></i>
                                </span>
                            </div>
                            <div class="form-text">Allowed file types: png, jpg, jpeg.</div>
                        </div>
                    </div>
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3 required">Name</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <input type="text" name="name" id="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Name" value="{{ old('name', $client->name ?? '') }}" required/>
                        </div>
                    </div>
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">General info.</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <textarea name="general_info" id="general_info" class="form-control form-control-solid h-100px mb-3 mb-lg-0">{{ old('general_info', $client->general_info ?? '') }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-2">Contact</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <div class="input-group">
                                <input type="text" class="form-control form-control-solid" id="full_name_contact" placeholder="Contact" disabled />
                                <button type="button" class="btn  ">
                                    <a href="#" class="link-primary mb-3 mb-lg-0" id="add-contact">Add contact</a>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Phone</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <input type="number" name="phone" id="phone" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Phone" value="{{ old('phone', $client->phone ?? '') }}" />
                        </div>
                    </div>

                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3">Website</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <input type="text" name="website" id="website" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Website" value="{{ old('website', $client->website ?? '') }}" />
                        </div>
                    </div>

                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3 required">Owner</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Select an owner" name="owner" id="owner" required>
                                <option></option>
                                @foreach (App\models\User::with('contact')->whereHas('userRole', function ($query){ $query->where('id_role', '=', App\Models\Role::where(['code' => 'client_owner', 'active' => 1])->first()->id_role); })->where('active', 1)->get()->sortBy('contact.name') as $user)
                                    <option value="{{ $user->id_user }}" @if(old('owner', $client->owner ?? '') == $user->id_user) selected @endif >{{ $user->contact->name }} {{ $user->contact->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-8">
                        <div class="col-xl-3">
                            <div class="fs-6 fw-semibold mt-2 mb-3 required">Director</div>
                        </div>
                        <div class="col-xl-9 fv-row">
                            <select class="form-select form-select-solid" data-control="select2" data-hide-search="true" data-placeholder="Select a director" name="director" id="director" required>
                                <option></option>
                                @foreach (App\models\User::with('contact')->whereHas('userRole', function ($query){ $query->where('id_role', '=', App\Models\Role::where(['code' => 'hr_director', 'active' => 1])->first()->id_role); })->where('active', 1)->get()->sortBy('contact.name') as $user)
                                    <option value="{{ $user->id_user }}" @if(old('director', $client->director ?? '') == $user->id_user) selected @endif >{{ $user->contact->name }} {{ $user->contact->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    @if (isset($client))
                        <button type="submit" form="client-header-form" class="btn btn-sm btn-primary">
                            Save
                        </button>
                        &nbsp;
                    @else
                        <button type="submit" form="client-header-form" class="btn btn-sm btn-primary">
                            Create
                        </button>
                        &nbsp;
                    @endif

                    <a href="javascript:history.back()" class="btn btn-sm btn-secondary">Cancel</a>
                    &nbsp;

                    @if (isset($client))
                        <a href="#" onclick="deleteClient('{{ $client->id_client }}')" class="btn btn-sm btn-danger">Delete</a>
                    @endif
                </div>
            </form>
        </div>
    @elseif (isset($client))
        {{-- header deadline --}}
        <input id="id_client" name="id_client" value="{{ $client->id_client }}" hidden>
        <div class="card mb-5">
            <div class="card-body pt-9 pb-0">
                <!--begin::Details-->
                <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
                    <div class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                        <img class="mw-80px mw-lg-100px" src="{{ $client->getPicture() }}" alt="image" />
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <div class="d-flex flex-column col-10">
                                <div class="d-flex align-items-center mb-1">
                                    <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">
                                       {{ $client->name }}
                                    </a>
                                    {{-- <span class="badge badge-light-success me-auto">In Progress</span> --}}
                                </div>
                                <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-400">
                                    {{ $client->general_info }}
                                </div>
                            </div>
                            <!--begin::Actions-->
                                <div class="d-flex mb-4 col-2 justify-content-end">
                                    @if (App\Repositories\UsersRepositories::isAllowed('edit-client'))
                                        <a href="{{ route('read-client', ['edit', 'id' => $client->id_client]) }}" class="btn btn-sm btn-facebook" style="color:white">
                                            Edit
                                        </a>
                                    @endif
                                    &nbsp;
                                    @if (App\Repositories\UsersRepositories::isAllowed('delete-client'))
                                        <a href="#" onclick="deleteClient('{{ $client->id_client }}')" class="btn btn-sm btn-danger">Delete</a>
                                    @endif
                                </div>
                            <!--end::Actions-->
                        </div>
                        <div class="d-flex flex-wrap justify-content-start">
                            <div class="d-flex flex-wrap">
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-4 fw-bold">
                                            {{ $client->user->contact->getName() }}
                                        </div>
                                    </div>
                                    <div class="fw-semibold fs-6 text-gray-400">Owner</div>
                                </div>
                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-4 fw-bold">
                                            {{ $client->website }}
                                        </div>
                                    </div>
                                    <div class="fw-semibold fs-6 text-gray-400">Website</div>
                                </div>

                                <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="fs-4 fw-bold">
                                            {{ isset($client->directorUser) ? $client->directorUser->contact->getName() : '' }}
                                        </div>
                                    </div>
                                    <div class="fw-semibold fs-6 text-gray-400">Director</div>
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
                        <a class="nav-link text-active-primary py-5 me-6 section-general
                            @if ($section == "general")
                                active
                            @endif"
                            href="@if ($view == 'view')
                                {{ route('view-client', ['general', 'id' => $client->id_client]) }}
                            @else
                                {{ route('read-client', ['general', 'id' => $client->id_client]) }}
                            @endif
                        ">
                            General
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-active-primary py-5 me-6
                            @if ($section == "contacts")
                                active
                            @endif"
                            href="@if ($view == 'view')
                                {{ route('view-client',  ['contacts', 'id' => $client->id_client]) }}
                            @else
                                {{ route('read-client',  ['contacts', 'id' => $client->id_client]) }}
                            @endif
                            ">
                            Contacts
                        </a>
                    </li>

                </ul>
            </div>
        </div>
        @if ($section == "general")
            <div class="col-xl-4">
                <!--begin::List Widget 1-->
                <div class="card card-xl-stretch mb-xl-8">
                    <!--begin::Header-->
                    <div class="card-header border-0 pt-5">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">Projects</span>
                            <span class="text-muted mt-1 fw-semibold fs-7">{{ App\Repositories\ProjectRepositories::getProjectByClient($client->id_client)->count() }} projects</span>
                        </h3>
                        <div class="card-title align-items-start flex-column">
                            <a href="{{ route('create-project', ['id_client' => $client->id_client]) }}" class="btn btn-sm btn-primary">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                    </svg>
                                </span>
                                Add
                            </a>
                        </div>
                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-5" style=" max-height: 500px; overflow-y: auto;">
                        @foreach (App\Repositories\ProjectRepositories::getProjectByClient($client->id_client) as $project)
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-7">
                                <!--begin::Symbol-->
                                <div class="symbol symbol-50px me-5">
                                    <span class="symbol-label bg-light-success">
                                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs027.svg-->
                                        <span class="svg-icon svg-icon-2x svg-icon-success">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path opacity="0.3" d="M21.25 18.525L13.05 21.825C12.35 22.125 11.65 22.125 10.95 21.825L2.75 18.525C1.75 18.125 1.75 16.725 2.75 16.325L4.04999 15.825L10.25 18.325C10.85 18.525 11.45 18.625 12.05 18.625C12.65 18.625 13.25 18.525 13.85 18.325L20.05 15.825L21.35 16.325C22.35 16.725 22.35 18.125 21.25 18.525ZM13.05 16.425L21.25 13.125C22.25 12.725 22.25 11.325 21.25 10.925L13.05 7.62502C12.35 7.32502 11.65 7.32502 10.95 7.62502L2.75 10.925C1.75 11.325 1.75 12.725 2.75 13.125L10.95 16.425C11.65 16.725 12.45 16.725 13.05 16.425Z" fill="currentColor" />
                                                <path d="M11.05 11.025L2.84998 7.725C1.84998 7.325 1.84998 5.925 2.84998 5.525L11.05 2.225C11.75 1.925 12.45 1.925 13.15 2.225L21.35 5.525C22.35 5.925 22.35 7.325 21.35 7.725L13.05 11.025C12.45 11.325 11.65 11.325 11.05 11.025Z" fill="currentColor" />
                                            </svg>
                                        </span>
                                        <!--end::Svg Icon-->
                                    </span>
                                </div>
                                <!--end::Symbol-->
                                <!--begin::Text-->
                                <div class="d-flex flex-column">
                                    <a href="{{ route('read-project', ['submissions', 'id' => $project->id_project]) }}" class="text-dark text-hover-primary fs-6 fw-bold">{{ $project->name }}</a>
                                    <span class="text-muted fw-bold">{{ $project->product->name }}</span>
                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Item-->
                        @endforeach
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::List Widget 1-->
            </div>
        @else
            <div class="col-xl-4">
                <!--begin::List Widget 2-->
                <div class="card card-xl-stretch mb-xl-8">
                    <!--begin::Header-->
                    <div class="card-header border-0">
                        <h3 class="card-title fw-bold text-dark">Contacts</h3>

                    </div>
                    <!--end::Header-->
                    <!--begin::Body-->
                    <div class="card-body pt-2">
                        @foreach (App\Repositories\ContactsRepositories::getAllContactsByClient($client->id_client) as $contact)
                            <!--begin::Item-->
                            <div class="d-flex align-items-center mb-7">
                                <!--begin::Avatar-->
                                <div class="symbol symbol-50px me-5">
                                    <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M16.5 9C16.5 13.125 13.125 16.5 9 16.5C4.875 16.5 1.5 13.125 1.5 9C1.5 4.875 4.875 1.5 9 1.5C13.125 1.5 16.5 4.875 16.5 9Z" fill="currentColor"/>
                                        <path d="M9 16.5C10.95 16.5 12.75 15.75 14.025 14.55C13.425 12.675 11.4 11.25 9 11.25C6.6 11.25 4.57499 12.675 3.97499 14.55C5.24999 15.75 7.05 16.5 9 16.5Z" fill="currentColor"/>
                                        <rect x="7" y="6" width="4" height="4" rx="2" fill="currentColor"/>
                                        </svg>
                                    </span>
                                </div>
                                <!--end::Avatar-->
                                <!--begin::Text-->
                                <div class="flex-grow-1">
                                    <a class="text-dark fw-bold fs-6">{{ $contact->name }} {{ $contact->last_name }}</a>
                                    <span class="text-muted d-block fw-bold">@lang('babel.'.$contact->type)</span>
                                </div>
                                <!--end::Text-->
                            </div>
                            <!--end::Item-->
                        @endforeach
                    </div>
                    <!--end::Body-->
                </div>
                <!--end::List Widget 2-->
            </div>
        @endif

    @endif
@endsection

@push('modals')
    <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header" id="kt_modal_add_user_header">
                    <h2 class="fw-bold" id="new-contact">Create contact</h2>
                    <h2 class="fw-bold" id="edit-contact">Select contact</h2>
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form id="kt_modal_add_user_form" class="form" action="#">
                        <input id="id_contact" name="contact[id_contact]" value="" form="client-header-form" hidden>
                        @csrf
                        @php
                            $getAllContactsMBD = App\Repositories\ContactsRepositories::getAllContactsMBD();
                        @endphp
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                            <div class="fv-row mb-7" id="search-form">
                                <select class="form-select form-select-solid" data-control="select2" id="search_contact" name="contact[search_contact]" data-placeholder="Search or Add a contact" data-allow-clear="true" data-dropdown-parent="#kt_modal_add_user_header">
                                    @foreach ($getAllContactsMBD as $contactMBD)
                                        <option value="{{ $contactMBD->id_contact }}">{{ $contactMBD->custom_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="detail-form">
                                <div class="fv-row mb-7">
                                    <input type="text" class="form-control form-control-solid name-contact" id="name_contact" placeholder="Name *" name="contact[name]" value="" autofocus form="client-header-form"/>
                                </div>
                                <div class="fv-row mb-7">
                                    <input type="text" class="form-control form-control-solid" id="last_name_contact" placeholder="Last name *" name="contact[last_name_contact]" value="" form="client-header-form" />
                                </div>
                                <div class="fv-row mb-7">
                                    <select class="form-select form-select-solid required" data-control="select2" id="type_contact" name="contact[type_contact]" form="client-header-form" data-placeholder="Select a type" data-allow-clear="true" data-dropdown-parent="#kt_modal_add_user_header">
                                        <option value="marketing_business_development" selected>Marketing/Business Development</option>
                                    </select>
                                </div>

                                <div class="fv-row mb-7">
                                    <input type="email" class="form-control form-control-solid" id="email_contact" placeholder="Email *" name="contact[email]" value="" form="client-header-form"/>
                                </div>
                                <div class="fv-row mb-7">
                                    <input type="number" class="form-control form-control-solid" id="phone_contact" placeholder="Phone" name="contact[phone]" value="" form="client-header-form"/>
                                </div>
                                <div class="fv-row mb-7">
                                    <textarea name="contact[description_contact]" id="description_contact" placeholder="Description" form="client-header-form" class="form-control form-control-solid h-100px"></textarea>
                                </div>
                                <div class="fv-row mb-7">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="" id="no_contact" name="contact[no_contact]" form="client-header-form"/>
                                        <label class="form-check-label" for="no_contact">
                                            No contact
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center pt-15">
                            <button type="button" class="btn btn-primary new-save-contact" data-bs-dismiss="modal">
                                <span class="indicator-label">Save</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            var contacts = {!! json_encode($getAllContactsMBD) !!};
            $('#add-contact').on('click', function(e){
                e.preventDefault();
                $('#id_contact').val('');
                $('#name_contact').val('');
                $('#last_name_contact').val('');
                $('#email_contact').val('');
                $('#phone_contact').val('');
                $('#description_contact').val('');
                $('#search_contact').val('').trigger('change');
                document.getElementById("no_contact").checked = false;
                hideShowSection("detail-form", true);
                hideShowSection("search-form", false);
                document.getElementById('new-contact').hidden = false;
                document.getElementById('edit-contact').hidden = true;
                $('#kt_modal_add_user').modal('show').on('shown.bs.modal', function(){
                    $('#search_contact').select2('open').trigger('select2:open');
                });

                $("#search_contact").select2({
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

                $('#search_contact').on('change', function(){
                    let search = $(this).val();
                    console.log(contacts);
                    let filteredData = contacts.filter(function (item) {
                        return (item.id_contact == search);
                    });
                    $('#id_contact').val('');
                    $('#name_contact').val('');
                    $('#last_name_contact').val('');
                    $('#email_contact').val('');
                    $('#phone_contact').val('');
                    $('#description_contact').val('');
                    document.getElementById("no_contact").checked = false;

                    hideShowSection("detail-form", false);
                    hideShowSection("search-form", true);

                    if(filteredData.length>0){
                        $('#id_contact').val(filteredData[0].id_contact);
                        $('#name_contact').val(filteredData[0].name);
                        $('#last_name_contact').val(filteredData[0].last_name);
                        $('#email_contact').val(filteredData[0].email);
                        $('#phone_contact').val(filteredData[0].phone);
                        $('#type_contact').val(filteredData[0].type).trigger('change');
                        $('#description_contact').val(filteredData[0].description);
                        let isCheck = filteredData[0].no_contact == 1 ?  true : false;
                        document.getElementById("no_contact").checked = isCheck;
                        $('#name_contact').focus();
                        document.getElementById('new-contact').hidden = true;
                        document.getElementById('edit-contact').hidden = false;
                    } else if(search.length>0) {
                        $('#last_name_contact').focus();
                        $('#name_contact').val(search);
                        $('#type_contact').val('marketing_business_development').trigger('change');
                    }
                });
            });
            $('#no_contact').on('click', function(){
                $('#no_contact').val($("#no_contact").is(":checked"));
            });
            $('.new-save-contact').on('click', function(e){
                let fullName = $('#name_contact').val()+' '+$('#last_name_contact').val();
                $('#full_name_contact').val(fullName)

            });
        });
        function hideShowSection(id, status)
        {
            document.getElementById(id).hidden = status;
        }
    </script>
    <script>
        function removePicture(id)
        {
             $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {'id_client' : id},
                url: "{{ route('delete-client-picture') }}",
                success:function(response){
                    if(response.status == 1){
                        toastrAlert('success', 'Picture removed successfully');
                    }
                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                },
            }).then(function () {
            });
        }
        function deleteClient(id)
        {
            Swal.fire({
                html: 'Are you sure you want to delete this client?',
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
                        data: {'id_client' : id},
                        url: "{{ route('delete-client') }}",
                        success:function(response){
                            if(response.status == 0){
                                toastrAlert('error', 'It is not possible to delete this client');
                            } else {
                                toastrAlert('success', 'Client removed successfully');
                                window.location.href = "{{ route('clients') }}";
                            }
                        },
                        error: function(xhr) {
                            if (xhr.status === 419) {
                                window.location.reload();
                            }
                        }
                    }).then(function () {
                    });
                }
            });
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
    <script src="{{ URL::asset('assets/plugins/global/plugins.bundle.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jsgrid/1.5.3/jsgrid.min.js"></script>
@endpush
