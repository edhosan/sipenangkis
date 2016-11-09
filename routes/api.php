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
  Route::get('desa/{id}/detail','DataMaster\KecamatanController@getDetailDesa');

  Route::get('kategori/index','DataMaster\IndikatorController@index');
  Route::get('kategori/ref_kategori','DataMaster\IndikatorController@refKategoriIndikator');
  Route::get('indikator/dasar','DataMaster\IndikatorController@getIndikatorDasar');

  Route::get('stakeholder/ref_stakeholder','DataMaster\StakeholderController@getAllStakeholder');
  Route::get('stakeholder/index','DataMaster\StakeholderController@index');
  Route::get('stakeholder/{id}/delete','DataMaster\StakeholderController@delete');
  Route::post('stakeholder/store','DataMaster\StakeholderController@store');

  Route::get('program/index','DataMaster\ProgramController@index');
  Route::get('program/ref_program','DataMaster\ProgramController@refProgram');
  Route::post('program/store','DataMaster\ProgramController@store');

  Route::get('sumber_dana/index','DataMaster\SumberDanaController@index');
  Route::get('sumber_dana/ref_sumber_dana','DataMaster\SumberDanaController@getAllSumberDana');
  Route::post('sumber_dana/store','DataMaster\SumberDanaController@store');

  Route::get('intervensi/index','DataMaster\IntervensiController@index');
  Route::get('intervensi/{program_id}/{sasaran_id}/intervensi_program','DataMaster\IntervensiController@getIntervensiByProgramSasaran');
  Route::post('intervensi/{id}/update','DataMaster\IntervensiController@update');
  Route::post('intervensi/store','DataMaster\IntervensiController@store');

  Route::post('tujuan/{intervensi_id}/store','DataMaster\IntervensiController@storeTujuan');
  Route::get('tujuan/{intervensi_id}/index','DataMaster\IntervensiController@indexTujuan');


  Route::get('sasaran/index','DataMaster\SasaranIntervensiController@index');
  Route::get('sasaran/ref_sasaran_intervensi','DataMaster\SasaranIntervensiController@refSasaranIntervensi');

  Route::get('pekerjaan/index','DataMaster\PekerjaanController@index');
  Route::get('pekerjaan/ref_pekerjaan','DataMaster\PekerjaanController@refPekerjaan');
  Route::get('pekerjaan/{id}/delete','DataMaster\PekerjaanController@delete');

  Route::get('pendidikan/index','DataMaster\PendidikanController@index');
  Route::get('pendidikan/ref_pendidikan','DataMaster\PendidikanController@refPendidikan');

  Route::get('kluster/index','DataMaster\KlusterController@index');
  Route::post('kluster/store','DataMaster\KlusterController@store');
  Route::post('kluster/{id}/update','DataMaster\KlusterController@update');

  Route::get('keluarga/ref_hubungan','PenerimaManfaat\KeluargaController@getHubungan');
  Route::get('keluarga/ref_status','PenerimaManfaat\KeluargaController@getStatus');
  Route::get('keluarga/ref_agama','PenerimaManfaat\KeluargaController@getAgama');
  Route::get('keluarga/ref_kartu','PenerimaManfaat\KeluargaController@getKartuIdentitas');
  Route::get('keluarga/ref_disabilitas','PenerimaManfaat\KeluargaController@getDisabilitas');
  Route::get('keluarga/{penerima_id}/index','PenerimaManfaat\KeluargaController@index');
  Route::post('keluarga/{penerima_id}/store','PenerimaManfaat\KeluargaController@store');
  Route::get('keluarga/{penerima_id}/kepala_keluarga','PenerimaManfaat\KeluargaController@getKepalaKeluarga');
  Route::get('keluarga/{id}/detail_keluarga','PenerimaManfaat\KeluargaController@detailKeluarga');
  Route::get('keluarga/{id}/indikator_individu','PenerimaManfaat\KeluargaController@penilaianIndividu');

  Route::get('kelompok/index','PenerimaManfaat\KelompokPenerimaController@index');
  Route::get('kelompok/{id}/edit','PenerimaManfaat\KelompokPenerimaController@edit');
  Route::get('kelompok/{id}/delete','PenerimaManfaat\KelompokPenerimaController@destroy');
  Route::post('kelompok/store','PenerimaManfaat\KelompokPenerimaController@store');
  Route::post('kelompok/{id}/update','PenerimaManfaat\KelompokPenerimaController@update');
  Route::get('kelompok/penerima/index','PenerimaManfaat\KelompokPenerimaController@kelompokManfaat');
  Route::get('kelompok/keluarga/index','PenerimaManfaat\KelompokPenerimaController@penerimaManfaat');
  Route::get('kelompok/penerima/{id}/delete','PenerimaManfaat\KelompokPenerimaController@destroyPenerima');
  Route::post('kelompok/penerima/store','PenerimaManfaat\KelompokPenerimaController@storePenerima');

  Route::get('penerima_indikator/{penerima_id}/index','PenerimaManfaat\TindikatorController@index');
  Route::post('penerima_indikator/{penerima_id}/store','PenerimaManfaat\TindikatorController@store');
  Route::get('penerima_indikator/{penerima_id}/new','PenerimaManfaat\TindikatorController@newIndikator');
  Route::get('penerima_indikator/{id}/delete','PenerimaManfaat\TindikatorController@deleteIndikator');

  Route::post('penerima_manfaat/store','PenerimaManfaat\PenerimaManfaatController@store');
  Route::get('penerima_manfaat/{id}/index','PenerimaManfaat\PenerimaManfaatController@getPenerimaManfaat');

  Route::get('pembaharuan/index','PenerimaManfaat\PembaharuanRTMController@index');
  Route::get('pembaharuan/{id}/delete','PenerimaManfaat\PembaharuanRTMController@delete');

  Route::get('program_intervensi/{penerima_id}/detail_keluarga','ProgramIntervensi\ProsesIntervensiController@detailKeluarga');
  Route::get('program_intervensi/{user_id}/ref_data','ProgramIntervensi\ProsesIntervensiController@programIntervensiRef');
  Route::post('program_intervensi/{user_id}/store','ProgramIntervensi\ProsesIntervensiController@store');
  Route::post('program_intervensi/{id}/store_individu','ProgramIntervensi\ProsesIntervensiController@storeIndividu');
  Route::post('program_intervensi/{id}/store_kawasan','ProgramIntervensi\ProsesIntervensiController@storeKawasan');
  Route::post('program_intervensi/{id}/store_kelompok','ProgramIntervensi\ProsesIntervensiController@storeKelompok');
  Route::post('program_intervensi/{program_intervensi_id}/store_rincian','ProgramIntervensi\ProsesIntervensiController@rincianStore');
  Route::get('program_intervensi/rincian','ProgramIntervensi\ProsesIntervensiController@rincianIndex');
  Route::get('program_intervensi/detail_intervensi_keluarga','ProgramIntervensi\ProsesIntervensiController@detailIntervensi');
  Route::get('program_intervensi/index_keluarga','ProgramIntervensi\ProsesIntervensiController@intervensiKeluarga');
  Route::get('program_intervensi/{id}/edit','ProgramIntervensi\ProsesIntervensiController@edit');
  Route::get('program_intervensi/{id}/edit_individu','ProgramIntervensi\ProsesIntervensiController@editIndividu');
  Route::get('program_intervensi/{id}/edit_kawasan','ProgramIntervensi\ProsesIntervensiController@editKawasan');
  Route::get('program_intervensi/{id}/edit_kelompok','ProgramIntervensi\ProsesIntervensiController@editKelompok');
  Route::get('program_intervensi/{id}/delete_rincian','ProgramIntervensi\ProsesIntervensiController@deleteRincian');
  Route::get('program_intervensi/{id}/delete_intervensi','ProgramIntervensi\ProsesIntervensiController@deleteIntervensi');
  Route::post('program_intervensi/{id}/update_rincian','ProgramIntervensi\ProsesIntervensiController@updateRincian');
  Route::post('program_intervensi/update_intervensi_keluarga','ProgramIntervensi\ProsesIntervensiController@updateIntervensiKeluarga');
  Route::post('program_intervensi/update_intervensi_individu','ProgramIntervensi\ProsesIntervensiController@updateIntervensiIndividu');
  Route::post('program_intervensi/update_intervensi_kawasan','ProgramIntervensi\ProsesIntervensiController@updateIntervensiKawasan');
  Route::post('program_intervensi/update_intervensi_kelompok','ProgramIntervensi\ProsesIntervensiController@updateIntervensiKelompok');
  Route::get('program_intervensi/index_individu','ProgramIntervensi\ProsesIntervensiController@intervensiIndividu');
  Route::get('program_intervensi/index_kawasan','ProgramIntervensi\ProsesIntervensiController@intervensiKawasan');
  Route::get('program_intervensi/index_kelompok','ProgramIntervensi\ProsesIntervensiController@intervensiKelompok');


  Route::get('tools/export/index','Tools\ExportController@index');
  Route::post('tools/export/store','Tools\ExportController@store');

  Route::get('dashboard','DashboardController@index');


});






