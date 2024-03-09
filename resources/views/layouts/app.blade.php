<!doctype html>
<html lang="ja" class="semi-dark">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <base href="{{asset('/')}}">
  <link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
  <!--plugins-->
    <link href="assets/plugins/simplebar/css/simplebar.css" rel="stylesheet"/>
    <link href="assets/plugins/select2/css/select2.min.css" rel="stylesheet"/>
    <link href="assets/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet"/>

    <!--jquery ui-->
    <link href="assets/plugins/jquery-ui/jquery-ui.css" rel="stylesheet"/>

  <!-- datetimepicker CSS -->
  <link href="assets/plugins/datetimepicker/css/classic.css" rel="stylesheet" />
	<link href="assets/plugins/datetimepicker/css/classic.time.css" rel="stylesheet" />
	<link href="assets/plugins/datetimepicker/css/classic.date.css" rel="stylesheet" />
	<link rel="stylesheet" href="assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <!-- lobibox CSS -->
  <link rel="stylesheet" href="assets/plugins/notifications/css/lobibox.min.css" />
  <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
  <link href="assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="assets/css/bootstrap-extended.css" rel="stylesheet" />
  <link href="assets/css/style.css" rel="stylesheet" />
  <link href="assets/css/icons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
  <link href="css/style.css" rel="stylesheet" />
  @yield('css')
  <!-- loader-->
  <link href="assets/css/pace.min.css" rel="stylesheet" />


  <!--Theme Styles-->
  <link href="assets/css/dark-theme.css" rel="stylesheet" />
  <link href="assets/css/light-theme.css" rel="stylesheet" />
  <link href="assets/css/semi-dark.css" rel="stylesheet" />
  <link href="assets/css/header-colors.css" rel="stylesheet" />

  <title> @yield('title') </title>
</head>

<body>


  <!--start wrapper-->
  <div class="wrapper">

       @include('layouts.elements.header')


       @include('layouts.elements.sidebar')

       <!--start content-->
          <main class="page-content">
            <!--breadcrumb-->
            <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
              <div class="breadcrumb-title pe-3">@yield('title')</div>
              <div class="ps-3">
                <nav aria-label="breadcrumb">
                  <ol class="breadcrumb mb-0 p-0">
                    <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">@yield('breadcrumb')</li>
                  </ol>
                </nav>
              </div>
              <div class="ms-auto">

              </div>
            </div>
            <!--end breadcrumb-->

            @yield('content')

          </main>
       <!--end page main-->


       <!--start overlay-->
        <div class="overlay nav-toggle-icon"></div>
       <!--end overlay-->

        <!--Start Back To Top Button-->
        <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
        <!--End Back To Top Button-->


  </div>
  <!--end wrapper-->


  <!-- Bootstrap bundle JS -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!--plugins-->
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/js/jquery-ui.min.js"></script>
  <script src="assets/plugins/simplebar/js/simplebar.min.js"></script>
  <script src="assets/plugins/metismenu/js/metisMenu.min.js"></script>
  <script src="assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
  <script src="assets/plugins/sweetalert/sweetalert2.js"></script>
  <script src="https://kit.fontawesome.com/8d4ec2ee71.js" crossorigin="anonymous"></script>
  <script src="assets/js/pace.min.js"></script>
  <script src="assets/plugins/select2/js/select2.min.js"></script>
  <script src="assets/js/form-select2.js"></script>
  <!--datetimepicker js -->
  <script src="assets/plugins/datetimepicker/js/legacy.js"></script>
	<script src="assets/plugins/datetimepicker/js/picker.js"></script>
	<script src="assets/plugins/datetimepicker/js/picker.time.js"></script>
	<script src="assets/plugins/datetimepicker/js/picker.date.js"></script>
	<script src="assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js"></script>
	<script src="assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js"></script>
  <script src="assets/js/form-date-time-pickes.js"></script>
   <!--notification js -->
	<script src="assets/plugins/notifications/js/lobibox.min.js"></script>
	<script src="assets/plugins/notifications/js/notifications.min.js"></script>
	<script src="assets/plugins/notifications/js/notification-custom-script.js"></script>
  <!--app-->
  <script src="assets/js/app.js"></script>
  <script src="js/lang/ja.js"></script>
  <script>
    $(document).ready(function() {
            @if (Session::get('flash_level') == 'success')
              Lobibox.notify('success', {
                title: '成功',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'bx bx-check-circle',
                msg: "{{ Session::get('flash_message') }}"
              });
            @elseif (Session::get('flash_level') == 'warning')
              Lobibox.notify('warning', {
                title: '注意',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'bx bx-error',
                msg: "{{ Session::get('flash_message') }}"
              });
            @elseif (Session::get('flash_level') == 'error')
              Lobibox.notify('error', {
                title: 'エラー',
                pauseDelayOnHover: true,
                continueDelayOnInactiveTab: false,
                position: 'top right',
                icon: 'bx bx-x-circle',
                msg: "{{ Session::get('flash_message') }}"
              });
            @endif

            //modal logout
            $('.btn-logout').click(function(){
              Swal.fire({
                  title: 'Ban co muon dang xuat khong?',
                  showDenyButton: true,
                  confirmButtonText: '{{ __('Ok') }}',
                  denyButtonText: '{{__('Cancel') }}',
                  customClass: {
                      confirmButton: 'swal-btn',
                      denyButton: 'swal-btn'
                  },
              }).then((result) => {
                  if (result.isConfirmed) {
                      $('#logout-form-menu').submit();
                  }else if (result.isDenied) {
                  }
              })
            })
        });

  </script>
  @yield('script')

</body>

</html>
