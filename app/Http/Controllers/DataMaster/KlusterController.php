<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Kluster;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class KlusterController extends Controller
{
  public function index(Request $request)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = Kluster::with('kategoriIndikator')->orderBy($sortCol, $sortDir);
    }else{
      $query = Kluster::with('kategoriIndikator')->orderBy('id', 'asc');
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

  public function store(Request $request)
  {
    $kluster = new Kluster();
    $kluster->name = $request->input('name');
    $kluster->min = $request->input('min');
    $kluster->max = $request->input('max');
    $kluster->icon = $request->input('icon');
    $kluster->class = $request->input('class');
    $kluster->save();

    foreach ($request->input('kategori') as $key => $value) {
      $kluster->kategoriIndikator()->attach($value['value']);
    }

    return $kluster;
  }

  public function update(Request $request, $id)
  {
    $kluster = Kluster::find($id);
    $kluster->name = $request->input('name');
    $kluster->min = $request->input('min');
    $kluster->max = $request->input('max');
    $kluster->icon = $request->input('icon');
    $kluster->class = $request->input('class');
    $kluster->update();

    DB::table('m_kluster_m_kategori')->where('m_kluster_m_kategori.m_kluster_id',$id)->delete();

    foreach ($request->input('kategori') as $key => $value) {
      $kluster->kategoriIndikator()->attach($value['value']);
    }

    return $kluster;
  }

  public function delete($id)
  {
    $kluster = Kluster::find($id);

    return response()->json($kluster->delete());
  }
}
