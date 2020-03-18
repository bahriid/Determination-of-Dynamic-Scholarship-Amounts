@extends('layout.app')

@section('content')
  <h3>Pengaturan Rules Fuzzy 1</h3>
    <table class="table table-striped table-bordered">
    <thead>
      <tr>
        <th>Id</th>
        <th>Penghasilan Orang Tua</th>
        <th>Nilai Akademik</th>
        <th>Point Sertifikat</th>
        <th>Then</th>
        <th>Aksi</th>
      </tr>
    </thead>
    <tbody>
    @foreach($fuzzysets as $fuzzyset)
      <tr>
        <td>{{ $fuzzyset->id }}</td>
        <td>{{ $fuzzyset->penghasilan_orangtua }}</td>
        <td>{{ $fuzzyset->nilai_akademik }}</td>
        <td>{{ $fuzzyset->poin_sertifikat }}</td>
        <td>{{ $fuzzyset->result_price }}</td>
        <td><a href="{{ action('FuzzysetController@showSet', [$fuzzyset->id]) }}" class="btn btn-default">Show</a></td>
    @endforeach
    <tbody>
  </table>
@endsection