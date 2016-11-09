<?php

namespace App\Http\Controllers\PenerimaManfaat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\IndikatorPenerimaManfaat;
use App\Models\PenilaianPenerimaManfaat;
use App\Models\KategoriIndikator;
use App\Models\Kluster;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\PenerimaManfaat;

class TindikatorController extends Controller
{
  public function store(Request $request, $penilaian_id)
  {
      $penilaian = PenilaianPenerimaManfaat::find($penilaian_id);
      $penilaian->rincianIndikator()->delete();

      foreach ($request->input('indikator') as $key => $value) {
        $tindikator = new IndikatorPenerimaManfaat();
        $tindikator->m_indikator_id = $value['id'];
        $tindikator->value = $value['value'];

        $penilaian->rincianIndikator()->save($tindikator);
      }

      $penilaian = $this->updateHasil($penilaian);

      return response()->json($penilaian);
  }

  private function updateHasil($penilaian)
  {
    $query = DB::table('t_pm_indikator')
              ->join('m_indikator','m_indikator.id','=','t_pm_indikator.m_indikator_id')
              ->join('m_kategori_indikator','m_kategori_indikator.id','=','m_indikator.m_kategori_indikator_id')
              ->join('m_kluster_m_kategori','m_kluster_m_kategori.m_kategori_id','=','m_kategori_indikator.id')
              ->join('m_kluster','m_kluster.id','=','m_kluster_m_kategori.m_kluster_id')
              ->where('t_pm_indikator.t_pmp_id',$penilaian->id)
              ->groupBy('m_kluster.name','m_kluster.min','m_kluster.max','m_kluster.id')
              ->havingRaw('sum(t_pm_indikator.value) >= min and sum(t_pm_indikator.value) <= max')
              ->select(DB::raw('sum(t_pm_indikator.value) as total, m_kluster.name,m_kluster.min,m_kluster.max, m_kluster.id'))
              ->get();

    foreach ($query as $value) {
      $penilaian->nilai = $value->total;
      $penilaian->kriteria = $value->name;
      $penilaian->m_kluster_id = $value->id;

      $penilaian->update();
    }

     return $penilaian;
  }

  public function index(Request $request,$penerima_manfaat_id)
  {
    $query = PenilaianPenerimaManfaat::where('m_pm_id',$penerima_manfaat_id)->orderBy('id', 'desc');

    $perPage = $request->has('per_page') ? (int) $request->per_page : null;
    $page = $request->has('page') ? (int) $request->page : 1;

    $result = $query->get()->toArray();
    $offset = ($page * $perPage) - $perPage;
    $itemCurrentPage = array_slice($result, $offset, $perPage, true);
    $result = new LengthAwarePaginator($itemCurrentPage, count($result), $perPage, $page);
    $result = $result->toArray();

    return $result;
  }

  public function rincianIndikatorHasil($id)
  {
    $query = IndikatorPenerimaManfaat::where('t_pmp_id',$id)->get();

    return $query;
  }

  public function newIndikator($penerima_manfaat_id)
  {
    $penerimaManfaat = PenerimaManfaat::find($penerima_manfaat_id);

    $hasil_indikator = new PenilaianPenerimaManfaat();
    $hasil_indikator =  $penerimaManfaat->hasilIndikator()->save($hasil_indikator);

    return $hasil_indikator;

  }

  public function deleteIndikator($id)
  {
    $penilaian = PenilaianPenerimaManfaat::find($id);
    $penilaian->delete();

    return response()->json($penilaian);
  }

}
