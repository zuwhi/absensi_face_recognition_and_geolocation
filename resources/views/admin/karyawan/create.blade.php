@extends('admin.layout')

@section('content')

  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Data</h1>
  </div>

  <div class="col-lg-8">

  <form method="post" action="/admin/karyawan/store" enctype="multipart/form-data">
    @csrf
      <div class="form-group mb-2">
        <label for="nik">Masukan nik :</label>
        <input type="text" name="nik" class="form-control mt-2" id="nik" value="{{ old('nik') }}"  placeholder="masukan nik" required autofocus>
      </div>
      <div class="form-group mb-2">
        <label for="nama">Masukan nama :</label>
        <input type="text" name="nama_lengkap" class="form-control mt-2" id="nama" value="{{ old('nama_lengkap') }}"  placeholder="masukan nama" required autofocus>
      </div>
      <div class="form-group mb-2">
        <label for="telepon">telepon :</label>
        <input type="number" name="telepon" class="form-control mt-2" id="telepon"  value="{{ old('telepon') }}" placeholder="masukan No Telepon">
      </div>
      <div class="form-group mb-2">
        <label for="password">password :</label>
        <input type="password" name="password" class="form-control mt-2" id="password"  value="{{ old('password') }}" placeholder="masukan No password">
      </div>

      <div class="form-group mb-2">
        <label for="select">jabatan :</label>
        <select class="form-select" aria-label="Default select example" name="jabatan_id">
          @foreach ($jabatan as $jb)
          @if (old('jabatan_id') == $jb->id)
          <option value="{{ $jb->id }}" selected>{{ $jb->nama_jabatan }}</option>
          @else
          <option value="{{ $jb->id }}" >{{ $jb->nama_jabatan }}</option>
          @endif
          @endforeach
        </select>
      </div>
     
      {{-- <div class="form-group mb-2">
        <label for="image" class="form-label">Masukan gambar :</label>
        <img  class="img-preview img-fluid col-sm-5">
        <input onchange="previewImage()" class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image">
      </div>
      @error('image')
      <div class="invalid-feedback">
        {{ $message }}
      </div>
      @enderror --}}

      {{-- <div class="form-group mb-2">
        <label for="select">jabatan :</label>
        <select class="form-select" aria-label="Default select example" name="jabatan_id">
          @foreach ($jabatans as $jabatan)
          @if (old('jabatan_id') == $jabatan->id)
          <option value="{{ $jabatan->id }}" selected>{{ $jabatan->nama_jabatan }}</option>
          @else
          <option value="{{ $jabatan->id }}" >{{ $jabatan->nama_jabatan }}</option>
          @endif
          @endforeach
        </select>
      </div> --}}

      <button type="submit" class="btn btn-primary">Create Post</button>
    </form>
</div>



<script>
    function previewImage(){
      const img = document.querySelector('#img')
      const imgPreview = document.querySelector('.img-preview')
      
      imgPreview.style.display = 'block';

      const OFReader = new FileReader();
      OFReader.readAsDataURL(image.files[0]);

      OFReader.onload = function(OFREvent){
        imgPreview.src = OFREvent.target.result;
      }
    }
    
</script>
@endsection