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
    </style>
@endpush

@section('master-header-buttons')
@endsection

@section('master-content')
    @if ($view == 'create' || $view == 'edit')
        @include('partials.create-project')
    @elseif (isset($project))
        @include('partials.project-header')
        <x-datatable.datatable id="kt_contacts_table" title="contacts" idTableFilter="data-kt-contacts-table" qtyColumns="6">
            <x-slot name="buttons">
                @if ($isView == false)
                    <button type="button" class="btn btn-sm btn-primary add-user" data-bs-toggle="modal" data-bs-target="#kt_modal_add_user">
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                            </svg>
                        </span>
                        Add
                    </button>
                @elseif (App\Repositories\UsersRepositories::isAllowed('read-project'))
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end pt-5">
                                <a href="{{ route('read-project',  ['contacts', 'id' => $project->id_project]) }}" class="btn btn-sm btn-facebook" style="color:white">
                                    Edit Contacts
                                </a>
                            </div>
                        </div>
                    </div>
                @endif
            </x-slot>
            <x-slot name="headers">
                <th class="min-w-100px">Name</th>
                <th class="min-w-100px">Last name</th>
                <th class="min-w-100px">Type</th>
                <th class="min-w-100px">Email</th>
                <th class="min-w-50px">Phone</th>
                <th>Description</th>
                <th class="text-end min-w-100px">Actions</th>
            </x-slot>
            <x-slot name="records">
                @foreach (App\Repositories\ContactsRepositories::getContacts($project) as $contact)
                    <tr>
                        <td>
                            <a class="text-gray-800 text-hover-primary mb-1">{{ $contact->name }}</a>
                        </td>
                        <td>{{ $contact->last_name }}</td>
                        <td>{{  __('babel.'.$contact->type) }}</td>
                        <td>{{ $contact->email }}</td>
                        <td>{{ $contact->phone }}</td>
                        <td>
                            <span class="info-format">
                                {{ substr($contact->description, 0, 120) }}
                            </span>
                        </td>
                        <td class="text-end">
                            <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" onclick="editRecord('{{ $contact->id_contact }}'); return false;">
                                <span class="svg-icon svg-icon-3">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                        <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                    </svg>
                                </span>
                            </a>
                            <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="deleteContactRel('{{ $contact->id_contact }}'); return false;" id="{{ $contact->id_contact }}">
                                <span class="svg-icon svg-icon-3">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5 9C5 8.44772 5.44772 8 6 8H18C18.5523 8 19 8.44772 19 9V18C19 19.6569 17.6569 21 16 21H8C6.34315 21 5 19.6569 5 18V9Z" fill="currentColor" />
                                        <path opacity="0.5" d="M5 5C5 4.44772 5.44772 4 6 4H18C18.5523 4 19 4.44772 19 5V5C19 5.55228 18.5523 6 18 6H6C5.44772 6 5 5.55228 5 5V5Z" fill="currentColor" />
                                        <path opacity="0.5" d="M9 4C9 3.44772 9.44772 3 10 3H14C14.5523 3 15 3.44772 15 4V4H9V4Z" fill="currentColor" />
                                    </svg>
                                </span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </x-slot>
        </x-datatable.datatable>
    @endif
@endsection

@push('modals')
      <!--begin::Modal - Add user-->
    <div class="modal fade" id="kt_modal_add_user" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content">
                <!--begin::Modal header-->
                <div class="modal-header" id="kt_modal_add_user_header">
                    <!--begin::Modal title-->
                    <h2 class="fw-bold" id="new-contact">Create contact</h2>
                    <h2 class="fw-bold" id="edit-contact">Edit contact</h2>
                    <!--end::Modal title-->
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
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
                        <input id="id_contact" name="id_contact" value="" hidden>
                        @csrf
                        <div class="d-flex flex-column scroll-y me-n7 pe-7" id="kt_modal_add_user_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="auto" data-kt-scroll-dependencies="#kt_modal_add_user_header" data-kt-scroll-wrappers="#kt_modal_add_user_scroll" data-kt-scroll-offset="300px">
                            <div class="fv-row mb-7" id="search-form">
                                <select class="form-select form-select-solid" data-control="select2" id="search_contact" name="search_contact" data-placeholder="Search or Add a contact" data-allow-clear="true" data-dropdown-parent="#kt_modal_add_user_header">
                                    @foreach (json_decode($contactsByClient) as $contactByClient)
                                        <option value="{{ $contactByClient->id_contact }}">{{ $contactByClient->custom_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="detail-form">
                                <div class="fv-row mb-7">
                                    <input type="text" class="form-control form-control-solid name-contact" id="name_contact" placeholder="Name *" name="name" value="" autofocus/>
                                </div>
                                <div class="fv-row mb-7">
                                    <input type="text" class="form-control form-control-solid" id="last_name_contact" placeholder="Last name *" name="last_name_contact" value="" />
                                </div>
                                <div class="fv-row mb-7">
                                    <select class="form-select form-select-solid required" data-control="select2" id="type_contact" name="type_contact" data-placeholder="Select a type" data-allow-clear="true" data-dropdown-parent="#kt_modal_add_user_header">
                                        <option value="marketing_business_development" selected>Marketing/Business Development</option>
                                    </select>
                                </div>

                                <div class="fv-row mb-7">
                                    <input type="email" class="form-control form-control-solid" id="email_contact" placeholder="Email *" name="email" value="" />
                                </div>
                                <div class="fv-row mb-7">
                                    <input type="number" class="form-control form-control-solid" id="phone_contact" placeholder="Phone" name="phone" value="" />
                                </div>
                                <div class="fv-row mb-7">
                                    <textarea name="description_contact" id="description_contact" placeholder="Description" class="form-control form-control-solid h-100px"></textarea>
                                </div>
                                <div class="fv-row mb-7">
                                    <div class="form-check form-check-custom form-check-solid">
                                        <input class="form-check-input" type="checkbox" value="" id="no_contact"/>
                                        <label class="form-check-label" for="no_contact">
                                            No contact
                                        </label>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!--begin::Actions-->
                        <div class="text-center pt-15">
                            <button type="submit" class="btn btn-primary" data-kt-users-modal-action="submit">
                                <span class="indicator-label">Save</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <button type="reset" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
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
    <script>
        $( document ).ready(function(){
            $('.add-user').on('click', function(){
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
                let contacts = {!! $contactsByClient !!};
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

        function editRecord(id)
        {
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: { 'id_contact' : id },
                url: '{{ route('edit-contact') }}',
                success:function(response){
                    hideShowSection("detail-form", false);
                    $('#id_contact').val(response.id_contact);
                    $('#name_contact').val(response.name);
                    $('#last_name_contact').val(response.last_name);
                    $('#email_contact').val(response.email);
                    $('#phone_contact').val(response.phone);
                    $('#type_contact').val(response.type).trigger('change');
                    $('#description_contact').val(response.description);
                    let isCheck = response.no_contact == 1 ?  true : false;
                    document.getElementById("no_contact").checked = isCheck;
                    hideShowSection("search-form", true);
                    document.getElementById('new-contact').hidden = true;
                    document.getElementById('edit-contact').hidden = false;
                    $('#kt_modal_add_user').modal('show').on('shown.bs.modal', function(){
                        $('#search_contact').select2('close');
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                },
            });
        }
        function deleteContactRel(id)
        {
            Swal.fire({
                html: 'This contact will be removed from the project but it will remain linked to the client. If you would like to remove the contact from the system, go to the Client catalog and remove it from there.',
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
                        data: {'id_contact' : id, 'id_project': $('#id_project').val(), 'type_element': 'project'},
                        url: "{{ route('delete-contact-rel') }}",
                        success:function(response){
                            if(response.status == 1){
                                successToastr(response.message);
                                window.location.reload();
                            } else {
                                errorToastr(response.message);
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
    </script>
    <script>
        function hideShowSection(id, status)
        {
            document.getElementById(id).hidden = status;
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

    </script>
    <script src="{{ URL::asset('assets/plugins/global/plugins.bundle.js') }}"></script>
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
                        // console.log(n);
                        //funcion eliminar -- obtengo el record a eliminar
                        let id_contact = (n.querySelectorAll("td")[6].querySelectorAll("a")[2]).id;
                        r = n.querySelectorAll("td")[0].querySelectorAll("a")[0].innerText;Swal.fire({
                            text:"Are you sure you want to delete "+r+"?",
                            icon:"warning",showCancelButton:!0,buttonsStyling:!1,
                            confirmButtonText:"Yes, delete!",cancelButtonText:"No, cancel",
                            customClass:{
                                confirmButton:"btn fw-bold btn-primary",
                                cancelButton:"btn fw-bold btn-danger"
                            }
                        }).then((function(t){
                            t.value?(
                                $.ajax({
                                    headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                    method: 'post',
                                    data: { 'id_contact' : id_contact },
                                    url: '{{ route('delete-contact') }}',
                                    success:function(response){
                                        e.row($(n)).remove().draw()
                                    },
                                    error: function(xhr) {
                                        if (xhr.status === 419) {
                                            window.location.reload();
                                        }
                                    },
                                })

                            ):"cancel"===t.dismiss
                        }))
                    })
                )}))
            },
            l=()=>{
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
                                        confirmButton:"btn fw-bold btn-primary"}})}))}))
            };

            const a=()=>{
                const e=o.querySelectorAll('tbody [type="checkbox"]');
                                        let c=!1,l=0;e.forEach((e=>{e.checked&&(c=!0,l++)})),c?(r.innerHTML=l,t.classList.add("d-none"),
                                        n.classList.remove("d-none")):(t.classList.remove("d-none"),n.classList.add("d-none"))
            };

                        return{
                            init:function(){
                                o&&(o.querySelectorAll("tbody tr").forEach((e=>{
                                    const t=e.querySelectorAll("td"),n=t[3].innerText.toLowerCase();
                                    let r=0,o="minutes";
                                    n.includes("yesterday")?(r=1,o="days"):n.includes("mins")?(r=parseInt(n.replace(/\D/g,"")),o="minutes"):n.includes("hours")?(r=parseInt(n.replace(/\D/g,"")),o="hours"):n.includes("days")?(r=parseInt(n.replace(/\D/g,"")),o="days"):n.includes("weeks")&&(r=parseInt(n.replace(/\D/g,"")),o="weeks");
                                    const c=moment().subtract(r,o).format();
                                    t[3].setAttribute("data-order",c);
                                    //cambiar al num de columnas
                                    const l=moment(t[4].innerHTML,"DD MMM YYYY, LT").format();
                                    t[4].setAttribute("data-order",l)
                                })),
                                (e=$(o).DataTable({
                                    info:!1,order:[],pageLength:10,lengthChange:!1,
                                    //target especificar cantidad de columnas
                                    columnDefs:[{orderable:!1,targets:0},{orderable:!1,targets:6}]
                                })).on("draw",(function(){l(),c(),a()})),l(),

                                document.querySelector('[data-kt-user-table-filter="search"]').addEventListener("keyup",(function(t){
                                    e.search(t.target.value).draw()

                                }))
                                // document.querySelector('[data-kt-user-table-filter="reset"]').addEventListener("click",(function(){
                                //     document.querySelector('[data-kt-user-table-filter="form"]').querySelectorAll("select").forEach((e=>{
                                //         $(e).val("").trigger("change")})),e.search("").draw()
                                // })),
                                // c(),
                                // (
                                    // ()=>{

                                // const t=document.querySelector('[data-kt-user-table-filter="form"]'),
                                // n=t.querySelector('[data-kt-user-table-filter="filter"]'),
                                // r=t.querySelectorAll("select");
                                // n.addEventListener("click",(function(){
                                //     var t="";r.forEach(((e,n)=>{e.value&&""!==e.value&&(0!==n&&(t+=" "),t+=e.value)})),e.search(t).draw()
                                // }))
                                // }
                                // )
                                // ()
                                )
                            }
                        }
                    }();

                        KTUtil.onDOMContentLoaded((function(){
                            KTUsersList.init()
                        }));
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
                                name:{validators:{notEmpty:{message:"Name is required"}}},
                                type_contact:{validators:{notEmpty:{message:"Type contact is required"}}},
                                last_name_contact:{validators:{notEmpty:{message:"Last name is required"}}},
                                email: {
                                    validators:{
                                        notEmpty:{
                                            message:"Email is required"
                                        },
                                        emailAddress: {
                                            message: 'The value is not a valid email address'
                                        }
                                    }
                                }
                                // phone: {
                                //     validators: {
                                //         phone: {
                                //             country: 'US', // Change the country code to your country
                                //             message: 'The value is not a valid phone number'
                                //         }
                                //     }
                                // }
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
                                // console.log("validated!"),
                                "Valid"==t?(
                                    i.setAttribute("data-kt-indicator","on"),
                                    i.disabled=!0,
                                    setTimeout((function(){
                                        i.removeAttribute("data-kt-indicator"),
                                        i.disabled=!1,
                                        $.ajax({
                                            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                                            method: 'post',
                                            data: { 'name' : $('#name_contact').val(),
                                                    'id_contact' : $('#id_contact').val(),
                                                    'id_project' : $('#id_project').val(),
                                                    'id_client' : $('#id_client').val(),
                                                    'last_name' : $('#last_name_contact').val(),
                                                    'type' : $('#type_contact').val(),
                                                    'email' : $('#email_contact').val(),
                                                    'phone' : $('#phone_contact').val(),
                                                    'description' : $('#description_contact').val(),
                                                    'no_contact' : $("#no_contact").is(":checked") },
                                            url: '{{ route('save-contact') }}',
                                            success:function(response){
                                                if(response){
                                                    t.isConfirmed&&n.hide(),
                                                    successToastr('Contact details saved correctly'),
                                                    window.location.reload();
                                                }
                                            },
                                            error: function(xhr) {
                                                if (xhr.status === 419) {
                                                    window.location.reload();
                                                }
                                            }
                                        });

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
                        }))


                    })()
                }
            }}();

            KTUtil.onDOMContentLoaded((function(){
                KTUsersAddUser.init()
            }));
    </script>
@endpush
