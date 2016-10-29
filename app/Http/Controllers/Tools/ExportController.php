<?php

namespace App\Http\Controllers\Tools;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class ExportController extends Controller
{
  public function index(Request $request)
  {
  	$db_tkpk = DB::connection('mysql2');

    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = $db_tkpk->table('survey')
      					->join('kelurahan', function($join){
      						$join->on('survey.id_kec','=','kelurahan.id_kec')
      							 ->on('survey.id_kel','=','kelurahan.id');
					      })
      					->join('survey_anggota_keluarga', function($join_keluarga){
      						$join_keluarga->on('survey_anggota_keluarga.id_survey','=','survey.id');
      					})
      					->where('survey.proses','2.0')
      					->where('survey_anggota_keluarga.is_kk','=',1)
      					->select('survey.id','survey.no_kk','survey_anggota_keluarga.nama')
      					->orderBy($sortCol, $sortDir);
    }else{
      $query =  $db_tkpk->table('survey')
      					->join('kelurahan', function($join){
      						$join->on('survey.id_kec','=','kelurahan.id_kec')
      							 ->on('survey.id_kel','=','kelurahan.id');
					      })
					  	->join('survey_anggota_keluarga', function($join_keluarga){
      						$join_keluarga->on('survey_anggota_keluarga.id_survey','=','survey.id');      									 
      					})      					
      					->where('survey.proses','2.0')
      					->where('survey_anggota_keluarga.is_kk','=',1)
      					->select('survey.id','survey.no_kk','survey_anggota_keluarga.nama')
					    ->orderBy('id', 'asc');
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
}
