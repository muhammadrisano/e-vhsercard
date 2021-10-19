<!--
=========================================================
* Material Dashboard PRO - v3.0.1
=========================================================

* Product Page:  https://www.creative-tim.com/product/material-dashboard-pro 
* Copyright 2021 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)

* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../../../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
  <title>
        HSE OBSERVATION CARD
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('templatelogin/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('templatelogin/assets/css/nucleo-svg.css')}}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('templatelogin/assets/css/material-dashboard.css?v=3.0.1') }}" rel="stylesheet" />
</head>

<body class="bg-gray-200">
  
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url({{ URL::asset('assets/img/bg-login/bg-virtus.jpg') }});">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="row">
          <div class="col-lg-4 col-md-8 col-12 mx-auto">
            <div class="card z-index-0 fadeIn3 fadeInBottom">
              <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                <div class="bg-gradient-primary shadow-primary border-radius-lg py-3 pe-1">
                  <h4 class="text-white font-weight-bolder text-center mt-2 mb-0">Sign in</h4>
                  <div class="row mt-3">
                    <div class="navbar-toggler navbar-nav" >
                        <img src="{{ asset('assets/img/bg-login/login-sign.png')}} ">
                        
                      </a>
                    </div>
                    
                    
                  </div>
                </div>
              </div>
              <div class="card-body">
                <form method="POST" action="{{ route('login') }}" role="form" class="text-start" >
                  {{-- <form method="POST" action="{{ route('login') }}"> --}}
                    @csrf
                  <div class="input-group input-group-outline my-3">
                    <label class="form-label">NIK</label>
                    <input type="text" class="form-control  @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                    @enderror
                  </div>
                  <div class="input-group input-group-outline mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                    @enderror
                  </div>
                  <div class="form-check form-switch d-flex align-items-center mb-3">
                    <input class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label mb-0 ms-2" for="rememberMe">Remember me</label>
                  </div>
                  <div class="text-center">
                    <button type="submit" class="btn bg-gradient-primary w-100 my-4 mb-2">Sign in</button>
                  </div>
                 
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer position-absolute bottom-2 py-2 w-100">
        <div class="container">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-12 col-md-6 my-auto">
              <div class="copyright text-center text-sm text-white text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart" aria-hidden="true"></i> by
                <a href="https://www.creative-tim.com" class="font-weight-bold text-white" target="_blank">IT Virtusway</a>
                for a better web.
              </div>
            </div>
         
          </div>
        </div>
      </footer>
    </div>
  </main>
  <!--   Core JS Files   -->
  <script src="{{ asset('templatelogin/assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('templatelogin/assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('templatelogin/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('templatelogin/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <!-- Kanban scripts -->
  <script src="{{ asset('templatelogin/assets/js/plugins/dragula/dragula.min.js')}}"></script>
  <script src="{{ asset('templatelogin/assets/js/plugins/jkanban/jkanban.js')}}"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('templatelogin/assets/js/material-dashboard.min.js?v=3.0.1')}}"></script>
  
  
</body>

</html>