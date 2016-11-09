<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Kecamatan;
use App\Models\Desa;
use DB;
use Illuminate\Pagination\LengthAwarePaginator;

class KecamatanController extends Controller
{
  public function store(Request $request)
  {
    $kecamatan = new Kecamatan();
    $kecamatan->name = $request->input('name');
    $kecamatan->save();

    return $kecamatan;
  }

  public function index(Request $request)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = Kecamatan::with('desa')->orderBy($sortCol, $sortDir);
    }else{
      $query = Kecamatan::with('desa')->orderBy('id', 'asc');
    }

    if($request->exists('filter')){
      $query->where(function($q) use($request){
        $value = "%{$request->filter}%";
        $q->where('m_kecamatan.name', 'like', $value)
          ->orWhere('m_desa.name','like',$value);
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

  public function update(Request $request, $id)
  {
    $kecamatan = Kecamatan::find($id);
    $kecamatan->name = $request->input('name');

    $kecamatan->update();

    return $kecamatan;
  }

  public function delete($id)
  {
    $kecamatan = Kecamatan::find($id);

    return response()->json($kecamatan->delete());
  }

  public function storeDesa(Request $request, $id)
  {
    $kecamatan = Kecamatan::find($id);

    $desa = new Desa();
    $desa->name = $request->input('name');

    return $kecamatan->desa()->save($desa);
  }

  public function indexDesa(Request $request, $id)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = Desa::where('m_kecamatan_id',$id)->orderBy($sortCol, $sortDir);
    }else{
      $query = Desa::where('m_kecamatan_id',$id)->orderBy('id', 'asc');
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

  public function updateDesa(Request $request, $id)
  {
    $desa = Desa::find($id);

    $desa->name = $request->input('name');
    $desa->update();

    return $desa;
  }

  public function deleteDesa($id)
  {
    $desa = Desa::find($id)->delete();

    return response()->json(array('data' => 'true'));
  }

  public function refKecamatan(Request $request)
  {
    if($request->has('id')){
      $kecamatan = Kecamatan::where('id',$request->input('id'))->get(['id','name']);
    }else{
      $kecamatan = Kecamatan::all(['id','name']);
    }

    $list = $kecamatan->map(
      function($kecamatan){
          return[
            'value' => $kecamatan->id,
            'label' => $kecamatan->name
          ];
      }
    );

    return $list;
  }

  public function refDesa(Request $request)
  {
    if($request->has('id')){
      $desa = Desa::where('id',$request->input('id'))->get(['id','name']);
    }else{
      $desa = Desa::all(['id','name']);
    }

    $list = $desa->map(
      function($desa){
          return[
            'value' => $desa->id,
            'label' => $desa->name
          ];
      }
    );

    return $list;
  }

  public function refDesaByKecamatan($id)
  {
    $kecamatan = Kecamatan::find($id);
    $desa = $kecamatan->desa()->get(['id','name']);

    $list = $desa->map(
      function($desa){
          return[
            'value' => $desa->id,
            'label' => $desa->name
          ];
      }
    );

    return $list;
  }

  public function getDetailDesa($id)
  {
    $query = Desa::where('id', $id)->get();

    $result = array();
    foreach ($query as $value) {
     $result['desa'] = $value;
     $result['kecamatan'] = $value->kecamatan()->first();
    }

    return response()->json($result);
  }


}
