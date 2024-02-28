@extends('layouts.master')

@section('master-title', '')

@push('styles')
    <link href="{{ URL::asset('assets/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endpush

@section('master-content')
    @if (!isset($user) || isset($section) ?? $section == 'edit')
        <div class="card">
            <div class="card-header">
                <div class="card-title fs-3 fw-bold">
                User
                </div>
                <div class="card-title d-flex justify-content-end">
                </div>
            </div>

            <div class="card-body py-4">
                <form class="form" method="POST" id="group-form" action="{{ route('save-user') }}">
                    @csrf
                    <div class="card-body p-9">
                        <input id="id_user" name="id_user" value="{{ $user->id_user ?? '' }}" hidden>
                        <div class="row mb-8">
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3 required">Name</div>
                            </div>
                            <div class="col-xl-9 fv-row">
                                <input type="text" class="form-control form-control-solid" name="name" value="{{ old('name', $user->contact->name ?? '') }}" required/>
                            </div>
                        </div>
                        <div class="row mb-8">
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3 required">Last Name</div>
                            </div>
                            <div class="col-xl-9 fv-row">
                                <input type="text" class="form-control form-control-solid" name="last_name" value="{{ old('last_name', $user->contact->last_name ?? '') }}" required/>
                            </div>
                        </div>
                        <div class="row mb-8">
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3">Phone</div>
                            </div>
                            <div class="col-xl-9 fv-row">
                                <input type="number" class="form-control form-control-solid" name="phone" value="{{ old('phone', $user->contact->phone ?? '') }}"/>
                            </div>
                        </div>
                        <div class="row mb-8">
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3 required">Email</div>
                            </div>
                            <div class="col-xl-9 fv-row">
                                <input type="email" id="email" name="email" class="form-control form-control-solid mb-3 mb-lg-0" value="{{ old('email', $user->email ?? '') }}" @if(isset($user->provider_id)) disabled required @endif />
                            </div>
                        </div>
                        <div class="row mb-8">
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3">Password</div>
                            </div>
                            <div class="col-xl-9 fv-row">
                                {{-- <input type="password" name="password" id="password" class="form-control form-control-solid mb-3 mb-lg-0" value="" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}"  placeholder="Minimum 8 characters, uppercase, lowercase, numbers and a symbol" @if(isset($user->provider_id)) disabled @endif/> --}}
                                <div class="fv-row" data-kt-password-meter="true">
                                    <div class="mb-1">

                                        <div class="position-relative mb-3">
                                            <input class="form-control form-control-lg form-control-solid" type="password" placeholder="" id="password" name="password"  pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}"  autocomplete="off" @if(isset($user->provider_id)) disabled @endif/>

                                            <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                                                    <i class="ki-duotone las la-low-vision fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span></i>
                                                    <i class="ki-duotone lar la-eye d-none fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                            </span>
                                        </div>

                                        <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                                            <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                                        </div>
                                    </div>

                                    <div class="text-muted">
                                        Use 8 or more characters with a mix of letters, numbers & symbols.
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-8">
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3">Role</div>
                            </div>
                            <div class="col-xl-9 fv-row">
                                <select class="form-select form-select-lg form-select-solid" name="ids_role[]" data-control="select2" data-placeholder="Select an option" data-allow-clear="true" multiple="multiple">
                                    <?php $ids_role = isset($user) ? $user->userRole->pluck('id_role')->toArray() : old('ids_role', []); ?>
                                    @foreach (App\models\Role::orderBy('name')->where('active', 1)->get() as $role)
                                        <option value="{{ $role->id_role }}" @if(in_array($role->id_role, $ids_role)) selected @endif >{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-8">
                            <div class="col-xl-3">
                                <div class="fs-6 fw-semibold mt-2 mb-3 required">Time zone</div>
                            </div>
                            <div class="col-xl-9 fv-row">
                                <select class="form-select form-select-solid" data-control="select2" id="timezone" name="timezone" data-placeholder="Select a timezone"  data-allow-clear="true" required>
                                    <option></option>
                                    @foreach (timezone_identifiers_list() as $timezone)
                                        <option value="{{ $timezone }}" @if(old('timezone', $user->timezone ?? '') == $timezone) selected @endif>{{ $timezone }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        @if(isset($user))
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
                    <div class="d-flex flex-center flex-column py-5">
                        <div class="symbol symbol-100px symbol-circle mb-7">
                            <img src="{{ $user->contact->getProfilePic() }}" alt="image" />
                        </div>
                        <a href="#" class="fs-3 text-gray-800 text-hover-primary fw-bold mb-3">{{ $user->contact->name }} {{ $user->contact->last_name }}</a>
                        <div class="mb-9">
                            @foreach ($user->userRole as $item)
                                <div class="badge badge-lg badge-light-primary d-inline">{{ $item->role->name }}</div>
                            @endforeach
                        </div>
                        {{-- <div class="fw-bold mb-3">Assigned Tickets
                            <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-html="true" data-bs-content="Number of support tickets assigned, closed and pending this week."></i>
                        </div>
                        <div class="d-flex flex-wrap flex-center">
                            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                <div class="fs-4 fw-bold text-gray-700">
                                    <span class="w-75px">243</span>
                                    <span class="svg-icon svg-icon-3 svg-icon-success">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
                                            <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="fw-semibold text-muted">Total</div>
                            </div>
                            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mx-4 mb-3">
                                <div class="fs-4 fw-bold text-gray-700">
                                    <span class="w-50px">56</span>
                                    <span class="svg-icon svg-icon-3 svg-icon-danger">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="11" y="18" width="13" height="2" rx="1" transform="rotate(-90 11 18)" fill="currentColor" />
                                            <path d="M11.4343 15.4343L7.25 11.25C6.83579 10.8358 6.16421 10.8358 5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75L11.2929 18.2929C11.6834 18.6834 12.3166 18.6834 12.7071 18.2929L18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25C17.8358 10.8358 17.1642 10.8358 16.75 11.25L12.5657 15.4343C12.2533 15.7467 11.7467 15.7467 11.4343 15.4343Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="fw-semibold text-muted">Solved</div>
                            </div>
                            <div class="border border-gray-300 border-dashed rounded py-3 px-3 mb-3">
                                <div class="fs-4 fw-bold text-gray-700">
                                    <span class="w-50px">188</span>
                                    <span class="svg-icon svg-icon-3 svg-icon-success">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect opacity="0.5" x="13" y="6" width="13" height="2" rx="1" transform="rotate(90 13 6)" fill="currentColor" />
                                            <path d="M12.5657 8.56569L16.75 12.75C17.1642 13.1642 17.8358 13.1642 18.25 12.75C18.6642 12.3358 18.6642 11.6642 18.25 11.25L12.7071 5.70711C12.3166 5.31658 11.6834 5.31658 11.2929 5.70711L5.75 11.25C5.33579 11.6642 5.33579 12.3358 5.75 12.75C6.16421 13.1642 6.83579 13.1642 7.25 12.75L11.4343 8.56569C11.7467 8.25327 12.2533 8.25327 12.5657 8.56569Z" fill="currentColor" />
                                        </svg>
                                    </span>
                                </div>
                                <div class="fw-semibold text-muted">Open</div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="d-flex flex-stack fs-4 py-3">
                        <div class="fw-bold rotate collapsible" data-bs-toggle="collapse" href="#kt_user_view_details" role="button" aria-expanded="false" aria-controls="kt_user_view_details">Details
                        <span class="ms-2 rotate-180">
                            <span class="svg-icon svg-icon-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                                </svg>
                            </span>
                        </span></div>
                        <span>
                            <a href="{{ route('edit-user', ['id' => $user->id_user]) }}" class="btn btn-sm btn-light-primary">Edit</a>
                        </span>
                    </div>
                    <div class="separator"></div>

                    <div id="kt_user_view_details" class="collapse show">
                        <div class="pb-5 fs-6">
                            <div class="fw-bold mt-5">Email</div>
                            <div class="text-gray-600">
                                <a href="#" class="text-gray-600 text-hover-primary">{{ $user->email }}</a>
                            </div>
                            <div class="fw-bold mt-5">Phone</div>
                            <div class="text-gray-600">{{ $user->contact->phone }}</div>
                            <div class="fw-bold mt-5">Timezone</div>
                            <div class="text-gray-600">{{ $user->timezone }}</div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="flex-lg-row-fluid ms-lg-15">
            <!--begin:::Tabs-->
            <ul class="nav nav-custom nav-tabs nav-line-tabs nav-line-tabs-2x border-0 fs-4 fw-semibold mb-8">
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4 active" data-bs-toggle="tab" href="#kt_user_view_overview_tab">Tap</a>
                </li>
                {{-- <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-kt-countup-tabs="true" data-bs-toggle="tab" href="#kt_user_view_overview_security">Tap 2</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-active-primary pb-4" data-bs-toggle="tab" href="#kt_user_view_overview_events_and_logs_tab">Tap 3</a>
                </li> --}}
                <li class="nav-item ms-auto">
                    {{-- <a href="#" class="btn btn-primary ps-7" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">Actions
                        <span class="svg-icon svg-icon-2 me-0">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
                            </svg>
                        </span>
                    </a> --}}
                    <!--begin::Menu-->
                    <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold py-4 w-250px fs-6" data-kt-menu="true">
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <div class="menu-content text-muted pb-2 px-5 fs-7 text-uppercase">Title</div>
                        </div>
                        <!--end::Menu item-->
                        <!--begin::Menu item-->
                        <div class="menu-item px-5">
                            <a href="#" class="menu-link px-5">btn</a>
                        </div>

                    </div>
                    <!--end::Menu-->
                    <!--end::Menu-->
                </li>
                <!--end:::Tab item-->
            </ul>
            <!--end:::Tabs-->
            <!--begin:::Tab content-->
            <div class="tab-content" id="myTabContent">
                <!--begin:::Tab pane-->
                <div class="tab-pane fade show active" id="kt_user_view_overview_tab" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card card-flush mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header mt-6">
                            <!--begin::Card title-->
                            <div class="card-title flex-column">
                                <h2 class="mb-1">In process</h2>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">

                            </div>
                            <!--end::Card toolbar-->
                        </div>

                    </div>
                    <!--end::Card-->

                </div>
                <!--end:::Tab pane-->
                <!--begin:::Tab pane-->
                <div class="tab-pane fade" id="kt_user_view_overview_security" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>In process</h2>
                            </div>
                            <!--end::Card title-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 pb-5">

                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                    <!--begin::Card-->
                </div>
                <!--end:::Tab pane-->
                <!--begin:::Tab pane-->
                <div class="tab-pane fade" id="kt_user_view_overview_events_and_logs_tab" role="tabpanel">
                    <!--begin::Card-->
                    <div class="card pt-4 mb-6 mb-xl-9">
                        <!--begin::Card header-->
                        <div class="card-header border-0">
                            <!--begin::Card title-->
                            <div class="card-title">
                                <h2>In process</h2>
                            </div>
                            <!--end::Card title-->
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar">

                            </div>
                            <!--end::Card toolbar-->
                        </div>
                        <!--end::Card header-->
                        <!--begin::Card body-->
                        <div class="card-body pt-0 pb-5">

                        </div>
                        <!--end::Card body-->
                    </div>

                </div>
                <!--end:::Tab pane-->
            </div>
            <!--end:::Tab content-->
        </div>
    </div>
    @endif
@endsection

@push('modals')

@endpush

@push('scripts')
    <script>
        $(document).ready(function(){

        });
        $(document).on('submit', 'form', function() {
            $('#email').prop('disabled', false);
        });

    </script>
@endpush
