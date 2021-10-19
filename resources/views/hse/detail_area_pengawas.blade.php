@extends('layouts.aplikasi')

@section('content')
<main class="main-content position-relative max-height-vh-100 h-100 mt-1 border-radius-lg ">
  <!-- Navbar -->
  <nav class="navbar navbar-main navbar-expand-lg bg-gradient-danger px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
    <div class="container-fluid py-1 px-3">
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
          <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Manager</a></li>
          <li class="breadcrumb-item text-sm text-dark active text-white" aria-current="page">Detail Area Pengawas</li>
        </ol>
        <h6 class="font-weight-bolder mb-0 text-white">Detail Area Pengawas</h6>
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
        <a href="{{ url('area') }}" class="btn btn-warning">Kembali</a>
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
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">No</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nama</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nik</th>
                <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Action</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($area_pengawas as $row)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                  <div class="d-flex px-2">
                    <div class="my-auto">
                      <h6 class="mb-0 text-sm">{{ $row->name }}</h6>
                    </div>
                  </div>
                </td>
                <td>
                  <div class="d-flex px-2">
                    <div class="my-auto">
                      <h6 class="mb-0 text-sm">{{ $row->email }}</h6>
                    </div>
                  </div>
                </td>
                <td class="align-middle">
                  <a href="{{ url('detail_pengawas_observasi_hse' . '/' . $row->id . '/' . $id) }}" class="btn btn-success">
                    <i class="fas fa-eye"></i>
                  </a>
                </td>
              </tr>
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