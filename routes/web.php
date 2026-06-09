<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/tr');

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'authenticate'])->name('admin.authenticate');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::middleware('demo.admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/html-entegrasyon', [AdminController::class, 'integration'])->name('integration.show');
    Route::get('/sayfalar', [AdminController::class, 'pages'])->name('pages.index');
    Route::get('/sayfalar/{page}/duzenle', [AdminController::class, 'editPage'])->name('pages.edit');
    Route::put('/sayfalar/{page}', [AdminController::class, 'updatePage'])->name('pages.update');
    Route::get('/medya', [AdminController::class, 'media'])->name('media.index');
    Route::post('/medya', [AdminController::class, 'storeMedia'])->name('media.store');
    Route::get('/diller', [AdminController::class, 'languages'])->name('languages.index');
    Route::post('/diller', [AdminController::class, 'storeLanguage'])->name('languages.store');
    Route::put('/diller/{language}', [AdminController::class, 'updateLanguage'])->name('languages.update');
    Route::get('/ceviriler', [AdminController::class, 'translations'])->name('translations.index');
    Route::put('/ceviriler', [AdminController::class, 'updateTranslations'])->name('translations.update');
    Route::get('/mesajlar', [AdminController::class, 'messages'])->name('messages.index');
    Route::get('/mesajlar/{message}', [AdminController::class, 'message'])->name('messages.show');
});

Route::get('/{locale}', [SiteController::class, 'home'])->name('site.home');
Route::get('/{locale}/hazir-html-demo', [SiteController::class, 'clientDemo'])->name('site.client-demo');
Route::post('/{locale}/iletisim', [SiteController::class, 'storeContact'])->name('site.contact.store');
Route::get('/{locale}/{slug}', [SiteController::class, 'page'])->name('site.page');
