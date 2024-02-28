<!DOCTYPE html>

<html lang="en">
	<!--begin::Head-->
	<head>
        <base href=""/>
		<title>KIDD AITKEN</title>
		<meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="description" content="Kidd Aitken Legal Marketing is the world’s largest team of legal directory and award consultants. Become a top ranked law firm with our support." />
		<meta name="keywords" content="Kidd Aitken Legal Marketing" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="Kidd Aitken Legal Marketing Ltd" />
		<meta property="og:url" content="https://www.kiddaitken.com/" />
		<meta property="og:site_name" content="Kidd Aitken" />

        <link rel="canonical" href="https://www.kiddaitken.com/" />
		<link rel="shortcut icon" href="{{ URL::asset('assets/media/logos/favicon.ico') }}" />
        @include('partials.core-styles')
        @stack('styles')
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
		<!--begin::Theme mode setup on page load-->
		<script>
            var defaultThemeMode = "light";
            var themeMode;
            if ( document.documentElement ) {
                if ( document.documentElement.hasAttribute("data-theme-mode"))
                { themeMode = document.documentElement.getAttribute("data-theme-mode"); } else { if ( localStorage.getItem("data-theme") !== null ) { themeMode = localStorage.getItem("data-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-theme", themeMode); }
        </script>

        @yield('core-content')

        @include('partials.core-js')

        @stack('scripts')
	</body>
	<!--end::Body-->
</html>
