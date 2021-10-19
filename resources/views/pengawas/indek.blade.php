@extends('layouts.aplikasi')

@section('content')
    <main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg bg-gradient-danger px-0 mx-4 shadow-none border-radius-xl"
            id="navbarBlur" navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Pengawas</a>
                        </li>
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
                                      <form action="{{ url('edit_pengawas_profile' . '/' . Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
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
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add">
                        Tambah
                    </a>
                    <h6>INSPECTION PROGRESS</h6>
                    @if ($data_cabang)
                        <span>Cabang : {{ $data_cabang->cabang }}</span>
                        <br>
                        {{-- <span>Area : {{ $data_cabang->positions }}</span>
                        <br> --}}
                        <span>Area Mananger : {{ $data_cabang->name }}</span>
                    @endif
                    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Observasi</h5>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ url('add_observasi') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        {{-- <div class="form-group">
                                            <label for="nama" class="form-control-label">Nama Lengkap</label>
                                            <input
                                                class="form-control @error('nama')
                                    is-invalid
                                    @enderror"
                                                type="text" value="{{ old('nama') }}" id="nama" name="nama" required>
                                        </div> --}}
                                        {{-- <div class="form-group">
                                    <label for="nik" class="form-control-label">NIK</label>
                                    <input class="form-control @error('nik')
                                      is-invalid
                                    @enderror" type="text" value="{{ old('nik') }}" id="nik" name="nik" required>
                                  </div> --}}
                                        @if (!$count_observasi)
                                            <div class="form-group">
                                                <label for="cabang" class="form-control-label">Cabang</label>
                                                <select
                                                    class="form-control @error('cabang')
                                      is-invalid
                                    @enderror"
                                                    id="cabang" name="cabang" required>
                                                    <option value="jakarta & metro">Jakarta & Metro</option>
                                                    <option value="balikpapan">Balikpapan</option>
                                                    <option value="karawang">Karawang</option>
                                                    <option value="surabaya">Surabaya</option>
                                                    <option value="jawa tengah">Jawa Tengah</option>
                                                </select>
                                            </div>
                                            @endif
                                            <div class="form-group">
                                                <label for="area" class="form-control-label">Nama Area</label>
                                                <select
                                                    class="form-control @error('area')
                                      is-invalid
                                    @enderror"
                                                    id="area" name="area" required>
                                                    @foreach ($area as $ares)
                                                        <option value="{{ $ares->id_positions }}">{{ $ares->positions }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        <div class="form-group">
                                            <label for="kejadian" class="form-control-label">Lokasi Kejadian</label>
                                            <textarea
                                                class="form-control @error('kejadian')
                                      is-invalid
                                    @enderror"
                                                value="{{ old('kejadian') }}" id="kejadian" name="kejadian" required
                                                placeholder="Input Lokasi Kejadian (contoh: Parkiran)"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="observasi" class="form-control-label">Kondisi Observasi</label>
                                            <select
                                                class="form-control @error('observasi')
                                        is-invalid
                                      @enderror"
                                                id="observasi" name="observasi" required>
                                                <option value="Tindakan aman">Tindakan aman</option>
                                                <option value="Tindakan tidak aman">Tindakan tidak aman</option>
                                                <option value="Kondisi aman">Kondisi aman</option>
                                                <option value="Kondisi tidak aman">Kondisi tidak aman</option>
                                                <option value="Nearmiss/nyaris celaka">Nearmiss/nyaris celaka</option>
                                                <option value="Accident">Accident</option>
                                            </select>
                                        </div>
                                        {{-- @if (!$count_observasi)
                                            <div class="form-group">
                                                <label for="manager" class="form-control-label">Area Manager</label>
                                                <select
                                                    class="form-control @error('manager')
                                        is-invalid
                                      @enderror"
                                                    id="manager" name="manager" required>
                                                    @foreach ($user as $row)
                                                        <option value="{{ $row->id }}">{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif --}}
                                        <div class="form-group">
                                            <label for="mulai" class="form-control-label">Mulai Kerja</label>
                                            <input
                                                class="form-control @error('mulai')
                                        is-invalid
                                      @enderror"
                                                id="mulai" name="mulai" type="time" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="selesai" class="form-control-label">Selesai Kerja</label>
                                            <input
                                                class="form-control @error('selesai')
                                        is-invalid
                                      @enderror"
                                                id="selesai" name="selesai" required type="time">
                                        </div>
                                        <div class="form-group">
                                            <label for="amati" class="form-control-label">Apa Yang Di Amati</label>
                                            <textarea
                                                class="form-control @error('amati')
                                        is-invalid
                                      @enderror"
                                                value="{{ old('amati') }}" id="amati" name="amati" required
                                                placeholder="Input Yang Di Amati (Contoh Memberikan Apresiasi Dan Coaching Agar Konsiten)">
                                                  </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="terulang" class="form-control-label">Apa Yang Yang Harus Di Lakukan
                                                Kejadian Serupa Tidak Terulang</label>
                                            <textarea
                                                class="form-control @error('terulang')
                                        is-invalid
                                      @enderror"
                                                value="{{ old('terulang') }}" id="terulang" name="terulang" required
                                                placeholder="Input Yang Perbaikan (Contoh Mengecek * Patroli Secara Konsisten)">
                                                  </textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="img" class="form-control-label">Attach File</label>
                                            <input type="file"
                                                class="form-control @error('img')
                                        is-invalid
                                      @enderror"
                                                id="img" name="img" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="obsearvasi" class="form-control-label">Type Aktifitas Yang Di
                                                Amati</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input type="radio" id="satu" value="Sehat untuk bekerja"
                                                            name="type" class="form-check-input" required>
                                                        <label class="custom-control-label" for="satu">Sehat untuk
                                                            bekerja</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" id="dua" value="Berkendara dengan aman"
                                                            name="type" class="form-check-input" required>
                                                        <label class="custom-control-label" for="dua">Berkendara dengan
                                                            aman</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" id="tiga" name="type"
                                                            value="Berhenti jika tidak aman" class="form-check-input"
                                                            required>
                                                        <label class="custom-control-label" for="tiga">Berhenti jika tidak
                                                            aman</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" id="lima" value="Ijin Kerja" name="type"
                                                            class="form-check-input" required>
                                                        <label class="custom-control-label" for="lima">Ijin Kerja</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" id="enam" value="Bekerja dengan bahan kimia"
                                                            name="type" class="form-check-input" required>
                                                        <label class="custom-control-label" for="enam">Bekerja dengan bahan
                                                            kimia</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input type="radio" id="tuju" value="Bekerja di ketinggian"
                                                            name="type" class="form-check-input" required>
                                                        <label class="custom-control-label" for="tuju">Bekerja di
                                                            ketinggian</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" id="sebelas" value="Alat pelindung diri"
                                                            name="type" class="form-check-input" required>
                                                        <label class="custom-control-label" for="sebelas">Alat pelindung
                                                            diri</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" id="delapan" value="Posisi tubuh aman"
                                                            name="type" class="form-check-input" required>
                                                        <label class="custom-control-label" for="delapan">Posisi tubuh
                                                            aman</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" id="sembilan" value="Kebersihan area kerja"
                                                            name="type" class="form-check-input" required>
                                                        <label class="custom-control-label" for="sembilan">Kebersihan area
                                                            kerja</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input type="radio" id="sepuluh" value="Bekerja diruang terbatas"
                                                            name="type" class="form-check-input" required>
                                                        <label class="custom-control-label" for="sepuluh">Bekerja diruang
                                                            terbatas</label>
                                                    </div>
                                                </div>
                                            </div>
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
                    @if (session('status'))
                        <div class="alert alert-primary text-white alert-dismissible fade show" role="alert">
                            <span class="alert-icon"><i class="fas fa-thumbs-up"></i></span>
                            <span class="alert-text">{{ session('status') }}</span>
                            <button type="button" class="btn-close text-white" style="margin-top: -13px;font-size: 25px"
                                data-bs-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-4">
                        <table class="table align-items-center justify-content-center mb-0 diplay" id="myTable"
                            style="width: 100%">
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
                                        Mulai Kerja</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Selesai Kerja</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Cabang</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Status</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @php
                            $no = 1;
                            @endphp
                                @foreach ($observasi as $row)
                                    <tr>
                                        <td>@php echo $no++;
                                        @endphp</td>
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
                                            <a href="#" class="btn btn-success" data-bs-toggle="modal"
                                                data-bs-target="#detail{{ $row->id_hseobs }}">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ asset('assets/img' . '/' . $row->img_hseobs) }}" download=""
                                                class="btn btn-info">
                                                <i class="fas fa-download"></i>
                                            </a>
                                            @if ($row->conditions == 1)
                                                <a href="{{ url('send_observasi' . '/' . $row->id_hseobs) }}"
                                                    class="btn btn-info">
                                                    <i class="fas fa-paper-plane"></i>
                                                </a>
                                            @endif
                                            <div class="modal fade" id="detail{{ $row->id_hseobs }}" tabindex="-1"
                                                role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Detail
                                                                Observasi</h5>
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
                                                                <li class="list-group-item">Mulai Kerja : {{ $row->mulai_kerja }}</li>
                                                                <li class="list-group-item">Selesai Kerja : {{ $row->selesai_kerja }}</li>
                                                                <li class="list-group-item">Apa Yang Di Amati : {{ $row->amati }}</li>
                                                                <li class="list-group-item">Apa Yang Yang Harus Di Lakukan Kejadian Serupa Tidak Terulang : {{ $row->terulang }}</li>
                                                                <li class="list-group-item">Gambar : 
                                                                    <div style="width: 200px;height: 150px;">
                                                                        <img src="{{ asset('assets/img' . '/' . $row->img_hseobs) }}" style="width: 100%;height: 100%;" alt="">
                                                                    </div>
                                                                </li>
                                                                <li class="list-group-item">Status :
                                                                    @if ($row->conditions == null)
                                                                        <span
                                                                            class=" badge badge-pill bg-gradient-warning">Belum
                                                                            Di
                                                                            Konfirmasi</span>
                                                                    @elseif ($row->conditions == 1)
                                                                        <span
                                                                            class=" badge badge-pill bg-gradient-danger">Di
                                                                            Tolak</span>
                                                                    @elseif($row->conditions == 2)
                                                                        <span
                                                                            class=" badge badge-pill bg-gradient-success">Di
                                                                            Approve</span>
                                                                    @elseif($row->conditions == 3)
                                                                        <span
                                                                            class=" badge badge-pill bg-gradient-primary">Selesai</span>
                                                                    @endif
                                                                </li>
                                                                @php
                                                                    // real time
                                                                    $akun = DB::table('users')
                                                                        ->where('email', $row->hse_nik)
                                                                        ->first();
                                                                    $real_time = DB::table('real_time_observasi')
                                                                        ->where('hseobs_id', $row->id_hseobs)
                                                                        ->where('user_id', $akun->id)
                                                                        ->get();
                                                                @endphp
                                                                <li class="list-group-item">
                                                                    <h6>Aktifitas Sedang Berjalan</h5>
                                                                        @foreach ($real_time as $pages)
                                                                            @if ($pages->status_real == 1)
                                                                                <div class="timeline timeline-one-side">
                                                                                    <div class="timeline-block mb-3">
                                                                                        <span class="timeline-step">
                                                                                            <i
                                                                                                class="fas fa-paper-plane text-warning text-gradient"></i>
                                                                                        </span>
                                                                                        <div class="timeline-content">
                                                                                            <h6
                                                                                                class="text-dark text-sm font-weight-bold mb-0">
                                                                                                {{ $pages->pesan_real_time }}
                                                                                            </h6>
                                                                                            <p
                                                                                                class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                                                                {{ date('d,F Y H:i:s', strtotime($pages->waktu_real_time)) }}
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @elseif($pages->status_real == 2)
                                                                                <div class="timeline timeline-one-side">
                                                                                    <div class="timeline-block mb-3">
                                                                                        <span class="timeline-step">
                                                                                            <i
                                                                                                class="fas fa-times text-danger text-gradient"></i>
                                                                                        </span>
                                                                                        <div class="timeline-content">
                                                                                            <h6
                                                                                                class="text-dark text-sm font-weight-bold mb-0">
                                                                                                {{ $pages->pesan_real_time }}
                                                                                            </h6>
                                                                                            <p
                                                                                                class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                                                                {{ date('d,F Y H:i:s', strtotime($pages->waktu_real_time)) }}
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @elseif($pages->status_real == 3)
                                                                                <div class="timeline timeline-one-side">
                                                                                    <div class="timeline-block mb-3">
                                                                                        <span class="timeline-step">
                                                                                            <i
                                                                                                class="fas fa-check text-info text-gradient"></i>
                                                                                        </span>
                                                                                        <div class="timeline-content">
                                                                                            <h6
                                                                                                class="text-dark text-sm font-weight-bold mb-0">
                                                                                                {{ $pages->pesan_real_time }}
                                                                                            </h6>
                                                                                            <p
                                                                                                class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                                                                {{ date('d,F Y H:i:s', strtotime($pages->waktu_real_time)) }}
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @elseif($pages->status_real == 4)
                                                                                <div class="timeline timeline-one-side">
                                                                                    <div class="timeline-block mb-3">
                                                                                        <span class="timeline-step">
                                                                                            <i
                                                                                                class="fas fa-sync-alt text-success text-gradient"></i>
                                                                                        </span>
                                                                                        <div class="timeline-content">
                                                                                            <h6
                                                                                                class="text-dark text-sm font-weight-bold mb-0">
                                                                                                {{ $pages->pesan_real_time }}
                                                                                            </h6>
                                                                                            <p
                                                                                                class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                                                                {{ date('d,F Y H:i:s', strtotime($pages->waktu_real_time)) }}
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @elseif($pages->status_real == 5)
                                                                                <div class="timeline timeline-one-side">
                                                                                    <div class="timeline-block mb-3">
                                                                                        <span class="timeline-step">
                                                                                            <i
                                                                                                class="fas fa-check-double text-primary text-gradient"></i>
                                                                                        </span>
                                                                                        <div class="timeline-content">
                                                                                            <h6
                                                                                                class="text-dark text-sm font-weight-bold mb-0">
                                                                                                {{ $pages->pesan_real_time }}
                                                                                            </h6>
                                                                                            <p
                                                                                                class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                                                                {{ date('d,F Y H:i:s', strtotime($pages->waktu_real_time)) }}
                                                                                            </p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            @elseif($pages->status_real == 6)
                                                                                <div class="timeline timeline-one-side">
                                                                                    <div class="timeline-block mb-3">
                                                                                        <span class="timeline-step">
                                                                                            <i
                                                                                                class="fas fa-times text-primary text-gradient"></i>
                                                                                        </span>
                                                                                        <div class="timeline-content">
                                                                                            <h6
                                                                                                class="text-dark text-sm font-weight-bold mb-0">
                                                                                                {{ $pages->pesan_real_time }}
                                                                                            </h6>
                                                                                            <p
                                                                                                class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                                                                {{ date('d,F Y H:i:s', strtotime($pages->waktu_real_time)) }}
                                                                                            </p>
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
                                            <a href="#" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#edit_data{{ $row->id_hseobs }}">
                                                <i class="fas fa-pen"></i>
                                            </a>
                                            <div class="modal fade" id="edit_data{{ $row->id_hseobs }}"
                                                tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Edit
                                                                Observasi</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ url('edit_observasi_pengawas' . '/' . $row->id_hseobs) }}"
                                                                method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="img_lama"
                                                                    value="{{ $row->img_hseobs }}">
                                                                <div class="form-group">
                                                                    <label for="nama" class="form-control-label">Nama
                                                                        Lengkap</label>
                                                                    <input
                                                                        class="form-control @error('nama')
                                                          is-invalid
                                                          @enderror"
                                                                        type="text" value="{{ $row->hse_name }}"
                                                                        id="nama" name="nama" required>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="kejadian" class="form-control-label">Lokasi
                                                                        Kejadian</label>
                                                                    <textarea
                                                                        class="form-control @error('kejadian')
                                                            is-invalid
                                                          @enderror"
                                                                        value="{{ old('kejadian') }}" id="kejadian"
                                                                        name="kejadian" required>{{ $row->location }}
                                                                      </textarea>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="observasi"
                                                                        class="form-control-label">Kondisi
                                                                        Observasi</label>
                                                                    <select
                                                                        class="form-control @error('observasi')
                                                              is-invalid
                                                            @enderror"
                                                                        id="observasi" name="observasi" required>
                                                                        <option value="Tindakan aman" @if ($row->kondisi_observasi == 'Tindakan aman')
                                                                            selected
                                @endif>Tindakan aman</option>
                                <option value="Tindakan tidak aman" @if ($row->kondisi_observasi == 'Tindakan tidak aman')
                                    selected
                                    @endif>Tindakan tidak aman</option>
                                <option value="Kondisi aman" @if ($row->kondisi_observasi == 'Kondisi aman')
                                    selected
                                    @endif>Kondisi aman</option>
                                <option value="Kondisi tidak aman" @if ($row->kondisi_observasi == 'Kondisi tidak aman')
                                    selected
                                    @endif>Kondisi tidak aman</option>
                                <option value="Nearmiss/nyaris celaka" @if ($row->kondisi_observasi == 'Nearmiss/nyaris celaka')
                                    selected
                                    @endif>Nearmiss/nyaris celaka</option>
                                <option value="Accident" @if ($row->kondisi_observasi == 'Accident')
                                    selected
                                    @endif>Accident</option>
                                </select>
                    </div>
                    <div class="form-group">
                        <label for="mulai" class="form-control-label">Mulai Kerja</label>
                        <input
                            class="form-control @error('mulai')
                    is-invalid
                  @enderror"
                            id="mulai" name="mulai" type="time" required value="{{ $row->mulai_kerja }}">
                    </div>
                    <div class="form-group">
                        <label for="selesai" class="form-control-label">Selesai Kerja</label>
                        <input
                            class="form-control @error('selesai')
                    is-invalid
                  @enderror"
                            id="selesai" name="selesai" required type="time" value="{{ $row->selesai_kerja }}">
                    </div>
                    <div class="form-group">
                        <label for="amati" class="form-control-label">Apa Yang Di Amati</label>
                        <textarea
                            class="form-control @error('amati')
                    is-invalid
                  @enderror"
                            value="{{ old('amati') }}" id="amati" name="amati" required
                            placeholder="Input Yang Di Amati (Contoh Memberikan Apresiasi Dan Coaching Agar Konsiten)">{!! $row->amati !!}
                              </textarea>
                    </div>
                    <div class="form-group">
                        <label for="terulang" class="form-control-label">Apa Yang Yang Harus Di Lakukan
                            Kejadian Serupa Tidak Terulang</label>
                        <textarea
                            class="form-control @error('terulang')
                    is-invalid
                  @enderror"
                            value="{{ old('terulang') }}" id="terulang" name="terulang" required
                            placeholder="Input Yang Perbaikan (Contoh Mengecek * Patroli Secara Konsisten)">{!! $row->terulang !!}
                              </textarea>
                    </div>
                    <div class="form-group">
                        <label for="img" class="form-control-label">Attach File</label>
                        <input type="file"
                            class="form-control @error('img')
                    is-invalid
                  @enderror"
                            id="img" name="img">
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="obsearvasi" class="form-control-label">Type Aktifitas Yang Di Amati</label>
                        <div class="form-check">
                            <input type="radio" id="dua" value="Berkendara dengan aman" name="type"
                                class="form-check-input" required @if ($row->type_activity == 'Berkendara dengan aman')
                            checked
                            @endif>
                            <label class="custom-control-label" for="dua">Berkendara dengan aman</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="tiga" name="type" value="Berhenti jika tidak aman"
                                class="form-check-input" required @if ($row->type_activity == 'Berhenti jika tidak aman')
                            checked
                            @endif>
                            <label class="custom-control-label" for="tiga">Berhenti jika tidak aman</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="empat" value="Sehat untuk bekerja" name="type" class="form-check-input"
                                required @if ($row->type_activity == 'Sehat untuk bekerja')
                            checked
                            @endif>
                            <label class="custom-control-label" for="empat">Sehat untuk bekerja</label>
                        </div>
                        <div class="form-check">
                            <input type="radio" id="lima" value="Ijin Kerja" name="type" class="form-check-input" required
                                @if ($row->type_activity == 'Ijin Kerja')
                            checked
                            @endif>
                            <label class="custom-control-label" for="lima">Ijin Kerja</label>
                        </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input type="radio" id="enam" value="Bekerja dengan bahan kimia" name="type"
                                        class="form-check-input" required @if ($row->type_activity == 'Bekerja dengan bahan kimia')
                                    checked
                                    @endif>
                                    <label class="custom-control-label" for="enam">Bekerja dengan bahan kimia</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="tuju" value="Bekerja di ketinggian" name="type"
                                        class="form-check-input" required @if ($row->type_activity == 'Bekerja di ketinggian')
                                    checked
                                    @endif>
                                    <label class="custom-control-label" for="tuju">Bekerja di ketinggian</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="sebelas" value="Alat pelindung diri" name="type"
                                        class="form-check-input" required @if ($row->type_activity == 'Alat pelindung diri')
                                    checked
                                    @endif>
                                    <label class="custom-control-label" for="sebelas">Alat pelindung diri</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="delapan" value="Posisi tubuh aman" name="type" class="form-check-input"
                                        required @if ($row->type_activity == 'Posisi tubuh aman')
                                    checked
                                    @endif>
                                    <label class="custom-control-label" for="delapan">Posisi tubuh aman</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="sembilan" value="Kebersihan area kerja" name="type"
                                        class="form-check-input" required @if ($row->type_activity == 'Kebersihan area kerja')
                                    checked
                                    @endif>
                                    <label class="custom-control-label" for="sembilan">Kebersihan area kerja</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" id="sepuluh" value="Bekerja diruang terbatas" name="type"
                                        class="form-check-input" required @if ($row->type_activity == 'Bekerja diruang terbatas')
                                    checked
                                    @endif>
                                    <label class="custom-control-label" for="sepuluh">Bekerja diruang terbatas</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
        </div>
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
                <h6>Teams Overview</h6>
            </div>
            <div class="card-body px-0 pt-0  pb-2">
                <div class="table-responsive p-4">
                    <table class="table align-items-center justify-content-center mb-0 diplay" id="myTable1"
                        style="width: 100%">
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
                                    Mulai Kerja</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Selesai Kerja</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Cabang</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Status</th>
                                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $urut = 1;
                            @endphp
                            @foreach ($area_observasi as $rowst)
                            @if ($rowst->hse_name != Auth::user()->name)
                            <tr>
                                <td>
                                    @php
                                        echo $urut++;
                                    @endphp
                                </td>
                                <td>
                                    <div class="d-flex px-2">
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm">
                                                {{ date('d/m/Y', strtotime($rowst->dibuat_hseobs)) }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2">
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm">{{ $rowst->hse_name }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2">
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm">{{ $rowst->hse_nik }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2">
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm">{{ $rowst->mulai_kerja }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2">
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm">{{ $rowst->selesai_kerja }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2">
                                        <div class="my-auto">
                                            <h6 class="mb-0 text-sm">{{ $rowst->cabang }}</h6>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex px-2">
                                        <div class="my-auto">
                                            @if ($rowst->conditions == null)
                                                <span class=" badge badge-pill bg-gradient-warning">Belum Di
                                                    Konfirmasi</span>
                                            @elseif ($rowst->conditions == 1)
                                                <span class=" badge badge-pill bg-gradient-danger">Di Tolak</span>
                                            @elseif($rowst->conditions == 2)
                                                <span class=" badge badge-pill bg-gradient-success">Di
                                                    Approve</span>
                                            @elseif($rowst->conditions == 3)
                                                <span class=" badge badge-pill bg-gradient-primary">Selesai</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="align-middle">
                                    <a href="#" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#detail{{ $rowst->id_hseobs }}">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ asset('assets/img' . '/' . $rowst->img_hseobs) }}" download=""
                                        class="btn btn-info">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <div class="modal fade" id="detail{{ $rowst->id_hseobs }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Detail
                                                        Observasi</h5>
                                                </div>
                                                <div class="modal-body d-block">
                                                    <ul class="list-group">
                                                        <li class="list-group-item">
                                                                Nama : {{ $rowst->hse_name }}
                                                        </li>
                                                        <li class="list-group-item">Nik : {{ $rowst->hse_nik }}
                                                        </li>
                                                        <li class="list-group-item">Lokasi Kejadian :
                                                            {{ $rowst->location }}</li>
                                                        <li class="list-group-item">Type Aktifitas Yang Di Amati :
                                                            {{ $rowst->type_activity }}</li>
                                                        <li class="list-group-item">Nama Area :
                                                            {{ $rowst->positions }}</li>
                                                        <li class="list-group-item">Kondisi Observasi :
                                                            {{ $rowst->kondisi_observasi }}</li>
                                                        <li class="list-group-item">Cabang : {{ $rowst->cabang }}
                                                        </li>
                                                        <li class="list-group-item">Mulai Kerja : {{ $rowst->mulai_kerja }}</li>
                                                        <li class="list-group-item">Selesai Kerja : {{ $rowst->selesai_kerja }}</li>
                                                        <li class="list-group-item">Apa Yang Di Amati : {{ $rowst->amati }}</li>
                                                        <li class="list-group-item">Apa Yang Yang Harus Di Lakukan Kejadian Serupa Tidak Terulang : {{ $rowst->terulang }}</li>
                                                        <li class="list-group-item">Gambar : 
                                                            <div style="width: 200px;height: 150px;">
                                                                <img src="{{ asset('assets/img' . '/' . $rowst->img_hseobs) }}" style="width: 100%;height: 100%;" alt="">
                                                            </div>
                                                        </li>
                                                        <li class="list-group-item">Status :
                                                            @if ($rowst->conditions == null)
                                                                <span class=" badge badge-pill bg-gradient-warning">Belum
                                                                    Di
                                                                    Konfirmasi</span>
                                                            @elseif ($rowst->conditions == 1)
                                                                <span class=" badge badge-pill bg-gradient-danger">Di
                                                                    Tolak</span>
                                                            @elseif($rowst->conditions == 2)
                                                                <span class=" badge badge-pill bg-gradient-success">Di
                                                                    Approve</span>
                                                            @elseif($rowst->conditions == 3)
                                                                <span
                                                                    class=" badge badge-pill bg-gradient-primary">Selesai</span>
                                                            @endif
                                                        </li>
                                                        @php
                                                            // real time
                                                            $akun = DB::table('users')
                                                                ->where('email', $rowst->hse_nik)
                                                                ->first();
                                                            $real_time = DB::table('real_time_observasi')
                                                                ->where('hseobs_id', $rowst->id_hseobs)
                                                                ->where('user_id', $akun->id)
                                                                ->get();
                                                        @endphp
                                                        <li class="list-group-item">
                                                            <h6>Aktifitas Sedang Berjalan</h5>
                                                                @foreach ($real_time as $pages)
                                                                    @if ($pages->status_real == 1)
                                                                        <div class="timeline timeline-one-side">
                                                                            <div class="timeline-block mb-3">
                                                                                <span class="timeline-step">
                                                                                    <i
                                                                                        class="fas fa-paper-plane text-warning text-gradient"></i>
                                                                                </span>
                                                                                <div class="timeline-content">
                                                                                    <h6
                                                                                        class="text-dark text-sm font-weight-bold mb-0">
                                                                                        {{ $pages->pesan_real_time }}
                                                                                    </h6>
                                                                                    <p
                                                                                        class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                                                        {{ date('d,F Y H:i:s', strtotime($pages->waktu_real_time)) }}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @elseif($pages->status_real == 2)
                                                                        <div class="timeline timeline-one-side">
                                                                            <div class="timeline-block mb-3">
                                                                                <span class="timeline-step">
                                                                                    <i
                                                                                        class="fas fa-times text-danger text-gradient"></i>
                                                                                </span>
                                                                                <div class="timeline-content">
                                                                                    <h6
                                                                                        class="text-dark text-sm font-weight-bold mb-0">
                                                                                        {{ $pages->pesan_real_time }}
                                                                                    </h6>
                                                                                    <p
                                                                                        class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                                                        {{ date('d,F Y H:i:s', strtotime($pages->waktu_real_time)) }}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @elseif($pages->status_real == 3)
                                                                        <div class="timeline timeline-one-side">
                                                                            <div class="timeline-block mb-3">
                                                                                <span class="timeline-step">
                                                                                    <i
                                                                                        class="fas fa-check text-info text-gradient"></i>
                                                                                </span>
                                                                                <div class="timeline-content">
                                                                                    <h6
                                                                                        class="text-dark text-sm font-weight-bold mb-0">
                                                                                        {{ $pages->pesan_real_time }}
                                                                                    </h6>
                                                                                    <p
                                                                                        class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                                                        {{ date('d,F Y H:i:s', strtotime($pages->waktu_real_time)) }}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @elseif($pages->status_real == 4)
                                                                        <div class="timeline timeline-one-side">
                                                                            <div class="timeline-block mb-3">
                                                                                <span class="timeline-step">
                                                                                    <i
                                                                                        class="fas fa-sync-alt text-success text-gradient"></i>
                                                                                </span>
                                                                                <div class="timeline-content">
                                                                                    <h6
                                                                                        class="text-dark text-sm font-weight-bold mb-0">
                                                                                        {{ $pages->pesan_real_time }}
                                                                                    </h6>
                                                                                    <p
                                                                                        class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                                                        {{ date('d,F Y H:i:s', strtotime($pages->waktu_real_time)) }}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @elseif($pages->status_real == 5)
                                                                        <div class="timeline timeline-one-side">
                                                                            <div class="timeline-block mb-3">
                                                                                <span class="timeline-step">
                                                                                    <i
                                                                                        class="fas fa-check-double text-primary text-gradient"></i>
                                                                                </span>
                                                                                <div class="timeline-content">
                                                                                    <h6
                                                                                        class="text-dark text-sm font-weight-bold mb-0">
                                                                                        {{ $pages->pesan_real_time }}
                                                                                    </h6>
                                                                                    <p
                                                                                        class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                                                        {{ date('d,F Y H:i:s', strtotime($pages->waktu_real_time)) }}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @elseif($pages->status_real == 6)
                                                                        <div class="timeline timeline-one-side">
                                                                            <div class="timeline-block mb-3">
                                                                                <span class="timeline-step">
                                                                                    <i
                                                                                        class="fas fa-times text-primary text-gradient"></i>
                                                                                </span>
                                                                                <div class="timeline-content">
                                                                                    <h6
                                                                                        class="text-dark text-sm font-weight-bold mb-0">
                                                                                        {{ $pages->pesan_real_time }}
                                                                                    </h6>
                                                                                    <p
                                                                                        class="text-secondary font-weight-bold text-xs mt-1 mb-0">
                                                                                        {{ date('d,F Y H:i:s', strtotime($pages->waktu_real_time)) }}
                                                                                    </p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                        </li>
                                                        <li class="list-group-item">Corretive User Mananger :
                                                            @if ($rowst->coretive == null)
                                                                Belum Di Isi
                                                            @else
                                                                <p>{{ $rowst->coretive }}</p>
                                                            @endif
                                                        </li>
                                                        <li class="list-group-item">Corretive User Hse Audit :
                                                            @if ($rowst->approve_hse_audit == null)
                                                                Belum Di Isi
                                                            @else
                                                                <p>{{ $rowst->approve_hse_audit }}</p>
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
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <footer class="footer pt-3  ">
            <div class="container-fluid">
                <div class="copyright text-center text-sm text-muted text-lg-start">
                    <h6 class="text-center">Copyright &copy; {{ $profile->nama . ' ' . date('Y') }}</h6>
                </div>
            </div>
        </footer>
        </div>
    </main>
@endsection
