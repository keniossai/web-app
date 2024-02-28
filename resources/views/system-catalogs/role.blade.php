@extends('layouts.master')

@section('master-title', 'Role')

@push('styles')
    <link href="{{ URL::asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@section('master-content')
    @if (!isset($role) || isset($section) ?? $section == 'edit')
        <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bold">
                    Role
                </div>
                <div class="card-title d-flex justify-content-end">
                </div>
            </div>

            <div class="card-body py-4">
                <form class="form" method="POST" id="role-form" action="{{ route('save-role') }}">
                    @csrf
                    <div class="card-body p-9">
                        <input id="id_role" name="id_role" value="{{ $role->id_role ?? '' }}" hidden>
                        <div class="row mb-8">
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3 required">Name</div>
                            </div>
                            <div class="col-xl-9 fv-row">
                                <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name', $role->name ?? '') }}" required/>
                            </div>
                        </div>
                        <div class="row mb-8">
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3">Description</div>
                            </div>
                            <div class="col-xl-9 fv-row">
                                <textarea name="description" class="form-control form-control-solid h-100px">{{ old('name', $role->description ?? '') }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        @if(isset($role))
                            <button type="submit" class="btn btn-sm btn-primary">
                                Save
                            </button>
                            &nbsp;
                        @else
                            <button type="submit" class="btn btn-sm btn-primary">
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
        <div class="flex-column flex-lg-row-auto w-lg-250px w-xl-350px mb-10">
            <div class="card mb-5 mb-xl-8">
                <div class="card-body">
                    <div class="card card-flush">
                        <div class="card-header">
                            <div class="card-title">
                                <h2 class="mb-0">{{ $role->name }}</h2>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div class="d-flex flex-column text-gray-600">
                                <div class="d-flex align-items-center py-2">
                                    <span class="bullet bg-primary me-3"></span>
                                    {{ $role->description ?? '' }}
                                </div>
                            </div>
                        </div>
                        <div class="card-footer pt-0">
                            <a href="{{ route('edit-role',  ['id' => $role->id_role]) }}" class="btn btn-light btn-active-primary" >Edit Role</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="flex-lg-row-fluid ms-lg-15">
            <x-datatable.datatable id="kt_users_table" title="users" idTableFilter="data-kt-users-table" qtyColumns="2">
                <x-slot name="buttons">
                    <a href="#" class="btn btn-sm btn-primary add-user">
                        <span class="svg-icon svg-icon-2">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.5" x="11.364" y="20.364" width="16" height="2" rx="1" transform="rotate(-90 11.364 20.364)" fill="currentColor" />
                                <rect x="4.36396" y="11.364" width="16" height="2" rx="1" fill="currentColor" />
                            </svg>
                        </span>
                        Add
                    </a>
                </x-slot>
                <x-slot name="headers">
                    <th class="min-w-125px">Name</th>
                    <th class="min-w-125px">Email</th>
                    <th class="text-end min-w-100px">Actions</th>
                </x-slot>
                <x-slot name="records">
                    @foreach ($role->users as $user)
                        <tr>
                            <td>
                                <a href="#" class="text-gray-800 text-hover-primary mb-1">{{ $user->user->contact->getName() }}</a>
                            </td>
                            <td>{{ $user->user->email }}</td>
                            <td class="text-end">
                                <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="deleteUser('{{ $user->id_userrole }}'); return false;">
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
        </div>
    </div>
    @endif
@endsection

@push('modals')
    <div class="modal fade" tabindex="-1" id="kt_modal_user">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">User</h3>

                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <span class="svg-icon svg-icon-1"></span>
                    </div>
                </div>
                <form class="form" method="POST" action="{{ route('save-user-role') }}">
                    @csrf
                    <div class="modal-body">
                        <input name="id_role" value="{{ $role->id_role }}" hidden>
                        <div class="row row-cols-1 row-cols-sm-2 rol-cols-md-1 row-cols-lg-1">
                            <div class="col">
                                <div class="fv-row mb-7">
                                    <select class="form-select form-select-solid required" id="id_user" name="id_user" data-control="select2"  data-dropdown-parent="#kt_modal_user" data-placeholder="Select a user" data-allow-clear="true">
                                        <option></option>
                                        @foreach (App\Models\User::where('active', 1)->get() as $user)

                                            <option value="{{ $user->id_user }}">{{ $user->contact->getName() }}
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
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endpush

@push('scripts')
    <script src="{{ URL::asset('assets/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
         $(document).ready(function(){
            $('.add-user').on('click', function(){
                $('#kt_modal_user').modal('show').on('shown.bs.modal', function(){
                    $('#id_user').select2('open').trigger('select2:open');
                });
            })
        });

        function deleteUser(id)
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
                        data: {'id_userrole' : id},
                        url: "{{ route('delete-user-role') }}",
                        success:function(response){
                            location.reload()
                            toastrAlert('success', 'User removed successfully');
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
