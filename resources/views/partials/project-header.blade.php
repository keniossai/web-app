<div class="card mb-5">
    <div class="card-body pt-9 pb-0">
        <!--begin::Details-->
        <div class="d-flex flex-wrap flex-sm-nowrap mb-6">
            <div class="d-flex flex-center flex-shrink-0 bg-light rounded w-100px h-100px w-lg-150px h-lg-150px me-7 mb-4">
                <img class="mw-50px mw-lg-100px" src="{{ $project->client->getPicture() }}" alt="image" />
            </div>
            <div class="flex-grow-1">
                <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                    <div class="d-flex flex-column">
                        <div class="d-flex align-items-center mb-1">
                            <a href="#" class="text-gray-800 text-hover-primary fs-2 fw-bold me-3">
                                {{ $project->name ?? '' }}
                                <input id="project_name" value="{{  $project->name ?? '' }}" hidden>
                                <input id="id_project" value="{{  $project->id_project ?? '' }}" hidden>
                                <input id="agreedDeadline" value="{{  $project->agreed_deadline ?? '' }}" hidden>
                            </a>
                            <span class="badge badge-light-success me-auto">In Progress</span>
                        </div>
                        <div class="d-flex flex-wrap fw-semibold mb-4 fs-5 text-gray-400">
                            {{ App\Models\Client::find($project->id_client)->name ?? ''}}
                            <input type="text" id="id_client" value="{{ $project->id_client }}" hidden>
                        </div>
                    </div>
                    <!--begin::Actions-->
                    <div class="d-flex mb-4">
                        @if(App\Repositories\UsersRepositories::isAllowed('read-project'))
                            <a href="{{ route('edit-project', ['edit', 'id' => $project->id_project]) }}" class="btn btn-sm btn-facebook" style="color:white">
                                Edit Project Header
                            </a>
                        @endif
                        &nbsp;
                        @if(App\Repositories\UsersRepositories::isAllowed('delete-project'))
                            <a href="#" onclick="deleteProject('{{ $project->id_project }}')" class="btn btn-sm btn-danger">Delete Project</a>
                        @endif
                    </div>
                    <!--end::Actions-->
                </div>
                <div class="d-flex flex-wrap justify-content-start">
                    <div class="d-flex flex-wrap">
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="fs-4 fw-bold">
                                    {{  $project->year ?? '' }}
                                    <input id="project_year" value="{{  $project->year ?? '' }}" hidden>
                                </div>
                            </div>
                            <div class="fw-semibold fs-6 text-gray-400">Year</div>
                        </div>
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="fs-4 fw-bold">
                                    @php
                                        $timezone = Auth::user()->timezone;
                                        $date = Carbon\Carbon::parse($project->created_at, isset($timezone) ? $timezone : 'UTC');
                                    @endphp

                                    {{ $date->isoFormat('MMMM Do YYYY') }}
                                </div>
                            </div>
                            <div class="fw-semibold fs-6 text-gray-400">Created At</div>
                        </div>
                        <div class="border border-gray-300 border-dashed rounded min-w-125px py-3 px-4 me-6 mb-3">
                            <div class="d-flex align-items-center">
                                <div class="fs-4 fw-bold">
                                    @if(isset($project->owner))
                                        {{ App\Models\User::find($project->owner)->contact->getName() }}
                                    @endif
                                </div>
                            </div>
                            <div class="fw-semibold fs-6 text-gray-400">Owner</div>
                        </div>
                    </div>
                    {{-- contacts --}}
                    {{-- <div class="symbol-group symbol-hover mb-3">
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Alan Warden">
                            <span class="symbol-label bg-warning text-inverse-warning fw-bold">A</span>
                        </div>
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Susan Redwood">
                            <span class="symbol-label bg-primary text-inverse-primary fw-bold">S</span>
                        </div>
                        <div class="symbol symbol-35px symbol-circle" data-bs-toggle="tooltip" title="Perry Matthew">
                            <span class="symbol-label bg-info text-inverse-info fw-bold">P</span>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
        <!--end::Details-->
        <div class="separator"></div>
        {{-- menu sections --}}
        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">

            @if ($isView == true)
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6 @if ($view == "submissions") active @endif" href="{{ route('view-project', ['submissions', 'id' => $project->id_project]) }}">Submissions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6 @if ($view == "contacts") active @endif" href="{{ route('view-project', ['contacts', 'id' => $project->id_project]) }}">Contacts</a>
                </li>
            @else
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6 @if ($view == "submissions") active @endif" href="{{ route('read-project',  ['submissions', 'id' => $project->id_project]) }}">Submissions</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-active-primary py-5 me-6 @if ($view == "contacts") active @endif" href="{{ route('read-project',  ['contacts', 'id' => $project->id_project]) }}">Contacts</a>
                </li>
            @endif
        </ul>
    </div>
</div>
