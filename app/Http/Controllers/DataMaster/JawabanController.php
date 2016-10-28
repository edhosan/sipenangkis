<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Jawaban;
use App\Models\Indikator;
use Illuminate\Pagination\LengthAwarePaginator;

class JawabanController extends Controller
{
  public function index(Request $request, $id)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = Jawaban::where('m_indikator_id',$id)->orderBy($sortCol, $sortDir);
    }else{
      $query = Jawaban::where('m_indikator_id', $id)->orderBy('id', 'asc');
    }

    if($request->exists('filter')){
      $query->where(function($q) use($request){
        $value = "%{$request->filter}%";
        $q->where('id', 'like', $value)
          ->orWhere('name','like',$value);
      });
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

  public function store(Request $request,$id)
  {
    $jawaban = new Jawaban();
    $jawaban->name = $request->input('name');
    $jawaban->nilai = $request->input('nilai');

    $indikator = Indikator::find($id);
    $indikator = $indikator->jawaban()->save($jawaban);

    return $indikator;
  }

  public function update(Request $request, $indikator_id, $id)
  {
    $jawaban = Jawaban::where('m_indikator_id',$indikator_id)
                      ->where('id', $id)
                      ->first();

    $jawaban->name = $request->input('name');
    $jawaban->nilai = $request->input('nilai');
    $jawaban->update();

    return $jawaban;
  }

  public function delete($indikator_id, $id)
  {
    $jawaban = Jawaban::where('m_indikator_id',$indikator_id)
                      ->where('id', $id)
                      ->first();

    return response()->json($jawaban->delete());
  }
}
