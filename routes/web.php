<?php

use App\Http\Controllers\DashboardUPPSController;
use App\Http\Controllers\DashboardAsesorController;
use App\Http\Controllers\DashboardProdiController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProdiController;
use App\Http\Controllers\UserAsesorController;
use App\Http\Controllers\JenisController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\InstrumenAsesorController;
use App\Http\Controllers\NilaiAsesmenLapanganD3Controller;
use App\Http\Controllers\NilaiDeskEvalController;
use App\Http\Controllers\RekapPenilaianController;
use App\Http\Controllers\InstrumenController;
use App\Http\Controllers\MatriksPenilaianController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\DataDukungUppsController;
use App\Http\Controllers\DataDukungAsesorController;
use App\Http\Controllers\DataDukungProdiController;
use App\Http\Controllers\SuplemenController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\InstrumenProdiController;
use App\Http\Controllers\NilaiProdiController;
use App\Http\Controllers\AjuanUppsController;
use App\Http\Controllers\AjuanProdiController;
use App\Http\Controllers\AjuanAsesorController;
use App\Http\Controllers\ProgramStudiController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\AkreditasiController;
use App\Http\Controllers\SettingTahunController;
use App\Http\Controllers\ImportLkpsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::get('/forgot-password', [LoginController::class, 'forgotpw'])->name('forgot-password');
    Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('password.resetPassword');
    Route::get('/reset-password/{token}', [LoginController::class, 'reset'])->name('password.reset');
    Route::post('/password-email', [LoginController::class, 'pwEmail'])->name('password-email.pwEmail');
    Route::post('/login/auth', [LoginController::class, 'auth'])->name('login.auth');
});

Route::group(["middleware" => ["autentikasi"]], function () {
    Route::group(["middleware" => ["can:UPPS"]], function () {
        Route::post('tahun-akreditasi/selesai/{id}', [DashboardUPPSController::class, 'selesai'])->name('tahun-akreditasi.selesai');
        Route::get('tahun-akreditasi/json', [DashboardUPPSController::class, 'json'])->name('tahun-akreditasi.json');
        Route::get('sertifikat/sertifTable', [DashboardUPPSController::class, 'sertifTable'])->name('sertifikat.sertifTable');
        Route::get('berita-acara/deskEvalTable', [DashboardUPPSController::class, 'deskEvalTable'])->name('berita-acara.deskEvalTable');
        Route::get('berita-acara/asesmenLapanganTable', [DashboardUPPSController::class, 'asesmenLapanganTable'])->name('berita-acara.asesmenLapanganTable');
        Route::post('tahun-akreditasi/store', [DashboardUPPSController::class, 'store'])->name('tahun-akreditasi.store');
        Route::resource('dashboard-UPPS', DashboardUPPSController::class);

        Route::post('akreditasi/asesmen-kecukupan/{id}', [AkreditasiController::class, 'selesai_ak'])->name('ak.selesai');
        Route::post('akreditasi/approve_ak/{id}', [AkreditasiController::class, 'approve_ak'])->name('ak.approve');
        Route::post('akreditasi/disapprove_ak/{id}', [AkreditasiController::class, 'disapprove_ak'])->name('ak.disapprove');
        Route::post('akreditasi/dokumen_ajuan/{id}', [AkreditasiController::class, 'selesai'])->name('dokumen_selesai');
        Route::post('akreditasi/approve/{id}/{type?}', [AkreditasiController::class, 'approve'])->name('dokumen_approve');
        Route::post('akreditasi/disapprove/{id}', [AkreditasiController::class, 'disapprove'])->name('dokumen_disapprove');
        Route::get('akreditasi/asesmen-kecukupan/show/rekap/{id}', [AkreditasiController::class, 'rekap'])->name('akreditasi.asesmenKecukupan.rekap');
        Route::get('akreditasi/asesmen-kecukupan/show/{id}/{id_krit}', [AkreditasiController::class, 'detail'])->name('akreditasi.asesmenKecukupan.detail');
        Route::get('akreditasi/asesmen-kecukupan/show/{id}', [AkreditasiController::class, 'show'])->name('akreditasi.asesmenKecukupan.show');
        Route::get('akreditasi/asesmen-kecukupan/json', [AkreditasiController::class, 'jsonAk'])->name('Upps.asesmen-kecukupan.json');
        Route::get('akreditasi/asesmen-lapangan/json', [AkreditasiController::class, 'jsonAl'])->name('Upps.asesmen-lapangan.json');
        Route::get('akreditasi/asesmen-lapangan', [AkreditasiController::class, 'asesmenLapangan'])->name('akreditasi.asesmenLapangan');
        Route::get('akreditasi/asesmen-kecukupan', [AkreditasiController::class, 'asesmenKecukupan'])->name('akreditasi.asesmenKecukupan');
        Route::get('akreditasi/selesai', [AkreditasiController::class, 'finish'])->name('akreditasi.selesai');
        Route::get('akreditasi/detail/{id_prodi}', [AkreditasiController::class, 'detail'])->name('UPPS.akreditasi.detail');
        Route::post('akreditasi/penugasanProdi', [AkreditasiController::class, 'penugasanProdi'])->name('UPPS.akreditasi.penugasanProdi');
        Route::post('akreditasi/penugasanAsesor', [AkreditasiController::class, 'penugasanAsesor'])->name('UPPS.akreditasi.penugasanAsesor');
        Route::get('akreditasi/json', [AkreditasiController::class, 'json'])->name('UPPS.akreditasi.json');
        Route::post('akreditasi/store', [AkreditasiController::class, 'store'])->name('UPPS.akreditasi.store');
        Route::resource('akreditasi', AkreditasiController::class);

        Route::get('timeline/json', [TimelineController::class, 'json'])->name('UPPS.timeline.json');
        Route::post('timeline/store', [TimelineController::class, 'store'])->name('UPPS.timeline.store');
        Route::resource('timeline', TimelineController::class);

        Route::post('user/update/{id}', [UserController::class, 'update'])->name('UPPS.user.update');
        Route::get('user/json', [UserController::class, 'json'])->name('UPPS.user.json');
        Route::post('user/store', [UserController::class, 'store'])->name('UPPS.user.create');
        Route::resource('user', UserController::class);

        Route::post('user-asesor/store', [UserAsesorController::class, 'store'])->name('UPPS.user.store');
        Route::get('user-asesor/jsonAsesor/{id}', [UserAsesorController::class, 'jsonAsesor'])->name('UPPS.user.jsonAsesor');
        Route::get('user-asesor/asesor/{id}', [UserAsesorController::class, 'asesor'])->name('UPPS.user-asesor.asesor');
        Route::resource('user-asesor', UserAsesorController::class);

        Route::post('user-prodi/store', [UserProdiController::class, 'store'])->name('UPPS.user-prodi.store');
        Route::get('user-prodi/jsonProdi{id}', [UserProdiController::class, 'jsonProdi'])->name('UPPS.user-prodi.jsonProdi');
        Route::get('user-prodi/prodi/{id}', [UserProdiController::class, 'prodi'])->name('UPPS.user-prodi.prodi');
        Route::resource('user-prodi', UserProdiController::class);

        Route::post('prodi/store', [ProgramStudiController::class, 'store'])->name('UPPS.prodi.store');
        Route::get('prodi/json', [ProgramStudiController::class, 'json'])->name('UPPS.prodi.json');
        Route::resource('prodi', ProgramStudiController::class);

        Route::post('instrumen/store', [InstrumenController::class, 'store'])->name('UPPS.instrumen.store');
        Route::get('instrumen/json/{id}', [InstrumenController::class, 'json'])->name('UPPS.instrumen.json');
        Route::get('instrumen/jenjang/{id}', [InstrumenController::class, 'jenjang'])->name('UPPS.instrumen.jenjang');
        Route::resource('instrumen', InstrumenController::class);

        Route::post('kriteria/store', [KriteriaController::class, 'store'])->name('UPPS.matriks-penilaian.kriteria.store');
        Route::get('kriteria/json', [KriteriaController::class, 'json'])->name('UPPS.matriks-penilaian.kriteria.json');
        Route::get('/kriteria/{id}', [KriteriaController::class, 'show'])->name('kriteria.show');
        Route::put('/kriteria/{id}', [KriteriaController::class, 'update'])->name('kriteria.update');
        Route::resource('kriteria', KriteriaController::class);

        Route::get('matriks-penilaian/json{id_jenjang}', [MatriksPenilaianController::class, 'json'])->name('UPPS.matriks-penilaian.json');
        Route::post('matriks-penilaian/store', [MatriksPenilaianController::class, 'store'])->name('UPPS.matriks-penilaian.store');
        Route::get('matriks-penilaian/create/{id}', [MatriksPenilaianController::class, 'create'])->name('UPPS.matriks-penilaian.create');
        Route::get('matriks-penilaian/edit/{id}/{id_jenjang}', [MatriksPenilaianController::class, 'edit'])->name('UPPS.matriks-penilaian.edit');
        Route::post('matriks-penilaian/update/{id}/{id_jenjang}', [MatriksPenilaianController::class, 'update'])->name('UPPS.matriks-penilaian.update');
        Route::get('matriks-penilaian/jenjang/{id}', [MatriksPenilaianController::class, 'jenjang'])->name('UPPS.matriks-penilaian.jenjang');
        Route::resource('matriks-penilaian', MatriksPenilaianController::class);

        // Route::post('upps-datadukung/update/{id_prodi}', [DataDukungUppsController::class, 'update'])->name('Upps.data-dukung.update');
        // Route::get('upps-datakung/data/{id_prodi}', [DataDukungUppsController::class, 'data'])->name('Upps.data-dukung.data');
        // Route::get('upps-datadukung/elemen/{id_prodi}', [DataDukungUppsController::class, 'elemen'])->name('Upps.data-dukung.elemen');
        // Route::get('upps-datadukung/download/{id}', [DataDukungUppsController::class, 'download'])->name('Upps.data-dukung.download');
        // Route::resource('upps-datadukung', DataDukungUppsController::class);

        Route::post('history-akreditasi/tugasLed', [AjuanUppsController::class, 'tugasLed'])->name('upps.dokumenajuan.tugasLed');
        Route::post('history-akreditasi/approveLed/{id}', [AjuanUppsController::class, 'approveLed'])->name('upps.dokumenajuan.approveLed');
        Route::get('history-akreditasi/assignLed/{id}/{id_prodi}', [AjuanUppsController::class, 'assignLed'])->name('upps.dokumenajuan.assignLed');
        Route::post('history-akreditasi/approveLkps/{id}', [AjuanUppsController::class, 'approveLkps'])->name('upps.dokumenajuan.approveLkps');
        Route::get('history-akreditasi/assignLkps/{id}/{id_prodi}', [AjuanUppsController::class, 'assignLkps'])->name('upps.dokumenajuan.assignLkps');
        Route::post('history-akreditasi/tugasLkps', [AjuanUppsController::class, 'tugasLkps'])->name('upps.dokumenajuan.tugasLkps');
        Route::get('history-akreditasi/prodi/{id_prodi}', [AjuanUppsController::class, 'prodi'])->name('upps.dokumenajuan.prodi');
    });

    Route::group(["middleware" => ["can:Asesor"]], function () {
        Route::get('dashboard-asesor/berita-acara/pdf', [DashboardAsesorController::class, 'pdf'])->name('dashboard-asesor.pdf');
        Route::get('dashboard-asesor/berita-acara/show', [DashboardAsesorController::class, 'show'])->name('dashboard-asesor.pdf.show');
        Route::get('dashboard-asesor/berita-acara/asesmen', [DashboardAsesorController::class, 'asesmen'])->name('dashboard-asesor.pdf.asesmen');
        Route::get('dashboard-asesor/sertifikat/sertif', [DashboardAsesorController::class, 'sertif'])->name('dashboard-asesor.sertifikat.sertif');
        Route::post('dashboard-asesor/sertifikat/storeSertif', [DashboardAsesorController::class, 'storeSertif'])->name('dashboard-asesor.sertifikat.storeSertif');
        Route::post('dashboard-asesor/berita-acara/deskEval', [DashboardAsesorController::class, 'deskEval'])->name('dashboard-asesor.berita-acara.deskEval');
        Route::post('dashboard-asesor/berita-acara/asesmenLapangan', [DashboardAsesorController::class, 'asesmenLapangan'])->name('dashboard-asesor.berita-acara.asesmenLapangan');
        Route::resource('dashboard-asesor', DashboardAsesorController::class);

        Route::get('instrumen-asesor/instrumen/{id}', [InstrumenAsesorController::class, 'instrumen'])->name('instrumen-asesor.instrumen');

        Route::get('asesor-ajuanprodi/getLkps/{id_prodi}', [AjuanAsesorController::class, 'getLkps'])->name('asesor-ajuanprodi.getLkps');
        Route::get('asesor-ajuanprodi/prodi/{id_prodi}', [AjuanAsesorController::class, 'prodi'])->name('asesor-ajuanprodi.prodi');

        Route::get('datadukung-d3/download/{id}', [DataDukungAsesorController::class, 'download'])->name('asesor.data-prodi.data-dukung.download');
        Route::get('datadukung-d3/json/{id_prodi}', [DataDukungAsesorController::class, 'json'])->name('asesor.data-prodi.data-dukung.json');
        Route::get('datadukung-d3/show/{id}', [DataDukungAsesorController::class, 'show'])->name('asesor.data-prodi.data-dukung.show');
        Route::resource('datadukung-d3', DataDukungAsesorController::class);

        Route::get('rekap-nilaid3/store', [RekapPenilaianController::class, 'store'])->name('rekap-nilaid3.store');

        Route::get('rekap-nilaiAk/json/{id_prodi}', [RekapPenilaianController::class, 'json'])->name('rekap-nilaiAk.json');
        Route::get('rekap-nilaiAl/json/{id_prodi}', [RekapPenilaianController::class, 'jsonAkhir'])->name('rekap-nilaiAl.jsonAkhir');
        Route::get('rekap-nilaiAk/prodi/{id_prodi}', [RekapPenilaianController::class, 'prodi'])->name('rekap-nilaiAk.prodi');
        Route::get('rekap-nilaiAl/prodi/{id_prodi}', [RekapPenilaianController::class, 'prodiasesmen'])->name('rekap-nilaiAl.prodi');
        Route::resource('rekap-nilai', RekapPenilaianController::class);

        Route::post('nilai-asesmen-kecukupan/store', [NilaiDeskEvalController::class, 'store'])->name('asesmen-kecukupan.store');
        Route::post('nilai-asesmen-kecukupan/calculate/{id}', [NilaiDeskEvalController::class, 'calculateItem'])->name('asesmen-kecukupan.calculate');
        Route::get('nilai-asesmen-kecukupan/json/{id}', [NilaiDeskEvalController::class, 'json'])->name('asesmen-kecukupan.json');
        Route::get('nilai-asesmen-kecukupan/show/{id}/{id_prodi}', [NilaiDeskEvalController::class, 'show'])->name('asesor.penilaian.asesmen-kecukupan.show');
        Route::post('nilai-asesmen-kecukupan/update/{id}', [NilaiDeskEvalController::class, 'update'])->name('asesor.penilaian.asesmen-kecukupan.update');
        Route::get('nilai-asesmen-kecukupan/elemen/{id_prodi}', [NilaiDeskEvalController::class, 'elemen'])->name('asesor.penilaian.asesmen-kecukupan.elemen');
        Route::resource('nilai-asesmen-kecukupan', NilaiDeskEvalController::class);

        Route::post('nilai-asesmenlapangan/store', [NilaiAsesmenLapanganD3Controller::class, 'store'])->name('nilai-asesmenlapangan.store');
        Route::post('nilai-asesmenlapangan/update/{id}', [NilaiAsesmenLapanganD3Controller::class, 'update'])->name('nilai-asesmenlapangan.update');
        Route::get('nilai-asesmenlapangan/json/{id}', [NilaiAsesmenLapanganD3Controller::class, 'json'])->name('nilai-asesmenlapangan.json');
        Route::get('nilai-asesmenlapangan/elemen/{id_prodi}', [NilaiAsesmenLapanganD3Controller::class, 'elemen'])->name('nilai-asesmenlapangan.elemen');
        Route::get('nilai-asesmenlapangan/show/{id}/{id_prodi}', [NilaiAsesmenLapanganD3Controller::class, 'show'])->name('asesor.penilaian.asesmen-lapangan.show');
        Route::resource('nilai-asesmenlapangan', NilaiAsesmenLapanganD3Controller::class);

        Route::get('nilai-perelemen/jsonBagian/{id}', [NilaiController::class, 'jsonBagian'])->name('nilai-perelemen.jsonBagian');
        Route::get('nilai-perelemen/{id}', [NilaiController::class, 'bagian'])->name('nilai-perelemen.bagian');
        Route::resource('nilai-akreditasi', NilaiController::class);

        Route::get('nilai-deskeval/history/{id_prodi}', [NilaiDeskEvalController::class, 'history'])->name('asesor.nilai-deskeval.history');
        Route::get('nilai-deskeval/jsonHistory/{id_prodi}', [NilaiDeskEvalController::class, 'jsonHistory'])->name('asesor.nilai-deskeval.jsonHistory');
    });
    Route::group(["middleware" => ["can:Prodi"]], function () {
        Route::resource('dashboard-prodi', DashboardProdiController::class);

        /**instrumen prodi */
        Route::get('instrumen-prodi/instrumen/{id}', [InstrumenProdiController::class, 'instrumen'])->name('prodi.instrumen');
        Route::get('instrumen-prodi/dashboard', [InstrumenProdiController::class, 'dashboard'])->name('prodi.instrumen.dashboard');
        Route::get('instrumen-prodi/json/{id_jenjang}', [InstrumenProdiController::class, 'json'])->name('prodi.instrumen.json');
        Route::get('instrumen-prodi/download/{id}', [InstrumenProdiController::class, 'download'])->name('prodi.instrumen.download');
        Route::resource('instrumen-prodi', InstrumenProdiController::class);

        /** Dokumen Ajuan Prodi */
        Route::get('ajuan-prodi/downloadlkps/{id}', [AjuanProdiController::class, 'downloadlkps'])->name('ajuan-prodi.downloadlkps');
        Route::post('ajuan-prodi/import-lkps/{id_prodi}', [AjuanProdiController::class, 'importLkps'])->name('ajuan-prodi.importLkps');
        Route::post('ajuan-prodi/updateSp/{id}', [AjuanProdiController::class, 'updateSp'])->name('ajuan-prodi.updateSp');
        Route::post('ajuan-prodi/updatelkps/{id}', [AjuanProdiController::class, 'updatelkps'])->name('ajuan-prodi.updatelkps');
        Route::post('ajuan-prodi/updateled/{id}', [AjuanProdiController::class, 'updateled'])->name('ajuan-prodi.updateled');
        Route::post('ajuan-prodi/storelkps', [AjuanProdiController::class, 'storelkps'])->name('ajuan-prodi.storelkps');
        Route::post('ajuan-prodi/storeled', [AjuanProdiController::class, 'storeled'])->name('ajuan-prodi.storeled');
        Route::post('ajuan-prodi/storeSp', [AjuanProdiController::class, 'storeSp'])->name('ajuan-prodi.storeSp');
        Route::get('ajuan-prodi/prodi/{id_prodi}', [AjuanProdiController::class, 'prodi'])->name('ajuan-prodi.prodi');
        Route::post('ajuan-prodi/prodi/ajukan', [AjuanProdiController::class, 'ajukan'])->name('ajuan-prodi.ajukan');
        Route::get('ajuan-prodi/history/{id_prodi}', [AjuanProdiController::class, 'history'])->name('ajuan-prodi.history');

        // Route::resource('ajuan-prodi', AjuanProdiController::class);
        /**data dukung prodi */
        // Route::get('data-dukung/dataHistory/{id}/{id_prodi}', [DataDukungProdiController::class, 'dataHistory'])->name('prodi.data-dukung.dataHistory');
        // Route::get('data-dukung/elemenHistory/{id}', [DataDukungProdiController::class, 'elemenHistory'])->name('prodi.data-dukung.elemenHistory');
        // Route::get('data-dukung/jsonHistory/{id_prodi}', [DataDukungProdiController::class, 'jsonHistory'])->name('prodi.data-dukung.jsonHistory');
        // Route::put('data-dukung/update/{id}', [DataDukungProdiController::class, 'update'])->name('prodi.data-dukung.update');
        // Route::get('data-dukung/history/{id_prodi}', [DataDukungProdiController::class, 'history'])->name('prodi.data-dukung.history');
    
        Route::get('data-dukung/fetch/{id}', [DataDukungProdiController::class, 'fetch'])->name('prodi.data-dukung.fetch');
        Route::put('data-dukung/update', [DataDukungProdiController::class, 'update'])->name('prodi.data-dukung.update');
        Route::delete('data-dukung/delete', [DataDukungProdiController::class, 'delete'])->name('prodi.data-dukung.delete');
        Route::post('data-dukung/store', [DataDukungProdiController::class, 'store'])->name('prodi.data-dukung.store');
        Route::get('data-dukung/{id}/{id_prodi}/{tahun}', [DataDukungProdiController::class, 'data'])->name('prodi.data-dukung.data');
        Route::get('data-dukung/json/{id_prodi}', [DataDukungProdiController::class, 'json'])->name('prodi.data-dukung.json');
        Route::get('data-dukung/elemen/{id}', [DataDukungProdiController::class, 'elemen'])->name('prodi.data-dukung.elemen');
        Route::resource('data-dukung', DataDukungProdiController::class);

        /**nilai prodi */
        Route::get('nilai-d3/json', [NilaiProdiController::class, 'json'])->name('prodi.diploma-tiga.nilai.json');
        Route::resource('nilai-d3', NilaiProdiController::class);
    });
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
});
