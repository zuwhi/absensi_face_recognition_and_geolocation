@extends('layouts.presensi')
@section('content')

<form action="/profil/{{ $karyawan->nik }}" method="POST" enctype="multipart/form-data">
  @method('put')
  @csrf
  <div class="col">
      {{-- <div class="form-group boxed">
          <div class="input-wrapper">
              <input type="text" class="form-control" value="{{ $karyawan->nik }}"  name="nik" placeholder="Nama Lengkap" autocomplete="off">
          </div>
      </div> --}}
      <div class="form-group boxed">
          <div class="input-wrapper">
              <input type="text" class="form-control" value="{{ $karyawan->nama_lengkap }}"  name="nama_lengkap" placeholder="Nama Lengkap" autocomplete="off">
          </div>
      </div>
      <div class="form-group boxed">
          <div class="input-wrapper">
              <input type="text" class="form-control" value="{{ $karyawan->telepon}}"  name="telepon" placeholder="No. HP" autocomplete="off">
          </div>
      </div>
      <div class="form-group boxed">
          <div class="input-wrapper">
              <input type="password" class="form-control" value="{{ $karyawan->password}}" name="password" placeholder="Password" autocomplete="off">
          </div>
      </div>
      {{-- <div class="custom-file-upload" id="fileUpload1">
          <input type="file" name="foto" id="fileuploadInput" accept=".png, .jpg, .jpeg">
          <label for="fileuploadInput">
              <span>
                  <strong>
                      <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                      <i>Tap to Upload</i>
                  </strong>
              </span>
          </label>
      </div> --}}
      <div class="form-group boxed">
          <div class="input-wrapper">
              <button type="submit" class="btn btn-primary btn-block">
                  <ion-icon name="refresh-outline"></ion-icon>
                  Update
              </button>
          </div>
      </div>
  </div>
</form>





@endsection