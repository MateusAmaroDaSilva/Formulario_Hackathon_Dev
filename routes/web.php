<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DevMenthorsController;

Route::get('/', function () {
    return 'Laravel funcionando';
});

Route::get('/hackathon', function () {
    return view('hackathon');
});

Route::get('/inscricao', function () {
    return view('inscricao');
})->name('inscricao');

Route::post('/devmenthors/store', [DevMenthorsController::class, 'store'])->name('devmenthors.store');