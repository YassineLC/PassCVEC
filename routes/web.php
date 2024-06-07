<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AideController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\BackOfficeController;
use App\Http\Controllers\BackOfficeDemandeController;

Route::get('/', [PostController::class, 'index'])->name('form');
Route::post('/store-form', [PostController::class, 'store'])->name('store-form');
Route::get('/aide', [AideController::class, 'index'])->name('aide');

Route::prefix('backoffice')->group(function() {
    Route::get('/', [BackOfficeController::class, 'index'])->name('backoffice.index');
    Route::get('/{id}', [BackOfficeDemandeController::class, 'afficherDemande'])->name('backoffice.demande');
    Route::post('/update-status', [BackOfficeController::class, 'updateStatus'])->name('backoffice.updateStatus');

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
            $scolarite_path = BackOfficeDemandeController::getPath($id, 'cvec');

            if ($scolarite_path) {
                return Response::file($scolarite_path, ['Content-Type' => 'application/pdf']);
            } else {
                abort(404);
            }
        })->name('assets.pdf.cvec');
    });
});

Route::get('/label', [LabelController::class, 'viewPdf'])->name('label');
