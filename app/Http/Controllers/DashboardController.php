<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kluster;
use App\Models\Kecamatan;
use DB;

class DashboardController extends Controller
{
	public function index()
	{
		return response()->json(array(
			'total_miskin' => $this->totalMiskin(),
			'chart_wilayah' => $this->totalMiskinWilayah() 
			));
	}

    public function totalMiskin()
    {
    	$query = DB::table('m_penerima_manfaat')
		          ->join('t_pm_penilaian','t_pm_penilaian.m_pm_id','=','m_penerima_manfaat.id')
		          ->join(DB::raw('(select max(t_pm_penilaian.id) id,m_pm_id from t_pm_penilaian group by m_pm_id) as tbl'), function($query){
		            $query->on('tbl.id','=','t_pm_penilaian.id');
		          })
		          ->join('m_kluster','m_kluster.id','=','t_pm_penilaian.m_kluster_id')
		          ->select('m_kluster.name','m_kluster.icon','m_kluster.class', DB::raw('count(m_penerima_manfaat.id) total'))
		          ->groupBy('t_pm_penilaian.m_kluster_id')
		          ->get();

		return $query;           
    }

    public function totalMiskinWilayah()
    {
    	$kecamatan = Kecamatan::orderBy('id','asc')->get();
    	$kluster = Kluster::orderBy('id','asc')->get();

    	$arr_kluster = array();

    	foreach ($kluster as $value) {
    		foreach ($kecamatan as $value2) {    			
	    		$data = $this->getTotalMiskinPerKlusterKec($value->id, $value2->id);
	    		foreach ($data as $value3) {
	    			$arr_kluster[$value->name][$value2->name] = $value3->total; 
	    		}
    		}
    	}

    	return array(
    		'data' => $arr_kluster
    		); 
    }

    private function getTotalMiskinPerKlusterKec($kluster_id, $kec_id)
    {
    	$query = DB::table('m_penerima_manfaat')
	          ->join('m_desa','m_desa.id','=','m_penerima_manfaat.m_desa_id')
   	          ->join('m_kecamatan','m_kecamatan.id','=','m_desa.m_kecamatan_id')
	          ->join('t_pm_penilaian','t_pm_penilaian.m_pm_id','=','m_penerima_manfaat.id')
	          ->join(DB::raw('(select max(t_pm_penilaian.id) id,m_pm_id from t_pm_penilaian group by m_pm_id) as tbl'), function($query){
	            $query->on('tbl.id','=','t_pm_penilaian.id');
	          })
	          ->join('m_kluster','m_kluster.id','=','t_pm_penilaian.m_kluster_id')
	          ->select('m_kecamatan.name', DB::raw('count(m_penerima_manfaat.id) total'))
	          ->where('m_kluster.id', $kluster_id)
	          ->where('m_kecamatan.id', $kec_id)
	          ->get();	

	    return $query;
    }


}
