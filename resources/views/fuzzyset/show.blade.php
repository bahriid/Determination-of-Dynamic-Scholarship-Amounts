@extends('layout.app')

@section('content')
  <h3>Pengaturan Rules Fuzzy 1</h3>
  <form class="form-horizontal" action="{{ action('FuzzysetController@updateForm', [$fuzzyset->id]) }}" method="get">
  <div class="form-group">
    <label for="competitorPrice" class="col-sm-2 control-label">Penghasilan Orang Tua</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="competitorPrice" value="{{ $fuzzyset->penghasilan_orangtua }}" readonly="readonly">
    </div>
  </div>
  <div class="form-group">
    <label for="beforePrice" class="col-sm-2 control-label">Nilai Akademik</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="beforePrice" value="{{ $fuzzyset->nilai_akademik }}" readonly="readonly">
    </div>
  </div>
  <div class="form-group">
    <label for="currentPrice" class="col-sm-2 control-label">Point Sertifikat</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="currentPrice" value="{{ $fuzzyset->poin_sertifikat }}" readonly="readonly">
    </div>
  </div>
  <div class="form-group">
    <label for="thenPrice" class="col-sm-2 control-label">Then</label>
    <div class="col-sm-10">
      <input type="text" class="form-control" id="thenPrice" value="{{ $fuzzyset->result_price }}" readonly="readonly">
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-default">Edit</button>
    </div>
  </div>
</form>
@endsection