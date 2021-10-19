<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
  <title>
    {{ $title }}
  </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="{{ asset('assets/css/nucleo-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="{{ asset('assets/css/nucleo-svg.css') }}" rel="stylesheet" />
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('assets/css/soft-ui-dashboard.css?v=1.0.3') }}" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.datatables.net/1.11.1/css/jquery.dataTables.min.css">
  <style>
     .list-group-item{
       white-space: normal !important;
     }
    .active i {
      color: white !important
    }

    .active span {
      color: black !important
    }

    .rowst {
      display: grid;
      grid-template-columns: repeat(2,1fr);
      gap: 20px;
      width: auto !important;
    }

    @media screen and (max-width:991px) {
      .rowst {
        grid-template-columns: repeat(1,1fr);
      }
    }
    .wrapper-img{
      height: fit-content;
      width: 100%;
      display: flex;
      flex-direction: row;
      flex-wrap: wrap
      /* flex-wrap: wrap; */
    }
    .container-img{
      height: 260px;
      width: 250px;
      margin-right: 20px;
      margin-bottom: 30px
    }
    .container-img h5{
      margin-bottom: 0px
    }
    .wrapper-img .container-img img{
      height: 100%;
      width: 100%;
      object-fit: cover;   
    }
    .gambarko {
      
        margin-top: 1%;
        width: 60px;
        height: 90px;
        align-self: auto;
        /* border: 2px solid #000000; */
    }
    ko {
        width: 900px;
        height: 400px;
    }
  </style>
</head>

<body class="g-sidenav-show  bg-gray-100">
    <aside class="sidenav navbar navbar-vertical bg-gradient-danger navbar-expand-xs border-0 border-radius-xl my-1 fixed-start ms-3 " id="sidenav-main">
      <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-10 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="gambarko ko" href="#" target="_blank">
          <img src="{{ asset('assets/img' . '/' . $profile->logo) }}" style="object-fit: cover !important" class="ms-3 gambarko" alt="main_logo">
          <span class="ms-1 font-weight-bold text-white" style="font-size: 20px">{{ $profile->nama }}</span>
        </a>
      </div>
      <hr class="horizontal dark mt-3">
      <div class="collapse navbar-collapse  w-auto  max-height-vh-100 h-100" id="sidenav-collapse-main">
        @if (Auth::user()->role == 1)
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link  @if ($title == "Observasi")
              active
            @endif" href="{{ url('home_pengawas') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-tachometer-alt" style="color: black"></i>
              </div>
              <span class="nav-link-text ms-1" style="color: white">Observasi</span>
            </a>
          </li>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="margin-left: 30px;margin-top: 10px;">
            <li class="nav-item">
              <a class="nav-linsk d-flex">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="background: rgb(233,236,239) !important">
                  <i class="fas fa-sign-out-alt " style="margin-top: -5px;color: black"></i>
                </div>
                  @csrf
                  <button class="nav-link-text ms-1 text-white" style="outline: none !important;background: none;border: none;font-size: 14px;color: #67748E" type="submit">Logout</button>
                </a>
              </li>
            </form>
        </ul>
        @elseif(Auth::user()->role == 2)
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link  @if ($title == "Observasi")
              active
            @endif" href="{{ url('home_manager') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-tachometer-alt" style="color: black"></i>
              </div>
              <span class="nav-link-text ms-1" style="color: white">Observasi</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  @if ($title == "Pengawas")
              active
            @endif" href="{{ url('pengawas_manager') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-users" style="color: black"></i>
              </div>
              <span class="nav-link-text ms-1" style="color: white">Pengawas</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link @if ($title == "Report Perhari")
              active
            @endif" href="{{ url('jam_monitoring') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-clipboard-list" style="color: black"></i>
              </div>
              <span class="nav-link-text ms-1" style="color: white">Report Perhari</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link @if ($title == "Report Per Minggu" || $title == "Detail Report Per Minggu" || $title == "Detail Report Per Minggu")
              active
            @endif" href="{{ url('laporan_minggu') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-calendar-week" style="color: black"></i>
              </div>
              <span class="nav-link-text ms-1" style="color: white">Report Perminggu</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link @if ($title == "Area Pengawas" || $title == "Detail Area Pengawas")
            active
          @endif" href="{{ url('area_pengawas') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-map-marker-alt" style="color: black"></i>
              </div>
              <span class="nav-link-text ms-1" style="color: white">Area</span>
            </a>
          </li>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="margin-left: 30px;margin-top: 10px;">
            <li class="nav-item">
              <a class="nav-linsk d-flex">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="background: rgb(233,236,239) !important">
                  <i class="fas fa-sign-out-alt " style="margin-top: -5px;color: black"></i>
                </div>
                  @csrf
                  <button class="nav-link-text text-white ms-1" style="outline: none !important;background: none;border: none;font-size: 14px;color: #67748E" type="submit">Logout</button>
                </a>
              </li>
            </form>
        </ul>
        @elseif(Auth::user()->role == 3)
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link  @if ($title == "Observasi")
              active
            @endif" href="{{ url('home_hse') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-tachometer-alt" style="color: black"></i>
              </div>
              <span class="nav-link-text ms-1" style="color: white">Observasi</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  @if ($title == "Approval Pengawas" || $title == "Detail Approval Pengawas" || $title == "Approval Proses")
              active
            @endif" href="{{ url('approval_hse') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-clipboard-list" style="color: black"></i>
              </div>
              <span class="nav-link-text ms-1" style="color: white">Report</span>
            </a>
          </li>
          {{-- <li class="nav-item">
            <a class="nav-link  @if ($title == "Report Area")
              active
            @endif" href="{{ url('report_area') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-map-marker-alt" style="color: black"></i>
              </div>
              <span class="nav-link-text ms-1" style="color: white">Report Area</span>
            </a>
          </li> --}}
          <li class="nav-item">
            <a class="nav-link  @if ($title == "Area" || $title == "Detail Area Pengawas")
              active
            @endif" href="{{ url('area') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-map-marker-alt" style="color: black"></i>
              </div>
              <span class="nav-link-text ms-1" style="color: white">Area</span>
            </a>
          </li>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="margin-left: 30px;margin-top: 10px;">
            <li class="nav-item">
              <a class="nav-linsk d-flex">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="background: rgb(233,236,239) !important">
                  <i class="fas fa-sign-out-alt " style="margin-top: -5px;color: black"></i>
                </div>
                  @csrf
                  <button class="nav-link-text ms-1 text-white" style="outline: none !important;background: none;border: none;font-size: 14px;color: #67748E" type="submit">Logout</button>
                </a>
              </li>
            </form>
        </ul>
        @else
        <ul class="navbar-nav">
          <li class="nav-item">
            <a class="nav-link  @if ($title == "Pengawas")
              active
            @endif" href="{{ url('home_admin') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-users" style="color: black"></i>
              </div>
              <span class="nav-link-text ms-1" style="color: white">Pengawas</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  @if ($title == "Area Mananger")
              active
            @endif" href="{{ url('area_mananger') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-user-tie" style="color: black"></i>
              </div>
              <span class="nav-link-text ms-1" style="color: white">Area Mananger</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  @if ($title == "HSE AUDIT")
              active
            @endif" href="{{ url('hse_audit') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-user-graduate" style="color: black"></i>
              </div>
              <span class="nav-link-text ms-1" style="color: white">HSE Audit</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link  @if ($title == "Setting")
              active
            @endif" href="{{ url('setting') }}">
              <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fas fa-cog" style="color: black"></i>
              </div>
              <span class="nav-link-text ms-1" style="color: white">Setting</span>
            </a>
          </li>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="margin-left: 30px;margin-top: 10px;">
            <li class="nav-item">
              <a class="nav-linsk d-flex">
                <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center" style="background: rgb(233,236,239) !important">
                  <i class="fas fa-sign-out-alt " style="margin-top: -5px;color: black"></i>
                </div>
                  @csrf
                  <button class="nav-link-text ms-1 text-white" style="outline: none !important;background: none;border: none;font-size: 14px;color: #67748E" type="submit">Logout</button>
                </a>
              </li>
            </form>
        </ul>
        @endif
      </div>
    </aside>
  @yield('content')
  <!--   Core JS Files   -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="{{ asset('assets/js/core/popper.min.js') }}"></script>
  <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{ asset('assets/js/plugins/chartjs.min.js') }}"></script>
  <script>

    $(document).ready(function(){		
      $('#myTable').DataTable();
      $('#myTable1').DataTable();
      
    });
    var ctx = document.getElementById("chart-bars").getContext("2d");

    new Chart(ctx, {
      type: "bar",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
          label: "Sales",
          tension: 0.4,
          borderWidth: 0,
          borderRadius: 4,
          borderSkipped: false,
          backgroundColor: "#fff",
          data: [450, 200, 100, 220, 500, 100, 400, 230, 500],
          maxBarThickness: 6
        }, ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
            },
            ticks: {
              suggestedMin: 0,
              suggestedMax: 500,
              beginAtZero: true,
              padding: 15,
              font: {
                size: 14,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
              color: "#fff"
            },
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false
            },
            ticks: {
              display: false
            },
          },
        },
      },
    });


    var ctx2 = document.getElementById("chart-line").getContext("2d");

    var gradientStroke1 = ctx2.createLinearGradient(0, 230, 0, 50);

    gradientStroke1.addColorStop(1, 'rgba(203,12,159,0.2)');
    gradientStroke1.addColorStop(0.2, 'rgba(72,72,176,0.0)');
    gradientStroke1.addColorStop(0, 'rgba(203,12,159,0)'); //purple colors

    var gradientStroke2 = ctx2.createLinearGradient(0, 230, 0, 50);

    gradientStroke2.addColorStop(1, 'rgba(20,23,39,0.2)');
    gradientStroke2.addColorStop(0.2, 'rgba(72,72,176,0.0)');
    gradientStroke2.addColorStop(0, 'rgba(20,23,39,0)'); //purple colors

    new Chart(ctx2, {
      type: "line",
      data: {
        labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [{
            label: "Mobile apps",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#cb0c9f",
            borderWidth: 3,
            backgroundColor: gradientStroke1,
            fill: true,
            data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
            maxBarThickness: 6

          },
          {
            label: "Websites",
            tension: 0.4,
            borderWidth: 0,
            pointRadius: 0,
            borderColor: "#3A416F",
            borderWidth: 3,
            backgroundColor: gradientStroke2,
            fill: true,
            data: [30, 90, 40, 140, 290, 290, 340, 230, 400],
            maxBarThickness: 6
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          legend: {
            display: false,
          }
        },
        interaction: {
          intersect: false,
          mode: 'index',
        },
        scales: {
          y: {
            grid: {
              drawBorder: false,
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              padding: 10,
              color: '#b2b9bf',
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
          x: {
            grid: {
              drawBorder: false,
              display: false,
              drawOnChartArea: false,
              drawTicks: false,
              borderDash: [5, 5]
            },
            ticks: {
              display: true,
              color: '#b2b9bf',
              padding: 20,
              font: {
                size: 11,
                family: "Open Sans",
                style: 'normal',
                lineHeight: 2
              },
            }
          },
        },
      },
    });
  </script>
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
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('assets/js/soft-ui-dashboard.min.js?v=1.0.3') }}"></script>
  <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
</body>

</html>