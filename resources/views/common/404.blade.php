@extends('layouts.master')

@section('core-content')
<!--begin::Main-->
<div class="d-flex flex-column flex-root">
    <!--begin::Error-->
    <div class="d-flex flex-row-fluid flex-column bgi-size-cover bgi-position-center bgi-no-repeat p-10 p-sm-30" style="background-image: url(img/404.png);">
    <!--begin::Content-->
        <h4 class="text-dark-75" style="font-size: 10rem">Route 404</h4>
        <p class="font-size-h3 text-muted font-weight-normal">
            You reached a dead end
        </p>
    <!--end::Content-->
    </div>
</div>
@endsection
