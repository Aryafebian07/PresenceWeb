<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DosenController;
use App\Http\Controllers\Admin\JadwalController;
use App\Http\Controllers\Admin\kelaseController;
use App\Http\Controllers\Admin\MahasiswaController;
use App\Http\Controllers\Admin\MatkulController;
use App\Http\Controllers\Admin\ProdiController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\RoleController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Jetstream\Rules\Role;

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
    if(Auth::check()){
        return redirect('/dashboard');
    }else{
        return redirect('/login');
    }
    // return Inertia::render('Welcome', [
    //     'canLogin' => Route::has('login'),
    //     'canRegister' => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion' => PHP_VERSION,
    // ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified','role:admin'
])->group(function () {

    Route::get('/dashboard',[DashboardController::class,'index'])->name('dashboard');
    // Route::get('/users',[UsersController::class,'index'])->name('users');
    // Route::get('/roles',[RoleController::class,'index'])->name('roles');
    Route::resource('/user',UsersController::class);
    Route::resource('/roles',RoleController::class);
    Route::resource('/users',UsersController::class);
    Route::resource('/prodis',ProdiController::class);
    Route::resource('/matkuls',MatkulController::class);
    Route::resource('/dosens',DosenController::class);
    Route::resource('/mahasiswas',MahasiswaController::class);
    Route::resource('/kelases',kelaseController::class);
    Route::resource('/jadwals',JadwalController::class);
});
