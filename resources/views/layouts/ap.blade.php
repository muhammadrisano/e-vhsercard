{{--

=========================================================
* Argon Dashboard PRO - v1.0.0
=========================================================

* Product Page: https://www.creative-tim.com/product/argon-dashboard-pro-laravel
* Copyright 2018 Creative Tim (https://www.creative-tim.com) & UPDIVISION (https://www.updivision.com)

* Coded by www.creative-tim.com & www.updivision.com

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

--}}
<!DOCTYPE html>
<html lang="en">

  <head>
    @if (env('IS_DEMO'))
        <!-- Anti-flicker snippet (recommended)  -->
    <style>.async-hide { opacity: 0 !important} </style>
    <script>(function(a,s,y,n,c,h,i,d,e){s.className+=' '+y;h.start=1*new Date;
    h.end=i=function(){s.className=s.className.replace(RegExp(' ?'+y),'')};
    (a[n]=a[n]||[]).hide=h;setTimeout(function(){i();h.end=null},c);h.timeout=c;
    })(window,document.documentElement,'async-hide','dataLayer',4000,
    {'GTM-K9BGS8K':true});</script>

    <!-- Analytics-Optimize Snippet -->
    <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
    })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
    ga('create', 'UA-46172202-22', 'auto', {allowLinker: true});
    ga('set', 'anonymizeIp', true);
    ga('require', 'GTM-K9BGS8K');
    ga('require', 'displayfeatures');
    ga('require', 'linker');
    ga('linker:autoLink', ["2checkout.com","avangate.com"]);
    </script>
    <!-- end Analytics-Optimize Snippet -->

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-NKDMSK6');</script>
    <!-- End Google Tag Manager -->
    @endif
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('material') }}/img/apple-icon.png">
    <link rel="icon" type="image/png" href="{{ asset('material') }}/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
      Material Dashboard Pro Laravel by Creative Tim & UPDIVISION
    </title>

    @if (env('IS_DEMO'))
    <!-- Extra details for Live View on GitHub Pages -->
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://www.creative-tim.com/product/material-dashboard-pro-laravel" />


    <!--  Social tags      -->
    <meta name="keywords" content="creative tim, html dashboard, laravel, html css dashboard laravel, web dashboard, bootstrap 4 dashboard laravel, bootstrap 4, css3 dashboard, bootstrap 4 admin laravel, material ui dashboard bootstrap 4 laravel, frontend, responsive bootstrap 4 dashboard, material design, material laravel bootstrap 4 dashboard">
    <meta name="description" content="Download Material Dashboard PRO Laravel, a Premium Frontend Preset for Laravel developed by Creative Tim and UPDIVISION. Over 200 components, see the live demo on our website and join over 700.000 creatives!">


    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="Material Dashboard Pro Laravel by Creative Tim & UPDIVISION">
    <meta itemprop="description" content="Download Material Dashboard PRO Laravel, a Premium Frontend Preset for Laravel developed by Creative Tim and UPDIVISION. Over 200 components, see the live demo on our website and join over 700.000 creatives!">

    <meta itemprop="image" content="https://s3.amazonaws.com/creativetim_bucket/products/158/thumb/opt_mdp_laravel_thumbnail.jpg">


    <!-- Twitter Card data -->
    <meta name="twitter:card" content="product">
    <meta name="twitter:site" content="@creativetim">
    <meta name="twitter:title" content="Material Dashboard Pro Laravel by Creative Tim & UPDIVISIONm">

    <meta name="twitter:description" content="Download Material Dashboard PRO Laravel, a Premium Frontend Preset for Laravel developed by Creative Tim and UPDIVISION. Over 200 components, see the live demo on our website and join over 700.000 creatives!">
    <meta name="twitter:creator" content="@creativetim">
    <meta name="twitter:image" content="https://s3.amazonaws.com/creativetim_bucket/products/158/thumb/opt_mdp_laravel_thumbnail.jpg">


    <!-- Open Graph data -->
    <meta property="fb:app_id" content="655968634437471">
    <meta property="og:title" content="Material Dashboard Pro Laravel by Creative Tim & UPDIVISION" />
    <meta property="og:type" content="article" />
    <meta property="og:url" content="https://material-dashboard-pro-laravel.creative-tim.com/" />
    <meta property="og:image" content="https://s3.amazonaws.com/creativetim_bucket/products/158/thumb/opt_mdp_laravel_thumbnail.jpg"/>
    <meta property="og:description" content="Download Material Dashboard PRO Laravel, a Premium Frontend Preset for Laravel developed by Creative Tim and UPDIVISION. Over 200 components, see the live demo on our website and join over 700.000 creatives!" />
    <meta property="og:site_name" content="Creative Tim" />

    @endif

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
    <!-- CSS Files -->
    <link href="{{ asset('material/css/material-dashboard.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/css/material-dashboard.css') }}" rel="stylesheet" />
    <!-- CSS Just for demo purpose, don't include it in your project -->
    {{-- <link href="{{ asset('material/demo/demo.css') }}" rel="stylesheet" /> --}}
  </head>
  <body class="{{ $class ?? '' }}">
    @if (env('IS_DEMO'))
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6"
      height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
      <!-- End Google Tag Manager (noscript) -->
      @endif
      <style>
        #ofBar { 
          display:none;
        }
      </style>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
      
      
        <!--   Core JS Files   -->
        <script src="{{ asset('material/js/core/jquery.min.js') }}"></script>
        <script src="{{ asset('material/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('material/js/core/bootstrap-material-design.min.js') }}"></script>
        <script src="{{ asset('material/js/plugins/perfect-scrollbar.jquery.min.js') }}"></script>
        <!-- Plugin for the momentJs  -->
        <script src="{{ asset('material/js/plugins/moment.min.js') }}"></script>
        <!--  Plugin for Sweet Alert -->
        <script src="{{ asset('material/js/plugins/sweetalert2.js') }}"></script>
        <!-- Forms Validations Plugin -->
        <script src="{{ asset('material/js/plugins/jquery.validate.min.js') }}"></script>
        <!-- Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
        <script src="{{ asset('material/js/plugins/jquery.bootstrap-wizard.js') }}"></script>
        <!--	Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
        <script src="{{ asset('material/js/plugins/bootstrap-selectpicker.js') }}"></script>
        <!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
        <script src="{{ asset('material/js/plugins/bootstrap-datetimepicker.min.js') }}"></script>
        <!--  DataTables.net Plugin, full documentation here: https://datatables.net/  -->
        <script src="{{ asset('material/js/plugins/jquery.dataTables.min.js') }}"></script>
        <!--	Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
        <script src="{{ asset('material/js/plugins/bootstrap-tagsinput.js') }}"></script>
        <!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
        <script src="{{ asset('material/js/plugins/jasny-bootstrap.min.js') }}"></script>
        <!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
        <script src="{{ asset('material/js/plugins/fullcalendar.min.js') }}"></script>
        <!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
        <script src="{{ asset('material/js/plugins/jquery-jvectormap.js') }}"></script>
        <!--  Plugin for the Sliders, full documentation here: http://refreshless.com/nouislider/ -->
        <script src="{{ asset('material/js/plugins/nouislider.min.js') }}"></script>
        <!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
        <!-- Library for adding dinamically elements -->
        <script src="{{ asset('material/js/plugins/arrive.min.js') }}"></script>
        <!--  Google Maps Plugin    -->
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCbVUXb1ZCXDbVu5V-0AjxpikPl6jmgpbQ"></script>
        <!-- Chartist JS -->
        <script src="{{ asset('material/js/plugins/chartist.min.js') }}"></script>
        <!--  Notifications Plugin    -->
        <script src="{{ asset('material/js/plugins/bootstrap-notify.js') }}"></script>
        <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
        <script src="{{ asset('material/js/material-dashboard.js?v=2.1.0') }}" type="text/javascript"></script>
        <!-- Material Dashboard DEMO methods, don't include it in your project! -->
        <script src="{{ asset('material/demo/demo.js') }}"></script>
        <script src="{{ asset('material/js/application.js') }}"></script>
        <script src="{{ asset('material/demo/jquery.sharrre.js') }}"></script>
        <script src="https://cdn.ckeditor.com/ckeditor5/19.1.1/classic/ckeditor.js"></script>
        <script>
          $(document).ready(function () {
                                // FileInput
        $('.form-file-simple .inputFileVisible').click(function() {
            $(this).siblings('.inputFileHidden').trigger('click');
        });

        $('.form-file-simple .inputFileHidden').change(function() {
            var filename = $(this).val().replace(/C:\\fakepath\\/i, '');
            $(this).siblings('.inputFileVisible').val(filename);
        });

        $('.form-file-multiple .inputFileVisible, .form-file-multiple .input-group-btn').click(function() {
            $(this).parent().parent().find('.inputFileHidden').trigger('click');
            $(this).parent().parent().addClass('is-focused');
        });

        $('.form-file-multiple .inputFileHidden').change(function() {
            var names = '';
            for (var i = 0; i < $(this).get(0).files.length; ++i) {
                if (i < $(this).get(0).files.length - 1) {
                    names += $(this).get(0).files.item(i).name + ',';
                } else {
                    names += $(this).get(0).files.item(i).name;
                }
            }
            $(this).siblings('.input-group').find('.inputFileVisible').val(names);
        });

        $('.form-file-multiple .btn').on('focus', function() {
            $(this).parent().siblings().trigger('focus');
        });

        $('.form-file-multiple .btn').on('focusout', function() {
            $(this).parent().siblings().trigger('focusout');
        });
            @if (session('status'))
              $.notify({
                icon: "done",
                message: "{{ session('status') }}"
              }, {
                type: 'success',
                timer: 3000,
                placement: {
                  from: 'top',
                  align: 'right'
                }
              });
            @endif

            @if (session('info'))
              $.notify({
                icon: "done",
                message: "{{ session('info') }}"
              }, {
                type: 'info',
                timer: 3000,
                placement: {
                  from: 'top',
                  align: 'right'
                }
              });
            @endif

            $('#facebook').sharrre({
              share: {
                facebook: true
              },
              enableHover: false,
              enableTracking: false,
              enableCounter: false,
              click: function(api, options) {
                api.simulateClick();
                api.openPopup('facebook');
              },
              template: '<i class="fab fa-facebook-f"></i> Facebook',
              url: 'https://material-dashboard-pro-laravel.creative-tim.com/login'
            });

            $('#google').sharrre({
              share: {
                googlePlus: true
              },
              enableCounter: false,
              enableHover: false,
              enableTracking: true,
              click: function(api, options) {
                api.simulateClick();
                api.openPopup('googlePlus');
              },
              template: '<i class="fab fa-google-plus"></i> Google',
              url: 'https://material-dashboard-pro-laravel.creative-tim.com/login'
            });

            $('#twitter').sharrre({
              share: {
                twitter: true
              },
              enableHover: false,
              enableTracking: false,
              enableCounter: false,
              buttons: {
                twitter: {
                  via: 'CreativeTim'
                }
              },
              click: function(api, options) {
                api.simulateClick();
                api.openPopup('twitter');
              },
              template: '<i class="fab fa-twitter"></i> Twitter',
              url: 'https://material-dashboard-pro-laravel.creative-tim.com/login'
            });

          });
        </script>
        @stack('js')
        
</body>

</html>