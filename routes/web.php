<?php

use App\Http\Livewire\Sale;
use App\Http\Livewire\Coins;
use App\Http\Livewire\Roles;
use App\Http\Livewire\Users;
use App\Http\Livewire\Asignar;
use App\Http\Livewire\Cashout;
use App\Http\Livewire\Reports;
use App\Http\Livewire\Products;
use App\Http\Livewire\Categories;
use App\Http\Livewire\Permissions;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportController;

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

Route::get('/', function(){
    return Redirect::to('/login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('categories', Categories::class);
Route::get('products', Products::class);
Route::get('coins', Coins::class);
Route::get('sales', Sale::class);
Route::get('roles', Roles::class);
Route::get('permissions', Permissions::class);
Route::get('asignar', Asignar::class);
Route::get('users', Users::class);
Route::get('cashout', Cashout::class);
Route::get('reports', Reports::class);

//Reportes PDF
Route::get('/report/pdf/{userId}/{reportType}/{dateFrom}/{dateTo}', [ExportController::class, 'reportPDF']);
Route::get('/report/pdf/{userId}/{reportType}', [ExportController::class, 'reportPDF']);


//Reportes Excel
Route::get('/report/excel/{userId}/{reportType}/{dateFrom}/{dateTo}', [ExportController::class, 'reportExcel']);
Route::get('/report/excel/{userId}/{reportType}', [ExportController::class, 'reportExcel']);
