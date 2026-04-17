<!DOCTYPE html>
<html>

<head>
    <title>Data Profil Mahasiswa</title>
</head>

<body>
@extends('layouts.main')
@section('content')
    <h1>Daftar Profil Mahasiswa</h1>

    <table border="1" cellpadding="10">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Program Studi</th>
            <th>Aksi</th>
        </tr>

        @foreach ($mahasiswa as $mhs)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $mhs['nama'] }}</td>
            <td>{{ $mhs['nim'] }}</td>
            <td>{{ $mhs['program_studi'] }}</td>
            <td>
                <a href="/profil/{{ $mhs['nim'] }}">Detail</a>
            </td>
        </tr>
        @endforeach

    </table>
@endsection
</body>

</html>
