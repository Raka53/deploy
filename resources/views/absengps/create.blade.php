@extends('layouts.presensi')
@section('header')
<div class="appHeader bg-primary text-light">
    <div class="left">
        <a href="javascript:;" class="headerButton goBack">
            <ion-icon name="chevron-back-outline"></ion-icon>
        </a>
    </div>
    <div class="pageTitle">E-Absensi</div>
    <div class="right"></div>
</div>
<style>
    .webcam-capture,
    .webcam-capture video{
        display: inline-block;
        width: 100% !important;
        margin: auto;
        height: auto !important;
        border-radius: 15px;
    }
    #map { height: 200px; }
</style>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     ></script>
@endsection
@section('content')
<div id="appCapsule">


    <div class="row" style="margin-top: 70px">
        <div class="col">
            <input type="hidden" id="lokasi">
            <div class="webcam-capture">

            </div>
        </div>
    </div>


    <div class="row mt-1">
        <div class="col">
            <div id="map"></div>
        </div>

    </div>

    <div class="row mt-2">
      <div class="col">
        @if ($cek > 0)
            <button id="takeabsen" class="btn btn-danger btn-block">
                <ion-icon name="camera-outline"></ion-icon>Absen Pulang</button>
        @else
            <button id="takeabsen" class="btn btn-primary btn-block">
                <ion-icon name="camera-outline"></ion-icon>Absen Masuk</button>
        @endif
    </div>

    </div>


</div>
@endsection

@push('myscript')
<script>
  Webcam.set({
      height: 400,
      width: 640,
      image_format: 'jpeg',
      jpeg_quality: 80
  });
  Webcam.attach('.webcam-capture');

  var lokasi = document.getElementById('lokasi');
  if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(succesCallback, errorCallback);
  }

  function succesCallback(position) {
      var latitude = position.coords.latitude;
      var longitude = position.coords.longitude;

      lokasi.value = latitude + "," + longitude;

      // Use Nominatim API to get location name
      $.getJSON(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${latitude}&lon=${longitude}`, function (data) {
          if (data.display_name) {
              var locationName = data.display_name;
              // Use locationName as needed, e.g., display it on the page

              lokasi.value = locationName;
          }
      });
      var map = L.map('map').setView([latitude, longitude], 18);
      L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
      }).addTo(map);
      var marker = L.marker([latitude, longitude]).addTo(map);
      var circle = L.circle([latitude, longitude], {
          color: 'red',
          fillColor: '#f03',
          fillOpacity: 0.5,
          radius: 50
      }).addTo(map);
  }

  function errorCallback() {}

  $('#takeabsen').click(function (e) {
      // Show notification when the button is clicked
      Swal.fire({
          title: 'Proses Absen',
          text: 'Absen sedang diproses, harap tunggu sebentar',
          icon: 'info',
          showCancelButton: false,
          showConfirmButton: false,
          allowOutsideClick: false
      });

      Webcam.snap(function (uri) {
          image = uri;
      });

      var lokasi = $("#lokasi").val();
      $.ajax({
          type: 'POST',
          url: '/presensi/store',
          data: {
              _token: "{{ csrf_token() }}",
              image: image,
              lokasi: lokasi
          },
          cache: false,
          success: function (respond) {
              var status = respond.split("|")
              Swal.close(); // Close the notification
              if (status[0] == "success") {
                  Swal.fire({
                      title: 'Success',
                      text: status[1],
                      icon: 'success'
                  })
                  setTimeout("location.href='/dashboardAbsen'", 3000)
              } else {
                  alert('gagal');
              }
          }
      })
  });
</script>
@endpush
