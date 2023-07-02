@extends('layouts.presensi')
@section('header')
<link rel="stylesheet" href="../assets/css/style.css">
<div class="appHeader bg-primary text-light mb-5" >
    <div class="left">
        <a href="/dashboard" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Edit Profil</div>
    <div class="right"></div>
</div>
<div class="" style="margin-bottom : 60px"></div>
@endsection
@section('content')
<div class="row">
    <div class="col">
        @php
         $pesanBerhasil = $request->session()->get('success');   
         $pesanGagal = $request->session()->get('error');   
        @endphp
        @if ($request->session()->get('success'))
        <div class="alert alert-success">
            {{ $pesanBerhasil }}
        </div>
        @endif
        @if ($request->session()->get('error'))
        <div class="alert alert-danger">
            {{ $pesanGagal }}
        </div>
        @endif
    </div>
</div>

<form action="/presensi/{{ $karyawan->nik }}/edit" method="POST" enctype="multipart/form-data">
  @csrf
  <div class="col">
        <div class="custom-file-upload border  border-5 bg-white my-1" id="fileUpload1" style="height: 35vw !important">
            <input type="file" name="foto" id="fileuploadInput" value="" accept=".png, .jpg, .jpeg">
            <label for="fileuploadInput">
                <span>
                    <strong>
                        <ion-icon name="cloud-upload-outline" role="img" class="md hydrated" aria-label="cloud upload outline"></ion-icon>
                        <i>Tekan disini untuk upload foto profil</i>
                    </strong>
                </span>
            </label>
        </div>
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
              <input type="password" class="form-control" value="" name="password" placeholder="Password" autocomplete="off">
          </div>
      </div>
  
      <div class="form-group boxed mb-1 d-flex" >
        <a href="/presensi/verif" class="btn bg-white text-secondary border border-4 btn-block m">
        Verifikasi wajah 
        </a>
      </div>
      
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