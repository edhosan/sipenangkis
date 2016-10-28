<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Pendidikan;
use Illuminate\Pagination\LengthAwarePaginator;

class PendidikanController extends Controller
{
  public function index(Request $request)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = Pendidikan::orderBy($sortCol, $sortDir);
    }else{
      $query = Pendidikan::orderBy('id', 'asc');
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
    $pendidikan = new Pendidikan();
    $pendidikan->name = $request->input('name');
    $pendidikan->save();

    return $pendidikan;
  }

  public function update(Request $request, $id)
  {
    $pendidikan = Pendidikan::find($id);
    $pendidikan->name = $request->input('name');

    $pendidikan->update();

    return $pendidikan;
  }

  public function delete($id)
  {
    $pendidikan = Pendidikan::find($id);

    return response()->json($pendidikan->delete());
  }

  public function refPendidikan(Request $request)
  {
    if($request->has('id')){
      $pendidikan = Pendidikan::find($request->input('id'));
    }else{
        $pendidikan = Pendidikan::all(['id','name']);
    }

    $list = $pendidikan->map(
      function($pendidikan){
          return[
            'value' => $pendidikan->id,
            'label' => $pendidikan->name
          ];
      }
    );

    return $list;
  }
}
