<?php

namespace App\Http\Controllers\ProgramIntervensi;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ProsesIntervensi;
use App\Models\PenerimaManfaat;
use App\Models\Desa;
use App\Models\Kelompok;
use App\Models\Keluarga;
use App\Models\Stakeholders;
use App\Models\User;
use App\Models\RincianProsesIntervensi;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class ProsesIntervensiController extends Controller
{
  public function intervensiKeluarga(Request $request)
  {
  
    $query = DB::table('m_penerima_manfaat')
                ->join('m_desa','m_desa.id','=','m_penerima_manfaat.m_desa_id')
                ->join('m_kecamatan','m_kecamatan.id','=','m_desa.m_kecamatan_id')
                ->join('m_penerima_manfaat_keluarga','m_penerima_manfaat_keluarga.m_penerima_manfaat_id','=','m_penerima_manfaat.id')
                ->join('t_pm_penilaian','t_pm_penilaian.m_pm_id','=','m_penerima_manfaat.id')
                ->join(DB::raw('(select max(t_pm_penilaian.id) id,m_pm_id from t_pm_penilaian group by m_pm_id) as tbl'), function($query){
                      $query->on('tbl.id','=','t_pm_penilaian.id');
                })
                ->leftJoin('t_intervensi', function($join){
                    $join->on('t_intervensi.penerima_id','=','m_penerima_manfaat.id')
                         ->on('t_intervensi.tahun', '=', DB::raw('YEAR(CURDATE())'));
                })          
                ->leftJoin('m_intervensi', function($join){
                    $join->on('m_intervensi.id','=','t_intervensi.m_intervensi_id')
                        ->on('m_intervensi.m_sasaran_intervensi_id','=', DB::raw('4'));
                })
                ->where('m_penerima_manfaat_keluarga.hubungan','01')
                ->select('m_penerima_manfaat.id','m_penerima_manfaat.alamat','m_penerima_manfaat.nkk','m_desa.name as desa','m_kecamatan.name as kecamatan','m_penerima_manfaat_keluarga.nama', 'm_penerima_manfaat_keluarga.sex','t_pm_penilaian.kriteria', 'm_intervensi.name as intervensi' );
              

    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = $query->orderBy($sortCol, $sortDir);
    }else{
      $query = $query->orderBy('id', 'asc');
    }

    if($request->exists('filter')){
      if($request->exists('key')){
        $query->where(function($q) use($request){
          $value = "{$request->filter}%";
          $key = "{$request->key}";
          $q->where($key, 'like', $value);
        });
      }
    }

    $perPage = $request->has('per_page') ? (int) $request->per_page : 10;

    $result = $query->paginate($perPage);

    return response()->json($result);
  }

  public function intervensiIndividu(Request $request)
  {
  
    $query = DB::table('m_penerima_manfaat')
                ->join('m_desa','m_desa.id','=','m_penerima_manfaat.m_desa_id')
                ->join('m_kecamatan','m_kecamatan.id','=','m_desa.m_kecamatan_id')
                ->join('m_penerima_manfaat_keluarga','m_penerima_manfaat_keluarga.m_penerima_manfaat_id','=','m_penerima_manfaat.id')
                ->join('t_pm_penilaian','t_pm_penilaian.m_pm_id','=','m_penerima_manfaat.id')
                ->join(DB::raw('(select max(t_pm_penilaian.id) id,m_pm_id from t_pm_penilaian group by m_pm_id) as tbl'), function($query){
                      $query->on('tbl.id','=','t_pm_penilaian.id');
                })
                ->leftJoin('t_intervensi', function($join){
                    $join->on('t_intervensi.penerima_id','=','m_penerima_manfaat_keluarga.id')
                         ->on('t_intervensi.tahun', '=', DB::raw('YEAR(CURDATE())'));
                })          
                ->leftJoin('m_intervensi', function($join){
                    $join->on('m_intervensi.id','=','t_intervensi.m_intervensi_id')
                        ->on('m_intervensi.m_sasaran_intervensi_id','=', DB::raw('5'));
                })
                ->select('m_penerima_manfaat_keluarga.id','m_penerima_manfaat.alamat','m_penerima_manfaat_keluarga.nik','m_desa.name as desa','m_kecamatan.name as kecamatan','m_penerima_manfaat_keluarga.nama', 'm_penerima_manfaat_keluarga.sex','t_pm_penilaian.kriteria', 'm_intervensi.name as intervensi' );
              

    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = $query->orderBy($sortCol, $sortDir);
    }else{
      $query = $query->orderBy('id', 'asc');
    }

    if($request->exists('filter')){
      if($request->exists('key')){
        $query->where(function($q) use($request){
          $value = "{$request->filter}%";
          $key = "{$request->key}";
          $q->where($key, 'like', $value);
        });
      }
    }

    $perPage = $request->has('per_page') ? (int) $request->per_page : 10;

    $result = $query->paginate($perPage);

    return response()->json($result);
  }

  public function intervensiKawasan(Request $request)
  {
  
    $query = DB::table('m_desa')
                ->join('m_kecamatan','m_kecamatan.id','=','m_desa.m_kecamatan_id')
                ->leftJoin('t_intervensi', function($join){
                    $join->on('t_intervensi.penerima_id','=','m_desa.id')
                         ->on('t_intervensi.tahun', '=', DB::raw('YEAR(CURDATE())'));
                })          
                ->leftJoin('m_intervensi', function($join){
                    $join->on('m_intervensi.id','=','t_intervensi.m_intervensi_id')
                        ->on('m_intervensi.m_sasaran_intervensi_id','=', DB::raw('2'));
                })
                ->select('m_desa.id', 'm_desa.name as desa','m_kecamatan.name as kecamatan','m_intervensi.name as intervensi' );
              

    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = $query->orderBy($sortCol, $sortDir);
    }else{
      $query = $query->orderBy('id', 'asc');
    }

    if($request->exists('filter')){
      if($request->exists('key')){
        $query->where(function($q) use($request){
          $value = "{$request->filter}%";
          $key = "{$request->key}";
          $q->where($key, 'like', $value);
        });
      }
    }

    $perPage = $request->has('per_page') ? (int) $request->per_page : 10;

    $result = $query->paginate($perPage);

    return response()->json($result);
  }

  public function intervensiKelompok(Request $request)
  {
  
    $query = DB::table('m_kelompok')
                ->join('m_desa','m_desa.id','=','m_kelompok.m_desa_id')
                ->join('m_kecamatan','m_kecamatan.id','=','m_desa.m_kecamatan_id')
                ->join('m_kelompok_penerima','m_kelompok_penerima.m_kelompok_id','=','m_kelompok.id')
                ->leftJoin('t_intervensi', function($join){
                    $join->on('t_intervensi.penerima_id','=','m_kelompok.id')
                         ->on('t_intervensi.tahun', '=', DB::raw('YEAR(CURDATE())'));
                })          
                ->leftJoin('m_intervensi', function($join){
                    $join->on('m_intervensi.id','=','t_intervensi.m_intervensi_id')
                        ->on('m_intervensi.m_sasaran_intervensi_id','=', DB::raw('3'));
                })
                ->select('m_kelompok.id', 'm_kelompok.name',DB::raw('count(m_kelompok_penerima.id) as total'), 'm_desa.name as desa','m_kecamatan.name as kecamatan','m_intervensi.name as intervensi' );
              

    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = $query->orderBy($sortCol, $sortDir);
    }else{
      $query = $query->orderBy('id', 'asc');
    }

    if($request->exists('filter')){
      if($request->exists('key')){
        $query->where(function($q) use($request){
          $value = "{$request->filter}%";
          $key = "{$request->key}";
          $q->where($key, 'like', $value);
        });
      }
    }

    $perPage = $request->has('per_page') ? (int) $request->per_page : 10;

    $result = $query->paginate($perPage);

    return response()->json($result);
  }

  public function detailKeluarga($id)
  {
    $keluarga = PenerimaManfaat::where('id',$id)
                              ->with('desa.kecamatan')
                              ->first();

    return $keluarga;
  }

  public function detailIntervensi(Request $request)
  {
    $query = DB::table('t_intervensi')
                ->join('m_intervensi',function($join)use($request){
                    $join->on('m_intervensi.id','=','t_intervensi.m_intervensi_id')
                         ->on('m_intervensi.m_sasaran_intervensi_id','=',DB::raw($request->sasaran));
                })
                ->select('t_intervensi.id','m_intervensi.name','t_intervensi.tahun','t_intervensi.rujukan');

    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = $query->orderBy($sortCol, $sortDir);
    }else{
      $query = $query->orderBy('id', 'desc');
    }

    if($request->exists('penerima_id')){
      $query->where(function($q) use($request){
        $q->where('t_intervensi.penerima_id', $request->penerima_id);
      });
    }

    $perPage = $request->has('per_page') ? (int) $request->per_page : 10;

    $result = $query->paginate($perPage);

    return response()->json($result);
  }

  public function deleteIntervensi($id)
  {
    $intervensi = ProsesIntervensi::find($id);
    $intervensi->delete();

    return response()->json($intervensi);
  }
  

  public function programIntervensiRef($user_id)
  {
    $user = User::where('userid',$user_id)
                ->with('stakeholder.program')
                ->first();

    $list_program = $user->stakeholder->program->map(
      function($program){
          return[
            'value' => $program->id,
            'label' => $program->name
          ];
      }
    );

    return response()->json(array(
        'list_program' => $list_program
      ));
  }

  public function store(Request $request, $id)
  {
    if($this->checkIntervensiKeluarga($request, $id) > 0){
      return response()->json(array('result' => false));
    }else{
      $penerimaManfaat = PenerimaManfaat::where('id',$id)->first();

      $prosesIntervensi = new ProsesIntervensi();
      $prosesIntervensi->m_intervensi_id = $request->input('m_intervensi_id');
      $prosesIntervensi->tahun = $request->input('tahun');
      $prosesIntervensi->rujukan = $request->input('rujukan');
      $prosesIntervensi->userid = $request->input('userid');

      $penerimaManfaat->intervensi()->save($prosesIntervensi);

      return $prosesIntervensi;
    }
  }

  public function storeIndividu(Request $request, $id)
  {
    if($this->checkIntervensiIndividu($request, $id) > 0){
      return response()->json(array('result' => false));
    }else{
      $keluarga = Keluarga::where('id',$id)->first();

      $prosesIntervensi = new ProsesIntervensi();
      $prosesIntervensi->m_intervensi_id = $request->input('m_intervensi_id');
      $prosesIntervensi->tahun = $request->input('tahun');
      $prosesIntervensi->rujukan = $request->input('rujukan');
      $prosesIntervensi->userid = $request->input('userid');

      $keluarga->intervensi()->save($prosesIntervensi);

      return $prosesIntervensi;
    }
  }

  public function storeKawasan(Request $request, $id)
  {
    if($this->checkIntervensiKawasan($request, $id) > 0){
      return response()->json(array('result' => false));
    }else{
      $desa = Desa::where('id',$id)->first();

      $prosesIntervensi = new ProsesIntervensi();
      $prosesIntervensi->m_intervensi_id = $request->input('m_intervensi_id');
      $prosesIntervensi->tahun = $request->input('tahun');
      $prosesIntervensi->rujukan = $request->input('rujukan');
      $prosesIntervensi->userid = $request->input('userid');

      $desa->intervensi()->save($prosesIntervensi);

      return $prosesIntervensi;
    }
  }

  public function storeKelompok(Request $request, $id)
  {
    if($this->checkIntervensiKelompok($request, $id) > 0){
      return response()->json(array('result' => false));
    }else{
      $kelompok = Kelompok::where('id',$id)->first();

      $prosesIntervensi = new ProsesIntervensi();
      $prosesIntervensi->m_intervensi_id = $request->input('m_intervensi_id');
      $prosesIntervensi->tahun = $request->input('tahun');
      $prosesIntervensi->rujukan = $request->input('rujukan');
      $prosesIntervensi->userid = $request->input('userid');

      $kelompok->intervensi()->save($prosesIntervensi);

      return $prosesIntervensi;
    }
  }

  public function updateIntervensiKeluarga(Request $request)
  {
    if($this->checkIntervensiKeluarga($request, $request->penerima_id) > 0){
      return response()->json(array('result' => false));
    }else{
      $prosesIntervensi = ProsesIntervensi::find($request->id);
      $prosesIntervensi->m_intervensi_id = $request->input('m_intervensi_id');
      $prosesIntervensi->tahun = $request->input('tahun');
      $prosesIntervensi->rujukan = $request->input('rujukan');
      $prosesIntervensi->userid = $request->input('userid');
      $prosesIntervensi->update();

      return $prosesIntervensi;
    }
  }

  public function updateIntervensiIndividu(Request $request)
  {
    if($this->checkIntervensiIndividu($request, $request->penerima_id) > 0){
      return response()->json(array('result' => false));
    }else{
      $prosesIntervensi = ProsesIntervensi::find($request->id);
      $prosesIntervensi->m_intervensi_id = $request->input('m_intervensi_id');
      $prosesIntervensi->tahun = $request->input('tahun');
      $prosesIntervensi->rujukan = $request->input('rujukan');
      $prosesIntervensi->userid = $request->input('userid');
      $prosesIntervensi->update();

      return $prosesIntervensi;
    }
  }

  public function updateIntervensiKawasan(Request $request)
  {
    if($this->checkIntervensiKawasan($request, $request->penerima_id) > 0){
      return response()->json(array('result' => false));
    }else{
      $prosesIntervensi = ProsesIntervensi::find($request->id);
      $prosesIntervensi->m_intervensi_id = $request->input('m_intervensi_id');
      $prosesIntervensi->tahun = $request->input('tahun');
      $prosesIntervensi->rujukan = $request->input('rujukan');
      $prosesIntervensi->userid = $request->input('userid');
      $prosesIntervensi->update();

      return $prosesIntervensi;
    }
  }

  public function updateIntervensiKelompok(Request $request)
  {
    if($this->checkIntervensiKelompok($request, $request->penerima_id) > 0){
      return response()->json(array('result' => false));
    }else{
      $prosesIntervensi = ProsesIntervensi::find($request->id);
      $prosesIntervensi->m_intervensi_id = $request->input('m_intervensi_id');
      $prosesIntervensi->tahun = $request->input('tahun');
      $prosesIntervensi->rujukan = $request->input('rujukan');
      $prosesIntervensi->userid = $request->input('userid');
      $prosesIntervensi->update();

      return $prosesIntervensi;
    }
  }

  private function checkIntervensiKeluarga(Request $request, $id)
  {
     $prosesIntervensi = ProsesIntervensi::where('m_intervensi_id', $request->input('m_intervensi_id'))
                                          ->where('tahun',$request->input('tahun'))
                                          ->where('penerima_id',$id)
                                          ->where('penerima_type','App\Models\PenerimaManfaat')
                                          ->count();
    return $prosesIntervensi;
  }

  private function checkIntervensiIndividu(Request $request, $id)
  {
     $prosesIntervensi = ProsesIntervensi::where('m_intervensi_id', $request->input('m_intervensi_id'))
                                          ->where('tahun',$request->input('tahun'))
                                          ->where('penerima_id',$id)
                                          ->where('penerima_type','App\Models\Keluarga')
                                          ->count();
    return $prosesIntervensi;
  }

  private function checkIntervensiKawasan(Request $request, $id)
  {
     $prosesIntervensi = ProsesIntervensi::where('m_intervensi_id', $request->input('m_intervensi_id'))
                                          ->where('tahun',$request->input('tahun'))
                                          ->where('penerima_id',$id)
                                          ->where('penerima_type','App\Models\Desa')
                                          ->count();
    return $prosesIntervensi;
  }

  private function checkIntervensiKelompok(Request $request, $id)
  {
     $prosesIntervensi = ProsesIntervensi::where('m_intervensi_id', $request->input('m_intervensi_id'))
                                          ->where('tahun',$request->input('tahun'))
                                          ->where('penerima_id',$id)
                                          ->where('penerima_type','App\Models\Kelompok')
                                          ->count();
    return $prosesIntervensi;
  }

  public function rincianStore(Request $request, $t_intervensi_id)
  {
    $t_intervensi = ProsesIntervensi::find($t_intervensi_id);

    $rincian = new RincianProsesIntervensi();
    $rincian->name = $request->input('name');
    $rincian->volume = $request->input('volume');
    $rincian->satuan = $request->input('satuan');
    $rincian->nilai = $request->input('nilai');
    $rincian->jumlah = $rincian->volume * $rincian->nilai;
    $t_intervensi->rincianIntervensi()->save($rincian);

    return $rincian;
  }

  public function rincianIndex(Request $request)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = RincianProsesIntervensi::orderBy($sortCol, $sortDir);
    }else{
      $query = RincianProsesIntervensi::orderBy('id', 'asc');
    }

    $query->where(function($q) use($request){
      $q->where('t_intervensi_id', $request->t_intervensi_id);
    });

    $perPage = $request->has('per_page') ? (int) $request->per_page : null;
    $page = $request->has('page') ? (int) $request->page : 1;

    $result = $query->paginate($perPage);

    return response()->json($result);
  }


  public function updateRincian(Request $request, $id)
  {
    $rincian = RincianProsesIntervensi::find($id);
    $rincian->name = $request->input('name');
    $rincian->volume = $request->input('volume');
    $rincian->satuan = $request->input('satuan');
    $rincian->nilai = $request->input('nilai');
    $rincian->jumlah = $rincian->volume * $rincian->nilai;
    $rincian->update();

    return $rincian;
  }

  public function deleteRincian($id)
  {
      $rincian = RincianProsesIntervensi::find($id);
      $rincian->delete();

      return $rincian;
  }

  public function edit($id)
  {
    $data = ProsesIntervensi::where('id', $id)->get();

    $result = array();
    foreach ($data as $value) {
      $penerima = $value->penerima()->first();
      $result['kk'] = $penerima->anggotaKeluarga()->where('hubungan','01')->first();

      $intervensi = $value->intervensi()->first();
      $result['program'] = $intervensi->program()->first();
      $result['intervensi'] = $intervensi;
      $result['t_intervensi'] = $value;
      $result['rincian'] = $value->rincianIntervensi()->get();
    }

    return response()->json($result);
  } 

  public function editIndividu($id)
  {
    $data = ProsesIntervensi::where('id', $id)->get();

    $result = array();
    foreach ($data as $value) {
      $penerima = $value->penerima()->first();
      $result['keluarga'] = $penerima;

      $intervensi = $value->intervensi()->first();
      $result['program'] = $intervensi->program()->first();
      $result['intervensi'] = $intervensi;
      $result['t_intervensi'] = $value;
      $result['rincian'] = $value->rincianIntervensi()->get();
    }

    return response()->json($result);
  } 

  public function editKawasan($id)
  {
    $data = ProsesIntervensi::where('id', $id)->get();

    $result = array();
    foreach ($data as $value) {
      $penerima = $value->penerima()->first();
      $result['desa'] = $penerima;

      $intervensi = $value->intervensi()->first();
      $result['program'] = $intervensi->program()->first();
      $result['intervensi'] = $intervensi;
      $result['t_intervensi'] = $value;
      $result['rincian'] = $value->rincianIntervensi()->get();
    }

    return response()->json($result);
  } 

  public function editKelompok($id)
  {
    $data = ProsesIntervensi::where('id', $id)->get();

    $result = array();
    foreach ($data as $value) {
      $penerima = $value->penerima()->first();
      $result['kelompok'] = $penerima;

      $intervensi = $value->intervensi()->first();
      $result['program'] = $intervensi->program()->first();
      $result['intervensi'] = $intervensi;
      $result['t_intervensi'] = $value;
      $result['rincian'] = $value->rincianIntervensi()->get();
    }

    return response()->json($result);
  } 



}
