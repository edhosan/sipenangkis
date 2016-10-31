<?php

namespace App\Http\Controllers\Tools;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Models\PenerimaManfaat;
use App\Models\PenilaianPenerimaManfaat;
use App\Models\IndikatorPenerimaManfaat;
use App\Models\Keluarga;

class ExportController extends Controller
{
  public function index(Request $request)
  {
  	$db_tkpk = DB::connection('mysql2');

    $query = $db_tkpk->table('survey')
				->join('kelurahan', function($join){
					$join->on('survey.id_kec','=','kelurahan.id_kec')
						 ->on('survey.id_kel','=','kelurahan.id');
		      	})
				->join('survey_anggota_keluarga', function($join_keluarga){
					$join_keluarga->on('survey_anggota_keluarga.id_survey','=','survey.id');
				})
				->where('survey.proses','2.0')
				->where('survey.export',false)
				->where('survey_anggota_keluarga.is_kk','=',1)
				->select('survey.id','survey.no_kk','survey_anggota_keluarga.nama','kelurahan.nm_kel');

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

	$result = $query->paginate($request->per_page);
	
    return response()->Json($result);
  }

  public function store(Request $request)
  {
	$db_tkpk = DB::connection('mysql2');

  	foreach ($request->data as $key => $value) {
  		$query = $db_tkpk->table('survey');	
  		$survey = $query->where('id',$value)->get();
  		$penerima_manfaat = $this->savePenerimaManfaat($survey, $request->desa_id);

  		$anggota_keluarga = $query->join('survey_anggota_keluarga','survey.id','=','survey_anggota_keluarga.id_survey')
  								  ->select('survey_anggota_keluarga.*')
  								  ->get();
  		$this->saveKeluarga($anggota_keluarga, $penerima_manfaat);

  		$indikator = $query->join('survey_indikator','survey.id','=','survey_indikator.id_survey')
  						   ->join('indikator','survey_indikator.id_indikator','=','indikator.idIndikator')
 	   					   ->select('indikator.refid','survey_indikator.nil')
 	   					   ->groupBy('refid')
 	   					   ->get();
 	   	$this->saveIndikator($indikator, $penerima_manfaat->id);

	  	$db_tkpk->table('survey')->where('id', $value)->update(['export' => true]);
  	}

  	return response()->json(array('success' => true));
  }

  private function savePenerimaManfaat($data, $desa_id)
  {
  	foreach ($data as $value) {
		$penerimaManfaat = new PenerimaManfaat();
  		$penerimaManfaat->m_desa_id = $desa_id;
	    $penerimaManfaat->rt = $value->rt;
	    $penerimaManfaat->alamat = $value->alamat;
	    $penerimaManfaat->no_rumah = $value->no_rumah;
	    $penerimaManfaat->domisili = $value->lama_domisili;
	    $penerimaManfaat->nkk = $value->no_kk;
	    $penerimaManfaat->userid = $value->petugas_input;
	
	    $penerimaManfaat->save();
  	}
 

    $hasil_indikator = new PenilaianPenerimaManfaat();
    $hasil_indikator =  $penerimaManfaat->hasilIndikator()->save($hasil_indikator);

    return $penerimaManfaat;
  }

  private function saveKeluarga($data, $penerima_manfaat)
  {
  	foreach ($data as $value) {
  		$keluarga = new Keluarga();
	    $keluarga->nik = $value->noktp;
	    $keluarga->nama = $value->nama;
	    $keluarga->sex = $value->sex;
	    $keluarga->tgl_lhr = $value->tgl_lahir;
	    $keluarga->hubungan = $this->cekHubungan($value);
	    $keluarga->hubungan_ket = $value->lainnya;

	    $penerima_manfaat->anggotaKeluarga()->save($keluarga);
  	}
  }

  private function cekHubungan($value)
  {
  	if($value->is_kk == 1){
  		return '01';
  	}else{
  		if($value->hub_kk == 'I'){
  			return '03';
  		}
  		elseif($value->hub_kk == 'L'){
  			return '11';
  		}
  		elseif($value->hub_kk == 'A'){
  			return '04';
  		}
  		elseif($value->hub_kk == 'S'){
  			return '02';
  		}
  		else{
  			return '';
  		}
  	}

  	return '';
  }

  private function saveIndikator($data, $penerima_manfaat_id)
  {
  	  $penilaian = PenilaianPenerimaManfaat::where('m_pm_id', $penerima_manfaat_id)->first();
      $penilaian->rincianIndikator()->delete();

      foreach ($data as $value) {
        $tindikator = new IndikatorPenerimaManfaat();
        $tindikator->m_indikator_id = $value->refid;
        $tindikator->value = $value->nil;

        $penilaian->rincianIndikator()->save($tindikator);
      }

      $penilaian = $this->updateHasil($penilaian);

      return $penilaian;
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

  
}
