<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name', 'E-Perpus') }}</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link rel="stylesheet" href="/assets/css/main/app.css">
    <link rel="shortcut icon" href="/assets/images/logo/favicon.svg" type="image/x-icon">
    <link rel="shortcut icon" href="/assets/images/logo/favicon.png" type="image/png">

    <link rel="stylesheet" href="/assets/css/shared/iconly.css">
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link rel="stylesheet" href="/assets/extensions/apexcharts/apexcharts.css">
    <link rel="stylesheet" href="/assets/extensions/simple-datatables/style.css">
    <link rel="stylesheet" href="/assets/css/pages/simple-datatables.css">
    <link rel="stylesheet" href="/assets/extensions/choices.js/public/assets/styles/choices.css" />
    <link rel="stylesheet" href="/assets/extensions/flatpickr/flatpickr.min.css" />
    <style>
        ::-webkit-scrollbar {
            width: 20px;
        }

        ::-webkit-scrollbar-track {
            background-color: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background-color: #d6dee1;
            border-radius: 20px;
            border: 6px solid transparent;
            background-clip: content-box;
        }

        ::-webkit-scrollbar-thumb:hover {
            background-color: #a8bbbf;
        }

        div.dataTable-top {
            padding: 5px 0;
        }

        .choices__inner {
            background-color: white;
            min-height: 0px;
            padding: 4px !important;
            border: 1px solid #dce7f1 !important;
        }

        .choices[data-type*=select-one] .choices__inner {
            padding: 0;
        }

        .modal-content {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            border-bottom: none;
            padding: 1.5rem 1.5rem 0.5rem;
            background: #dc3545;
            border-radius: 1rem 1rem 0 0;
            color: white;
        }

        .modal-title {
            font-weight: 600;
            font-size: 1.25rem;
        }

        .btn-close {
            filter: brightness(0) invert(1);
            opacity: 0.8;
            transition: opacity 0.2s;
        }

        .btn-close:hover {
            opacity: 1;
        }

        .modal-body {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            padding-top: 2rem;

            font-size: 1.1rem;
            color: #495057;
        }

        .modal-footer {
            border-top: none;
            padding: 1rem 1.5rem 1.5rem;
        }

        .warning-icon {
            font-size: 3rem;
            color: #dc3545;
            margin-bottom: 1rem;
        }

        .modal.fade .modal-dialog {
            transform: scale(0.95);
            transition: transform 0.2s ease-out;
        }

        .modal.show .modal-dialog {
            transform: scale(1);
        }
    </style>
    @stack('style')
</head>

<body class="theme-light">
    <div id="sidebar" class="active">
        <div class="sidebar-wrapper active">
            <div class="sidebar-header position-relative">
                <div class="d-flex justify-content-center align-items-center">
                    <div class="logo text-center">
                        <img src="/assets/images/lkc.png" style="width: 150px; height: 80px; " alt="Logo">
                    </div>
                </div>
            </div>
            <div class="sidebar-menu">
                <ul class="menu mt-0">
                    @yield('sidebar')
                </ul>
            </div>
        </div>
    </div>
    <div id="main" class='layout-navbar navbar-fixed'>
        <header>
            @yield('navbar')
        </header>
        <div id="main-content" class="pt-0" style="min-height: 80vh">
            @yield('content')
        </div>
    </div>

    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

    <script src="/assets/js/bootstrap.js"></script>
    <script src="/assets/js/app.js"></script>
    <script src="/assets/extensions/simple-datatables/umd/simple-datatables.js"></script>
    <script src="/assets/js/pages/simple-datatables.js"></script>
    <script src="/assets/extensions/choices.js/public/assets/scripts/choices.js"></script>
    <script src="/assets/js/pages/form-element-select.js"></script>
    <script src="/assets/extensions/apexcharts/apexcharts.js"></script>
    <script src="/assets/extensions/flatpickr/flatpickr.min.js"></script>

    <script>
        const appBody = document.body;
        if (localStorage.getItem('theme') == 'theme-dark') {
            localStorage.setItem('theme', "theme-light")
            appBody.classList.add("theme-light");
        } else {
            localStorage.setItem('theme', "theme-light")
            appBody.classList.add("theme-light");
        };
    </script>

    @stack('script')
</body>

</html>
