@extends('admin.layout')
@section('content')
<h1 class="pt-3">Karyawan</h1>
<hr class="border border-dark border-2 opacity-50 me-2">

</div>
@if(session()->has('success'))
<div class="alert alert-success col-sm-3" role="alert">
  {{ session('success') }}
</div>
@endif

<div class="row">
<div class="col-lg-9">
  <div class="tabel">
    <div class="row">
    <div class="col-sm-6"><a href="/admin/karyawan/create" class="mb-2 btn btn-success">Tambah Data</a>
    </div>
    <div class="col-sm-6  ps-5 me-auto">
      <form action="/admin/karyawan" method="get">
        <div class="input-group mb-3">
          <input type="text" class="form-control" placeholder="Search" name="search" value="{{ request('search') }}">
          <div class="input-group-append">
            <button class="btn btn-primary" type="submit">search</button>
          </div>
        </div>
      </form>
    </div>
  </div>
    <table class="table mx-auto">
      <thead class="table-light">
        <tr>
          <th scope="col">No</th>
          <th scope="col">Nik</th>
          <th scope="col">Nama Karyawan</th>
          <th scope="col">jabatan</th>
          <th scope="col">Telepon</th>
          <th scope="col">Perintah</th>
        </tr>
      </thead>
      <tbody>
          @foreach ($karyawan as $nomer => $item)

        <tr>
          <th scope="row">{{ $nomer +1 }}</th>
          <td>{{ $item->nik }}</td>
          <td>{{ $item->nama_lengkap }}</td>
          <td>{{ $item->jabatan->nama_jabatan }}</td>
          <td>{{ $item->telepon }}</td>
          <td>
              <a href="/admin/karyawan/{{ $item->nik }}" class="btn btn-primary text-decoration-none"> <img width="30px" src="https://img.icons8.com/fluency/48/null/view-details--v1.png"/></a>
             <!-- Button trigger modal -->
             <button class="btn btn-primary edit-btn" id="tombolEdit" data-nama='{{ $item->nama_lengkap }}' data-jabatan="{{$item->jabatan_id}}" data-telepon="{{ $item->telepon }}" data-nik="{{ $item->nik }}" data-password="{{ $item->password }}" >Edit</button>


              <form action="/admin/karyawan/{{ $item->nik }}" method="post" class="d-inline">
                @method('delete')
                @csrf
                <button type="submit" class="border-0 badge bg-danger p-2" onclick="return confirm('anda yakin ingin menghapus?')">              <img width="30px" src="https://img.icons8.com/fluency/48/null/filled-trash.png"/>
                </button>
                </form>
              {{-- <a href="/home/{{ $item->nik }}" class="btn btn-danger text-decoration-none">
                  <img width="30px" src="https://img.icons8.com/fluency/48/null/filled-trash.png"/>
              </a> --}}
          </td>
        </tr>
        @endforeach
      
      </tbody>
    </table>
  </div>
</div>

<div class="col-lg-3">
  <div class="cek">
    {{-- <table class="table">
      <thead class="table-light">
        <tr>
          <th scope="col">No</th>
          <th scope="col">Daftar Jabatan</th>
        </tr>
      </thead>
      <tbody>
        @foreach($jabatans as $jabatan)
        <tr>
          <td>{{ $jabatan->nik }}</td>
          <td><input type="text" class="form-control " name="jabatan" id="" value="{{ $jabatan->nama_jabatan }}"></td>
          <td><p>{{ $jabatan->nama_jabatan }}</p></td>
        </tr>
      @endforeach
      <tr id="extra"></tr>
    </tbody>
    </table> --}}
    <div class="row">

      <div class="col-sm-9 tambah"><button type="submit" class="btn btn-primary">Tambah</button></div>
      <div class="col-sm-3 ms-auto"><button type="submit" class="btn btn-success">simpan</button></div>

    </div>
  </div>
</div>
</div>



<!-- Modal -->
<div class="modal fade"  id="modalEdit" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true" aria-labelledby="editModalLabel"
>
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('update') }}" method="POST">
        @csrf
      <div class="modal-body">
        <div class="form-group">
            <label for="nik">nik</label>
            <input type="text" class="form-control" id="nik" name="nik" required readonly>
        </div>
        <div class="form-group">
            <label for="nama_lengkap">nama_lengkap</label>
            <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" required>
        </div>
        <div class="form-group mb-2">
          <label for="select">jabatan :</label>
          <select class="form-select" id="jabatan" aria-label="Default select example" name="jabatan_id">
            @foreach ($jabatan as $jb)          
            @if (old('jabatan_id') == $jb->id)
            <option value="{{ $jb->id }}" id="jabatan" selected>{{ $jb->nama_jabatan }}</option>
            @else
            <option value="{{ $jb->id }}" >{{ $jb->nama_jabatan }}</option>
            @endif
            @endforeach
          </select>
        </div>
        <div class="form-group">
            <label for="telepon">telepon</label>
            <input type="text" class="form-control" id="telepon" name="telepon" required>
        </div>
        <div class="form-group">
            <label for="password">password</label>
            <input type="password" class="form-control" placeholder="****" name="password" >
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">edit</button>
      </div>
    </form>
    </div>
  </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
  $(document).ready(function() {
    $(document).on('click', '#tombolEdit', function() {

        var nik = $(this).data('nik');
        var nama_lengkap = $(this).data('nama');
        var jabatan = $(this).data('jabatan');
        var telepon = $(this).data('telepon');
        var password = $(this).data('password');

        $('#modalEdit').modal('show');
        $('#nik').val(nik);
        $('#nama_lengkap').val(nama_lengkap);
        $('#jabatan').val(jabatan);
        $('#telepon').val(telepon);
        $('#password').val(password);
    })


  })

</script>
<style>
  .tabel{
    background-color: #fff;
    padding: 20px;
    border-radius: 20px;
  }
  table{
    border: 1px solid black;
    border-radius: 10px;
  }
  .cek{
    padding-top: 50px;
    background-color: #fff;
    padding: 20px;
    border-radius: 20px;}
    input{
      border: none
    }
</style>
@endsection
   