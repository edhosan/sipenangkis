<?php

namespace App\Http\Controllers\PenerimaManfaat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\PenerimaManfaat;
use App\Models\Keluarga;
use App\Models\PenilaianPenerimaManfaat;
use App\Models\IndikatorPenerimaManfaat;
use App\Models\Indikator;

class PenerimaManfaatController extends Controller
{
  public function store(Request $request)
  {
    $penerimaManfaat = new PenerimaManfaat();
    $penerimaManfaat->m_desa_id = $request->input('m_desa_id');
    $penerimaManfaat->rt = $request->input('rt');
    $penerimaManfaat->alamat = $request->input('alamat');
    $penerimaManfaat->no_rumah = $request->input('no_rumah');
    $penerimaManfaat->domisili = $request->input('domisili');
    $penerimaManfaat->nkk = $request->input('nkk');
    $penerimaManfaat->userid = $request->input('userid');
    $penerimaManfaat->rw = $request->input('rw');
    $penerimaManfaat->save();

    $hasil_indikator = new PenilaianPenerimaManfaat();
    $hasil_indikator =  $penerimaManfaat->hasilIndikator()->save($hasil_indikator);

    return response()->json(array('penerima_manfaat' => $penerimaManfaat,
                                  'hasil_indikator' => $hasil_indikator));
  }

  public function getPenerimaManfaat($id)
  {
    $penerimaManfaat = PenerimaManfaat::where('id', $id)
                                      ->with('desa')
                                      ->with('desa.kecamatan')
                                      ->first();

    $hasil_indikator = PenilaianPenerimaManfaat::where('m_pm_id', $id)->get();

    return response()->json(array('penerima_manfaat' => $penerimaManfaat,
                                  'hasil_indikator' => $hasil_indikator));
  }

}
