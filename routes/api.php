<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
*/

Route::post('signin','Auth\AuthController@signin');

Route::group(['middleware' => 'jwt.auth'], function(){
  Route::get('user/index','Auth\AuthController@index');
  Route::post('user/store','Auth\AuthController@store');
  Route::post('user/{id}/update','Auth\AuthController@update');
  Route::get('user/{id}/edit', 'Auth\AuthController@edit');
  Route::get('user/{id}/delete','Auth\AuthController@delete');

  Route::get('role/all','Auth\RolesController@getAllRoles');
  Route::get('role/index','Auth\RolesController@index');
  Route::post('role/store','Auth\RolesController@store');
  Route::post('role/{id}/update','Auth\RolesController@update');
  Route::get('role/{id}/delete','Auth\RolesController@delete');
  Route::get('role/{id}/edit','Auth\RolesController@edit');

  Route::get('all_permission','Auth\PermissionController@getAllPermission');
  Route::get('index_permission','Auth\PermissionController@index');
  Route::post('add_permission','Auth\PermissionController@store');
  Route::post('update/{id}/edit','Auth\PermissionController@update');
  Route::get('permission/{id}/delete','Auth\PermissionController@delete');

  Route::get('kecamatan/index','DataMaster\KecamatanController@index');
  Route::post('kecamatan/store','DataMaster\KecamatanController@store');
  Route::post('kecamatan/{id}/update','DataMaster\KecamatanController@update');
  Route::get('kecamatan/{id}/delete','DataMaster\KecamatanController@delete');
  Route::get('kecamatan/ref_kecamatan','DataMaster\KecamatanController@refKecamatan');

  Route::get('desa/{id}/index','DataMaster\KecamatanController@indexDesa');
  Route::post('desa/{id}/store','DataMaster\KecamatanController@storeDesa');
  Route::post('desa/{id}/update','DataMaster\KecamatanController@updateDesa');
  Route::get('desa/{id}/delete','DataMaster\KecamatanController@deleteDesa');
  Route::get('desa/ref_desa','DataMaster\KecamatanController@refDesa');
  Route::get('desa/{kecamatan_id}/ref_desa_by_kec','DataMaster\KecamatanController@refDesaByKecamatan');

  Route::get('kategori/index','DataMaster\IndikatorController@index');
  Route::get('kategori/ref_kategori','DataMaster\IndikatorController@refKategoriIndikator');
  Route::get('indikator/dasar','DataMaster\IndikatorController@getIndikatorDasar');

  Route::get('stakeholder/ref_stakeholder','DataMaster\StakeholderController@getAllStakeholder');
  Route::get('stakeholder/index','DataMaster\StakeholderController@index');
  Route::get('stakeholder/{id}/delete','DataMaster\StakeholderController@delete');

  Route::get('program/index','DataMaster\ProgramController@index');
  Route::get('program/ref_program','DataMaster\ProgramController@refProgram');

  Route::get('sumber_dana/index','DataMaster\SumberDanaController@index');
  Route::get('sumber_dana/ref_sumber_dana','DataMaster\SumberDanaController@getAllSumberDana');

  Route::get('intervensi/index','DataMaster\IntervensiController@index');
  Route::get('intervensi/{program_id}/{sasaran_id}/intervensi_program','DataMaster\IntervensiController@getIntervensiByProgramSasaran');

  Route::get('sasaran/index','DataMaster\SasaranIntervensiController@index');
  Route::get('sasaran/ref_sasaran_intervensi','DataMaster\SasaranIntervensiController@refSasaranIntervensi');

  Route::get('pekerjaan/index','DataMaster\PekerjaanController@index');
  Route::get('pekerjaan/ref_pekerjaan','DataMaster\PekerjaanController@refPekerjaan');
  Route::get('pekerjaan/{id}/delete','DataMaster\PekerjaanController@delete');

  Route::get('pendidikan/index','DataMaster\PendidikanController@index');
  Route::get('pendidikan/ref_pendidikan','DataMaster\PendidikanController@refPendidikan');

  Route::get('kluster/index','DataMaster\KlusterController@index');

  Route::get('keluarga/ref_hubungan','PenerimaManfaat\KeluargaController@getHubungan');
  Route::get('keluarga/ref_status','PenerimaManfaat\KeluargaController@getStatus');
  Route::get('keluarga/ref_agama','PenerimaManfaat\KeluargaController@getAgama');
  Route::get('keluarga/ref_kartu','PenerimaManfaat\KeluargaController@getKartuIdentitas');
  Route::get('keluarga/ref_disabilitas','PenerimaManfaat\KeluargaController@getDisabilitas');
  Route::get('keluarga/{penerima_id}/index','PenerimaManfaat\KeluargaController@index');
  Route::post('keluarga/{penerima_id}/store','PenerimaManfaat\KeluargaController@store');
  Route::get('keluarga/{penerima_id}/kepala_keluarga','PenerimaManfaat\KeluargaController@getKepalaKeluarga');

  Route::get('penerima_indikator/{penerima_id}/index','PenerimaManfaat\TindikatorController@index');
  Route::post('penerima_indikator/{penerima_id}/store','PenerimaManfaat\TindikatorController@store');

  Route::post('penerima_manfaat/store','PenerimaManfaat\PenerimaManfaatController@store');


  Route::get('pembaharuan/index','PenerimaManfaat\PembaharuanRTMController@index');

  Route::get('program_intervensi/{penerima_id}/detail_keluarga','ProgramIntervensi\ProsesIntervensiController@detailKeluarga');
  Route::get('program_intervensi/{user_id}/ref_data','ProgramIntervensi\ProsesIntervensiController@programIntervensiRef');
  Route::post('program_intervensi/{user_id}/store','ProgramIntervensi\ProsesIntervensiController@store');
  Route::post('program_intervensi/{program_intervensi_id}/store_rincian','ProgramIntervensi\ProsesIntervensiController@rincianStore');
  Route::get('program_intervensi/{program_intervensi_id}/rincian','ProgramIntervensi\ProsesIntervensiController@rincianIndex');
  Route::get('program_intervensi/{program_intervensi_id}/intervensi_index','ProgramIntervensi\ProsesIntervensiController@intervensiIndex');



});
