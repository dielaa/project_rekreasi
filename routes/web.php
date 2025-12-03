<?php

use App\Http\Controllers\FacilityController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return view('home');
})->name('home');


Route::prefix('ticket')->group(function () {
    Route::get('/', [TicketController::class, 'listTicket'])->name('ticket');
});
Route::post('/cart/add', [TicketController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [TicketController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [TicketController::class, 'removeCart'])->name('cart.remove');
Route::get('/reservation-summary', [TicketController::class, 'reservation'])->name('reservation.summary');
Route::get('/payment', [PaymentController::class, 'payment'])->name('payment');
Route::post('/finish-payment', [PaymentController::class, 'finishPayment'])->name('finish.payment');
Route::get('/payment-success/{invoice}', [PaymentController::class, 'success'])->name('paymentSuccess');
Route::get('/payment-success/pdf/{invoice}', [PaymentController::class, 'exportPdf'])->name('export_pdf');



Route::prefix('promo')->group(function () {
    Route::get('/', [PromoController::class, 'listPromo'])->name('promo');
});

Route::prefix('facility')->group(function () {
    Route::get('/', [FacilityController::class, 'listFacility'])->name('facility');
});


Route::prefix('dashboard')->name('dashboard.')->group(function () {
    Route::get('/', [AuthController::class, 'dashboard'])->name('dashboard');

    Route::prefix('/user')->middleware('checkRole:admin')->name('user.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/datatables', [UserController::class, 'getUsers'])->name('datatables');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [UserController::class, 'destroy'])->name('delete');
        // Route::get('/export',  [UserController::class, 'export'])->name('export');
        // Route::get('/trash', [UserController::class, 'trash'])->name('trash');
        // Route::get('/trash/datatables', [UserController::class, 'getTrashUer'])->name('trash.datatables');
        // Route::patch('/restore/{id}', [UserController::class, 'restore'])->name('restore');
        // Route::delete('/delete-permanent/{id}', [UserController::class, 'deletePermanent'])->name('delete_permanent');

    });
    Route::get('/export', [UserController::class, 'export'])->name('export');
    Route::get('/trash/datatables', [UserController::class, 'getTrashUser'])->name('trash.datatables');
    Route::patch('/restore/{id}', [UserController::class, 'restore'])->name('restore');
    Route::delete('/delete-permanent/{id}', [UserController::class, 'deletePermanent'])->name('delete_permanent');
    Route::get('/trash', [UserController::class, 'trash'])->name('trash');


    Route::prefix('/payment')->middleware('checkRole:admin')->name('payment.')->group(function () {
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::get('/datatables', [PaymentController::class, 'getPayments'])->name('datatables');
        Route::get('/create', [PaymentController::class, 'create'])->name('create');
        Route::post('/store', [PaymentController::class, 'store'])->name('store');
        Route::get('edit/{id}', [PaymentController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [PaymentController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [PaymentController::class, 'destroy'])->name('delete');
        Route::get('/export', [PaymentController::class, 'export'])->name('export');
        Route::get('/trash', [PaymentController::class, 'trash'])->name('trash');
        Route::get('/trash/datatables', [PaymentController::class, 'getTrashPayment'])->name('trash.datatables');
        Route::patch('/restore/{id}', [PaymentController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [PaymentController::class, 'deletePermanent'])->name('delete_permanent');
    });


    Route::prefix('/facility')->middleware('checkRole:admin')->name('facility.')->group(function () {
        Route::get('/', [FacilityController::class, 'index'])->name('index');
        Route::get('/datatables', [FacilityController::class, 'getFacilities'])->name('datatables');
        Route::get('/create', [FacilityController::class, 'create'])->name('create');
        Route::post('/store', [FacilityController::class, 'store'])->name('store');
        Route::get('edit/{id}', [FacilityController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [FacilityController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [FacilityController::class, 'destroy'])->name('delete');
        Route::get('/export', [FacilityController::class, 'export'])->name('export');
        Route::get('/trash', [FacilityController::class, 'trash'])->name('trash');
        Route::get('/trash/get', [FacilityController::class, 'getTrashFacilities'])->name('trash.datatables');
        Route::patch('/restore/{id}', [FacilityController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [FacilityController::class, 'deletePermanent'])->name('delete_permanent');

    });

    Route::prefix('/promo')->middleware('checkRole:admin,staff')->name('promo.')->group(function () {
        Route::get('/', [PromoController::class, 'index'])->name('index');
        Route::get('/datatables', [PromoController::class, 'getPromo'])->name('datatables');
        Route::get('/create', [PromoController::class, 'create'])->name('create');
        Route::post('/store', [PromoController::class, 'store'])->name('store');
        Route::get('edit/{id}', [PromoController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [PromoController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [PromoController::class, 'destroy'])->name('delete');
        Route::get('/export', [PromoController::class, 'export'])->name('export');
        Route::get('/trash', [PromoController::class, 'trash'])->name('trash');
        Route::get('/trash/datatables', [PromoController::class, 'getTrashPromo'])->name('trash.datatables');
        Route::patch('/restore/{id}', [PromoController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [PromoController::class, 'deletePermanent'])->name('delete_permanent');


    });

    Route::prefix('/ticket')->middleware('checkRole:admin,staff')->name('ticket.')->group(function () {
        Route::get('/', [TicketController::class, 'index'])->name('index');
        Route::get('/datatables', [TicketController::class, 'getTicket'])->name('datatables');
        Route::get('/create', [TicketController::class, 'create'])->name('create');
        Route::post('/store', [TicketController::class, 'store'])->name('store');
        Route::get('edit/{id}', [TicketController::class, 'edit'])->name('edit');
        Route::put('update/{id}', [TicketController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [TicketController::class, 'destroy'])->name('delete');
        Route::get('/export', [TicketController::class, 'export'])->name('export');
        Route::get('/trash', [TicketController::class, 'trash'])->name('trash');
        Route::get('/trash/datatables', [TicketController::class, 'getTrashTicket'])->name('trash.datatables');
        Route::patch('/restore/{id}', [TicketController::class, 'restore'])->name('restore');
        Route::delete('/delete-permanent/{id}', [TicketController::class, 'deletePermanent'])->name('delete_permanent');
        Route::get('/chart/data', [TicketController::class, 'chartData'])->name('chart');
        Route::get('/chart/status', [TicketController::class, 'chartStatus'])->name('status');

    });
});