<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Pekerjaan;
use Illuminate\Pagination\LengthAwarePaginator;

class PekerjaanController extends Controller
{
  public function index(Request $request)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = Pekerjaan::orderBy($sortCol, $sortDir);
    }else{
      $query = Pekerjaan::orderBy('id', 'asc');
    }

    if($request->exists('filter')){
      if($request->exists('key')){
        $query->where(function($q) use($request){
          $value = "%{$request->filter}%";
          $key = "{$request->key}";
          $q->where($key, 'like', $value)
            ->orWhere($key,'like',$value);
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

  public function store(Request $request)
  {
    $pekerjaan = new Pekerjaan();
    $pekerjaan->pekerjaan = $request->input('pekerjaan');
    $pekerjaan->save();

    return $pekerjaan;
  }

  public function update(Request $request, $id)
  {
    $pekerjaan = Pekerjaan::find($id);
    $pekerjaan->pekerjaan = $request->input('pekerjaan');

    $pekerjaan->update();

    return $pekerjaan;
  }

  public function delete($id)
  {
    $pekerjaan = Pekerjaan::find($id);

    return response()->json($pekerjaan->delete());
  }

  public function refPekerjaan(Request $request)
  {
    if($request->has('id')){
      $pekerjaan = Pekerjaan::find($request->input('id'));
    }else{
        $pekerjaan = Pekerjaan::all(['id','pekerjaan']);
    }

    $list = $pekerjaan->map(
      function($pekerjaan){
          return[
            'value' => $pekerjaan->id,
            'label' => $pekerjaan->pekerjaan
          ];
      }
    );

    return $list;
  }
}
