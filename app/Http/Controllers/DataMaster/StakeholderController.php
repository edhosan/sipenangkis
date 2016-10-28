<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Stakeholders;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;
use App\Models\Program;

class StakeholderController extends Controller
{
  public function index(Request $request)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = Stakeholders::with('program')->orderBy($sortCol, $sortDir);
    }else{
      $query = Stakeholders::with('program')->orderBy('id', 'asc');
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
    $stakeholder = new Stakeholders();
    $stakeholder->name = $request->input('name');
    $stakeholder->save();

    return $stakeholder;
  }

  public function update(Request $request, $id)
  {
    $stakeholder = Stakeholders::find($id);
    $stakeholder->name = $request->input('name');

    $stakeholder->update();

    return $stakeholder;
  }

  public function delete($id)
  {
    $stakeholder = Stakeholders::find($id);

    return response()->json($stakeholder->delete());
  }

  public function getAllStakeholder(Request $request)
  {
    if($request->has('id')){
      $program = Program::find($request->input('id'));
      $stakeholders = $program->stakeholders()->get(['id','name']);
    }else{
      $stakeholders = Stakeholders::all(['id','name']);
    }

    $list = $stakeholders->map(
      function($stakeholders){
          return[
            'value' => $stakeholders->id,
            'label' => $stakeholders->name
          ];
      }
    );

    return $list;
  }


}
