<?php

use App\Http\Controllers\absenController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\hrdController;
use App\Http\Controllers\dataController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardAbsenController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\KandidatController;
use App\Http\Controllers\SewaKendaraanController;
use App\Http\Controllers\MedicalController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\TeamScheduleDataTable;

Route::get('/', function () {
    return view('welcome');
});






Route::middleware(['auth'])->group(function () {

  Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
  Route::get('/home', function () {
    return view('home');
  })->name('home');
// Absen
Route::get('/presensi/create', [PresensiController::class, 'create'])->name('presensiCreate');
Route::post('/presensi/store', [PresensiController::class, 'store'])->name('presensiStore');



Route::get('/dashboardAbsen', [DashboardAbsenController::class, 'index'])->name('dashboardAbsen');
Route::get('teamschedule/teamschedule', [TeamScheduleDataTable::class, 'teamschedule'])->name('teamschedule.teamschedule');
Route::resource('teamschedule', TeamScheduleDataTable::class);
Route::get('/schedule-list', [EventController::class,'getScheduleList'])->name('schedule.list');

  Route::get('/events/get-job-title', [EventController::class, 'getJobTitle'])->name('events.getJobTitle');
  Route::resource('events', EventController::class)->only(['index', 'store', 'update', 'destroy','show']);





        Route::get('medical', [MedicalController::class, 'index'])->name('medical.index'); // Add this line
        Route::get('medical/{medical}', [MedicalController::class, 'show'])->name('medical.show');
    // Add patient to medical claim
    Route::get('medical/{id}/add-patient', [MedicalController::class, 'create'])->name('medical.create_patient');
    Route::post('medical', [MedicalController::class, 'store'])->name('medical.store');
    Route::get('medical/{medical}/edit', [MedicalController::class, 'edit'])->name('medical.edit');
    Route::put('medical/{medical}', [MedicalController::class, 'update'])->name('medical.update');
    Route::delete('medical/{medical}', [MedicalController::class, 'destroy'])->name('medical.destroy');

    // Get medical data for DataTables
    Route::get('medical/detail/{medical}/data', [MedicalController::class, 'getMedicalData'])->name('medical.detail.data');


    Route::get('/hrdJson', [GajiController::class, 'hrdJson'])->name('hrdJson');

    Route::get('medical/{id}/add-patient', [MedicalController::class, 'create'])->name('medical.create_patient');

   // Rute untuk menampilkan data karyawan yang telah dihapus (Soft Delete)
    Route::get('/hrd/deleted', [hrdController::class, 'showDeletedData'])->name('hrd.showDeletedData');

    // Rute untuk mengembalikan data karyawan yang telah dihapus
    Route::patch('/hrd/restore/{id}', [hrdController::class, 'restoreHrdData'])->name('hrd.restore');

    Route::get('datakaryawan', [dataController::class, 'datakry'])->name('datakaryawan.datakry');
    Route::get('datakaryawanAjax', [hrdController::class, 'index'])->name('datakaryawanAjax.index');
    Route::get('datakaryawanAjax/export/excel', [hrdController::class, 'exportExcel'])->name('export.kry');

    Route::get('datakandidat', [dataController::class, 'datakdt'])->name('datakaryawan.datakdt');
    Route::get('datakandidat/{id}/edit', [KandidatController::class, 'edit'])->name('datakandidat.edit');
    Route::patch('datakandidat/{id}', [KandidatController::class, 'update'])->name('datakandidat.update');
    Route::get('dataStatus', [dataController::class, 'dataStatus'])->name('datakaryawan.dataStatus');
    Route::get('statusData', [dataController::class, 'statusData'])->name('kandidat.dataStatus');
    Route::get('kandidat', [KandidatController::class, 'index'])->name('kandidat.index');
    Route::get('statuskandidat', [KandidatController::class, 'status'])->name('statuskandidat.status');
    Route::get('/datakandidat/create', [KandidatController::class, 'create'])->name('datakandidat.create');
    Route::get('/statusKdt/create', [KandidatController::class, 'createStatus'])->name('statusKdt.create');
    Route::post('kandidatStore', [KandidatController::class, 'store'])->name('kandidat.store');
    Route::post('statusTambah', [KandidatController::class, 'storeStatus'])->name('tambahStatus.store');
    Route::get('statusKdt/{id}/edit', [dataController::class, 'editStatus'])->name('statusKdt.edit');
    Route::patch('statusKdt/{id}', [dataController::class, 'updateStatus'])->name('updateKdt.update');

    //cari gaji
    Route::get('/cari-gaji', [GajiController::class,'cari'])->name('gaji.cari');
    Route::get('hasilGaji', [dataController::class,'dataCari'])->name('hasil.cari-gaji');
    Route::get('detailCari/{id}/show', [GajiController::class,'detailCari'])->name('detail.cari');
    Route::get('gaji/export/excel', [GajiController::class,'exportExcel'])->name('export.gaji');
    Route::get('gaji/related-data/{hrd_id}', [dataController::class, 'relatedData'])->name('gaji.related-data');







    Route::get('/hrdJsonEdit/{id}', [GajiController::class, 'hrdJsonEdit'])->name('hrdJsonEdit');

        Route::resource('adminController', AdminController::class);


        //sewakendaraan

        // Menampilkan halaman indeks
        Route::get('SewaKendaraan', [SewaKendaraanController::class, 'index'])->name('SewaKendaraan.index');

        // Menampilkan halaman formulir untuk membuat data baru
        Route::get('SewaKendaraan/create', [SewaKendaraanController::class, 'create'])->name('SewaKendaraan.create');

        // Menyimpan data baru ke database
        Route::post('SewaKendaraan', [SewaKendaraanController::class, 'store'])->name('SewaKendaraan.store');

        // Menampilkan halaman detail data
        Route::get('SewaKendaraan/{id}', [SewaKendaraanController::class, 'show'])->name('SewaKendaraan.show');

        // Menampilkan halaman formulir untuk mengedit data
        Route::get('SewaKendaraan/{id}/edit', [SewaKendaraanController::class, 'edit'])->name('SewaKendaraan.edit');

        // Menyimpan perubahan data yang telah di-edit ke database
        Route::put('SewaKendaraan/{id}', [SewaKendaraanController::class, 'update'])->name('SewaKendaraan.update');

        // Menyimpan perubahan data yang telah di-edit ke database (untuk beberapa kasus)
        Route::patch('SewaKendaraan/{id}', [SewaKendaraanController::class, 'update']);

        // Menghapus data dari database
        Route::delete('SewaKendaraan/{id}', [SewaKendaraanController::class, 'destroy'])->name('SewaKendaraan.destroy');





        //Data Karyawan
        Route::get('/datakaryawanAjax/create', [hrdController::class, 'create'])->name('datakaryawanAjax.create');
        Route::post('datakaryawanAjax', [hrdController::class, 'store'])->name('datakaryawanAjax.store');

        Route::patch('datakaryawanAjax/{id}', [hrdController::class, 'update'])->name('datakaryawanAjax.update');
        Route::delete('datakaryawanAjax/{id}', [hrdController::class, 'destroy'])->name('datakaryawanAjax.destroy');



        Route::get('datakaryawanAjax/{id}/edit', [HrdController::class, 'edit'])->name('datakaryawanAjax.edit');


//Gaji

// Menampilkan halaman indeks
Route::get('gajiAjax', [GajiController::class, 'index'])->name('gajiAjax.index');

// Menampilkan halaman formulir untuk membuat data baru
Route::get('gajiAjax/create', [GajiController::class, 'create'])->name('gajiAjax.create');

// Menyimpan data baru ke database
Route::post('gajiAjax', [GajiController::class, 'store'])->name('gajiAjax.store');

// Menampilkan halaman detail data
Route::get('gajiAjax/{id}', [GajiController::class, 'show'])->name('gajiAjax.show');

// Menampilkan halaman formulir untuk mengedit data
Route::get('gajiAjax/{id}/edit', [GajiController::class, 'edit'])->name('gajiAjax.edit');

// Menyimpan perubahan data yang telah di-edit ke database
Route::put('gajiAjax/{id}', [GajiController::class, 'update'])->name('gajiAjax.update');

// Menyimpan perubahan data yang telah di-edit ke database (untuk beberapa kasus)
Route::patch('gajiAjax/{id}', [GajiController::class, 'update']);

// Menghapus data dari database
Route::delete('gajiAjax/{id}', [GajiController::class, 'destroy'])->name('gajiAjax.destroy');



        Route::get('/hrdJson', [GajiController::class, 'hrdJson'])->name('hrdJson');

    Route::middleware(['role:it|manager'])->group(function () {

    });
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
