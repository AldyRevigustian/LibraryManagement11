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

        input:read-only {
            background-color: #efefef;
            pointer-events: none;
        }

        .choices__inner {
            background-color: white
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
