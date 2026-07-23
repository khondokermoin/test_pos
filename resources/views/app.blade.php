<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @inertiaHead

    <!-- App favicon -->
    <link rel="shortcut icon" href="/frontend_assets/images/favicon.ico">

    <!-- Theme Config Js (must be FIRST — sets data-bs-theme before CSS loads) -->
    <script src="/frontend_assets/js/config.js"></script>

    <!-- Vendor css -->
    <link href="/frontend_assets/css/vendor.min.css" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="/frontend_assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="/frontend_assets/css/icons.min.css" rel="stylesheet" type="text/css" />
</head>

<body>
    @inertia

    <!-- Vite React (mounts React app into #app div) -->
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])

    <!-- Vendor js (Bootstrap, SimpleBar, Popper — after React mounts) -->
    <script src="/frontend_assets/js/vendor.min.js"></script>

    <!-- App js (sidebar toggle, theme switcher — must be last) -->
    <script src="/frontend_assets/js/app.js"></script>
</body>

</html>
