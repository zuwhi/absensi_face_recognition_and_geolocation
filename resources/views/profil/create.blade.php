@extends('layouts.presensi')
@section('content')



<form method="post" action="/profil/" >
    @csrf
      <div class="form-group mb-2">
        <label for="title">Masukkan NIK:</label>
        <input type="text" name="nik" class="form-control mt-2" id="title" value=""  placeholder="masukan judul" required autofocus>
      </div>
      <div class="form-group mb-2">
        <label for="title">Masukan Nama Lengkap :</label>
        <input type="text" name="nama_lengkap" class="form-control mt-2" id="title" value=""  placeholder="..." required autofocus>
      </div>
      <div class="form-group mb-2">
        <label for="title">Masukan Jabatan:</label>
        <input type="text" name="jabatan" class="form-control mt-2" id="title" value=""  placeholder="..." required autofocus>
      </div>
      <div class="form-group mb-2">
        <label for="title">Masukan telepon:</label>
        <input type="number" name="telepon" class="form-control mt-2" id="title" value=""  placeholder="..." required autofocus>
      </div>
      <div class="form-group mb-2">
        <label for="title">Masukan Password:</label>
        <input type="password" name="password" class="form-control mt-2" id="title" value=""  placeholder="..." required autofocus>
      </div>

      <button type="submit" class="btn btn-primary">Create Post</button>

</form>

@endsection