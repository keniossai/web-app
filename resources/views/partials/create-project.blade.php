<div class="card">
    <div class="card-header">
        <div class="card-title fs-3 fw-bold">
            @if(isset($project))
                Edit
            @else
                Create
            @endif
        </div>
        <div class="card-title d-flex justify-content-end">
            @if(isset($project))
                <button type="submit" form="project-form" class="btn btn-sm btn-primary">
                    Save
                </button>
                &nbsp;
            @else
                <button type="submit" form="project-form" class="btn btn-sm btn-primary">
                    Create
                </button>
                &nbsp;
            @endif

            <a href="javascript:history.back()" class="btn btn-sm btn-secondary">Cancel</a>
            &nbsp;

            @if(isset($project))
                <a href="#" onclick="deleteProject('{{ $project->id_project }}')" class="btn btn-sm btn-danger">Delete</a>
            @endif
        </div>
    </div>
    <form class="form" method="POST" id="project-form" action="{{ route('save-project') }}">
        @csrf
        <div class="card-body p-9">
            <input id="id_project" name="id_project" value="{{ $project->id_project ?? '' }}" hidden>
            <div class="row mb-8">
                <div class="col-xl-3">
                    <div class="fs-6 fw-semibold mt-2 mb-3 required">Client</div>
                </div>
                <div class="col-xl-9 fv-row">
                    @php
                        $idRole = App\Models\Role::where(['code' => 'client_owner', 'active' => 1])->first()->id_role;
                        if(Auth::user()->userRole->contains('id_role', $idRole)){
                            $idUser = Auth::user()->id_user;
                        }
                        $clients = App\Models\Client::orderBy('name')->where('deleted', 0)->get();
                        if(isset($idUser)){
                            $clients = App\Models\Client::orderBy('name')->where(['deleted' => 0, 'owner' => $idUser])->get();
                        }
                    @endphp
                    <input id="idClient" value="{{ $_GET['id_client'] ?? '' }}" hidden>
                    <select class="form-select form-select-solid" data-control="select2" id="id_client" name="id_client" data-placeholder="Select a client" data-allow-clear="true" required>
                        <option></option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id_client }}" owner="{{ $client->owner }}" @if(old('id_client', $project->id_client ?? '') == $client->id_client) selected @endif>{{ $client->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-8">
                <div class="col-xl-3">
                    <div class="fs-6 fw-semibold mt-2 mb-3 required">Year</div>
                </div>
                <div class="col-xl-9 fv-row">
                    <select class="form-select form-select-solid" data-control="select2" id="year" name="year" data-placeholder="Select a year" data-allow-clear="true" required>
                        <option></option>
                        @for ($i = Carbon\Carbon::now()->subYear(2)->year; $i <= Carbon\Carbon::now()->addYear(3)->year; $i++)
                            <option value="{{ $i }}"  @if(old('year', $project->year ?? '') == $i) selected @endif>{{ $i }}</option>
                        @endfor
                    </select>

                </div>
            </div>

            <div class="row mb-8">
                <div class="col-xl-3">
                    <div class="fs-6 fw-semibold mt-2 mb-3 required">Project Name</div>
                </div>
                <div class="col-xl-9 fv-row">
                    <input type="text" class="form-control form-control-solid" id="project_name" name="name" value="{{ old('name', $project->name ?? '') }}" required/>
                </div>
            </div>

            <div class="row mb-8">
                <div class="col-xl-3">
                    <div class="fs-6 fw-semibold mt-2 mb-3 required">Product Type</div>
                </div>
                <div class="col-xl-9">
                    <div class="row g-9" data-kt-buttons="true" data-kt-buttons-target="[data-kt-button]">
                        @foreach (App\Models\Product::orderBy('order', 'asc')->get() as $product)
                            <div class="col-md-6 col-lg-6 col-xxl-6">
                                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary
                                @if(isset($project) && old('id_product', $project->id_product ?? '') == $product->id_product)
                                    active
                                @elseif($product->id_product == old('id_product'))
                                    active
                                @elseif(!isset($project) && $product->id_product == 3 && old('id_product') == null)
                                    active
                                @endif
                                d-flex text-start p-6" data-kt-button="true">
                                    <span class="form-check form-check-custom form-check-solid form-check-sm align-items-start mt-1">
                                        <input class="form-check-input" id="input-radio" type="radio" name="id_product" value="{{ $product->id_product }}"
                                            @if(isset($project) && old('id_product', $project->id_product ?? '') == $product->id_product)
                                                checked="checked"
                                            @elseif($product->id_product == old('id_product'))
                                                checked="checked"
                                            @elseif(!isset($project) && $product->id_product == 3 && old('id_product') == null)
                                                checked="checked"
                                            @endif
                                        />
                                    </span>
                                    <span class="ms-5">
                                        <span class="fs-4 fw-bold mb-1 d-block">{{ $product->name }}</span>
                                        <span class="fw-semibold fs-7 text-gray-600">{{ $product->description }}</span>
                                    </span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row mb-8">
                <div class="col-xl-3">
                    <div class="fs-6 fw-semibold mt-2 mb-3 required">Owner</div>
                </div>
                <div class="col-xl-9 fv-row">
                    <select class="form-select form-select-solid" data-control="select2" id="owner" name="owner" data-placeholder="Select an owner" data-allow-clear="true" required>
                        <option></option>
                        @foreach (App\models\User::with('contact')->where('active', 1)->get()->sortBy('contact.name') as $user)
                            <option value="{{ $user->id_user }}" @if(old('owner', $project->owner ?? '') == $user->id_user) selected @endif >{{ $user->contact->name }} {{ $user->contact->last_name ?? ''}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="row mb-8">
                <div class="col-xl-3">
                    <div class="fs-6 fw-semibold mt-2 mb-3">Description</div>
                </div>
                <div class="col-xl-9 fv-row">
                    <textarea name="description" class="form-control form-control-solid h-100px">{{ $project->description ?? '' }}</textarea>
                </div>
            </div>
            <div class="row mb-8">
                <div class="col-xl-3">
                    <div class="fs-6 fw-semibold mt-2 mb-3">Agreed deadline</div>
                </div>
                <div class="col-xl-9">
                    <div class="form-check form-switch form-check-custom form-check-solid">
                        <input class="form-check-input" type="checkbox" value="@if(isset($project) && $project->agreed_deadline == 1) 1 @else 1 @endif" id="agreedDeadline" name="agreed_deadline" @if(isset($project) && $project->agreed_deadline == 1) checked="checked" @endif/>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            @if(isset($project))
                <button type="submit" form="project-form" class="btn btn-sm btn-primary">
                    Save
                </button>
                &nbsp;
            @else
                <button type="submit" form="project-form" class="btn btn-sm btn-primary">
                    Create
                </button>
                &nbsp;
            @endif

            <a href="javascript:history.back()" class="btn btn-sm btn-secondary">Cancel</a>
            &nbsp;

            @if(isset($project))
                <a href="#" onclick="deleteProject('{{ $project->id_project }}')" class="btn btn-sm btn-danger">Delete</a>
            @endif
    </form>
</div>
