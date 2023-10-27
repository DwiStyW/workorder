<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/test', function () {
    return view('ui-notifications');
});
// Route::get('/dashboard', function () {
//     return view('dashboard.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // tiket
    Route::get('/ticket',[TicketController::class, 'index'])->name('ticket');
    Route::get('/ticket-baru',[TicketController::class, 'index'])->name('ticket');
    Route::get('/ticket-disetujui',[TicketController::class, 'index'])->name('ticket');
    Route::get('/ticket-proses',[TicketController::class, 'index'])->name('ticket');
    Route::get('/ticket-selesai',[TicketController::class, 'index'])->name('ticket');
    Route::get('/ticket-ditutup',[TicketController::class, 'index'])->name('ticket');
    Route::get('/ticket-ditolak',[TicketController::class, 'index'])->name('ticket');

    Route::get('/detail-ticket/{id_notif}/{no_tiket}',[TicketController::class, 'detail_fromnotif']);
    Route::get('/detail-ticket/{no_tiket}',[TicketController::class, 'detail_fromticket']);

    Route::get('/ticket/add',[TicketController::class, 'create'])->name('add.ticket');
    Route::post('/ticket/post',[TicketController::class, 'store'])->name('post.ticket');
});

require __DIR__.'/auth.php';