<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kluster;
use DB;

class DashboardController extends Controller
{
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
}
