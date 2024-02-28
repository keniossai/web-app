@extends('layouts.master')

@section('master-title', 'Clients')
@push('styles')
    <link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
    <style>
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

@section('master-content')
    <x-datatable.datatable id="kt_clients_table" title="clients" idTableFilter="data-kt-clients-table" qtyColumns="5">

        <x-slot name="buttons">
             <a href="{{ route('create-client') }}" class="btn btn-sm btn-primary add-record">
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
            <th class="min-w-125px">General info</th>
            <th class="min-w-125px">Owner</th>
            <th class="min-w-125px">Website</th>
            <th class="min-w-125px">Phone</th>
            <th class="text-end min-w-100px">Actions</th>
        </x-slot>
        <x-slot name="records">
            @foreach ($clients as $client)
                <tr>
                    <td>
                        <a href="{{ route('view-client', ['general', 'id' => $client->id_client]) }}" class="text-gray-800 text-hover-primary mb-1">{{ $client->name }}</a>
                    </td>
                    <td>
                        <span class="info-format">
                            {{ $client->general_info }}
                        </span>
                    </td>
                    <td>{{ $client->user->contact->name ?? '' }} {{ $client->user->contact->last_name ?? '' }}</td>
                    <td>{{ $client->website }}</td>
                    <td>{{ $client->phone }}</td>
                    <td class="text-end">
                        <a href="{{ route('read-client', ['general', 'id' => $client->id_client]) }}" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1">
                            <span class="svg-icon svg-icon-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M21.4 8.35303L19.241 10.511L13.485 4.755L15.643 2.59595C16.0248 2.21423 16.5426 1.99988 17.0825 1.99988C17.6224 1.99988 18.1402 2.21423 18.522 2.59595L21.4 5.474C21.7817 5.85581 21.9962 6.37355 21.9962 6.91345C21.9962 7.45335 21.7817 7.97122 21.4 8.35303ZM3.68699 21.932L9.88699 19.865L4.13099 14.109L2.06399 20.309C1.98815 20.5354 1.97703 20.7787 2.03189 21.0111C2.08674 21.2436 2.2054 21.4561 2.37449 21.6248C2.54359 21.7934 2.75641 21.9115 2.989 21.9658C3.22158 22.0201 3.4647 22.0084 3.69099 21.932H3.68699Z" fill="currentColor" />
                                    <path d="M5.574 21.3L3.692 21.928C3.46591 22.0032 3.22334 22.0141 2.99144 21.9594C2.75954 21.9046 2.54744 21.7864 2.3789 21.6179C2.21036 21.4495 2.09202 21.2375 2.03711 21.0056C1.9822 20.7737 1.99289 20.5312 2.06799 20.3051L2.696 18.422L5.574 21.3ZM4.13499 14.105L9.891 19.861L19.245 10.507L13.489 4.75098L4.13499 14.105Z" fill="currentColor" />
                                </svg>
                            </span>
                        </a>
                        <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm" onclick="deleteClient('{{ $client->id_client }}'); return false;">
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
@endsection


@push('scripts')
    <script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
    <script>
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
                        },
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
