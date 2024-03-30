<!doctype html>
<html lang="en" class="semi-dark">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <base href="{{asset('/')}}">
    <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png"/>
    <!--plugins-->
    <link href="assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet"/>
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet"/>
    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="assets/css/bootstrap-extended.css" rel="stylesheet"/>
    <link href="assets/css/style.css" rel="stylesheet"/>
    <link href="assets/css/icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/plugins/notifications/css/lobibox.min.css"/>
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet"/>
    <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet"/>
    <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet"/>
    <link href="assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet"/>
    <link href="assets/css/datepicker.css" rel="stylesheet"/>

    <!-- loader-->
    <link href="assets/css/pace.min.css" rel="stylesheet"/>

    <!--Theme Styles-->
    <link href="assets/css/dark-theme.css" rel="stylesheet"/>
    <link href="assets/css/light-theme.css" rel="stylesheet"/>
    <link href="assets/css/semi-dark.css" rel="stylesheet"/>
    <link href="assets/css/header-colors.css" rel="stylesheet"/>
    <link href="css/style.css" rel="stylesheet"/>
    @yield('css')
    <title>Quản lý bán hàng Vinh Lợi</title>
</head>
<body>
<div class="wrapper">
    <div class="top-header">
        @include('layouts.elements.header')
    </div>
    <div class="sidebar-wrapper">
        @include('layouts.elements.sidebar')
    </div>
    <div class="page-content">
        @include('layouts.elements.content')
    </div>
    @include('layouts.elements.footer')

    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="assets/js/pace.min.js"></script>
    <script src="assets/plugins/notifications/js/lobibox.min.js"></script>
    <script src="assets/plugins/notifications/js/notifications.min.js"></script>
    <script src="assets/plugins/notifications/js/notification-custom-script.js"></script>
    <script src="assets/plugins/select2/js/select2.min.js"></script>
    <script src="assets/js/form-select2.js"></script>
    <script src="assets/js/bootstrap-datepicker.js"></script>
    <script src="assets/js/jquery.formatCurrency-1.4.0.min.js"></script>
    <!--app-->
    <script src="assets/js/app.js"></script>
    <script>
        $(document).ready(function () {
            @if (Session::get('flash_level') == 'success')
            Lobibox.notify('success', {
                title: 'Thành công',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'bx bx-check-circle',
                msg: "{{ Session::get('flash_message') }}",
                sound: false
            });
            @elseif (Session::get('flash_level') == 'warning')
            Lobibox.notify('warning', {
                title: 'Cảnh báo',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'bx bx-error',
                msg: "{{ Session::get('flash_message') }}",
                sound: false
            });
            @elseif (Session::get('flash_level') == 'error')
            Lobibox.notify('error', {
                title: 'Lỗi',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'bx bx-x-circle',
                msg: "{{ Session::get('flash_message') }}",
                sound: false
            });
            @elseif ($errors->any())
            Lobibox.notify('error', {
                title: 'Lỗi',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'bx bx-x-circle',
                msg: "<div class=\"\">" +
                    "@foreach ($errors->all() as $error)" +
                    "    <div class=\"text-light\">{{ $error }}</div>" +
                    "@endforeach" +
                    "</div>"
            });
            @endif

        });

        $("#datepicker").datepicker({
            format: 'dd/mm/yyyy'
        });
    </script>
    @yield('script')
</div>
</body>
</html>
