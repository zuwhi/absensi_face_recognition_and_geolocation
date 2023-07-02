@extends('layouts.presensi')
@section('header')
<link rel="stylesheet" href="../assets/css/style.css">
<div class="appHeader bg-primary text-light mb-5" >
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Riwayat absensi</div>
    <div class="right"></div>
</div>
<div class="" style="margin-bottom : 70px"></div>
@endsection
@section('content')
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <select name="bulan" id="bulan"  class="form-control">
                @for ($i = 1; $i <= 12; $i++)
                <option value="{{ $i }}"{{ date("m") == $i ? 'selected' : '' }}>{{ $daftarBulan[$i] }}</option>
                @endfor

            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <select name="tahun" id="tahun" class="form-control">
                @php
                    $tahunmulai = 2022;
                    $tahunsekarang = date("Y");
                @endphp
                @for ($tahun = $tahunmulai; $tahun <= $tahunsekarang; $tahun++)

                <option value="{{ $tahun }}" {{ $tahun==$tahunsekarang ? 'selected' : '' }}>{{ $tahun }}</option>
                    
                @endfor
                
            </select>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group">
          <button class="btn btn-primary btn-block" id="cari" type="submit">Cek riawayat</button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="" id="tampilRiwayat"></div>
    </div>
</div>





@endsection

@push('myscript')
<script>
    $(function(){

        $('#cari').click(function(e){
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            var bulan = $('#bulan').val()
            var tahun = $('#tahun').val()
            $.ajax({
                type : 'POST',
                url : '/getRiwayat',
                data : {
                    _token : csrfToken,
                    bulan : bulan,
                    tahun : tahun
                },
                cache: false,
                success : function(respon){

                    $('#tampilRiwayat').html(respon);
                    

                }
            })
        });
    });
</script>
    
@endpush

