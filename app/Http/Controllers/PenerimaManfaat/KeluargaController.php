<?php

namespace App\Http\Controllers\PenerimaManfaat;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Models\PenerimaManfaat;
use Illuminate\Pagination\LengthAwarePaginator;

class KeluargaController extends Controller
{
  public function getAgama()
  {
    $list = [
      ['value'=>'1', 'label'=>'Islam'],
      ['value'=>'2', 'label'=>'Kristen'],
      ['value'=>'3', 'label'=>'Protestan'],
      ['value'=>'4', 'label'=>'Hindu'],
      ['value'=>'5', 'label'=>'Budha'],
      ['value'=>'6', 'label'=>'Konghucu']
    ];

    return response()->json($list);
  }

  public function getStatus()
  {
    $list = [
      ['value'=>'1', 'label'=>'Belum Kawin'],
      ['value'=>'2', 'label'=>'Kawin'],
      ['value'=>'3', 'label'=>'Cerai Hidup'],
      ['value'=>'4', 'label'=>'Cerai Mati'],
      ['value'=>'5', 'label'=>'Hidup Bersama']
    ];

    return response()->json($list);
  }

  public function getHubungan()
  {
    $list = [
      ['value'=>'01', 'label'=>'Kepala Keluarga'],
      ['value'=>'02', 'label'=>'Suami'],
      ['value'=>'03', 'label'=>'Istri'],
      ['value'=>'04', 'label'=>'Anak'],
      ['value'=>'05', 'label'=>'Menantu'],
      ['value'=>'06', 'label'=>'Cucu'],
      ['value'=>'07', 'label'=>'Orangtua'],
      ['value'=>'08', 'label'=>'Mertua'],
      ['value'=>'09', 'label'=>'Famili Lain'],
      ['value'=>'10', 'label'=>'Pembantu'],
      ['value'=>'11', 'label'=>'Lainnya'],
    ];

    return response()->json($list);
  }

  public function getKartuIdentitas()
  {
    $list = [
      ['value'=>'0', 'label'=>'Tidak Ada'],
      ['value'=>'1', 'label'=>'KTP'],
      ['value'=>'2', 'label'=>'SIM'],
      ['value'=>'3', 'label'=>'Kartu Pelajar'],
      ['value'=>'4', 'label'=>'Akta Lahir']
    ];

    return response()->json($list);
  }

  public function getDisabilitas()
  {
    $list = [
      ['value'=>'00', 'label'=>'Tidak Disabilitas'],
      ['value'=>'01', 'label'=>'Penglihatan'],
      ['value'=>'02', 'label'=>'Pendengaran'],
      ['value'=>'03', 'label'=>'Komunikasi'],
      ['value'=>'04', 'label'=>'Cacat Tubuh'],
      ['value'=>'05', 'label'=>'Cacat Mental']
    ];

    return response()->json($list);
  }

  public function store(Request $request, $id)
  {
    $penerimaManfaat = PenerimaManfaat::find($id);

    $keluarga = new Keluarga();
    $keluarga->nik = $request->input('nik');
    $keluarga->nama = $request->input('nama');
    $keluarga->sex = $request->input('sex');
    $keluarga->tgl_lhr = $request->input('tgl_lhr');
    $keluarga->tempat_lhr = $request->input('tempat_lhr');
    $keluarga->agama = $request->input('agama');
    $keluarga->status = $request->input('status');
    $keluarga->hubungan = $request->input('hubungan');
    $keluarga->hubungan_ket = $request->input('hubungan_ket');
    $keluarga->akta_nikah = $request->input('akta_nikah');
    $keluarga->kartu_identitas = $request->input('kartu_identitas');
    $keluarga->disabilitas_jenis = $request->input('disabilitas_jenis');
    $keluarga->disabilitas_kategori = $request->input('disabilitas_kategori');
    $keluarga->penyakit_kronis = $request->input('penyakit_kronis');
    $keluarga->nama_sekolah = $request->input('nama_sekolah');
    $keluarga->m_pekerjaan_id = $request->input('m_pekerjaan_id');
    $keluarga->m_pendidikan_id = $request->input('m_pendidikan_id');

    return $penerimaManfaat->anggotaKeluarga()->save($keluarga);
  }

  public function index(Request $request, $id)
  {
    if($request->has('sort')){
      list($sortCol, $sortDir) = explode('|', $request->sort);
      $query = Keluarga::where('m_penerima_manfaat_id',$id)->with('pekerjaan','pendidikan')->orderBy($sortCol, $sortDir);
    }else{
      $query = Keluarga::where('m_penerima_manfaat_id')->with('pekerjaan','pendidikan')->orderBy('hubungan', 'asc');
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

  public function update(Request $request,$m_penerima_manfaat_id,$id)
  {
    $keluarga = Keluarga::where('m_penerima_manfaat_id',$m_penerima_manfaat_id)
                        ->where('id',$id)
                        ->first();
    $keluarga->nik = $request->input('nik');
    $keluarga->nama = $request->input('nama');
    $keluarga->sex = $request->input('sex');
    $keluarga->tgl_lhr = $request->input('tgl_lhr');
    $keluarga->tempat_lhr = $request->input('tempat_lhr');
    $keluarga->agama = $request->input('agama');
    $keluarga->status = $request->input('status');
    $keluarga->hubungan = $request->input('hubungan');
    $keluarga->hubungan_ket = $request->input('hubungan_ket');
    $keluarga->akta_nikah = $request->input('akta_nikah');
    $keluarga->kartu_identitas = $request->input('kartu_identitas');
    $keluarga->disabilitas_jenis = $request->input('disabilitas_jenis');
    $keluarga->disabilitas_kategori = $request->input('disabilitas_kategori');
    $keluarga->penyakit_kronis = $request->input('penyakit_kronis');
    $keluarga->nama_sekolah = $request->input('nama_sekolah');
    $keluarga->m_pekerjaan_id = $request->input('m_pekerjaan_id');
    $keluarga->m_pendidikan_id = $request->input('m_pendidikan_id');
    $keluarga->update();

    return $keluarga;
  }

  public function delete($m_penerima_manfaat_id,$id)
  {
    $keluarga = Keluarga::where('m_penerima_manfaat_id',$m_penerima_manfaat_id)
                        ->where('id',$id)
                        ->first();
    return response()->json($keluarga->delete());
  }

  public function getKepalaKeluarga($penerima_id)
  {
    $keluarga = Keluarga::where('m_penerima_manfaat_id', $penerima_id)
                        ->where('hubungan','01')
                        ->first();

    return $keluarga;
  }


}
