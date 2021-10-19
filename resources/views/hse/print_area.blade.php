<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<body>
  @if ($type == "CFS")
  <h1>CFS</h1>
  @else
  <h1>SFS</h1>
  @endif
  <table border="2" style="border: 1px solid black">
    <thead>
      <tr>
        <td style="width: 15px">No</td>
        <td style="width: 25px">Nama Area</td>
        <td style="width: 15px">Submitting</td>
        <td style="width: 25px">Jumlah Pengawas</td>
        <td style="width: 15px">Presentasi</td>
        <td style="width: 15px">Rank</td>
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $row)
      <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $row->nama_area }}</td>
        <td>{{ $row->submitting }}</td>
        <td>{{ $row->jml_pengawas }} Orang</td>
        <td>{{ $row->presentase }} %</td>
        <td>{{ $loop->iteration }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>