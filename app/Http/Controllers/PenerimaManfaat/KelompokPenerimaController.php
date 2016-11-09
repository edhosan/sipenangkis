<?php 

namespace App\Http\Controllers\PenerimaManfaat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Models\Kelompok;
use App\Models\KelompokPenerima;
use DB;

class KelompokPenerimaController extends Controller {

	/**
	 * Display a listing of the resource.
	 * GET /penerimamanfaat\kelompokpenerima
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		$query = DB::table('m_kelompok')
              ->join('m_desa','m_desa.id','=','m_kelompok.m_desa_id')
              ->join('m_kecamatan','m_kecamatan.id','=','m_desa.m_kecamatan_id')
              ->leftJoin('m_kelompok_penerima','m_kelompok_penerima.m_kelompok_id','=','m_kelompok.id')
              ->select('m_kelompok.id','m_kelompok.name','m_kelompok.sk','m_desa.name as desa','m_kecamatan.name as kecamatan', 
              			DB::raw('count(m_kelompok_penerima.id) as total'))
              ->groupBy('m_kelompok.id');

	    if($request->has('sort')){
	      list($sortCol, $sortDir) = explode('|', $request->sort);
	      $query = $query->orderBy($sortCol, $sortDir);
	    }else{
	      $query = $query->orderBy('id', 'asc');
	    }

	    if($request->exists('filter')){
	      if($request->exists('key')){
	        $query->where(function($q) use($request){
	          $value = "{$request->filter}";
	          $key = "{$request->key}";
	          $q->where($key, 'like', $value);
	        });
	      }
	    }

	    $perPage = $request->has('per_page') ? (int) $request->per_page : 10;
	   
	    $result = $query->paginate($perPage);

	    return response()->json($result);

	}

	/**
	 * Show the form for creating a new resource.
	 * GET /penerimamanfaat\kelompokpenerima/create
	 *
	 * @return Response
	 */
	public function penerimaManfaat(Request $request)
	{
		$kelompok = KelompokPenerima::get(['penerima_id']);

		$query = DB::table('m_penerima_manfaat')
              ->join('m_penerima_manfaat_keluarga','m_penerima_manfaat.id','=','m_penerima_manfaat_keluarga.m_penerima_manfaat_id')
              ->join('m_desa','m_desa.id','=','m_penerima_manfaat.m_desa_id')
              ->join('m_kecamatan','m_kecamatan.id','=','m_desa.m_kecamatan_id')
              ->join('t_pm_penilaian','t_pm_penilaian.m_pm_id','=','m_penerima_manfaat.id')
              ->join(DB::raw('(select max(t_pm_penilaian.id) id,m_pm_id from t_pm_penilaian group by m_pm_id) as tbl'), function($query){
                $query->on('tbl.id','=','t_pm_penilaian.id');
              })
              ->where('m_penerima_manfaat_keluarga.hubungan','01')
              ->select('m_penerima_manfaat_keluarga.id','m_penerima_manfaat.nkk',DB::raw('concat(m_penerima_manfaat.alamat ," RT.", IFNULL(m_penerima_manfaat.rt,"")," RW.",IFNULL(m_penerima_manfaat.rw,"")) as alamat'),'m_penerima_manfaat_keluarga.nama','m_penerima_manfaat_keluarga.sex','m_kecamatan.name as kecamatan','m_desa.name as desa','t_pm_penilaian.nilai','t_pm_penilaian.kriteria');

	    if($request->has('sort')){
	      list($sortCol, $sortDir) = explode('|', $request->sort);
	      $query = $query->orderBy($sortCol, $sortDir);
	    }else{
	      $query = $query->orderBy('id', 'asc');
	    }

	    if($request->exists('filter')){
	      if($request->exists('key')){
	        $query->where(function($q) use($request){
	          $value = "{$request->filter}";
	          $key = "{$request->key}";
	          $q->where($key, '=', $value);
	        });
	      }
	    }

	    $query->whereNotIn('m_penerima_manfaat_keluarga.id', $kelompok->toArray());

	    $perPage = $request->has('per_page') ? (int) $request->per_page : 10;

	    $result = $query->paginate($perPage);

	    return response()->json($result);
	}

	public function kelompokManfaat(Request $request)
	{
		$query = DB::table('m_penerima_manfaat')
              ->join('m_penerima_manfaat_keluarga','m_penerima_manfaat.id','=','m_penerima_manfaat_keluarga.m_penerima_manfaat_id')
              ->join('m_desa','m_desa.id','=','m_penerima_manfaat.m_desa_id')
              ->join('m_kecamatan','m_kecamatan.id','=','m_desa.m_kecamatan_id')
              ->join('t_pm_penilaian','t_pm_penilaian.m_pm_id','=','m_penerima_manfaat.id')
              ->join(DB::raw('(select max(t_pm_penilaian.id) id,m_pm_id from t_pm_penilaian group by m_pm_id) as tbl'), function($query){
                $query->on('tbl.id','=','t_pm_penilaian.id');
              })
              ->join('m_kelompok_penerima','m_kelompok_penerima.penerima_id','=','m_penerima_manfaat_keluarga.id')
              ->where('m_penerima_manfaat_keluarga.hubungan','01')
              ->select('m_kelompok_penerima.id','m_penerima_manfaat.nkk',DB::raw('concat(m_penerima_manfaat.alamat ," RT.", IFNULL(m_penerima_manfaat.rt,"")," RW.",IFNULL(m_penerima_manfaat.rw,"")) as alamat'),'m_penerima_manfaat_keluarga.nama','m_penerima_manfaat_keluarga.sex','m_kecamatan.name as kecamatan','m_desa.name as desa','t_pm_penilaian.nilai','t_pm_penilaian.kriteria');

	    if($request->has('sort')){
	      list($sortCol, $sortDir) = explode('|', $request->sort);
	      $query = $query->orderBy($sortCol, $sortDir);
	    }else{
	      $query = $query->orderBy('id', 'asc');
	    }

	    if($request->exists('filter')){
	      if($request->exists('key')){
	        $query->where(function($q) use($request){
	          $value = "{$request->filter}";
	          $key = "{$request->key}";
	          $q->where($key, '=', $value);
	        });
	      }
	    }

	    $perPage = $request->has('per_page') ? (int) $request->per_page : 10;

	    $result = $query->paginate($perPage);

	    return response()->json($result);
	}

	/**
	 * Store a newly created resource in storage.
	 * POST /penerimamanfaat\kelompokpenerima
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		$kelompok = new Kelompok();
		$kelompok->m_desa_id = $request->m_desa_id;
		$kelompok->name = $request->name;
		$kelompok->sk = $request->sk;
		$kelompok->save();

		return $kelompok;
	}

	/**
	 * Display the specified resource.
	 * GET /penerimamanfaat\kelompokpenerima/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function storePenerima(Request $request)
	{
		$kelompok = Kelompok::where('id',$request->kelompok_id)->with('desa')->first();

		foreach ($request->data as $key => $value) {
			$penerima = new KelompokPenerima();
			$penerima->penerima_id = $value;

			$kelompok->penerima()->save($penerima);
		}

		return $kelompok;
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /penerimamanfaat\kelompokpenerima/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		$kelompok = Kelompok::where('id',$id)->get();

		$result = array();
		foreach ($kelompok as $value) {
			$result['kelompok'] = $value;

			$desa = $value->desa()->first();
			$result['desa'] = $desa;
			$result['kecamatan'] = $desa->kecamatan()->first();
		}

		return response()->json($result);
	}

	/**
	 * Update the specified resource in storage.
	 * PUT /penerimamanfaat\kelompokpenerima/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request, $id)
	{
		$kelompok = Kelompok::find($id);
		$kelompok->m_desa_id = $request->m_desa_id;
		$kelompok->name = $request->name;
		$kelompok->sk = $request->sk;
		$kelompok->update();

		return $kelompok;
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /penerimamanfaat\kelompokpenerima/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		$kelompok = Kelompok::find($id);

		return response()->json($kelompok->delete());
	}

	public function destroyPenerima($id)
	{
		$penerima = KelompokPenerima::find($id);

		return response()->json($penerima->delete());
	}	

}