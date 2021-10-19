<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Observasi</title>
</head>
<body>
  <h1>OBSERVASI</h1>
  <table border="2" style="border: 1px solid black">
    <thead>
      <tr>
        <td style="width: 15px">No</td>
        <td style="width: 15px">DATE</td>
        <td style="width: 15px">BULAN</td>
        <td style="width: 15px">DEVISI SERVICE</td>
        <td style="width: 20px">NAMA LENGKAP OBSERVER</td>
        <td style="width: 15px">NIK</td>
        <td style="width: 20px">CABANG</td>
        <td style="width: 20px">NAMA AREA CFS</td>
        <td style="width: 20px">NAMA AREA SFS</td>
        <td style="width: 25px">lOKASI KEJADIAN</td>
        <td style="width: 20px;">EMAIL</td>
        <td style="width: 35px">KONDISI</td>
        <td style="width: 35px">TIPE AKTIVITAS YANG DIAMATI</td>
        <td style="width: 35px">APA KEJADIAN YANG DIAMATI (AMAN/TIDAK AMAN/LAIN)</td>
        <td style="width: 35px">TINDAKAN PERBAIKAN YANG DILAKUKAN</td>
        <td style="width: 80px">APA YANG HARUS DI LAKUKAN AGAR KEJADIAN SERUPA TIDAK TERULANG</td>
        <td style="width: 80px">BUKTI KONDISI</td>
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $row)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->dibuat_hseobs }}</td>
        <td>{{ date('F',strtotime($row->dibuat_hseobs)) }}</td>
        <td>
          @php
            $posisi = DB::table('positions')->where('id_positions',$row->event)->first();
          @endphp
          @if ($posisi->type == "SFS")
            SECURITY FS
          @else
            CLEANING FS
          @endif
        </td>
        <td>{{ $row->hse_name }}</td>
        <td>{{ $row->hse_nik }}</td>
        <td>{{ $row->cabang }}</td>
        <td>
          @if ($posisi->type == "CFS")
            {{ $posisi->positions }}
          @endif
        </td>
        <td>
          @if ($posisi->type == "SFS")
            {{ $posisi->positions }}
          @endif
        </td>
        <td>{{ $row->location }}</td>
        @php
          $users = DB::table('users')->where('email',$row->hse_nik)->first();
        @endphp
        <td>{{ $users->email_address_id }}</td>
        <td>{{ $row->kondisi_observasi }}</td>
        <td>{{ $row->type_activity }}</td>
        <td>{{ $row->amati }}</td>
        <td>{{ $row->perbaikan }}</td>
        <td>{{ $row->terulang }}</td>
        <td>asset/img/{{ $row->img_hseobs }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>