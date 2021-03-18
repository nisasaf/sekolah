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
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::namespace('API')
    ->group(function () {
        Route::get('test', 'AuthController@test');
        Route::post('login/student', 'AuthController@studentLogin');
        Route::post('login/school', 'AuthController@schoolLogin');

        Route::get('matapelajaran', 'MataPelajaranController@read');
        Route::post('matapelajaran', 'MataPelajaranController@write');

        Route::get('home-information', 'HomeController@index');
        Route::get('library', 'LibraryController@index');
        Route::get('category', 'CategoryController@index');
        Route::resource('voting', 'VotingController');
        Route::get('posisi-kandidat', 'VotingController@posisiKandidat');
        Route::get('calon-kandidat', 'VotingController@calonKandidat');
        Route::get('sudah-voting', 'VotingController@hasVote');
        Route::get('hasil-voting', 'VotingController@getHasilVoting');
        Route::get('jadwalpelajaran', 'JadwalPelajaranController@read');
        Route::get('absensi', 'AbsensiController@read');
        Route::post('absensi', 'AbsensiController@write');

        Route::get('kelas', 'KelasController@index');
        Route::get('pelanggaran', 'PelanggaranController@index');
        Route::get('pelanggaran-siswa/{id}', 'PelanggaranController@pelanggaranSiswa');


        Route::get('sekolah/{sekolah_id}/sliders', 'SliderController@index');

        Route::get('sekolah/{sekolah_id}/sliders', 'SliderController@index');

        //Berita
        Route::get('berita', 'BeritaController@index');
        Route::get('kalender/{id}', 'KalenderController@index');
    });
