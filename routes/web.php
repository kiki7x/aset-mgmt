<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;


// Auth Controller
Route::get('login', [App\Http\Controllers\Auth\AuthController::class, 'index'])->name('login');
Route::post('post-login', [App\Http\Controllers\Auth\AuthController::class, 'postLogin'])->name('login.post');
Route::get('register', [App\Http\Controllers\Auth\AuthController::class, 'register'])->name('register');
Route::post('post-register', [App\Http\Controllers\Auth\AuthController::class, 'postRegister'])->name('register.post');
Route::get('dashboard', [App\Http\Controllers\Auth\AuthController::class, 'dashboard']);
Route::post('logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');

// FrontSite landing page
Route::get('testing', [App\Http\Controllers\FrontController::class, 'testing'])->name('testing');
Route::get('/', [App\Http\Controllers\FrontController::class, 'index'])->name('/');
Route::get('/lacak', [App\Http\Controllers\FrontController::class, 'lacak'])->name('lacak');
Route::get('/lacak/show/{id}', [App\Http\Controllers\FrontController::class, 'lacak_show'])->name('lacak.show');

//Admin Area
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    // Route Aset TIK
    Route::middleware(['role:superadmin|admin_tik|staf_tik'])->group(function () {
        Route::get('/asettik', [App\Http\Controllers\AssetController::class, 'index_tik'])->name('admin.asettik');
        Route::get('/asettik/get_assets', [App\Http\Controllers\AssetController::class, 'get_assets'])->name('admin.asettik.get_assets');
        Route::post('/asettik/store/{classification}', [App\Http\Controllers\AssetController::class, 'store'])->name('admin.asettik.store');
        Route::get('/asettik/{id}/edit', [App\Http\Controllers\ShowAsetController::class, 'getEditAssetContent'])->name('admin.asettik.edit');
        Route::patch('/asettik/{id}/update', [App\Http\Controllers\AssetController::class, 'update'])->name('admin.asettik.update');
        Route::delete('/asettik/destroy/{id}/{classification}', [App\Http\Controllers\AssetController::class, 'destroy'])->name('admin.asettik.destroy');
        Route::get('/asettik/{id}/overview', [App\Http\Controllers\ShowAsetController::class, 'getOverviewContent'])->name('admin.asettik.overview');
        Route::get('/asettik/{id}/pemeliharaan', [App\Http\Controllers\PemeliharaanController::class, 'index'])->name('admin.asettik.pemeliharaan');
        Route::get('/asettik/{id}/penugasan', [App\Http\Controllers\ShowAsetController::class, 'getPenugasanContent'])->name('admin.asettik.penugasan');
        Route::get('/asettik/{id}/tickets', [App\Http\Controllers\ShowAsetController::class, 'getTicketsContent'])->name('admin.asettik.tickets');
        Route::get('/asettik/{id}/files', [App\Http\Controllers\ShowAsetController::class, 'getFilesContent'])->name('admin.asettik.files');
        Route::get('/asettik/{id}/timelog', [App\Http\Controllers\ShowAsetController::class, 'getTimeLogContent'])->name('admin.asettik.timelog');
        Route::get('/asettik/{id}/edit', [App\Http\Controllers\ShowAsetController::class, 'getEditAssetContent'])->name('admin.asettik.edit');
    });
    // Route Aset Rumah Tangga
    Route::middleware(['role:superadmin|admin_rt|staf_driver|staf_engineering'])->group(function () {
        Route::get('/asetrt', [App\Http\Controllers\AssetController::class, 'index_rt'])->name('admin.asetrt');
        Route::get('/asetrt/get_assets', [App\Http\Controllers\AssetController::class, 'get_assets'])->name('admin.asetrt.get_assets');
        Route::post('/asetrt/store/{classification}', [App\Http\Controllers\AssetController::class, 'store'])->name('admin.asetrt.store');
        Route::post('/asettik/destroy/{id}/{classification}', [App\Http\Controllers\AssetController::class, 'destroy'])->name('admin.asetrt.destroy');
        Route::get('/asetrt/{id}', [App\Http\Controllers\ShowAsetController::class, 'showDetails'])->name('admin.asetrt.details');
        Route::get('/asetrt/{id}/overview', [App\Http\Controllers\ShowAsetController::class, 'getOverviewContent'])->name('admin.asetrt.overview');
        Route::get('/asetrt/{id}/pemeliharaan', [App\Http\Controllers\PemeliharaanController::class, 'index'])->name('admin.asetrt.pemeliharaan');
        Route::get('/asetrt/{id}/pemeliharaan/preventifdataTable', [App\Http\Controllers\PemeliharaanController::class, 'preventifdataTable'])->name('admin.asetrt.pemeliharaan.preventifdataTable');
        Route::post('/asetrt/{id}/pemeliharaan/preventifstore', [App\Http\Controllers\PemeliharaanController::class, 'preventifStore'])->name('admin.asetrt.pemeliharaan.preventifStore');
        Route::get('/asetrt/{id}/pemeliharaan/preventifEdit/', [App\Http\Controllers\PemeliharaanController::class, 'preventifEdit'])->name('admin.asetrt.pemeliharaan.preventifEdit');
        Route::patch('/asetrt/{id}/pemeliharaan/preventifUpdate', [App\Http\Controllers\PemeliharaanController::class, 'preventifUpdate'])->name('admin.asetrt.pemeliharaan.preventifUpdate');
        Route::delete('/asetrt/{id}/pemeliharaan/preventifDelete', [App\Http\Controllers\PemeliharaanController::class, 'preventifDelete'])->name('admin.asetrt.pemeliharaan.preventifDelete');
        Route::get('/asetrt/{id}/pemeliharaan/korektifdataTable', [App\Http\Controllers\PemeliharaanController::class, 'korektifdataTable'])->name('admin.asetrt.pemeliharaan.korektifdataTable');
        Route::get('/asetrt/{id}/pemeliharaan/korektifStore', [App\Http\Controllers\PemeliharaanController::class, 'korektifdataTable'])->name('admin.asetrt.pemeliharaan.korektiStpre');
        Route::get('/asetrt/{id}/penugasan', [App\Http\Controllers\ShowAsetController::class, 'getPenugasanContent'])->name('admin.asetrt.penugasan');
        Route::get('/asetrt/{id}/tickets', [App\Http\Controllers\ShowAsetController::class, 'getTicketsContent'])->name('admin.asetrt.tickets');
        Route::get('/asetrt/{id}/files', [App\Http\Controllers\ShowAsetController::class, 'getFilesContent'])->name('admin.asetrt.files');
        Route::get('/asetrt/{id}/timelog', [App\Http\Controllers\ShowAsetController::class, 'getTimeLogContent'])->name('admin.asetrt.timelog');
        Route::get('/asetrt/{id}/edit', [App\Http\Controllers\ShowAsetController::class, 'getEditAssetContent'])->name('admin.asetrt.edit');
    });


    // Route Penugasan
    Route::middleware(['role:superadmin|admin_tik|admin_rt|staf_tik|staf_driver|staf_engineering'])->group(function () {
        Route::get('/issues', [App\Http\Controllers\IssuesController::class, 'index'])->name('admin.issues');
        Route::get('/issues/get_issues', [App\Http\Controllers\IssuesController::class, 'getIssues'])->name('admin.issues.get_issues');
    });

    // Route Kalender Pemeliharaan
    Route::middleware(['role:superadmin|admin_tik|admin_rt|staf_tik|staf_driver|staf_engineering'])->group(function () {
        Route::get('/kalender-pemeliharaan', [App\Http\Controllers\KalenderPemeliharaan::class, 'index'])->name('admin.kalender-pemeliharaan');
    });

    // Route Setting Atribut / Master Data
    Route::middleware(['role:superadmin|admin_tik|admin_rt|staf_tik|staf_driver|staf_engineering'])->group(function () {
        Route::get('/setting_attr', [App\Http\Controllers\SetatributController::class, 'index'])->name('admin.setting_attr');
        // Route Setting Klasifikasi
        Route::get('/setting_attr/klasifikasi', [App\Http\Controllers\SetatributController::class, 'klasifikasi'])->name('admin.setting_attr.klasifikasi');
        Route::get('/setting_attr/klasifikasi/get_klasifikasi', [App\Http\Controllers\SetatributController::class, 'getKlasifikasi'])->name('admin.setting_attr.klasifikasi.get_klasifikasi');
        Route::post('/setting_attr/klasifikasi/store', [App\Http\Controllers\SetatributController::class, 'storeKlasifikasi'])->name('admin.setting_attr.klasifikasi.store');
        Route::get('/setting_attr/klasifikasi/edit/{id}', [App\Http\Controllers\SetatributController::class, 'editKlasifikasi'])->name('admin.setting_attr.klasifikasi.edit');
        Route::patch('/setting_attr/klasifikasi/update/{id}', [App\Http\Controllers\SetatributController::class, 'updateKlasifikasi'])->name('admin.setting_attr.klasifikasi.update');
        Route::delete('/setting_attr/klasifikasi/delete/{id}', [App\Http\Controllers\SetatributController::class, 'deleteKlasifikasi'])->name('admin.setting_attr.klasifikasi.delete');
        // Route Setting Kategori
        Route::get('/setting_attr/kategori', [App\Http\Controllers\SetatributController::class, 'kategori'])->name('admin.setting_attr.kategori');
        Route::get('/setting_attr/kategori/get_kategori', [App\Http\Controllers\SetatributController::class, 'getKategori'])->name('admin.setting_attr.kategori.get_kategori');
        Route::post('/setting_attr/kategori/store', [App\Http\Controllers\SetatributController::class, 'storeKategori'])->name('admin.setting_attr.kategori.store');
        Route::get('/setting_attr/kategori/edit/{id}', [App\Http\Controllers\SetatributController::class, 'editKategori'])->name('admin.setting_attr.kategori.edit');
        Route::patch('/setting_attr/kategori/update/{id}', [App\Http\Controllers\SetatributController::class, 'updateKategori'])->name('admin.setting_attr.kategori.update');
        Route::delete('/setting_attr/kategori/delete/{id}', [App\Http\Controllers\SetatributController::class, 'deleteKategori'])->name('admin.setting_attr.kategori.delete');
        // Route Setting Merk
        Route::get('/setting_attr/merk', App\Livewire\Assets\IndexAsetMerk::class)->name('admin.setting_attr.merk');
        Route::get('/setting_attr/merk/show/{id}/{section?}', App\Livewire\Assets\ShowMerk::class)->name('admin.setting_attr.merk.show');
        Route::get('/setting_attr/merk/edit/{id}/{section?}', App\Livewire\Assets\EditMerk::class)->name('admin.setting_attr.merk.edit');
        // Route Setting Model
        Route::get('/setting_attr/model', App\Livewire\Assets\IndexAsetModel::class)->name('admin.setting_attr.model');
        Route::get('/setting_attr/model/show/{id}/{section?}', App\Livewire\Assets\ShowModel::class)->name('admin.setting_attr.model.show');
        Route::get('/setting_attr/model/edit/{id}/{section?}', App\Livewire\Assets\EditModel::class)->name('admin.setting_attr.model.edit');
        // Route Setting Supplier
        Route::get('/setting_attr/supplier', App\Livewire\Assets\IndexAsetSupplier::class)->name('admin.setting_attr.supplier');
        Route::get('/setting_attr/supplier/show/{id}/{section?}', App\Livewire\Assets\ShowSupplier::class)->name('admin.setting_attr.supplier.show');
        Route::get('/setting_attr/supplier/edit/{id}/{section?}', App\Livewire\Assets\EditSupplier::class)->name('admin.setting_attr.supplier.edit');
        // Route Setting Label
        Route::get('/setting_attr/label', App\Livewire\Assets\IndexAsetLabel::class)->name('admin.setting_attr.label');
        Route::get('/setting_attr/label/show/{id}/{section?}', App\Livewire\Assets\ShowLabel::class)->name('admin.setting_attr.label.show');
        Route::get('/setting_attr/label/edit/{id}/{section?}', App\Livewire\Assets\EditLabel::class)->name('admin.setting_attr.label.edit');
        // Route Setting Lokasi
        Route::get('/setting_attr/lokasi', App\Livewire\Assets\IndexAsetLokasi::class)->name('admin.setting_attr.lokasi');
        Route::get('/setting_attr/lokasi/show/{id}/{section?}', App\Livewire\Assets\ShowLokasi::class)->name('admin.setting_attr.lokasi.show');
        Route::get('/setting_attr/lokasi/edit/{id}/{section?}', App\Livewire\Assets\EditLokasi::class)->name('admin.setting_attr.lokasi.edit');
    });

    // Route Laporan
    Route::middleware(['role:superadmin|admin_tik|admin_rt'])->group(function () {
    Route::get('/laporan', [App\Http\Controllers\LaporanController::class, 'index'])->name('admin.laporan');
    });

    // Route User Manager
    Route::middleware(['role:superadmin|admin_tik|admin_rt|staf_tik|staf_driver|staf_engineering'])->group(function () {
        Route::get('usermanager', [App\Http\Controllers\UserController::class, 'index'])->name('admin.usermanager');
        Route::get('usermanager/profil/{id}', [App\Http\Controllers\UserController::class, 'profil'])->name('admin.usermanager.profil');
        Route::get('usermanager/create', [App\Http\Controllers\UserController::class, 'create'])->name('admin.usermanager.create');
        Route::get('usermanager/edit/{id}', [App\Http\Controllers\UserController::class, 'edit'])->name('admin.usermanager.edit');
    });

    // Route Notifikasi
    Route::get('/notifikasi', [App\Http\Controllers\NotifikasiController::class, 'index'])->name('admin.notifikasi');

    Route::post('/notifikasi/read/{id}', function ($id) {
        $notification = auth()->user()->notifications()->find($id);

        if ($notification && is_null($notification->read_at)) {
            $notification->markAsRead();
        }

        return back();
    })->name('notif.read');

    Route::post('/notifikasi/unread/{id}', function ($id) {
        $notification = auth()->user()->notifications()->findOrFail($id);
        if ($notification->read()) {
            $notification->update(['read_at' => null]);
        }
        return back();
    })->name('notif.unread');

    Route::post('/notifikasi/delete/{id}', function ($id) {
        auth()->user()->notifications()->where('id', $id)->delete();
        return back();
    })->name('notif.delete');

    Route::post('/tandai-notifikasi-telah-dibaca', function () {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    })->name('admin.tandai-notifikasi-telah-dibaca');
});
