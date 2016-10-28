<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\SasaranIntervensi;

class SasaranIntervensiController extends Controller
{
  public function index(Request $request)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = SasaranIntervensi::orderBy($sortCol, $sortDir);
    }else{
      $query = SasaranIntervensi::orderBy('id', 'asc');
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
    $sasaran = new SasaranIntervensi();
    $sasaran->name = $request->input('name');
    $sasaran->save();

    return $sasaran;
  }

  public function update(Request $request, $id)
  {
    $sasaran = SasaranIntervensi::find($id);
    $sasaran->name = $request->input('name');

    $sasaran->update();

    return $sasaran;
  }

  public function delete($id)
  {
    $sasaran = SasaranIntervensi::find($id);

    return response()->json($sasaran->delete());
  }

  public function refSasaranIntervensi(Request $request)
  {
    if($request->has('id')){
      $sasaran = SasaranIntervensi::find($request->input('id'));
    }else{
        $sasaran = SasaranIntervensi::all(['id','name']);
    }

    $list = $sasaran->map(
      function($sasaran){
          return[
            'value' => $sasaran->id,
            'label' => $sasaran->name
          ];
      }
    );

    return $list;
  }

}
