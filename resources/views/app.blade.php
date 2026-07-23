<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Cloud POS') }}</title>

        <!-- App favicon -->
        <link rel="shortcut icon" href="/frontend_assets/images/favicon.ico">

        <!-- Theme CSS -->
        <link href="/frontend_assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
        <link href="/frontend_assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="/frontend_assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

        <!-- Scripts -->
        @viteReactRefresh
        @vite(['resources/js/app.jsx', "resources/js/Pages/{$page['component']}.jsx"])
        @inertiaHead
    </head>
    <body className="loading" data-layout-color="light" data-leftbar-theme="dark" data-layout-mode="fluid" data-data-layout="topnav">
        @inertia
    </body>
</html>
