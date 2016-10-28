<?php

namespace App\Http\Controllers\ProgramIntervensi;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\ProsesIntervensi;
use App\Models\PenerimaManfaat;
use App\Models\Stakeholders;
use App\Models\User;
use App\Models\RincianProsesIntervensi;
use Illuminate\Pagination\LengthAwarePaginator;

class ProsesIntervensiController extends Controller
{
  public function detailKeluarga($id)
  {
    $keluarga = PenerimaManfaat::where('id',$id)
                              ->with('desa.kecamatan')
                              ->first();

    return $keluarga;
  }

  public function intervensiIndex(Request $request, $m_intervensi_id)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = PenerimaManfaat::find($m_intervensi_id)->with('intervensi')->orderBy($sortCol, $sortDir);
    }else{
      $query = PenerimaManfaat::find($m_intervensi_id)->with('intervensi')->orderBy('id', 'asc');
    }

    $perPage = $request->has('per_page') ? (int) $request->per_page : null;
    $page = $request->has('page') ? (int) $request->page : 1;

    $result = $query->first()->intervensi->toArray();
    $offset = ($page * $perPage) - $perPage;
    $itemCurrentPage = array_slice($result, $offset, $perPage, true);
    $result = new LengthAwarePaginator($itemCurrentPage, count($result), $perPage, $page);
    $result = $result->toArray();

    return $result;
  }

  public function programIntervensiRef($user_id)
  {
    $user = User::where('userid',$user_id)
                ->with('stakeholder.program')
                ->first();

    $list_program = $user->stakeholder->program->map(
      function($program){
          return[
            'value' => $program->id,
            'label' => $program->name
          ];
      }
    );

    return response()->json(array(
        'list_program' => $list_program
      ));
  }

  public function store(Request $request, $id)
  {
    if($this->checkIntervensiKeluarga($request, $id) > 0){
      return response()->json(array('result' => false));
    }else{
      $penerimaManfaat = PenerimaManfaat::where('id',$id)->first();

      $prosesIntervensi = new ProsesIntervensi();
      $prosesIntervensi->m_intervensi_id = $request->input('m_intervensi_id');
      $prosesIntervensi->tahun = $request->input('tahun');
      $prosesIntervensi->rujukan = $request->input('rujukan');
      $prosesIntervensi->userid = $request->input('userid');

      $penerimaManfaat->intervensi()->save($prosesIntervensi);

      return $prosesIntervensi;
    }
  }

  private function checkIntervensiKeluarga(Request $request, $id)
  {
     $prosesIntervensi = ProsesIntervensi::where('m_intervensi_id', $request->input('m_intervensi_id'))
                                          ->where('tahun',$request->input('tahun'))
                                          ->where('penerima_id',$id)
                                          ->where('penerima_type','App\Models\PenerimaManfaat')
                                          ->count();
    return $prosesIntervensi;
  }

  public function rincianStore(Request $request, $t_intervensi_id)
  {
    $t_intervensi = ProsesIntervensi::find($t_intervensi_id);

    $rincian = new RincianProsesIntervensi();
    $rincian->name = $request->input('name');
    $rincian->volume = $request->input('volume');
    $rincian->satuan = $request->input('satuan');
    $rincian->nilai = $request->input('nilai');
    $rincian->jumlah = $rincian->volume * $rincian->nilai;
    $t_intervensi->rincianIntervensi()->save($rincian);

    return $rincian;
  }

  public function rincianIndex(Request $request, $t_intervensi_id)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = RincianProsesIntervensi::where('t_intervensi_id', $t_intervensi_id)->orderBy($sortCol, $sortDir);
    }else{
      $query = RincianProsesIntervensi::where('t_intervensi_id', $t_intervensi_id)->orderBy('id', 'asc');
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


  public function updateRincian(Request $request, $id)
  {
    $rincian = RincianProsesIntervensi::find($id);
    $rincian->name = $request->input('name');
    $rincian->volume = $request->input('volume');
    $rincian->satuan = $request->input('satuan');
    $rincian->nilai = $request->input('nilai');
    $rincian->jumlah = $rincian->volume * $rincian->nilai;
    $rincian->update();

    return $rincian;
  }

  public function deleteRincian($id)
  {
      $rincian = RincianProsesIntervensi::find($id);
      $rincian->delete();

      return $rincian;
  }

}
