<?php

use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Mahasiswa;
use App\Http\Controllers\Mentor\MonitoringController as MentorMonitoringController;
use App\Http\Middleware\RoleMiddleware;
use App\Models\Beasiswa;
use App\Models\KtmDigital;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Route;

// ---------- Publik ----------
Route::get('/', function () {
    return view('landing', [
        'beasiswa' => Beasiswa::terbuka()->orderBy('tgl_tutup')->take(1)->get(),
        'pengumuman' => Pengumuman::terbit()->with('beasiswa')->latest('tgl_publish')->take(3)->get(),
    ]);
})->name('home');

Route::get('/verifikasi-ktm/{nomor}', function (string $nomor) {
    $ktm = KtmDigital::with('pendaftaran.user.profile', 'pendaftaran.beasiswa')->where('nomor_ktm', $nomor)->first();

    return view('verifikasi-ktm', compact('ktm', 'nomor'));
})->name('ktm.verifikasi');

Route::get('/pengumuman', function () {
    $pengumuman = Pengumuman::terbit()
        ->with('beasiswa')
        ->latest('tgl_publish')
        ->paginate(10);

    return view('pengumuman.index', compact('pengumuman'));
})->name('pengumuman.index');

// ---------- Autentikasi ----------
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', fn () => redirect()->route(auth()->user()->dashboardRoute()))->name('dashboard');
});

// ---------- Mahasiswa ----------
Route::middleware(['auth', RoleMiddleware::class . ':mahasiswa'])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/', [Mahasiswa\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profil', [Mahasiswa\ProfilController::class, 'edit'])->name('profil.edit');
    Route::put('/profil', [Mahasiswa\ProfilController::class, 'update'])->name('profil.update');

    Route::get('/beasiswa', [Mahasiswa\PendaftaranController::class, 'beasiswa'])->name('beasiswa.index');
    Route::post('/beasiswa/{beasiswa}/daftar', [Mahasiswa\PendaftaranController::class, 'daftar'])->name('beasiswa.daftar');

    Route::get('/pendaftaran', [Mahasiswa\PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::get('/pendaftaran/{pendaftaran}', [Mahasiswa\PendaftaranController::class, 'show'])->name('pendaftaran.show');
    Route::post('/pendaftaran/{pendaftaran}/berkas', [Mahasiswa\PendaftaranController::class, 'upload'])->name('pendaftaran.upload');
    Route::post('/pendaftaran/{pendaftaran}/ajukan', [Mahasiswa\PendaftaranController::class, 'ajukan'])->name('pendaftaran.ajukan');
    Route::delete('/berkas/{berkas}', [Mahasiswa\PendaftaranController::class, 'hapusBerkas'])->name('berkas.destroy');

    Route::get('/hasil', [Mahasiswa\DashboardController::class, 'hasil'])->name('hasil');
    Route::get('/monitoring', [Mahasiswa\DashboardController::class, 'monitoring'])->name('monitoring');
    Route::get('/ktm', [Mahasiswa\DashboardController::class, 'ktm'])->name('ktm');
});


 // ---------- Mentor ----------
Route::middleware(['auth', RoleMiddleware::class . ':mentor'])
    ->prefix('mentor')
    ->name('mentor.')
    ->group(function () {

        // Dashboard
        Route::get('/', [MentorMonitoringController::class, 'dashboard'])
            ->name('dashboard');

        // Mahasiswa binaan
        Route::get('/mahasiswa', [MentorMonitoringController::class, 'mahasiswa'])
            ->name('mahasiswa.index');

        // Kegiatan pembinaan
        Route::get('/kegiatan', [MentorMonitoringController::class, 'kegiatan'])
            ->name('kegiatan.index');

        // Monitoring kehadiran
        Route::get('/monitoring', [MentorMonitoringController::class, 'index'])
            ->name('monitoring.index');

        // Rekap monitoring
        Route::get('/rekap', [MentorMonitoringController::class, 'rekap'])
            ->name('rekap.index');

        // Rekomendasi mahasiswa
        Route::get('/evaluasi', [MentorMonitoringController::class, 'evaluasi'])
            ->name('evaluasi.index');

        // Proses penyimpanan
        Route::post('/kegiatan', [MentorMonitoringController::class, 'storeKegiatan'])
            ->name('kegiatan.store');

        Route::post('/kegiatan/{kegiatan}/monitoring', [MentorMonitoringController::class, 'storeMonitoring'])
            ->name('monitoring.store');

        Route::post('/pendaftaran/{pendaftaran}/rekomendasi', [MentorMonitoringController::class, 'storeRekomendasi'])
            ->name('rekomendasi.store');
    });


// ---------- Penyelenggara beasiswa (Admin) ----------
Route::middleware(['auth', RoleMiddleware::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Pengelolaan akun internal perusahaan: Admin dan Mentor.
    Route::resource('akun', Admin\AkunController::class)->except('show')->parameters(['akun' => 'akun']);
    Route::patch('/akun/{akun}/toggle', [Admin\AkunController::class, 'toggle'])->name('akun.toggle');

    Route::resource('beasiswa', Admin\BeasiswaController::class)->except('show')->parameters(['beasiswa' => 'beasiswa']);
    Route::get('/pendaftaran', [Admin\PendaftaranController::class, 'index'])->name('pendaftaran.index');
    Route::get('/pendaftaran/{pendaftaran}', [Admin\PendaftaranController::class, 'show'])->name('pendaftaran.show');
    Route::patch('/pendaftaran/{pendaftaran}/verifikasi', [Admin\PendaftaranController::class, 'verifikasi'])->name('pendaftaran.verifikasi');
    Route::patch('/pendaftaran/{pendaftaran}/seleksi', [Admin\PendaftaranController::class, 'seleksi'])->name('pendaftaran.seleksi');
    Route::patch('/berkas/{berkas}', [Admin\PendaftaranController::class, 'updateBerkas'])->name('berkas.update');
    Route::get('/pengumuman', [Admin\PengumumanController::class, 'index'])->name('pengumuman.index');
    Route::post('/pengumuman', [Admin\PengumumanController::class, 'store'])->name('pengumuman.store');
    Route::delete('/pengumuman/{pengumuman}', [Admin\PengumumanController::class, 'destroy'])->name('pengumuman.destroy');
    Route::get('/penempatan', [Admin\PenempatanController::class, 'index'])->name('penempatan.index');
    Route::post('/penempatan', [Admin\PenempatanController::class, 'simpan'])->name('penempatan.simpan');
    Route::post('/penempatan/ktm', [Admin\PenempatanController::class, 'terbitkanKtm'])->name('penempatan.ktm');
    Route::post('/kelompok', [Admin\PenempatanController::class, 'storeKelompok'])->name('kelompok.store');
    Route::delete('/kelompok/{kelompok}', [Admin\PenempatanController::class, 'destroyKelompok'])->name('kelompok.destroy');
    Route::get('/evaluasi', [Admin\EvaluasiController::class, 'index'])->name('evaluasi.index');
    Route::patch('/evaluasi/{evaluasi}/putusan', [Admin\EvaluasiController::class, 'putuskan'])->name('evaluasi.putuskan');
});
