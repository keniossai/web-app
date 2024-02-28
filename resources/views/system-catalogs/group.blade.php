@extends('layouts.master')

@section('master-title', '')

@push('styles')
    <link href="{{ URL::asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@section('master-content')
    @if (!isset($group) || isset($section) ?? $section == 'edit')
        <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bold">
                group
                </div>
                <div class="card-title d-flex justify-content-end">
                </div>
            </div>
            <div class="card-body py-4">
                <form class="form" method="POST" id="group-form" action="{{ route('save-group') }}">
                    @csrf
                    <div class="card-body p-9">
                        <input name="id_group" value="{{ $group->id_group ?? '' }}" hidden>
                        <div class="row mb-8">
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3 required">Name</div>
                            </div>
                            <div class="col-xl-9 fv-row">
                                <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name', $group->name ?? '') }}" required/>
                            </div>
                        </div>
                        {{-- <div class="row mb-8">
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3 required">Role</div>
                            </div>
                            <div class="col-xl-9 fv-row">
                                <select class="form-select form-select-solid" data-control="select2" name="role" data-placeholder="Select an role" data-allow-clear="true" required>
                                    <option></option>
                                    @foreach (App\models\Role::where('active', 1)->get()->sortBy('name') as $role)
                                        <option value="{{ $role->code }}" @if(old('role', $group->role ?? '') == $role->code) selected @endif >{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> --}}
                        <div class="row mb-8">
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3">Description</div>
                            </div>
                            <div class="col-xl-9 fv-row">
                                <textarea name="description" class="form-control form-control-solid h-100px">{{ $group->description ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        @if(isset($group))
                            <button type="submit" class="btn btn-sm btn-primary">
                                Save
                            </button>
                            &nbsp;
                        @else
                            <button type="submit" form="group-form" class="btn btn-sm btn-primary">
                                Create
                            </button>
                            &nbsp;
                        @endif
                        <a href="javascript:history.back()" class="btn btn-sm btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    @else
        <div class="d-flex flex-column flex-lg-row">
            <!--begin::Sidebar-->
            <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-300px mb-10">
                <!--begin::Card-->
                <div class="card mb-5 mb-xl-8">
                    <!--begin::Card body-->
                    <div class="card-body">
                        <!--begin::Summary-->
                        <!--begin::User Info-->
                        <div class="d-flex flex-center flex-column py-5">
                            <!--begin::Name-->
                            <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{ $group->name }}</a>
                            <div class="fw-bold mb-3">
                                {{ $group->description }}
                            </div>
                        </div>
                        <!--end::User Info-->
                        <!--end::Summary-->
                        <!--begin::Details toggle-->
                        <div class="d-flex flex-stack fs-4 py-3">
                            <div class="fw-bold rotate collapsible">
                                <span class="ms-2 rotate-180">
                                </span>
                            </div>
                            <a href="{{ route('edit-group', ['id' => $group->id_group]) }}" class="btn btn-sm btn-light-primary" >Edit</a>
                        </div>
                    </div>
                    <!--end::Card body-->
                </div>

            </div>
            <!--end::Sidebar-->
            <!--begin::Content-->
            <div class="flex-lg-row-fluid ms-lg-15">
                <!--begin::Card-->
                <div class="card pt-4 mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <h2>Users</h2>
                        </div>
                        <!--end::Card title-->
                        <div class="card-toolbar">
                            <button type="button" class="btn btn-sm btn-primary add-user">
                                <span class="svg-icon svg-icon-2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                        <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                                    </svg>
                                </span>
                                Add
                            </button>
                        </div>
                        <!--end::Card toolbar-->
                    </div>
                    <!--end::Card header-->
                    <!--begin::Card body-->
                    <div class="card-body pt-0 pb-5">
                        <!--begin::Table wrapper-->
                        <div class="table-responsive">
                            <!--begin::Table-->
                            <table class="table align-middle table-row-dashed gy-5" >
                                <!--begin::Table head-->
                                <thead class="border-bottom border-gray-200 fs-7 fw-bold">
                                    <!--begin::Table row-->
                                    <tr class="text-start text-muted text-uppercase gs-0">
                                        <th class="min-w-100px">Name</th>
                                        <th class="min-w-100px">Email</th>
                                        <th>Role</th>
                                        <th>Assignment</th>
                                        <th class="min-w-100px">Actions</th>
                                    </tr>
                                    <!--end::Table row-->
                                </thead>
                                <!--end::Table head-->
                                <!--begin::Table body-->
                                <tbody class="fs-6 fw-semibold text-gray-600">
                                    @foreach($group->groupdetail as $groupdetail)
                                        <tr>
                                            <td>{{ $groupdetail->user->contact->name }} {{ $groupdetail->user->contact->last_name }}</td>
                                            <td>{{ $groupdetail->user->email }}</td>
                                            <td>
                                                @foreach ($groupdetail->user->userRole as $item)
                                                    <span class="badge badge-light-success">
                                                        {{ $item->role->name }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if ($groupdetail->is_admin == 1)
                                                    Admin
                                                @else
                                                    Member
                                                @endif
                                            </td>
                                            <td class="text-end">
                                                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" onclick="editGroupDetail('{{ $groupdetail->id_groupdetail }}'); return false;">
                                                    <span class="svg-icon svg-icon-3">
                                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                                            <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                                        </svg>
                                                    </span>
                                                </a>
                                                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="deleteGroupDetail('{{ $groupdetail->id_groupdetail }}'); return false;">
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

                                </tbody>
                                <!--end::Table body-->
                            </table>
                            <!--end::Table-->
                        </div>
                        <!--end::Table wrapper-->
                    </div>
                    <!--end::Card body-->
                </div>

            </div>
            <!--end::Content-->
        </div>
    @endif
@endsection

@push('modals')
    <div class="modal fade" tabindex="-1" id="kt_modal_1">
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">User</h3>
                </div>

                <div class="modal-body scroll-y mx-5 mx-xl-15 my-7">
                    <form class="form" method="POST" id="user-form" action="{{ route('save-user-group') }}">
                        @csrf
                        <input name="id_group"  id="id_group" value="{{ $group->id_group ?? '' }}" hidden>
                        <input name="id_groupdetail" id="id_groupdetail" value="" hidden>
                        <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-1">
                            <div class="col">
                                <div class="fv-row mb-7">
                                    @php
                                        $ids_user = [];
                                    @endphp
                                    <select class="form-select form-select-solid" id="id_user" name="id_user" data-control="select2" data-placeholder="Select a user" data-allow-clear="true" data-dropdown-parent="#kt_modal_1">
                                        <option></option>
                                        @foreach (App\Models\User::whereNotIn('id_user', $ids_user)->where('active', 1)->get() as $user)
                                            <option value="{{ $user->id_user }}">{{ $user->contact->name }} {{ $user->contact->last_name }}
                                                [
                                                    @foreach ($user->userRole as $key => $item)
                                                        {{ $item->role->name }}
                                                        @if ($key != count($user->userRole) - 1)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                ]
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-check form-switch form-check-custom form-check-solid">
                                    <input class="form-check-input" type="checkbox"  id="flexSwitchDefault" name="is_admin"/>
                                    <label class="form-check-label" for="flexSwitchDefault">
                                        Admin
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="text-center pt-15">
                            <button class="btn btn-primary" type="submit" >
                                <span class="indicator-label">Save</span>
                            </button>
                            <button type="button" class="btn btn-light me-3" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script>
        $(document).ready(function(){
            $('.add-user').on('click', function(){
                $('#id_groupdetail').val('');
                $('#id_user').val('').trigger('change');
                $('#flexSwitchDefault').prop('checked', false);
                $('#kt_modal_1').modal('show');
            });
        });

        function editGroupDetail(id_groupdetail)
        {
            $('#flexSwitchDefault').prop('checked', false);
            $.ajax({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                method: 'post',
                data: {'id_groupdetail' : id_groupdetail},
                url: "{{ route('get-group-detail') }}",
                success:function(response){
                    $('#id_groupdetail').val(response.id_groupdetail);
                    $('#id_user').val(response.id_user).trigger('change');
                    console.log(response.is_admin);
                    if(response.is_admin == 1){
                        $('#flexSwitchDefault').prop('checked', true);
                    }
                    $('#kt_modal_1').modal('show');
                },
                error: function(xhr) {
                    if (xhr.status === 419) {
                        window.location.reload();
                    }
                }
            }).then(function () {

            });
        }

        function deleteGroupDetail(id_groupdetail)
        {
            Swal.fire({
                html: 'Are you sure you want to delete this user?',
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
                        data: {'id_groupdetail' : id_groupdetail},
                        url: "{{ route('deactivate-groupdetail') }}",
                        success:function(response){
                            console.log(response);
                            toastrAlert(response.status, response.msj);
                            if(response.status == 'success')
                            {
                                setTimeout(function() {
                                    window.location.reload();
                                }, 1000);
                            }
                        },
                        error: function(xhr) {
                        }
                    }).then(function () {
                    });
                }
            });
        }

        function toastrAlert(type, msg)
        {
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
@endpush
