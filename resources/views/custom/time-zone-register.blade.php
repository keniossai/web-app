<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->

<head>
    <base href="../../" />
    <title>Register - time zone</title>
    <meta charset="utf-8" />
    <meta name="description" content="kidd aitken" />
    <meta name="keywords" content="kidd aitken" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:locale" content="en_US" />
    <meta property="og:type" content="article" />
    <meta property="og:title" content="kidd aitken" />
    <meta property="og:url" content="https://keenthemes.com/metronic" />
    <meta property="og:site_name" content="Keenthemes | Metronic" />
    <link rel="canonical" href="https://preview.keenthemes.com/metronic8" />
    <link rel="shortcut icon" href="{{ URL::asset('assets/media/logos/favicon.ico') }}" />
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <!--end::Fonts-->
    <!--begin::Global Stylesheets Bundle(mandatory for all pages)-->
    <link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--end::Global Stylesheets Bundle-->
</head>
<!--end::Head-->
<!--begin::Body-->

<body id="kt_body" class="app-blank app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
    <!--begin::Theme mode setup on page load-->
    <script>
        var defaultThemeMode = "light";
        var themeMode;
        if (document.documentElement) {
            if (document.documentElement.hasAttribute("data-theme-mode")) {
                themeMode = document.documentElement.getAttribute("data-theme-mode");
            } else {
                if (localStorage.getItem("data-theme") !== null) {
                    themeMode = localStorage.getItem("data-theme");
                } else {
                    themeMode = defaultThemeMode;
                }
            }
            if (themeMode === "system") {
                themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light";
            }
            document.documentElement.setAttribute("data-theme", themeMode);
        }
    </script>
    <!--end::Theme mode setup on page load-->
    <!--begin::Root-->
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Page bg image-->
        <style>
            body {
                background-image: url('assets/media/auth/bg_gray.png');
                background-size: unset !important;
            }

            [data-theme="dark"] body {
                background-image: url('assets/media/auth/bg9-dark.jpg');
                background-size: unset !important;
            }
        </style>
        <!--end::Page bg image-->
        <!--begin::Authentication - Signup Welcome Message -->
        <div class="d-flex flex-column flex-center flex-column-fluid">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center text-center p-10">
                <!--begin::Wrapper-->
                <div class="card card-flush w-lg-650px py-5">
                    <div class="card-body">
                        <!--begin::Logo-->
                        <div class="mb-10">
                            <a class="">
                                <img alt="Logo" src="{{ URL::asset('assets/media/logos/KA-logo-light-grey.png') }}"
                                    class="h-80px" />
                            </a>
                        </div>
                        <!--end::Logo-->
                        <!--begin::Title-->
                        <h3 class="fw-bolder text-gray-900">Complete your registration</h3>

                        <!--end::Text-->
                        <!--begin::Form-->
                        <div class="card">
                            <div class="card-header justify-content-end">
                                <div class="card-title d-flex justify-content-end">
                                    <a class="btn btn-sm btn-secondary" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        Cancel
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                    &nbsp;
                                    <button type="submit" form="register-form" class="btn btn-sm btn-primary">
                                        Save
                                    </button>
                                    &nbsp;
                                </div>
                            </div>
                            <form class="form" method="POST" id="register-form" action="{{ route('time-zone-register') }}">
                                @csrf
                                <div class="card-body p-9">
                                    <div class="row mb-8">
                                        <div class="col-xl-3">
                                            <div class="fs-6 fw-semibold mt-2 mb-3 required">Timezone</div>
                                        </div>
                                        <div class="col-xl-9 fv-row">
                                            <select class="form-control timezone-select2" data-control="select2" id="timezone" name="timezone" data-placeholder="Select a timezone" data-allow-clear="true" required>
                                                <option></option>
                                                @foreach (timezone_identifiers_list() as $timezone)
                                                    <option
                                                        value="{{ $timezone }}"{{ $timezone == old('timezone') ? ' selected' : '' }}>
                                                        {{ $timezone }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-8">
                                        <div class="col-xl-3">
                                            <div class="fs-6 fw-semibold mt-2 mb-3 required">Name</div>
                                        </div>
                                        <div class="col-xl-9 fv-row">
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', Auth::user()->contact->name ?? '') }}" required/>
                                        </div>
                                    </div>
                                    <div class="row mb-8">
                                        <div class="col-xl-3">
                                            <div class="fs-6 fw-semibold mt-2 mb-3 required">Last Name</div>
                                        </div>
                                        <div class="col-xl-9 fv-row">
                                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ old('last_name', Auth::user()->contact->last_name ?? '') }}" required/>
                                        </div>
                                    </div>
                                    <div class="row mb-8">
                                        <div class="col-xl-3">
                                            <div class="fs-6 fw-semibold mt-2 mb-3">Phone</div>
                                        </div>
                                        <div class="col-xl-9 fv-row">
                                            <input type="number" class="form-control" id="phone" name="phone" value="{{ old('phone', Auth::user()->contact->phone ?? '') }}"/>
                                        </div>
                                    </div>
                                    <div class="row mb-8">
                                        <div class="col-xl-3">
                                            <div class="fs-6 fw-semibold mt-2 mb-3 required">Email</div>
                                        </div>
                                        <div class="col-xl-9 fv-row">
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', Auth::user()->contact->email ?? '') }}" readonly required/>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-3">
                                            <div class="fs-6 fw-semibold mt-2 mb-3 required">Job Title </div>
                                        </div>
                                        <div class="col-xl-9 fv-row">
                                            <input type="text" class="form-control" id="job_title" name="job_title" value="{{ old('job_title', Auth::user()->contact->job_title ?? '') }}" required/>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-footer d-flex justify-content-end mb-0 pb-0">
                                    <a class="btn btn-sm btn-secondary" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                        Cancel
                                    </a>
                                    &nbsp;
                                    <button type="submit" form="register-form" class="btn btn-sm btn-primary">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                        <!--end::Illustration-->
                    </div>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Signup Welcome Message-->
    </div>
    <!--end::Root-->
    <!--begin::Javascript-->
    <script>
        var hostUrl = "assets/";
    </script>
    <!--begin::Global Javascript Bundle(mandatory for all pages)-->
    <script src="assets/plugins/global/plugins.bundle.js"></script>
    <script src="assets/js/scripts.bundle.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('focus', '.timezone-select2', function(e) {
                $(this).closest(".select2-container").siblings('select:enabled').select2('open');
            });
        });
    </script>
</body>
<!--end::Body-->

</html>
