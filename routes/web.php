<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AideController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\BackOfficeController;
use App\Http\Controllers\CreateMailController;
use App\Http\Controllers\BackOfficeDemandeController;
use App\Http\Controllers\MentionsController;
use App\Http\Controllers\BackofficeUserController;

Route::get('/', [PostController::class, 'index'])->name('form');
Route::post('/store-form', [PostController::class, 'store'])->name('store-form');
Route::get('/aide', [AideController::class, 'index'])->name('aide');
Route::get('/mentions-legales', [MentionsController::class, 'index'])->name('mentions-legales');

Route::get('/backoffice/unauthorized', function() { return view('backoffice.unauthorized'); })->name('backoffice.unauthorized');

Route::prefix('backoffice')->name('backoffice.')->middleware('shibboleth.auth')->group(function () {
    Route::get('/', [BackOfficeController::class, 'index'])->name('index');
    Route::get('/logout', [App\Http\Controllers\BackOfficeController::class, 'logout'])->name('logout');
    Route::get('/{id}', [BackOfficeDemandeController::class, 'afficherDemande'])->name('demande')->where('id', '[0-9]+');
    Route::post('/update-status', [BackOfficeController::class, 'updateStatus'])->name('updateStatus');
    Route::post('/update-request-status/{id}', [BackOfficeDemandeController::class, 'updateRequestStatus'])->name('updateRequestStatus');
    Route::get('/create-mail', [CreateMailController::class, 'index'])->name('test');
    Route::post('/send-newsletter', [CreateMailController::class, 'send'])->name('send-newsletter');

    Route::get('/users/unauthorized', [BackofficeUserController::class, 'index'])->name('users.index');
    Route::post('/users/{id}/activate', [BackofficeUserController::class, 'activate'])->name('users.activate');
    Route::post('/users/{id}/deactivate', [BackofficeUserController::class, 'deactivate'])->name('users.deactivate');

    Route::prefix('assets')->group(function() {
        Route::get('pdf/scolarite/{id}', function ($id) {
            $scolarite_path = BackOfficeDemandeController::getPath($id, 'scolarite');
            if ($scolarite_path) {
                return Response::file($scolarite_path, ['Content-Type' => 'application/pdf']);
            } else {
                abort(404);
            }
        })->name('assets.pdf.scolarite');
        Route::get('pdf/cvec/{id}', function ($id) {
            $cvec_path = BackOfficeDemandeController::getPath($id, 'cvec');
            if ($cvec_path) {
                return Response::file($cvec_path, ['Content-Type' => 'application/pdf']);
            } else {
                abort(404);
            }
        })->name('assets.pdf.cvec');
    });
});
