@extends('layouts.aplikasi')

@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
  <!-- Navbar -->
  <nav class="navbar navbar-main navbar-expand-lg bg-gradient-danger px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
          <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Hse Audit</a></li>
          <li class="breadcrumb-item text-sm text-dark active text-white" aria-current="page">Observasi</li>
        </ol>
        <h6 class="font-weight-bolder mb-0 text-white">Observasi</h6>
      </nav>
      <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
        <div class="ms-md-auto pe-md-3 d-flex align-items-center">
        </div>
        <ul class="navbar-nav  justify-content-end">
          <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
              <div class="sidenav-toggler-inner">
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
                <i class="sidenav-toggler-line"></i>
              </div>
            </a>
          </li>
          <li class="nav-item dropdown pe-2 d-flex align-items-center">
            <a href="javascript:;" class="nav-link text-body p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
              <div class="d-flex justify-content-center">
                <h6 class="users text-white" style="margin-left: 10px;">{{ Str::limit(Auth::user()->name, 10, '') }}</h6>
                <div style="width: 30px;height: 30px;margin-left: 10px;" data-bs-toggle="modal" data-bs-target="#img_profile">
                  <img src="{{ asset('assets/img' . '/' . Auth::user()->img) }}" alt="" style="width: 100%;height: 100%;border-radius: 50%;object-fit: cover">
                </div>
              </div>
            </a>
            <div class="modal fade" id="img_profile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Profile</h5>
                    </div>
                    <div class="modal-body">
                      <form action="{{ url('edit_hse_profile' . '/' . Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="img_lama" value="{{ Auth::user()->img }}">
                      <div class="form-group">
                        <label for="nama" class="form-control-label">Nama Lengkap</label>
                        <input class="form-control @error('nama')
                        is-invalid
                        @enderror" type="text" value="{{ Auth::user()->name }}" id="nama" name="nama" required>
                      </div>
                      <div class="form-group">
                        <label for="nik" class="form-control-label">NIK</label>
                        <input class="form-control @error('nik')
                          is-invalid
                        @enderror" type="number" value="{{ Auth::user()->email }}" id="nik" name="nik" required>
                      </div>
                      <div class="form-group">
                        <label for="email" class="form-control-label">Email</label>
                        <input class="form-control @error('email')
                          is-invalid
                        @enderror" type="email" value="{{ Auth::user()->email_address_id }}" id="email" name="email" required>
                      </div>
                      <div class="form-group">
                        <label for="img" class="form-control-label">Gambar</label>
                        <input class="form-control @error('img')
                          is-invalid
                        @enderror" type="file"  id="img" name="img">
                      </div>
                      <div class="form-group">
                        <label for="password" class="form-control-label">Password</label>
                        <input class="form-control @error('password')
                          is-invalid
                        @enderror" type="password" id="password" name="password">
                      </div>
                      <div class="form-group">
                        <label for="repeat" class="form-control-label">Repeat Password</label>
                        <input class="form-control @error('repeat')
                          is-invalid
                        @enderror" type="password" id="repeat" name="repeat">
                      </div>
                        <button type="submit" class="btn btn-success">Simpan</button>
                      </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-secondary"
                            data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- End Navbar -->
  <div class="container py-4" style="overflow-x: hidden">
    <div class="card">
      <div class="card-header">
        @if (session('status'))
        <div class="alert alert-primary text-white alert-dismissible fade show" role="alert">
          <span class="alert-icon"><i class="fas fa-thumbs-up"></i></span>
          <span class="alert-text">{{ session('status') }}</span>
          <button type="button" class="btn-close text-white" style="margin-top: -13px;font-size: 25px" data-bs-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
          </button>
      </div>
        @endif
      </div>
      <div class="card-body px-0 pt-0 pb-2">
        <div class="table-responsive p-4">
          <table class="table align-items-center justify-content-center mb-0 diplay" id="myTable" style="width: 100%">
            <thead>
              <tr>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No
                </th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                    Date</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                    Nama</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                    Nik</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                    Jam Mulai Observasi</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                    Jam Selesai Observasi</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                    Cabang</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                    Status</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                    Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($observasi as $row)
              <tr>
                <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">
                                                        {{ date('d/m/Y', strtotime($row->dibuat_hseobs)) }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $row->hse_name }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $row->hse_nik }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $row->mulai_kerja }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $row->selesai_kerja }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    <h6 class="mb-0 text-sm">{{ $row->cabang }}</h6>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex px-2">
                                                <div class="my-auto">
                                                    @if ($row->conditions == null)
                                                        <span class=" badge badge-pill bg-gradient-warning">Belum Di
                                                            Konfirmasi</span>
                                                    @elseif ($row->conditions == 1)
                                                        <span class=" badge badge-pill bg-gradient-danger">Di Tolak</span>
                                                    @elseif($row->conditions == 2)
                                                        <span class=" badge badge-pill bg-gradient-success">Di
                                                            Approve</span>
                                                    @elseif($row->conditions == 3)
                                                        <span class=" badge badge-pill bg-gradient-primary">Selesai</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                <td class="align-middle">
                  <a href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#detail{{ $row->id_hseobs }}">
                    <i class="fas fa-eye"></i>
                  </a>
                  @if ($row->conditions == 2)
                  <a href="{{ url('terimas_observasi' . '/' . $row->id_hseobs) }}" class="btn btn-primary">
                    <i class="fas fa-check"></i>
                  </a>
                  <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#id{{ $row->id_hseobs }}">
                    <i class="fas fa-times"></i>
                  </a>
                  <div class="modal fade" id="id{{ $row->id_hseobs }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Observasi</h5>
                            </div>
                            <div class="modal-body">
                              <form action="{{ url('edits_observasi_tolak' . '/' . $row->id_hseobs) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                              <div class="form-group">
                                <label for="pesan" class="form-control-label">Pesan</label>
                                <textarea class="form-control @error('pesan')
                                is-invalid
                                @enderror"  value="{{ old('pesan') }}" id="pesan" name="pesan" required></textarea>
                              </div>
                                <button type="submit" class="btn btn-success">Simpan</button>
                              </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn bg-gradient-secondary"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
                  @endif
                  <div class="modal fade" id="detail{{ $row->id_hseobs }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                  aria-hidden="true">
                                  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h5 class="modal-title" id="exampleModalLabel">Detail Observasi</h5>
                                          </div>
                                          <div class="modal-body">
                                            <ul class="list-group">
                                              <li class="list-group-item">Nama : {{ $row->hse_name }}
                                              </li>
                                              <li class="list-group-item">Nik : {{ $row->hse_nik }}
                                              </li>
                                              <li class="list-group-item">Lokasi Kejadian :
                                                  {{ $row->location }}</li>
                                              <li class="list-group-item">Type Aktifitas Yang Di Amati :
                                                  {{ $row->type_activity }}</li>
                                              <li class="list-group-item">Nama Area :
                                                  {{ $row->positions }}</li>
                                              <li class="list-group-item">Kondisi Observasi :
                                                  {{ $row->kondisi_observasi }}</li>
                                              <li class="list-group-item">Cabang : {{ $row->cabang }}
                                              </li>
                                              {{-- <li class="list-group-item">Jam Schedule : {{ $row->brands_name }}</li> --}}
                                              <li class="list-group-item">Status :
                                                @if ($row->conditions == null)
                                                <span class=" badge badge-pill bg-gradient-warning">Belum Di
                                                    Konfirmasi</span>
                                            @elseif ($row->conditions == 1)
                                                <span class=" badge badge-pill bg-gradient-danger">Di Tolak</span>
                                            @elseif($row->conditions == 2)
                                                <span class=" badge badge-pill bg-gradient-success">Di
                                                    Approve</span>
                                            @elseif($row->conditions == 3)
                                                <span class=" badge badge-pill bg-gradient-primary">Selesai</span>
                                            @endif
                                              </li>
                                              @php
                                              // real time
                                                $akun  = DB::table('users')->where('email',$row->hse_nik)->first();
                                                  $real_time = DB::table('real_time_observasi')->where('hseobs_id',$row->id_hseobs)->where('user_id',$akun->id)->get();
                                              @endphp
                                              <li class="list-group-item">
                                                <h6>Aktifitas Sedang Berjalan</h5>
                                                  @foreach ($real_time as $pages)  
                                                  @if ($pages->status_real == 1)
                                                  <div class="timeline timeline-one-side">
                                                    <div class="timeline-block mb-3">
                                                        <span class="timeline-step">
                                                          <i class="fas fa-paper-plane text-warning text-gradient"></i>
                                                        </span>
                                                        <div class="timeline-content">
                                                            <h6
                                                                class="text-dark text-sm font-weight-bold mb-0">
                                                                {{ $pages->pesan_real_time }}</h6>
                                                            <p
                                                                class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                                {{ date('d,F Y H:i:s',strtotime($pages->waktu_real_time)) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                  @elseif($pages->status_real == 2)
                                                  <div class="timeline timeline-one-side">
                                                    <div class="timeline-block mb-3">
                                                        <span class="timeline-step">
                                                          <i class="fas fa-times text-danger text-gradient"></i>
                                                        </span>
                                                        <div class="timeline-content">
                                                            <h6
                                                                class="text-dark text-sm font-weight-bold mb-0">
                                                                {{ $pages->pesan_real_time }}</h6>
                                                            <p
                                                                class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                                {{ date('d,F Y H:i:s',strtotime($pages->waktu_real_time)) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @elseif($pages->status_real == 3)
                                                <div class="timeline timeline-one-side">
                                                  <div class="timeline-block mb-3">
                                                      <span class="timeline-step">
                                                        <i class="fas fa-check text-info text-gradient"></i>
                                                      </span>
                                                      <div class="timeline-content">
                                                          <h6
                                                              class="text-dark text-sm font-weight-bold mb-0">
                                                              {{ $pages->pesan_real_time }}</h6>
                                                          <p
                                                              class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                              {{ date('d,F Y H:i:s',strtotime($pages->waktu_real_time)) }}</p>
                                                      </div>
                                                  </div>
                                              </div>
                                              @elseif($pages->status_real == 4)
                                              <div class="timeline timeline-one-side">
                                                <div class="timeline-block mb-3">
                                                    <span class="timeline-step">
                                                      <i class="fas fa-sync-alt text-success text-gradient"></i>
                                                    </span>
                                                    <div class="timeline-content">
                                                        <h6
                                                            class="text-dark text-sm font-weight-bold mb-0">
                                                            {{ $pages->pesan_real_time }}</h6>
                                                        <p
                                                            class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                            {{ date('d,F Y H:i:s',strtotime($pages->waktu_real_time)) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            @elseif($pages->status_real == 5)
                                            <div class="timeline timeline-one-side">
                                              <div class="timeline-block mb-3">
                                                  <span class="timeline-step">
                                                    <i class="fas fa-check-double text-primary text-gradient"></i>
                                                  </span>
                                                  <div class="timeline-content">
                                                      <h6
                                                          class="text-dark text-sm font-weight-bold mb-0">
                                                          {{ $pages->pesan_real_time }}</h6>
                                                      <p
                                                          class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                          {{ date('d,F Y H:i:s',strtotime($pages->waktu_real_time)) }}</p>
                                                  </div>
                                              </div>
                                          </div>
                                            @elseif($pages->status_real == 6)
                                            <div class="timeline timeline-one-side">
                                              <div class="timeline-block mb-3">
                                                  <span class="timeline-step">
                                                    <i class="fas fa-times text-primary text-gradient"></i>
                                                  </span>
                                                  <div class="timeline-content">
                                                      <h6
                                                          class="text-dark text-sm font-weight-bold mb-0">
                                                          {{ $pages->pesan_real_time }}</h6>
                                                      <p
                                                          class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                          {{ date('d,F Y H:i:s',strtotime($pages->waktu_real_time)) }}</p>
                                                  </div>
                                              </div>
                                          </div>
                                                  @endif
                                                  @endforeach
                                              </li>
                                              <li class="list-group-item">Corretive User Mananger :
                                                @if ($row->coretive == null)
                                                    Belum Di Isi
                                                @else
                                                    <p>{{ $row->coretive }}</p>
                                                @endif
                                            </li>
                                            <li class="list-group-item">Corretive User Hse Audit :
                                                @if ($row->approve_hse_audit == null)
                                                    Belum Di Isi
                                                @else
                                                    <p>{{ $row->approve_hse_audit }}</p>
                                                @endif
                                            </li>
                                          </ul>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="button" class="btn bg-gradient-secondary"
                                                  data-bs-dismiss="modal">Close</button>
                                          </div>
                                      </div>
                                  </div>
                              </div>
                              <a href="{{ asset('assets/img' . '/' . $row->img_hseobs) }}" download=""
                                class="btn btn-info">
                                <i class="fas fa-download"></i>
                            </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="card mt-5">
      <div class="card-header">
        <h6>Submission</h6>
        <form action="{{ url('cari_kondisi') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-6">
            <div class="input-group">
                <input type="date" name="waktu" required class="form-control @error('waktu')
                  is-invalid
                @enderror" required>
              </div>
              <div class="input-group mt-3">
                <select name="area" id="area" class="form-control @error('area')
                  is-invalid
                @enderror" required>
                @foreach ($area as $rowst)
                  <option value="{{ $rowst->id_positions }}">{{ $rowst->positions }}</option>
                @endforeach
              </select>
              </div>
            </div>
            <div class="col-md-6">
              <button type="submit" class="btn btn-primary">Cari</button>
            </div>
          </div>
        </form>
      </div>
      <div class="card-body">
        <div id="chart"></div>
      </div>
    </div>

    <footer class="footer pt-3  ">
      <div class="container-fluid">
        <div class="copyright text-center text-sm text-muted text-lg-start">
         <h6 class="text-center">Copyright &copy; APLIKASI HSE OBSERVATION  {{ date('Y') }}</h6>
      </div>
      </div>
    </footer>
  </main>
  </div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    
    var options = {
          series: [
            @php
              foreach($kondisi_submision as $rows) {
                $total = $rows->tindakan_aman + $rows->tindakan_tidak_aman + $rows->kondisi_aman + $rows->kondisi_tidak_aman + $rows->Nearmiss + $rows->Accident;
                echo "' $rows->tindakan_aman ' " . ',' . "' $rows->tindakan_tidak_aman ' " . ',' . "' $rows->kondisi_aman ' " . ',' . "' $rows->kondisi_tidak_aman ' " . ',' . "' $rows->Nearmiss ' " . ',' . "' $rows->Accident ' " ;
              }
            @endphp
            // 44, 55, 67, 83,33,34,34,34
          ],
          chart: {
          height: 400,
          type: 'radialBar',
        },
        plotOptions: {
          radialBar: {
            dataLabels: {
              name: {
                fontSize: '22px',
              },
              value: {
                fontSize: '20px',
              },
              total: {
                show: true,
                label: 'Total',
                formatter: function (w) {
                  // By default this function returns the average of all series. The below is just an example to show the use of custom formatter function
                  return @php
                     echo $total;
                  @endphp
                }
              }
            },
          }
        },
        labels: ['Tindakan Aman', 'Tindakan Tidak Aman', 'Kondisi Aman', 'Kondisi Tidak Aman','Nearmiss/nyaris celaka','Accident'],
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
      
</script>
@endsection