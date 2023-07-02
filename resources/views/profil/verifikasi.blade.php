@extends('layouts.presensi')
@section('header')
<link rel="stylesheet" href="../assets/css/style.css">
<div class="appHeader bg-primary text-light mb-5" >
    <div class="left">
        <a href="/presensi/edit" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    @if ($verif > 0)
        
    <div class="pageTitle">Verifikasi Wajah kedua</div>
    @else
    <div class="pageTitle">Verifikasi Wajah pertama</div>
        
    @endif
    <div class="right"></div>
</div>
<div class="" style="margin-bottom : 60px"></div>
@endsection
@section('content')
<div class="row">
    <div class="col">
        <video id="videoElement" autoplay></video>
    </div>
</div>
<div class="row">
    <button type="submit" id="ambil" data-toggle="modal" class="btn btn-primary btn-block m-2">Ambil Wajah</button>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    const videoElement = document.getElementById('videoElement');
    navigator.mediaDevices.getUserMedia({ video: true })
    .then(function(stream) {
        // Memasang stream video ke elemen video
        videoElement.srcObject = stream;
    })
    .catch(function(error) {
        console.error('Error accessing camera:', error);
    });
    $('#ambil').click(function(){

        // Membuat elemen canvas untuk menggambar gambar
        const canvas = document.createElement('canvas');
        const context = canvas.getContext('2d');
        // Mengatur ukuran canvas sesuai dengan ukuran video
        canvas.width = videoElement.videoWidth;
        canvas.height = videoElement.videoHeight;
        // Menggambar gambar dari elemen video ke canvas
        context.drawImage(videoElement, 0, 0, canvas.width, canvas.height);
        // Mendapatkan data gambar dalam bentuk base64
        const imageDataURL = canvas.toDataURL('image/jpeg');
        // Menyimpan data gambar ke dalam variabel
        const image = imageDataURL;
        // Menampilkan data gambar yang telah disimpan ke dalam variabel
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let nik = '{{ $nik }}';

        $.ajax({
            type: 'POST',
            url: '/presensi/prosesVerif',
            data: {
                _token : csrfToken,
                image:image,
                nik:nik
            }, 
            cache:false,
            success: function(respond){
                console.log(respond);
                var pesan = respond.pesan;
                if (pesan == '1'){
                    Swal.fire({
                    icon: 'success',
                    title: 'Berhasil verif wajah',
                    text: 'Anda telah Melakukan verifikasi wajah pertama',
                    // imageUrl: '../'+gambar+'',
                    // imageWidth: 400,
                    // imageHeight: 250,
                    // imageAlt: 'data Absen',
                    
                    })
                    setTimeout("location.href='/presensi/verif'",3000);

                }else{
                    Swal.fire({
                    icon: 'error',
                    title: 'anda gagal verif',
                    text: 'Anda gagal verifikasi wajah'})
                }

            }
        })

    })
</script>


<style>
     #videoElement{
    display: inline-block;
    width: 100% !important;
    margin: auto;
    height: auto !important;
    border-radius: 15px;
    
     
  }
</style>
@endsection