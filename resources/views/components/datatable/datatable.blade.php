@props([
    'id',
    'search' => 'search',
    'title' => null,
    'filters' => null,
    'headers' => null,
    'records' => null,
    'declaredColumns' => null,
    'toolbar' => null,
    'idTableFilter',
    'dateColumn' => null,
    'qtyColumns',
    'statusFilter' => null,
    'buttons' => null
])
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
                <input type="text" {{ $idTableFilter }}-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search" />
            </div>
            <!--end::Search-->
        </div>
        <!--begin::Card title-->

        <!--begin::Card toolbar-->
        <div class="card-toolbar">
            <!--begin::Toolbar-->
            <div class="d-flex justify-content-end" {{ $idTableFilter }}-toolbar="base">
                <!--begin::Filter-->
                <div class="w-150px me-3">
                    <!--begin::Select2-->
                    {{ $filters }}
                    <!--end::Select2-->
                </div>
                <!--end::Filter-->
                <!--begin::Export-->
                {{-- <button type="button" class="btn btn-light-primary me-3" data-bs-toggle="modal" data-bs-target="#kt_customers_export_modal">
                    <span class="svg-icon svg-icon-2">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1" transform="rotate(90 12.75 4.25)" fill="currentColor" />
                            <path d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z" fill="currentColor" />
                            <path opacity="0.3" d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z" fill="currentColor" />
                        </svg>
                    </span>
                    Export
                </button> --}}
                <!--end::Export-->
                <!--begin::Add buttons-->
                {{ $buttons }}
                <!--end::Add customer-->
            </div>
            <!--end::Toolbar-->
            <!--begin::Group actions-->
            <div class="d-flex justify-content-end align-items-center d-none" {{ $idTableFilter }}-toolbar="selected">
                <div class="fw-bold me-5">
                <span class="me-2" {{ $idTableFilter }}-select="selected_count"></span>Selected</div>
                <button type="button" class="btn btn-danger" {{ $idTableFilter }}-select="delete_selected">Delete Selected</button>
            </div>
            <!--end::Group actions-->
        </div>
        <!--end::Card toolbar-->
    </div>
    <!--end::Card header-->

    <!--begin::Card body-->
    <div class="card-body pt-0">
        <!--begin::Table-->
        <table class="table align-middle table-row-dashed fs-6 gy-5" id="{{ $id }}">
            <!--begin::Table head-->
            <thead>
                <!--begin::Table row-->
                <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                    {{ $headers }}

                </tr>
                <!--end::Table row-->
            </thead>
            <!--end::Table head-->
            <!--begin::Table body-->

            <tbody class="fw-semibold text-gray-600">
                {{ $records }}
            </tbody>
        </table>
        <!--end::Table-->
    </div>
    <!--end::Card body-->
</div>
@push('scripts')
<script>
    "use strict";
    var KTCustomersList{{ $id }}=function(){
        var t,e,o=()=>{
            //eliminacion por fila
            e.querySelectorAll('[{{ $idTableFilter }}-filter="delete_row"]').forEach((
                e=>{e.addEventListener("click",(function(e){
                    e.preventDefault();
                    const o=e.target.closest("tr"),
                    n=o.querySelectorAll("td")[1].innerText;
                    Swal.fire({
                        text:"Are you sure you want to delete "+n+"?",icon:"warning",showCancelButton:!0,buttonsStyling:!1,confirmButtonText:"Yes, delete!",cancelButtonText:"No, cancel",customClass:{confirmButton:"btn fw-bold btn-danger",cancelButton:"btn fw-bold btn-active-light-primary"}
                    }).then((function(e){
                        e.value?
                        t.row($(o)).remove().draw()
                        :"cancel"===e.dismiss
                    }))
                }))}
            ))
        },
        n=()=>{//eliminacion masivo usando checkbox
            const o=e.querySelectorAll('[type="checkbox"]'),
            n=document.querySelector('[{{ $idTableFilter }}-select="delete_selected"]');
            o.forEach((t=>{
                t.addEventListener("click",(function(){
                    setTimeout((function(){
                        c()
                    }),50)
                }))
            })),
            n.addEventListener("click",(function(){
                Swal.fire({
                    text:"Are you sure you want to delete selected customers?",icon:"warning",showCancelButton:!0,buttonsStyling:!1,confirmButtonText:"Yes, delete!",cancelButtonText:"No, cancel",customClass:{confirmButton:"btn fw-bold btn-danger",cancelButton:"btn fw-bold btn-active-light-primary"}
                }).then((function(n){
                    n.value?Swal.fire({
                        text:"You have deleted all selected customers!.",icon:"success",buttonsStyling:!1,confirmButtonText:"Ok, got it!",customClass:{confirmButton:"btn fw-bold btn-primary"}
                    }).then((function(){
                        o.forEach((e=>{
                            e.checked&&t.row($(e.closest("tbody tr"))).remove().draw()
                        }));
                        e.querySelectorAll('[type="checkbox"]')[0].checked=!1
                    })):"cancel"===n.dismiss&&Swal.fire({
                        text:"Selected customers was not deleted.",icon:"error",buttonsStyling:!1,confirmButtonText:"Ok, got it!",customClass:{confirmButton:"btn fw-bold btn-primary"}
                    })
                }))
            }))
        };

        const c=()=>{
            const t=document.querySelector('[{{ $idTableFilter }}-toolbar="base"]'),
            o=document.querySelector('[{{ $idTableFilter }}-toolbar="selected"]'),
            n=document.querySelector('[{{ $idTableFilter }}-select="selected_count"]'),
            c=e.querySelectorAll('tbody [type="checkbox"]');
            let r=!1,l=0;
            c.forEach((t=>{
                t.checked&&(r=!0,l++)
            })),
            r?(
                n.innerHTML=l,
                t.classList.add("d-none"),
                o.classList.remove("d-none")
            ):(
                t.classList.remove("d-none"),
                o.classList.add("d-none")
            )
        };

        return{
            init:function(){
                (
                    e=document.querySelector("#{{ $id }}")
                )&&(//formatear fechas
                    @if($dateColumn)
                        e.querySelectorAll("tbody tr").forEach((t=>{
                            const e=t.querySelectorAll("td"),
                            o=moment(e[{{ $dateColumn }}].innerHTML,"DD MMM YYYY, LT").format();
                            e[{{ $dateColumn }}].setAttribute("data-order",o)
                        })),
                    @endif

                    (t=$(e).DataTable({
                            // info:!1,order:[],columnDefs:[{orderable:!1,targets:0},{orderable:!1,targets:{{ $qtyColumns }}}]
                            info:!1,order:[0, 'asc'],columnDefs:[{orderable:!1},{orderable:!1,targets:{{ $qtyColumns }}}]
                        })
                    ).on("draw",(function(){
                        n(),o(),c()
                    })),n(),
                    document.querySelector('[{{ $idTableFilter }}-filter="search"]').addEventListener("keyup",(function(e){
                        t.search(e.target.value).draw()
                    })),o(),
                    (
                        ()=>{
                            //se filtra desde en encabezado
                            // if({{ $statusFilter }}){
                                const e=document.querySelector('[{{ $idTableFilter }}-order-filter="status"]');
                                $(e).on("change",(e=>{
                                    let o=e.target.value;
                                    "all"===o&&(o=""),
                                    t.column({{ $statusFilter ?? '' }}).search(o).draw()//se especifica la columna a filtrar
                                }))
                            // }
                        }
                    )()
                )
            }
        }
    }();
    KTUtil.onDOMContentLoaded((function(){
        KTCustomersList{{ $id }}.init()
    }));
</script>

@endpush
