@extends('layout.app')

@section('content')
<style>
#map-canvas {
  height:460px;
}
</style>
    @php
      $fuzzy_price = $rumah->fuzzy_price;
      $luas_rumah = $rumah->luas_rumah;
      $prediksi_rumah = $fuzzy_price;



      $hasilAkhir = $prediksi_rumah;
    @endphp

  
  <form class="form-horizontal" method="get">

  @php
        // Provides: You should eat pizza, beer, and ice cream every day
    $phrase  = $rumah->nama_lokasi;
    $hapus = array("[", "]", "\\", "\"", "\n", "  ", "_");
    $ganti   = array("", "", "", "", "", "", " ");

    $hasilphrase = str_replace($hapus, $ganti, $phrase);

    $pecahhasil = explode(",",$hasilphrase);
  @endphp

  {{-- <div class="form-group">
    <label for="" class="col-sm-2 control-label">Letak Lokasi</label>
    <div class="col-sm-10">
      <div id="map-canvas" class="col-sm-6"></div>

      <label for="" class="col-sm-6 control-label" style="text-align: center;">Nilai Lokasi (0-10) = {{ $rumah->lokasi_tanah }}</label>
      <div class="col-sm-6" style="padding-right: 0px;text-align: center;">
        <div style="float:left;width: 100%;padding: 5px 10px;">
         @for ($i =0; $i < $rumah->lokasi_tanah ; $i++)
           <span class="glyphicon glyphicon-star" aria-hidden="true" style="top:3px;font-size: 150%;font-weight: 200;color:#eca330;"></span>        
         @endfor
         @for ($i = $rumah->lokasi_tanah; $i < 10 ; $i++)
           <span class="glyphicon glyphicon-star-empty" aria-hidden="true" style="top:3px;font-size: 150%;font-weight: 200;color:#999;"></span>        
          @endfor
        </div>
      </div>
      <div class="col-sm-6" style="padding-right: 0px;">
        <hr style="margin: 0px;">
      </div>
      
      <label for="" class="col-sm-6 control-label" style="text-align: center;margin-top: 10px;">Akses Lokasi</label>
      <ul id="check-list-box" class="list-group checked-list-box2 col-sm-6" style="padding: 15px 0px 15px 15px ;margin: 0;">
      @foreach ($pecahhasil as $nama_lokasi)
        @if ($nama_lokasi == "Tempat Makan")
            <li class="list-group-item col-sm-6" data-color="success" style="float:left;"> <i class="fa fa-cutlery" aria-hidden="true"></i> {{ $nama_lokasi }}</li>
        @elseif ($nama_lokasi == "Pasar Tradisional")
            <li class="list-group-item col-sm-6" data-color="success" style="float:left;"> <i class="fa fa-shopping-basket" aria-hidden="true"></i> {{ $nama_lokasi }}</li>
        @elseif ($nama_lokasi == "Pasar Modern")
            <li class="list-group-item col-sm-6" data-color="success" style="float:left;"> <i class="fa fa-shopping-cart" aria-hidden="true"></i> {{ $nama_lokasi }}</li>
        @elseif ($nama_lokasi == "Sekolah SD" || $nama_lokasi == "Sekolah SMP" || $nama_lokasi == "Sekolah SMA" )
            <li class="list-group-item col-sm-6" data-color="success" style="float:left;"> <i class="fa fa-graduation-cap" aria-hidden="true"></i> {{ $nama_lokasi }}</li>
        @elseif ($nama_lokasi == "Universitas")
            <li class="list-group-item col-sm-6" data-color="success" style="float:left;"> <i class="fa fa-university" aria-hidden="true"></i> {{ $nama_lokasi }}</li>
        @elseif ($nama_lokasi == "Rumah Ibadah")
            <li class="list-group-item col-sm-6" data-color="success" style="float:left;"> <i class="fa fa-universal-access" aria-hidden="true"></i> {{ $nama_lokasi }}</li>
        @elseif ($nama_lokasi == "Jalan Tol")
            <li class="list-group-item col-sm-6" data-color="success" style="float:left;"> <i class="fa fa-shopping-basket" aria-hidden="true"></i> {{ $nama_lokasi }}</li>
        @elseif ($nama_lokasi == "Kantor Pemerintahan")
            <li class="list-group-item col-sm-6" data-color="success" style="float:left;"> <i class="fa fa-university" aria-hidden="true"></i> {{ $nama_lokasi }}</li>
        @elseif ($nama_lokasi == "Rumah Sakit")
            <li class="list-group-item col-sm-6" data-color="success" style="float:left;"> <i class="fa fa-hospital-o" aria-hidden="true"></i> {{ $nama_lokasi }}</li>
        @elseif ($nama_lokasi == "Terminal Bus")
            <li class="list-group-item col-sm-6" data-color="success" style="float:left;"> <i class="fa fa-bus" aria-hidden="true"></i> {{ $nama_lokasi }}</li>
        @elseif ($nama_lokasi == "Stasiun")
            <li class="list-group-item col-sm-6" data-color="success" style="float:left;"> <i class="fa fa-subway" aria-hidden="true"></i> {{ $nama_lokasi }}</li>
        @endif
      @endforeach
      </ul>

      <div class="col-sm-6" style="padding-right: 0px;position: absolute;right: 0;bottom: 130px;">
        <hr style="margin: 0px;">
      </div>
      <label for="" class="col-sm-6 control-label" style="text-align: center;margin-top: 10px;position: absolute;right: 0;bottom: 100px;">Alamat</label>
      <div class="form-group col-sm-6" style="margin:0px;position: absolute;right: 0;bottom: 0;">
        <textarea name="" id="alamat_lokasi" cols="30" rows="4" class="form-control" readonly></textarea>
      </div>
    </div>
  </div> --}}
  <div class="form-group">
    <label for="rumahNjop" class="col-sm-2 control-label">Penghasilan Orang Tua</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="rumahNjop" name="penghasilanOrangtua" value="{{ currency($rumah->penghasilan_orangtua) }}" readonly="readonly">
    </div>
  </div>
  <div class="form-group">
    <label for="rumahKondisi" class="col-sm-2 control-label">Nilai Akademik</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="rumahKondisi" name="nilaiAkademik" value="{{ $rumah->nilai_akademik }}" readonly="readonly">
    </div>
  </div>
  <div class="form-group">
    <label for="rumahUsia" class="col-sm-2 control-label">Point Sertifikat</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="rumahUsia" name="usiaRumah" value="{{ $rumah->poin_sertifikat }} Poin" readonly="readonly">
    </div>
  </div>
  {{-- <div class="form-group">
    <label for="rumahLuas" class="col-sm-2 control-label">Luas Rumah</label>
    <div class="col-sm-1">
      <input type="text" class="form-control" id="rumahLuas" name="luasRumah" value="{{ $rumah->luas_rumah }}" readonly="readonly"> 
    </div>
    <label for="" class="control-label">m<sup>2</sup></label>
  </div> --}}
  <hr>
  {{-- <div class="form-group">
    <label for="tanahNjop" class="col-sm-2 control-label">Harga NJOP Tanah</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="tanahNjop" name="njopTanah" value="{{ currency($rumah->penghasilan_tanah) }}" readonly="readonly">
    </div>
  </div>
  <div class="form-group">
    <label for="tanahLuas" class="col-sm-2 control-label">Luas Tanah</label>
    <div class="col-sm-1">
      <input type="text" class="form-control" id="tanahLuas" name="luasTanah" value="{{ $rumah->luas_tanah }}" readonly="readonly">
    </div>
    <label for="" class="control-label">m<sup>2</sup></label>
  </div>
  <hr> --}}
  <div class="form-group">
    <label for="inputFuzzy" class="col-sm-2 control-label">Jumlah Beasiswa</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputFuzzy" value="{{ currency($fuzzy_price) }}" readonly="readonly">
    </div>
  </div>
  {{-- <div class="form-group">
    <label for="inputFuzzy" class="col-sm-2 control-label">Prediksi Harga Tanah</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="inputFuzzy" value="{{ currency($fuzzy2_price) }}" readonly="readonly">
    </div>
  </div>
    <div class="form-group">
    <label for="hasilAkhir" class="col-sm-2 control-label">Hasil Akhir Prediksi</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="hasilAkhir" value="{{ currency($hasilAkhir) }}" readonly="readonly">
    </div>
  </div> --}}

  <table class="table" style="width:100%;">
    <tr>
      <td style="padding:10px;border:none;"><h3>Terbilang</h3></td>
      <td style="padding-left:20px;border-left: 2px solid #333;border-top:none;"><h3>{{currency($hasilAkhir)}}</h3></td>
    </tr>
    <tr>
      <td style="border:none;"></td>
      <td class="success" style="padding-left:20px;border-left: 2px solid #333;"><h4 style="margin:0px;text-transform:capitalize;">{{numbertoword($hasilAkhir)}}</h4></td>
    </tr>
  </table>
  <hr>
</form>

<script>
var
    on = {
          labelOrigin: new google.maps.Point(11, 25),
          url: '{{ asset('transparent.gif') }}',
          size: new google.maps.Size(22, 40),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(11, 40),
      },
    off = {
          labelOrigin: new google.maps.Point(11, 25),
          url: '{{ asset('transparent.gif') }}',
          size: new google.maps.Size(22, 40),
          origin: new google.maps.Point(0, 0),
          anchor: new google.maps.Point(11, 40),
      };


window.onload = function init() {

    var
        contentCenter = '<span class="infowin">Lokasi</span>',

        latLngCenter = new google.maps.LatLng({{$rumah->lat}}, {{$rumah->lng}}),
        latLngCMarker = new google.maps.LatLng({{$rumah->lat}}, {{$rumah->lng}}),
        map = new google.maps.Map(document.getElementById('map-canvas'), {
            zoom: 15,
            center: latLngCenter,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            scrollwheel: false,
            navigationControl: false,
            mapTypeControl: false,
            scaleControl: false,
            draggable: false,
        }),
        markerCenter = new google.maps.Marker({
            position: latLngCMarker,
            title: 'Lokasi',
            //label: 'x',
            map: map,
            draggable: false,
            icon: {
                    labelOrigin: new google.maps.Point(11, 20),
                    url: '{{ asset('marker_orange.png') }}',
                    size: new google.maps.Size(22, 40),
                    origin: new google.maps.Point(0, 0),
                    anchor: new google.maps.Point(11, 40),
                  },
        }),
        infoCenter = new google.maps.InfoWindow({
            content: contentCenter
        }),

        // exemplary setup: 
        // Assumes that your map is signed to the var "map"
        // Also assumes that your marker is named "marker"

        radius = 1000,
        circle = new google.maps.Circle({
            map: map,
            clickable: false,
            draggable: false,
            // metres
            radius: radius,
            fillColor: '#fff',
            fillOpacity: 0,
            strokeColor: 'red', //'#313131',
            strokeOpacity: .7,
            strokeWeight: .8
        });
    // attach circle to marker
    circle.bindTo('center', markerCenter, 'position');

    codeLatLng(markerCenter.getPosition());

    function codeLatLng(value)
    {
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'latLng': value}, function(results, status)
        {
            if (status == google.maps.GeocoderStatus.OK)
            {
                if (results[0])
                {

                    jQuery('#alamat_lokasi').html(results[0].formatted_address);

                }
                else
                {
                    jQuery('#alamat_lokasi').val("No results found");
                }
            }
            else
            {
                alert("Geocoder failed due to: " + status);
            }
        });
    }

};

</script>
@endsection