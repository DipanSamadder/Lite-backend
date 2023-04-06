<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ContactFormController;
use App\Http\Controllers\MailController;


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
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('contact-form/submit-data', [ContactFormController::class, 'ajax_submit_data'])->name('contact_form.submit_data');


Route::get('/p/{slug}', [PagesController::class, 'show_custom_page'])->name('custom-pages.show_custom_page');
Route::get('/b/{slug}', [PostController::class, 'show_custom_blogs'])->name('blogs.show_blog');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
