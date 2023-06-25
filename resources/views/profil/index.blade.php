@extends('layouts.presensi')
@section('content')

<div class="row">
    <div class="col-sm-8">
        <a href="/profil/create" class="btn btn-success">tambah</a>
        <table class="table">
            <thead>
              <tr>
                <th scope="col">No</th>
                <th scope="col">Nik</th>
                <th scope="col">Nama Lengkap</th>
                <th scope="col">Jabatan</th>
                <th scope="col">Telepon</th>
                <th scope="col">Perintah</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">1</th>
                <td>{{ $karyawan->nik }}</td>
                <td>{{ $karyawan->nama_lengkap }}</td>
                <td>{{ $karyawan->jabatan }}</td>
                <td>{{ $karyawan->telepon }}</td>
                <td><a href="/profil/{{ $karyawan->nik }}/edit" class="btn btn-warning">edit</a> | 
                    <form action="/profil{{ $karyawan->nik }}" method="post" class="d-inline">
                        @method('delete')
                        @csrf
                        <button type="submit" class="border-0 badge bg-danger p-2" onclick="return confirm('anda yakin ingin menghapus?')"> Hapus
                        </button>
                    </form>
                
                </td>
                
              </tr>
            </tbody>
          </table>
    </div>
</div>

@endsection