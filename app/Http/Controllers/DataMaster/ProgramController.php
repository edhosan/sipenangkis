<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Stakeholders;
use App\Models\SumberDana;
use App\Models\Program;
use App\Models\Intervensi;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class ProgramController extends Controller
{
  public function index(Request $request)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = Program::with('stakeholders','sumberDana')->orderBy($sortCol, $sortDir);
    }else{
      $query = Program::with('stakeholders','sumberDana')->orderBy('id', 'asc');
    }

    if($request->exists('filter')){
      $query->where(function($q) use($request){
        $value = "%{$request->filter}%";
        $q->where('name', 'like', $value)
          ->orWhere('id','like',$value);
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
    $program = new Program();
    $program->name = $request->input('name');
    $program->save();

    foreach($request->input('stakeholders') as $key => $value ){
      $program->stakeholders()->attach($value['value']);
    }

    foreach($request->input('sumber_dana') as $key => $value ){
      $program->sumberDana()->attach($value['value']);
    }

    return response()->json($request->input('stakeholders'));
  }

  public function update(Request $request, $id)
  {
    $program = Program::find($id);
    $program->name = $request->input('name');
    $program->update();

    DB::table('m_program_stakeholder')->where("m_program_id",$id)->delete();
    DB::table('m_sumber_dana_program')->where("m_program_id",$id)->delete();

    foreach($request->input('stakeholders') as $key => $value ){
      $program->stakeholders()->attach($value['value']);
    }

    foreach($request->input('sumber_dana') as $key => $value ){
      $program->sumberDana()->attach($value['value']);
    }

    return response()->json($program);
  }

  public function delete($id)
  {
    $program = Program::find($id);

    return response()->json($program->delete());
  }

  public function refProgram(Request $request)
  {
    if($request->has('id')){
      $intervensi = Intervensi::find($request->input('id'));
      $program = $intervensi->program()->get(['id','name']);
    }else{
      $program = Program::all(['id','name']);
    }

    $list = $program->map(
      function($program){
          return[
            'value' => $program->id,
            'label' => $program->name
          ];
      }
    );

    return $list;
  }

}
