@extends('layouts.presensi')
@section('header')
<link rel="stylesheet" href="../assets/css/style.css">
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">Presensi</div>
    <div class="right"></div>
</div>
@endsection
@section('content')

@if ($cekOut > 0)
<script>
  document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'MAAF',
        text: 'Anda Telah Absen Pada Hari Ini!',
        icon: 'warning',
        timer: 4000,
        timerProgressBar: true,
        showConfirmButton: false
    });
});

  setTimeout("location.href='/dashboard'",4000);
</script>
@else


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="crossorigin=""/>
<div class="row" style="margin-top: 70px">
    <div class="col">
      <video id="videoElement" autoplay></video>
      <input type="hidden" name="lokasi" id="lokasi">
    </div>
</div>
<div class="row">
  @if ($cek > 0)
  <button type="submit" id="ambil" data-toggle="modal" class="btn btn-warning btn-block m-2">Absen Pulang</button>
  @else
  <button type="submit" id="ambil" data-toggle="modal" class="btn btn-primary btn-block m-2">Absen Masuk</button>
  @endif
</div>
<div class="row">
  <div class="col">
    <div id="map"></div>
  </div>
</div>





<style>
  #map { height: 250px; }
  #peta { height: 200px; }
  #videoElement{
    display: inline-block;
    width: 100% !important;
    margin: auto;
    height: auto !important;
    border-radius: 15px;
    
     
  }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js" integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
crossorigin=""></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>

// ==================== LOKASI ===================

var lokasi = document.getElementById('lokasi');
var options = {
    enableHighAccuracy: true
  };
if (navigator.geolocation) {
  // Mendapatkan lokasi terakhir pengguna
  navigator.geolocation.watchPosition(showPosition,showError, options);
} else {
  alert('lokasi tidak ditemukan')
}

function showPosition(position) {
  var longitude = position.coords.longitude;
  var latitude = position.coords.latitude;
  lokasi.value = latitude+','+longitude;
  var map = L.map('map').setView([latitude,longitude], 17);
  L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
var marker = L.marker([latitude,longitude]).addTo(map);
var circle = L.circle([-6.61600216950022,110.69242794969078], {
    color: 'green',
    fillColor: 'green',
    fillOpacity: 0.3,
    radius: 100
}).addTo(map);
  
  // Lakukan sesuatu dengan koordinat latitude dan longitude di sini
}

function showError(error) {
  switch (error.code) {
    case error.PERMISSION_DENIED:
        Swal.fire({
        icon: 'warning',
        title: 'INVALID GPS',
        text: 'GPS kamu belum kamu aktifkan njir !' })
        setTimeout("location.href='/dashboard'",3000); 
      break;
    case error.POSITION_UNAVAILABLE:
      
      console.log("Informasi lokasi tidak tersedia.");
      break;
    case error.TIMEOUT:
      console.log("Waktu permintaan geolokasi habis.");
      break;
    case error.UNKNOWN_ERROR:
      console.log("Terjadi kesalahan yang tidak diketahui.");
      break;
  }
}

// ========================= KAMERA ===========================
const videoElement = document.getElementById('videoElement');

navigator.mediaDevices.getUserMedia({ video: true })
  .then(function(stream) {
    // Memasang stream video ke elemen video
    videoElement.srcObject = stream;
  })
  .catch(function(error) {
    console.error('Error accessing camera:', error);
  });
  $('#ambil').click(function(e){

    var lokasi = $('#lokasi').val()
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

    $.ajax({
      type: 'POST',
      url: '/presensi/store',
      data: {
        _token : csrfToken,
        image:image,
        lokasi:lokasi,
      }, 
      cache:false,
      success: function(respond){
       console.log(respond.message);
       
       if(respond.message == 'invalid_jarak'){
        Swal.fire({
        icon: 'error',
        title: 'Invalid Radius',
        text: 'Anda tidak berada dalam radius Kantor!'})

       }else{
        gambar = respond.data['image'];
       if(respond.message == 'masuk'){
        Swal.fire({
          title: 'Berhasil Absen Masuk!',
          text: 'Anda telah Melakukan absen Masuk',
          imageUrl: '../'+gambar+'',
          imageWidth: 400,
          imageHeight: 250,
          imageAlt: 'data Absen',
        })
        setTimeout("location.href='/dashboard'",3000);

       }else{
        
        Swal.fire({
          title: 'Berhasil Absen pulang!',
          text: 'Anda telah Melakukan absen pulang',
          imageUrl: '../'+gambar+'',
          imageWidth: 400,
          imageHeight: 250,
          imageAlt: 'data Absen',
        })
        setTimeout("location.href='/dashboard'",3000);
      }
   
    
      }
    }
    })


    
  })

</script>
@endif
@endsection
