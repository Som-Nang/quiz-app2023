<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\QuizController;

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

Route::get('/', function () {
    return Inertia::render('Home');
});

Route::get('/question', [QuestionController::class,'index'])->name('question');
Route::post('/question', [QuestionController::class,'store']);
Route::put('/answers', [AnswerController::class,'update']);
Route::delete('/question/{question}', [QuestionController::class,'destroy']);

Route::get('/quiz', [QuizController::class,'index']);
Route::post('/results', [QuizController::class,'results']);

Route::fallback(function(){
    return Inertia('Home');
});
require __DIR__.'/auth.php';
