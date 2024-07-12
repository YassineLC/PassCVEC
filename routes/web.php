<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AideController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\BackOfficeController;
use App\Http\Controllers\CreateMailController;
use App\Http\Controllers\BackOfficeDemandeController;
use App\Http\Controllers\MentionsController;

Route::get('/', [PostController::class, 'index'])->name('form');
Route::post('/store-form', [PostController::class, 'store'])->name('store-form');
Route::get('/aide', [AideController::class, 'index'])->name('aide');
Route::get('/mentions-legales', [MentionsController::class, 'index'])->name('mentions-legales');

Route::prefix('backoffice')->group(function() {
    Route::get('/', [BackOfficeController::class, 'index'])->name('backoffice.index');
    Route::get('/{id}', [BackOfficeDemandeController::class, 'afficherDemande'])->name('backoffice.demande')->where('id', '[0-9]+');
    Route::post('/update-status', [BackOfficeController::class, 'updateStatus'])->name('backoffice.updateStatus');
    Route::get('/create-mail', [CreateMailController::class, 'index'])->name('backoffice.test');
    Route::post('/send-newsletter', [CreateMailController::class, 'send'])->name('send-newsletter');

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
