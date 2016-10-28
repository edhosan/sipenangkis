<?php

namespace App\Http\Controllers\DataMaster;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\KategoriIndikator;
use App\Models\Indikator;
use App\Models\Jawaban;
use Illuminate\Pagination\LengthAwarePaginator;
use DB;

class IndikatorController extends Controller
{
  public function index(Request $request)
  {
    $query = KategoriIndikator::with('indikator')
                ->orderBy('id', 'asc');
    $result = $query->get();

    $data = array();
    foreach ($result as $key => $value) {
      $data[$value->name] = Indikator::where('m_kategori_indikator_id',$value->id)
                                    ->with('kategori')
                                    ->with('jawaban')
                                    ->get();
    }

    return $data;
  }

  public function getIndikatorDasar(Request $request)
  {
    $query = KategoriIndikator::with('indikator')
                ->whereIn('id',[5,6,8])
                ->orderBy('id', 'asc');

    $result = $query->get();

    $data = array();
    foreach ($result as $key => $value) {
      $data[$value->name] = Indikator::where('m_kategori_indikator_id',$value->id)
                                    ->with('kategori')
                                    ->with('jawaban')
                                    ->get();
    }

    return $data;
  }

  public function store(Request $request)
  {
    $kategori = new KategoriIndikator();
    $kategori->name = $request->input('name');
    $kategori->save();

    return response()->json($kategori);
  }

  public function update(Request $request, $id)
  {
    $kategori = KategoriIndikator::find($id);
    $kategori->name = $request->input('name');
    $kategori->update();

    return response()->json($kategori);
  }

  public function delete($id)
  {
    $kategori = KategoriIndikator::find($id)->delete();

    return response()->json($kategori);
  }

  public function storeIndikator(Request $request, $id)
  {
    $indikator = new Indikator();
    $indikator->name = $request->input('name');

    $kategori = KategoriIndikator::find($id);
    return $kategori->indikator()->save($indikator);
  }

  public function updateIndikator(Request $request, $id)
  {
    $indikator = Indikator::find($id);
    $indikator->name = $request->input('name');
    $indikator->update();

    return $indikator;
  }

  public function indexIndikator(Request $request, $id)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = Indikator::where('m_kategori_indikator_id',$id)
                          ->with('jawaban')
                          ->orderBy($sortCol, $sortDir);
    }else{
      $query = Indikator::where('m_kategori_indikator_id',$id)
                        ->with('jawaban')
                        ->orderBy('id', 'asc');
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

  public function deleteIndikator($id)
  {
    $indikator = Indikator::find($id)->delete();

    return response()->json($indikator);
  }

  public function refKategoriIndikator(Request $request)
  {
    if($request->has('id')){
      $kategori = KategoriIndikator::find($request->input('id'));
    }else{
      $kategori = KategoriIndikator::all(['id','name']);
    }

    $list = $kategori->map(
      function($kategori){
          return[
            'value' => $kategori->id,
            'label' => $kategori->name
          ];
      }
    );

    return $list;
  }
}
