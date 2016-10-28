<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\SumberDana;
use App\Models\Program;
use Illuminate\Pagination\LengthAwarePaginator;

class SumberDanaController extends Controller
{
  public function index(Request $request)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = SumberDana::with('program')->orderBy($sortCol, $sortDir);
    }else{
      $query = SumberDana::with('program')->orderBy('id', 'asc');
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
    $sumber_dana = new SumberDana();
    $sumber_dana->name = $request->input('name');
    $sumber_dana->save();

    return $sumber_dana;
  }

  public function update(Request $request, $id)
  {
    $sumber_dana = SumberDana::find($id);
    $sumber_dana->name = $request->input('name');

    $sumber_dana->update();

    return $sumber_dana;
  }

  public function delete($id)
  {
    $sumber_dana = SumberDana::find($id);

    return response()->json($sumber_dana->delete());
  }

  public function getAllSumberDana(Request $request)
  {
    if($request->has('id')){
      $program = Program::find($request->input('id'));
      $sumber_dana = $program->sumberDana()->get(['id','name']);
    }else{
        $sumber_dana = SumberDana::all(['id','name']);
    }

    $list = $sumber_dana->map(
      function($sumber_dana){
          return[
            'value' => $sumber_dana->id,
            'label' => $sumber_dana->name
          ];
      }
    );

    return $list;
  }
}
