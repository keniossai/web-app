@extends('layouts.master')

@section('master-title', 'Users')

@push('styles')
    <link href="{{ URL::asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
    <style>
        .select2-results .select2-results__options {
            max-height: 160px !important;
        }
    </style>
@endpush

@section('master-content')
    <!--begin::Card-->
    <div class="card">
        <!--begin::Card header-->
        <div class="card-header border-0 pt-6">
            <!--begin::Card title-->
            <div class="card-title">
                <!--begin::Search-->
                <div class="d-flex align-items-center position-relative my-1">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen021.svg-->
                    <span class="svg-icon svg-icon-1 position-absolute ms-6">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.5" x="17.0365" y="15.1223" width="8.15546" height="2" rx="1" transform="rotate(45 17.0365 15.1223)" fill="currentColor" />
                            <path d="M11 19C6.55556 19 3 15.4444 3 11C3 6.55556 6.55556 3 11 3C15.4444 3 19 6.55556 19 11C19 15.4444 15.4444 19 11 19ZM11 5C7.53333 5 5 7.53333 5 11C5 14.4667 7.53333 17 11 17C14.4667 17 17 14.4667 17 11C17 7.53333 14.4667 5 11 5Z" fill="currentColor" />
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <input type="text" data-kt-user-table-filter="search" class="form-control form-control-solid w-250px ps-14" placeholder="Search" />
                </div>
                <!--end::Search-->
            </div>
            <!--begin::Card title-->
            <!--begin::Card toolbar-->
            <div class="card-toolbar">
                <!--begin::Toolbar-->
                <div class="d-flex justify-content-end" data-kt-user-table-toolbar="base">
                    <!--begin::Filter-->
                    <button type="button" class="btn btn-light-primary me-3" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                        <!--begin::Svg Icon | path: icons/duotune/general/gen031.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.0759 3H4.72777C3.95892 3 3.47768 3.83148 3.86067 4.49814L8.56967 12.6949C9.17923 13.7559 9.5 14.9582 9.5 16.1819V19.5072C9.5 20.2189 10.2223 20.7028 10.8805 20.432L13.8805 19.1977C14.2553 19.0435 14.5 18.6783 14.5 18.273V13.8372C14.5 12.8089 14.8171 11.8056 15.408 10.964L19.8943 4.57465C20.3596 3.912 19.8856 3 19.0759 3Z" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        Filter
                    </button>
                    <!--begin::Menu 1-->
                    <div class="menu menu-sub menu-sub-dropdown w-300px w-md-325px" data-kt-menu="true">
                        <!--begin::Header-->
                        <div class="px-7 py-5">
                            <div class="fs-5 text-dark fw-bold">Filter Options</div>
                        </div>
                        <!--end::Header-->
                        <!--begin::Separator-->
                        <div class="separator border-gray-200"></div>
                        <!--end::Separator-->
                        <!--begin::Content-->
                        <div class="px-7 py-5" data-kt-user-table-filter="form">
                            <!--begin::Input group-->
                            <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">Role:</label>
                                <select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="role" data-hide-search="true">
                                    <option></option>
                                    @foreach (App\models\Role::where('active', 1)->get() as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            {{-- <div class="mb-10">
                                <label class="form-label fs-6 fw-semibold">Two Step Verification:</label>
                                <select class="form-select form-select-solid fw-bold" data-kt-select2="true" data-placeholder="Select option" data-allow-clear="true" data-kt-user-table-filter="two-step" data-hide-search="true">
                                    <option></option>
                                    <option value="Enabled">Enabled</option>
                                </select>
                            </div> --}}
                            <!--end::Input group-->
                            <!--begin::Actions-->
                            <div class="d-flex justify-content-end">
                                <button type="reset" class="btn btn-light btn-active-light-primary fw-semibold me-2 px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="reset">Reset</button>
                                <button type="submit" class="btn btn-primary fw-semibold px-6" data-kt-menu-dismiss="true" data-kt-user-table-filter="filter">Apply</button>
                            </div>
                            <!--end::Actions-->
                        </div>
                        <!--end::Content-->
                    </div>
                    <!--end::Menu 1-->
                    <!--end::Filter-->
                    <!--begin::Export-->

                    <!--end::Export-->
                    <!--begin::Add user-->
                    <button type="button" class="btn btn-sm btn-primary add-user" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr075.svg-->
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        Add
                    </button>
                    <!--end::Add user-->
                </div>
                <!--end::Toolbar-->
                <!--begin::Group actions-->
                <div class="d-flex justify-content-end align-items-center d-none" data-kt-user-table-toolbar="selected">
                    <div class="fw-bold me-5">
                    <span class="me-2" data-kt-user-table-select="selected_count"></span>Selected</div>
                    <button type="button" class="btn btn-sm btn-danger" data-kt-user-table-select="delete_selected">Delete Selected</button>
                </div>
                <!--end::Group actions-->
            </div>
            <!--end::Card toolbar-->
        </div>
        <!--end::Card header-->

        <!--begin::Card body-->
        <div class="card-body py-4">
            <!--begin::Table-->
            <table class="table align-middle table-row-dashed fs-6 gy-5" id="kt_table_users">
                <!--begin::Table head-->
                <thead>
                    <!--begin::Table row-->
                    <tr class="text-start text-muted fw-bold fs-7 text-uppercase gs-0">
                        {{-- <th class="w-10px pe-2">
                            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_table_users .form-check-input" value="1" />
                            </div>
                        </th> --}}
                        <th class="min-w-125px">Name</th>
                        <th class="min-w-125px">Role</th>
                        <th class="min-w-125px">Email</th>
                        <th class="min-w-125px">Time zone</th>
                        <th class="min-w-125px">Created at</th>
                        <th class="text-end min-w-100px">Actions</th>
                    </tr>
                    <!--end::Table row-->
                </thead>
                <!--end::Table head-->
                <!--begin::Table body-->
                <tbody class="text-gray-600 fw-semibold">
                    @foreach ($users as $user)
                        <tr>
                            {{-- <td>
                                <div class="form-check form-check-sm form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox" value="1" />
                                </div>
                            </td> --}}
                            <td>
                                <div class="d-flex flex-column">
                                    <a href="#" class="text-gray-800 text-hover-primary mb-1">{{ $user->contact->name }}</a>
                                    <span></span>
                                </div>
                            </td>
                            <td>
                                @foreach ($user->userRole as $item)
                                    <span class="badge badge-light-success">
                                        {{ $item->role->name }}
                                    </span>
                                @endforeach
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->timezone }}</td>
                            <td>{{ $user->created_at }}</td>
                            {{-- <td class="text-end">
                                <a onclick="deleteRecord({{ $user->id_user }})" href="#">
                                    <button class="btn btn-md btn-icon btn-light-danger mr-2">
                                        <i class="las la-trash-alt fs-3x"></i>
                                    </button>
                                </a>
                            </td> --}}
                            <td class="text-end">
                                <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
                                    <span class="svg-icon svg-icon-5 m-0">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                </a>
                                <!--begin::Menu-->
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                    <div class="menu-item px-3">
                                        <a class="menu-link px-3" onclick="editRecord('{{ $user->id_user }}')">
                                             Edit
                                        </a>
                                    </div>
                                    <div class="menu-item px-3">
                                        <a href="#" class="menu-link px-3" id="{{ $user->id_user }}" data-kt-users-table-filter="delete_row">Delete</a>
                                    </div>
                                </div>
                                <!--end::Menu-->
                            </td>
                        </tr>
                    @endforeach

                </tbody>

                <!--end::Table body-->
            </table>
            <!--end::Table-->
        </div>
        <!--end::Card body-->
    </div>
    <!--end::Card-->
@endsection

@push('modals')
    <!--begin::Modal - Adjust Balance-->
    <div class="modal fade" id="kt_modal_export_users" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">Export Users</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_export_users_form" class="form" action="#">
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="fs-6 fw-semibold form-label mb-2">Select Roles:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="role" data-control="select2" data-placeholder="Select a role" data-hide-search="true" class="form-select form-select-solid fw-bold">
                                <option></option>
                                <option value="Administrator">Administrator</option>
                                <option value="Analyst">Analyst</option>
                                <option value="Developer">Developer</option>
                                <option value="Support">Support</option>
                                <option value="Trial">Trial</option>
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="fv-row mb-10">
                            <!--begin::Label-->
                            <label class="required fs-6 fw-semibold form-label mb-2">Select Export Format:</label>
                            <!--end::Label-->
                            <!--begin::Input-->
                            <select name="format" data-control="select2" data-placeholder="Select a format" data-hide-search="true" class="form-select form-select-solid fw-bold">
                                <option></option>
                                <option value="excel">Excel</option>
                                <option value="pdf">PDF</option>
                                <option value="cvs">CVS</option>
                                <option value="zip">ZIP</option>
                            </select>
                            <!--end::Input-->
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Discard</button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - New Card-->

    <!--begin::Modal - Add user-->
    <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold">User</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-kt-users-modal-action="close">
                        <!--begin::Svg Icon | path: icons/duotune/arrows/arr061.svg-->
                        <span class="svg-icon svg-icon-1">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)" fill="currentColor" />
                                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--end::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <!--begin::Form-->
                    <form id="kt_modal_add_user_form" class="form" action="#">
                        <!--begin::Scroll-->
                        <input id="id_user" name="id_user" value="" hidden>
                        @csrf
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">Name</label>
                                <input type="text" name="name" id="name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Name" value="" />
                            </div>
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">Last Name</label>
                                <input type="text" name="last_name" id="last_name" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Last name" value="" />
                            </div>
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">Phone</label>
                                <input type="number" name="phone" id="phone" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Phone" value="" />
                            </div>
                            <div class="fv-row mb-7">
                                <label class="required fw-semibold fs-6 mb-2">Email</label>
                                <input type="email" name="email" id="email" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Email" value="" />
                            </div>
                            <div class="fv-row mb-7" id="password-div">
                                <label class="required fw-semibold fs-6 mb-2">Password</label>
                                <input type="password" name="password" id="password" class="form-control form-control-solid mb-3 mb-lg-0" placeholder="Password" value="" />
                            </div>
                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Role</label>
                                <select class="form-select form-select-solid" data-control="select2" id="id_role" name="role" data-dropdown-parent="#kt_modal_add_user_form" data-placeholder="Select a role" data-allow-clear="true" required>
                                    @foreach (App\models\Role::orderBy('name')->where('active', 1)->get() as $role)
                                        <option value="{{ $role->id_role }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="fv-row mb-7">
                                <label class="required fs-6 fw-semibold mb-2">Time zone</label>
                                <select class="form-select form-select-solid" data-control="select2" id="timezone" name="timezone" data-dropdown-parent="#kt_modal_add_user_form" data-placeholder="Select a time zone" data-allow-clear="true" required>
                                    @foreach (timezone_identifiers_list() as $timezone)
                                        <option value="{{ $timezone }}"{{ $timezone == old('timezone') ? ' selected' : '' }}>{{ $timezone }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span class="indicator-label">Save</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <button type="reset" class="btn btn-light me-3" data-kt-users-modal-action="cancel">Cancel</button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - Add task-->

@endpush

@push('scripts')
    <script src="{{ URL::asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>

    <script>
        "use strict";
        var KTUsersList=function(){
            var e,t,n,r,o=document.getElementById("kt_table_users"),
            c=()=>{
                o.querySelectorAll('[data-kt-users-table-filter="delete_row"]').forEach((t=>{
                        t.addEventListener("click",(function(t){
                        t.preventDefault();
                        const n=t.target.closest("tr");
                        //obtengo el record a eliminar
                        let id_user = (n.querySelectorAll("td")[5].querySelectorAll("a")[2]).id;
                        r=n.querySelectorAll("td")[0].querySelectorAll("a")[0].innerText;Swal.fire({
                            text:"Are you sure you want to delete "+r+"?",
                            icon:"warning",showCancelButton:!0,buttonsStyling:!1,
                            confirmButtonText:"Yes, delete!",cancelButtonText:"No, cancel",
                            customClass:{
                                confirmButton:"btn fw-bold btn-danger",
                                cancelButton:"btn fw-bold btn-active-light-primary"
                            }}).then((function(t){
                                t.value?(
                                    $.ajax({
                                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                        method: 'post',
                                        data: { 'id' : id_user },
                                        url: '{{ route('deactivate-user') }}',
                                        success:function(response){
                                            var logout =  response.logout;
                                            var route = response.route;

                                            Swal.fire({
                                                text:"You have deleted "+r+"!.",
                                                icon:"success",buttonsStyling:!1,
                                                confirmButtonText:"Ok, got it!",
                                                customClass:{
                                                    confirmButton:"btn fw-bold btn-primary"
                                                }
                                            }).then((function(){
                                                    e.row($(n)).remove().draw();
                                                }
                                            )).then((function(response){
                                                    a();
                                                    if(logout){
                                                        window.location.href = route;
                                                    }
                                                }
                                            ))
                                        },
                                        error: function(xhr) {
                                            if (xhr.status === 419) {
                                                window.location.reload();
                                            }
                                        }
                                    })

                               ):"cancel"===t.dismiss&&Swal.fire({
                                        text:customerName+" was not deleted.",
                                        icon:"error",
                                        buttonsStyling:!1,
                                        confirmButtonText:"Ok, got it!",customClass:{
                                            confirmButton:"btn fw-bold btn-primary"
                                        }
                                })

                                }))
                            }))}))},l=()=>{
                                const c=o.querySelectorAll('[type="checkbox"]');
                                t=document.querySelector('[data-kt-user-table-toolbar="base"]'),
                                n=document.querySelector('[data-kt-user-table-toolbar="selected"]'),
                                r=document.querySelector('[data-kt-user-table-select="selected_count"]');
                                const s=document.querySelector('[data-kt-user-table-select="delete_selected"]');
                                c.forEach((e=>{e.addEventListener("click",(function(){setTimeout((function(){a()}),50)}))})),
                                s.addEventListener("click",(function(){Swal.fire({
                                    text:"Are you sure you want to delete selected customers?",
                                    icon:"warning",showCancelButton:!0,buttonsStyling:!1,
                                    confirmButtonText:"Yes, delete!",cancelButtonText:"No, cancel",customClass:{
                                        confirmButton:"btn fw-bold btn-danger",cancelButton:"btn fw-bold btn-active-light-primary"}
                                    }).then((function(t){t.value?Swal.fire({
                                        text:"You have deleted all selected customers!.",
                                        icon:"success",buttonsStyling:!1,confirmButtonText:"Ok, got it!",customClass:{
                                            confirmButton:"btn fw-bold btn-primary"}}).then((function(){
                                                c.forEach((t=>{t.checked&&e.row($(t.closest("tbody tr"))).remove().draw()}));
                                                o.querySelectorAll('[type="checkbox"]')[0].checked=!1
                                            })).then((function(){a(),l()})):"cancel"===t.dismiss&&Swal.fire({
                                                text:"Selected customers was not deleted.",icon:"error",
                                                buttonsStyling:!1,confirmButtonText:"Ok, got it!",customClass:{
                                                    confirmButton:"btn fw-bold btn-primary"}})}))}))};
                                                    const a=()=>{const e=o.querySelectorAll('tbody [type="checkbox"]');
                                                    let c=!1,l=0;e.forEach((e=>{e.checked&&(c=!0,l++)})),c?(r.innerHTML=l,t.classList.add("d-none"),
                                                    n.classList.remove("d-none")):(t.classList.remove("d-none"),n.classList.add("d-none"))};
                                                    return{init:function(){o&&(o.querySelectorAll("tbody tr").forEach((e=>{
                                                        const t=e.querySelectorAll("td"),n=t[3].innerText.toLowerCase();
                                                        let r=0,o="minutes";
                                                        n.includes("yesterday")?(r=1,o="days"):n.includes("mins")?(r=parseInt(n.replace(/\D/g,"")),o="minutes"):n.includes("hours")?(r=parseInt(n.replace(/\D/g,"")),o="hours"):n.includes("days")?(r=parseInt(n.replace(/\D/g,"")),o="days"):n.includes("weeks")&&(r=parseInt(n.replace(/\D/g,"")),o="weeks");
                                                        const c=moment().subtract(r,o).format();
                                                        t[3].setAttribute("data-order",c);
                                                        //cambiar al num de columnas
                                                        const l=moment(t[4].innerHTML,"DD MMM YYYY, LT").format();
                                                        t[4].setAttribute("data-order",l)})),(e=$(o).DataTable({
                                                            info:!1,order:[],pageLength:10,lengthChange:!1,
                                                            //target especificar cantidad de columnas
                                                            columnDefs:[{orderable:!1,targets:0},{orderable:!1,targets:5}]})).on("draw",(function(){l(),c(),a()})),l(),
                                                            document.querySelector('[data-kt-user-table-filter="search"]').addEventListener("keyup",(function(t){
                                                                e.search(t.target.value).draw()})),
                                                                document.querySelector('[data-kt-user-table-filter="reset"]').addEventListener("click",(function(){
                                                                    document.querySelector('[data-kt-user-table-filter="form"]').querySelectorAll("select").forEach((e=>{
                                                                        $(e).val("").trigger("change")})),e.search("").draw()})),c(),(()=>{
                                                                            const t=document.querySelector('[data-kt-user-table-filter="form"]'),
                                                                            n=t.querySelector('[data-kt-user-table-filter="filter"]'),
                                                                            r=t.querySelectorAll("select");
                                                                            n.addEventListener("click",(function(){
                                                                                var t="";r.forEach(((e,n)=>{e.value&&""!==e.value&&(0!==n&&(t+=" "),t+=e.value)})),e.search(t).draw()}))})())}}}();
                                                                                KTUtil.onDOMContentLoaded((function(){KTUsersList.init()}));
    </script>

    <script>
        "use strict";
        var KTUsersAddUser=function(){
            const t=document.getElementById("kt_modal_add_user"),
            e=t.querySelector("#kt_modal_add_user_form"),
            n=new bootstrap.Modal(t);
            return{
                init:function(){
                    (()=>{
                        var o=FormValidation.formValidation(e,{
                            fields:{
                                name:{validators:{notEmpty:{message:"Full name is required"}}},
                                email:{validators:{notEmpty:{message:"Valid email address is required"}}},
                                role:{validators:{notEmpty:{message:"Role is required"}}},
                                timezone:{validators:{notEmpty:{message:"Timezone is required"}}},
                            },
                            plugins:{trigger:new FormValidation.plugins.Trigger,
                                bootstrap:new FormValidation.plugins.Bootstrap5({
                                    rowSelector:".fv-row",eleInvalidClass:"",
                                    eleValidClass:""})
                            }
                        });
                        const i=t.querySelector('[data-kt-users-modal-action="submit"]');
                        i.addEventListener("click",(t=>{
                            t.preventDefault(),
                            o&&o.validate().then((function(t){
                                console.log("validated!"),
                                "Valid"==t?(
                                    i.setAttribute("data-kt-indicator","on"),
                                    i.disabled=!0,
                                    setTimeout((function(){
                                        i.removeAttribute("data-kt-indicator"),
                                        i.disabled=!1,

                                        $.ajax({
                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                            method: 'post',
                                            data: { 'name' : $('#name').val(),
                                                    'last_name' : $('#last_name').val(),
                                                    'phone' : $('#phone').val(),
                                                    'email' : $('#email').val(),
                                                    'password' : $('#password').val(),
                                                    'id_role' : $('#id_role').val(),
                                                    'id_user' : $('#id_user').val(),
                                                    'timezone' : $('#timezone').val() },
                                            url: '{{ route('save-user') }}',
                                            success:function(response){
                                                console.log(response);
                                                if(response){
                                                    Swal.fire({
                                                        text:"Registered user successfully!",
                                                        icon:"success",
                                                        buttonsStyling:!1,
                                                        confirmButtonText:"Ok, got it!",
                                                        customClass:{confirmButton:"btn btn-primary"}
                                                    }).then((function(t){
                                                        t.isConfirmed&&n.hide(),
                                                        window.location.reload();
                                                    }));
                                                } else {
                                                    Swal.fire({
                                                        text:"Email already exists!",
                                                        icon:"error",
                                                        buttonsStyling:!1,
                                                        confirmButtonText:"Ok, got it!",
                                                        customClass:{confirmButton:"btn btn-primary"}
                                                    }).then((function(t){
                                                        // t.isConfirmed&&n.hide()
                                                    }));
                                                }

                                            },
                                            error: function(xhr) {
                                                if (xhr.status === 419) {
                                                    window.location.reload();
                                                }
                                            }
                                        })


                                    }),2e3)
                                ):Swal.fire({
                                    text:"Sorry, looks like there are some errors detected, please try again.",
                                    icon:"error",
                                    buttonsStyling:!1,
                                    confirmButtonText:"Ok, got it!",
                                    customClass:{
                                        confirmButton:"btn btn-primary"}
                                })
                            }))
                        })),
                        t.querySelector('[data-kt-users-modal-action="cancel"]').addEventListener("click",(t=>{
                            t.preventDefault(),
                            Swal.fire({
                                text:"Are you sure you would like to cancel?",
                                icon:"warning",
                                showCancelButton:!0,
                                buttonsStyling:!1,
                                confirmButtonText:"Yes, cancel it!",
                                cancelButtonText:"No, return",
                                customClass:{
                                    confirmButton:"btn btn-primary",cancelButton:"btn btn-active-light"}
                            }).then((function(t){
                                t.value?(e.reset(),
                                n.hide()):"cancel"===t.dismiss&&Swal.fire({
                                    text:"Your form has not been cancelled!.",
                                    icon:"error",
                                    buttonsStyling:!1,
                                    confirmButtonText:"Ok, got it!",
                                    customClass:{
                                        confirmButton:"btn btn-primary"}
                                })
                            }))
                        })),
                        t.querySelector('[data-kt-users-modal-action="close"]').addEventListener("click",(t=>{
                            t.preventDefault(),
                            Swal.fire({
                                text:"Are you sure you would like to cancel?",
                                icon:"warning",
                                showCancelButton:!0,
                                buttonsStyling:!1,
                                confirmButtonText:"Yes, cancel it!",
                                cancelButtonText:"No, return",
                                customClass:{
                                    confirmButton:"btn btn-primary",
                                    cancelButton:"btn btn-active-light"}
                            }).then((function(t){
                                t.value?(e.reset(),
                                n.hide()):"cancel"===t.dismiss&&Swal.fire({
                                    text:"Your form has not been cancelled!.",
                                    icon:"error",
                                    buttonsStyling:!1,
                                    confirmButtonText:"Ok, got it!",
                                    customClass:{
                                        confirmButton:"btn btn-primary"}
                                })
                            }))
                        }))
                    })()
                }
            }}();

            KTUtil.onDOMContentLoaded((function(){
                KTUsersAddUser.init()
            }));
    </script>
    <script>
        $( document ).ready(function(){
            $('.add-user').on('click', function(){
                $('#id_user').val('');
                $('#name').val('');
                $('#email').val('');
                $('#timezone').val('').trigger('change');
                $('#id_role').val('').trigger('change');
            });

            $(document).on('focus', '.form-select-solid', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            });
        });

        function editRecord(id){
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { 'id_user' : id },
                url: '{{ route('read-user') }}',
                success:function(response){
                    if(response.provider_id != null){
                        document.getElementById("password-div").outerHTML = "";
                    }
                    document.getElementById('email').setAttribute('readonly', true);

                    $('#id_user').val(response.id_user);
                    $('#name').val(response.contact.name);
                    $('#last_name').val(response.contact.last_name);
                    $('#phone').val(response.contact.phone);
                    $('#email').val(response.email);
                    $('#id_role').val(response.id_role).trigger('change');
                    $('#timezone').val(response.timezone).trigger('change');
                    $('#kt_modal_add_user').modal('show');
                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                }
            });
        }
    </script>

@endpush
