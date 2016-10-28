<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Intervensi;
use App\Models\TujuanIntervensi;
use App\Models\Program;
use Illuminate\Pagination\LengthAwarePaginator;

class IntervensiController extends Controller
{
  public function index(Request $request)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = Intervensi::with('program','tujuan','sasaran')->orderBy($sortCol, $sortDir);
    }else{
      $query = Intervensi::with('program','tujuan','sasaran')->orderBy('id', 'asc');
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
    $intervensi = new Intervensi();
    $intervensi->name = $request->input('name');
    $intervensi->m_sasaran_intervensi_id = $request->input('m_sasaran_intervensi_id');

    $program = Program::find($request->input('program_id'));
    $intervensi->program()->associate($program);

    $intervensi->save();

    return $intervensi;
  }

  public function update(Request $request, $id)
  {
    $intervensi = Intervensi::find($id);
    $intervensi->name = $request->input('name');
    $intervensi->m_sasaran_intervensi_id = $request->input('m_sasaran_intervensi_id');

    $intervensi->program()->dissociate();

    $program = Program::find($request->input('program_id'));
    $intervensi->program()->associate($program);

    $intervensi->update();

    return $intervensi;
  }

  public function delete($id)
  {
    $intervensi = Intervensi::find($id);

    return response()->json($intervensi->delete());
  }

  public function storeTujuan(Request $request, $id)
  {
    $intervensi = Intervensi::find($id);

    $tujuan = new TujuanIntervensi();
    $tujuan->name = $request->input('name');

    return $intervensi->tujuan()->save($tujuan);
  }

  public function indexTujuan(Request $request, $id)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = TujuanIntervensi::where('m_intervensi_id',$id)->orderBy($sortCol, $sortDir);
    }else{
      $query = TujuanIntervensi::where('m_intervensi_id',$id)->orderBy('id', 'asc');
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

  public function updateTujuan(Request $request, $id)
  {
    $tujuan = TujuanIntervensi::find($id);

    $tujuan->name = $request->input('name');
    $tujuan->update();

    return $tujuan;
  }

  public function deleteTujuan($id)
  {
    $tujuan = TujuanIntervensi::find($id)->delete();

    return response()->json(array('data' => 'true'));
  }

  public function getAllIntervensi()
  {
    $intervensi = Intervensi::all(['id','name']);
    $list = $intervensi->map(
      function($intervensi){
          return[
            'value' => $intervensi->id,
            'label' => $intervensi->name
          ];
      }
    );

    return $list;
  }

  public function getIntervensiByProgramSasaran($program_id, $sasaran_id)
  {
    $intervensi = Intervensi::where('m_program_id',$program_id)
                            ->where('m_sasaran_intervensi_id', $sasaran_id)
                            ->get();

    $list = $intervensi->map(
      function($intervensi){
          return[
            'value' => $intervensi->id,
            'label' => $intervensi->name
          ];
      }
    );

    return $list;
  }
}
