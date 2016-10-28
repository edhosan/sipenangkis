<?php

namespace App\Http\Controllers\PenerimaManfaat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\PenerimaManfaat;
use DB;

class PembaharuanRTMController extends Controller
{
  public function index(Request $request)
  {
    $query = DB::table('m_penerima_manfaat')
              ->join('m_penerima_manfaat_keluarga','m_penerima_manfaat.id','=','m_penerima_manfaat_keluarga.m_penerima_manfaat_id')
              ->join('m_desa','m_desa.id','=','m_penerima_manfaat.m_desa_id')
              ->join('m_kecamatan','m_kecamatan.id','=','m_desa.m_kecamatan_id')
              ->join('t_pm_penilaian','t_pm_penilaian.m_pm_id','=','m_penerima_manfaat.id')
              ->join(DB::raw('(select max(t_pm_penilaian.id) id,m_pm_id from t_pm_penilaian group by m_pm_id) as tbl'), function($query){
                $query->on('tbl.id','=','t_pm_penilaian.id');
              })
              ->where('m_penerima_manfaat_keluarga.hubungan','01')
              ->select('m_penerima_manfaat.id','m_penerima_manfaat.nkk',DB::raw('concat(m_penerima_manfaat.alamat ," ", m_penerima_manfaat.rt," ",m_penerima_manfaat.rw) as alamat'),
                       'm_penerima_manfaat_keluarga.nama','m_penerima_manfaat_keluarga.sex','m_kecamatan.name as kecamatan','m_desa.name as desa','t_pm_penilaian.nilai','t_pm_penilaian.kriteria');

    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = $query->orderBy($sortCol, $sortDir);
    }else{
      $query = $query->orderBy('id', 'asc');
    }

    if($request->exists('filter')){
      if($request->exists('key')){
        $query->where(function($q) use($request){
          $value = "%{$request->filter}%";
          $key = "{$request->key}";
          $q->where($key, 'like', $value);
        });
      }
    }

    $perPage = $request->has('per_page') ? (int) $request->per_page : null;
    $page = $request->has('page') ? (int) $request->page : 1;

    $result = $query->get()->toArray();
    $offset = ($page * $perPage) - $perPage;
    $itemCurrentPage = array_slice($result, $offset, $perPage, true);
    $result = new LengthAwarePaginator($itemCurrentPage, count($result), $perPage, $page);
    $result = $result->toArray();

    return $result;
  }

  public function delete($id)
  {
    $penerimaManfaat = PenerimaManfaat::find($id);

    return response()->json($penerimaManfaat->delete());
  }

}
