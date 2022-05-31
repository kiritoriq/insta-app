<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostController;

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
    if (Auth::check()) {
        return redirect()->route('dashboard.index');
    } else {
        return view('auth.login');
    }
});

Route::post('login/auth', [LoginController::class, 'auth'])->name('login.auth');
Route::post('login/action', [LoginController::class, 'login_action'])->name('login.login_action');
Route::get('/reload-captcha', [LoginController::class, 'recaptcha'])->name('login.recaptcha');

Route::group([
    'middleware' => ['web', 'auth'],
    'prefix' => 'post',
    'as' => 'post.'
], function() {
    Route::get('', [PostController::class, 'allPost'])->name('all');
    Route::get('/{user_id}', [PostController::class, 'postByUser'])->name('user-post');
    Route::post('', [PostController::class, 'post'])->name('store');
    Route::get('/{post_id}', [PostController::class, 'edit'])->name('edit');
    Route::put('', [PostController::class, 'update'])->name('update');
    Route::delete('/{post_id}', [PostController::class, 'destroy'])->name('delete');
    Route::post('/comment/{post_id}', [PostController::class, 'postComment'])->name('comment');
    Route::post('/like/{post_id}', [PostController::class, 'postLike'])->name('likes');
});


// Demo routes
// Route::get('/datatables', 'PagesController@datatables');
// Route::get('/ktdatatables', 'PagesController@ktDatatables');
// Route::get('/select2', 'PagesController@select2');
// Route::get('/icons/custom-icons', 'PagesController@customIcons');
// Route::get('/icons/flaticon', 'PagesController@flaticon');
// Route::get('/icons/fontawesome', 'PagesController@fontawesome');
// Route::get('/icons/lineawesome', 'PagesController@lineawesome');
// Route::get('/icons/socicons', 'PagesController@socicons');
// Route::get('/icons/svg', 'PagesController@svg');

// Quick search dummy route to display html elements in search dropdown (header search)
Route::get('/quick-search', [PagesController::class, 'quickSearch'])->name('quick-search');

Auth::routes();
// Route::post('register', 'Auth\RegisterController@register')->name('register.action');
