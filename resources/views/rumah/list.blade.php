@extends('layout.app')

@section('content')
  <h3>List Data Utama</h3>
  <div class="list-main-btn">
    <div class="row">
      @if (Auth::user()->isLevel('ADMIN'))
      <div class="col-sm-4">
        <a href="{{ action('RumahController@createFormRumah') }}" class="btn btn-success">Hitung Beasiswa</a>
      </div>
      <div class="col-sm-8">
        <form class="form" role="form" method="get" action="{{ action('RumahController@listRumah') }}">
          <input class="form-control" type="text" name="q" placeholder="search" value="{{ Request::get('q') }}">
        </form>
      </div>
      @else
      <div class="col-sm-12">
        <form class="form" role="form" method="get" action="{{ action('RumahController@listRumah') }}">
          <input class="form-control" type="text" name="q" placeholder="search" value="{{ Request::get('q') }}">
        </form>
      </div>
      @endif
    </div>
  </div>
  <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Penghasilan Orang Tua</th>
        <th>Nilai Akademik</th>        
        <th>Point Sertifikat</th>
        <th>Jumlah Beasiswa</th>
        <th width="125">Aksi</th>
      </tr>
    </thead>
    <tbody>
    @foreach($rumahs as $rumah)
    @php
      $fuzzy_price = $rumah->fuzzy_price;
      $luas_rumah = $rumah->luas_rumah;
      $prediksi_rumah = $fuzzy_price * $luas_rumah;

      $fuzzy2_price = $rumah->fuzzy2_price;
      $luas_tanah = $rumah->luas_tanah;
      $prediksi_tanah = $fuzzy2_price * $luas_tanah;

      $hasilAkhir = $prediksi_tanah + $prediksi_rumah;
    @endphp
      <tr>
        <td>{{ currency($rumah->penghasilan_orangtua) }}</td>
        <td>{{ $rumah->nilai_akademik }}</td>
        <td>{{ $rumah->poin_sertifikat }}</td>
        <td>{{ currency($fuzzy_price) }}</td>
        <td>
          <form class="list-action" method="get" action="{{ action('RumahController@showRumah', [$rumah->id]) }}">
            <button type="submit" class="btn btn-default btn-xs">Show</button>
          </form>
          <form class="list-action" method="post" action="{{ action('RumahController@deleteRumah', [$rumah->id]) }}">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-danger btn-xs">Delete</button>
          </form>
        </td>
    @endforeach
    <tbody>
  </table>
@endsection