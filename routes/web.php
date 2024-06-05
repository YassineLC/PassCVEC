<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AideController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\LabelController;
use App\Http\Controllers\BackOfficeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PostController::class, 'index'])->name('form');
Route::post('/store-form', [PostController::class, 'store'])->name('store-form');
Route::get('/aide', [AideController::class, 'index'])->name('aide');

Route::prefix('backoffice')->group(function() {
    Route::get('/', [BackOfficeController::class, 'index'])->name('backoffice.index');
    Route::get('/{id}', [BackOfficeController::class, 'afficherDemande'])->name('backoffice.demande');

    Route::prefix('assets')->group(function() {
        Route::get('pdf/scolarite/{id}', function ($id) {
            $scolarite_path = BackOfficeController::getPath($id, 'scolarite');

            if ($scolarite_path) {
                return Response::file($scolarite_path, ['Content-Type' => 'application/pdf']);
            } else {
                abort(404);
            }
        })->name('assets.pdf.scolarite');

        Route::get('pdf/cvec/{id}', function ($id) {
            $scolarite_path = BackOfficeController::getPath($id, 'cvec');

            if ($scolarite_path) {
                return Response::file($scolarite_path, ['Content-Type' => 'application/pdf']);
            } else {
                abort(404);
            }
        })->name('assets.pdf.cvec');
    });
});

Route::get('/label', [LabelController::class, 'viewPdf'])->name('label');
