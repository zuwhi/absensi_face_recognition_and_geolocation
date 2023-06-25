@extends('layouts.presensi')
@section('header')

<link rel="stylesheet" href="../assets/css/style.css">
<div class="appHeader bg-primary text-light mb-4">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    @if ($cek > 0)
    <div class="pageTitle">Absen Pulang</div>
    @else
    <div class="pageTitle">Absen Masuk</div>
    @endif
    <div class="right"></div>
</div>
@endsection

@section('content')
@if ($cekPulang > 0)
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

<style>
    .webcam {
    padding: 0;
    margin: 0;
    display: flex;
    align-items: center;
    justify-content: center;
}
#video{
    display: inline-block;
    width: 100% !important;
    margin: auto;
    height: auto !important;
    border-radius: 15px;
     
  }
#map { 
  border-radius: 15px;
  margin: auto;
  height: 250px; }

canvas {
    position: absolute;
}
</style>
<link rel="stylesheet" href="../assets/css/style.css">
<script src="../assets/js/jquery.js"></script>
<script src="../assets/js/face-api.min.js"></script>


<div class="row" style="margin-top: 70px">
    <div class="col">
        <div class="webcam">
            <video id="video" width="600" height="450" autoplay>
        </div>

    </div>
</div>

{{-- {{ $cek }} --}}
    <input type="hidden" name="lokasi" id="lokasi">

<div class="row mt-3">
  <div class="col">
    <div id="map"></div>
  </div>
</div>
    
    {{-- <img src="/labels/Lisa/2.jpg" alt="" srcset=""> --}}

@php
    $models = asset('assets/js/models')

@endphp

<script>

////////////////////////////// PROSES DETEKSI LOKASI \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
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







////////////////////////////// PROSES DETEKSI CAMERA \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

const video = document.getElementById("video");

Promise.all([
  faceapi.nets.ssdMobilenetv1.loadFromUri("../assets/js/models"),
  faceapi.nets.faceRecognitionNet.loadFromUri("../assets/js/models"),
  faceapi.nets.faceLandmark68Net.loadFromUri("../assets/js/models"),
]).then(startWebcam);

function startWebcam() {
  navigator.mediaDevices
    .getUserMedia({
      video: true,
      audio: false,
    })
    .then((stream) => {
      video.srcObject = stream;
    })
    .catch((error) => {
      console.error(error);
    });
}


function getLabeledFaceDescriptions() {
  const labels = ["Rehan", "Heisenberg", "Jokowi"];
  return Promise.all(
    labels.map(async (label) => {
      const descriptions = [];
      for (let i = 1; i <= 2; i++) {
        const img = await faceapi.fetchImage(`../labels/${label}/${i}.jpg`);
        const detections = await faceapi
          .detectSingleFace(img)
          .withFaceLandmarks()
          .withFaceDescriptor();
        descriptions.push(detections.descriptor);
      }
      return new faceapi.LabeledFaceDescriptors(label, descriptions);
    })
  );
}


video.addEventListener("play", async () => {
  const labeledFaceDescriptors = await getLabeledFaceDescriptions();
  const faceMatcher = new faceapi.FaceMatcher(labeledFaceDescriptors);

  const canvas = faceapi.createCanvasFromMedia(video);
  $('.webcam').append(canvas);

  const displaySize = { width: video.width, height: video.height };
  faceapi.matchDimensions(canvas, displaySize);

  

  let intervalId = setInterval(async () => {
    const detections = await faceapi
      .detectAllFaces(video)
      .withFaceLandmarks()
      .withFaceDescriptors();

    const resizedDetections = faceapi.resizeResults(detections, displaySize);

    canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);

    const results = resizedDetections.map((d) => {
      return faceMatcher.findBestMatch(d.descriptor);
    });
    results.forEach((result, i) => {
      const box = resizedDetections[i].detection.box;
      const drawBox = new faceapi.draw.DrawBox(box, {
        label: result,
        
      });
      
      drawBox.draw(canvas);
      if(result.label == 'Jokowi') {
        clearInterval(intervalId);
        var lokasi = $('#lokasi').val()
        var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        $.ajax({
          type: 'POST',
          url: '/presensi/prosesAbsen',
          data: {
            _token : csrfToken,
            lokasi: lokasi
          },
          cache: false,
          success: function(resp){
            var pesan = resp.pesan;
            
            
            if(pesan == 'invalid_jarak'){

              Swal.fire({
              icon: 'error',
              title: 'Invalid Radius',
              text: 'Anda tidak berada dalam radius Kantor!'})
              setTimeout("location.href='/dashboard'",3000);
            }else{
              if(pesan == 'pulang'){
                Swal.fire({
              icon: 'success',
              title: 'ABSEN PULANG',
              text: 'Anda berhasil absen pulang'})
              }else{
                Swal.fire({
              icon: 'success',
              title: 'ABSEN MASUK',
              text: 'Anda berhasil absen masuk'})
              setTimeout("location.href='/dashboard'",3000);
              }
              
            }

            setTimeout("location.href='/dashboard'",3000);

          
          }
        })

      }
      
     
    });

  }, 800);
 
});

</script>
@endif
@endsection