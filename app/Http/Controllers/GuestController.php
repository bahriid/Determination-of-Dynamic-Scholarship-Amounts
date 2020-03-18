<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cornford\Googlmapper\Facades\MapperFacade as Mapper;
use App\Http\Requests;
use App\Rumah;
use App\Markerlokasi;
use App\Petablok;

class GuestController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRumah($id)
    {
        $markers = Markerlokasi::get();
        $rumah = Rumah::find($id);
        return view('guest.show')->with('rumah', $rumah)->with('markers', $markers);
    }

    public function createFormRumah()
    {
        $markers = Markerlokasi::get();
        $polygons = Petablok::get();
        return view('guest.create')->with('markers', $markers)->with('polygons', $polygons);
    }

    public function createRumah(Request $request)
    {
        $this->validate($request, [
            'penghasilanOrangtua' => 'required|numeric|min:0|max:5000000',
            'nilaiAkademik' => 'required|numeric|min:0',
            'usiaRumah1' => 'required|numeric|min:0',
            'usiaRumah2' => 'required|numeric|min:0',
            'usiaRumah3' => 'required|numeric|min:0',
            'usiaRumah4' => 'required|numeric|min:0',
            'usiaRumah5' => 'required|numeric|min:0',
        ]);

        
        
        $rumah = new Rumah();
        $rumah->penghasilan_orangtua = $request->penghasilanOrangtua;
        $rumah->nilai_akademik = $request->nilaiAkademik;
        $rumah->poin_sertifikat = $request->usiaRumah1 + $request->usiaRumah2 + $request->usiaRumah3 + $request->usiaRumah4 + $request->usiaRumah5;
        $rumah->save();

        return redirect()->action('GuestController@showRumah', [$rumah->id]);
    }
}
