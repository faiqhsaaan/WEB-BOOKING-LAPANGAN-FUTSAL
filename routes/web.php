<?php

use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DependantDropdownController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\front\HomeController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\KeuanganController;
use App\Http\Controllers\LapanganController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromotionController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Models\Brand;
use App\Models\Regency;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('front.index');
});


Route::get('/', [HomeController::class, 'index'])->name('home.index'); 
Route::get('/home/profile', [HomeController::class, 'profile'])->name('home.profile'); 
Route::put('/home/profile/edit/{id}', [HomeController::class, 'edit_profile'])->name('home.edit.profile'); 
Route::get('/search', [HomeController::class, 'search'])->name('home.search'); 
Route::get('/detail/{lapangan}', [HomeController::class, 'detail_futsal'])->name('home.detail');
Route::get('/detail/{lapangan}/{field}', [HomeController::class, 'jadwal_detail'])->name('jadwal.detail');
Route::get('/jadwal', [HomeController::class, 'getEvents']);

Route::get('/home/{lapangan}/about', [HomeController::class, 'home_about'])->name('home.about');
Route::get('/detail/gallery/{id}', [HomeController::class, 'gallery_futsal'])->name('home.gallery');
Route::get('/detail/gallery/create/{id}', [HomeController::class, 'gallery_add'])->name('home.gallery.create');


Route::get('/chart', [BookingController::class, 'chart'])->name('chart')->middleware('auth');;
Route::post('/chart/create', [BookingController::class, 'add_chart'])->name('add-to-chart');
Route::delete('/chart/{id}', [BookingController::class, 'chart_destroy'])->name('chart.destroy');

Route::post('/review/rating', [BookingController::class, 'review'])->name('review.rating');

Route::get('/transaction', [BookingController::class, 'transaction'])->name('transaction.index')->middleware('auth');;
Route::get('/transaction/{id}', [BookingController::class, 'transaction_detail'])->name('transaction.detail')->middleware('auth');;
Route::delete('/booking/{id}', [BookingController::class, 'delete_booking'])->name('delete.booking');
Route::post('/payment', [BookingController::class, 'payment'])->name('payment');

Route::get('/callback/notify', [BookingController::class, 'notify'])->name('callback.notify');
Route::post('/callback/return', [BookingController::class, 'return'])->name('callback.return');
Route::view('/cancel', 'callback.cancel')->name('callback.cancel');

Route::resource('home_contact', CommentController::class);

Route::post('/save-booking', [HomeController::class, 'saveBooking'])->name('save-booking');

// Route::get('/api/regencies/{province}', function($province) {
//     return Regency::where('province_id', $province)->get();
// });

Route::post('/jadwal/update-status', [JadwalController::class, 'updateStatus'])->name('jadwal.updateStatus');
Route::post('/jadwal/update-price', [JadwalController::class, 'updatePrice'])->name('jadwal.updatePrice');

Route::get('/transaction/{id}/pdf', [BookingController::class, 'generatePDF'])->name('transaction.pdf');
// Route::post('/jadwal/bulk-order', [JadwalController::class, 'bulkOrder'])->name('jadwal.bulkOrder');

Route::middleware('auth')->group(function () {
    
    Route::get('/api/regencies/{province}', function($province) {
        return Regency::where('province_id', $province)->get();
    });

    Route::get('/home/profile', [HomeController::class, 'profile'])->name('home.profile'); 
    Route::put('/home/profile/edit/{id}', [HomeController::class, 'edit_profile'])->name('home.edit.profile'); 

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/profile', [HomeController::class, 'profile'])->name('home.profile');
    Route::put('/profile/edit/{id}', [HomeController::class, 'edit_profile'])->name('home.edit.profile');
    
    Route::resource('lapangan', LapanganController::class);
    Route::resource('field', FieldController::class);

    Route::post('/fields/{field}/extend-schedule', [FieldController::class, 'extendSchedule'])->name('field.extend-schedule');
    
    Route::get('laporan', [ReportController::class, 'report'])->name('report');
    
    Route::get('jadwal/{field}', [JadwalController::class, 'index'])->name('jadwal.index');
    Route::get('jadwal/create/{field}', [JadwalController::class, 'create'])->name('jadwal.create');
    Route::post('jadwal/create/process/{field}', [JadwalController::class, 'store'])->name('jadwal.store');
    Route::get('jadwal/edit/{field}/{jadwal}', [JadwalController::class, 'edit'])->name('jadwal.edit');
    Route::put('jadwal/edit/process/{jadwal}', [JadwalController::class, 'update'])->name('jadwal.update');
    Route::delete('jadwal/delete/{field}/{id}', [JadwalController::class, 'destroy'])->name('jadwal.destroy');
    
    Route::resource('brand', LogoController::class);
    Route::resource('contact', ContactController::class);

    Route::resource('discount', DiscountController::class);
    Route::get('/get-fields/{lapanganId}', [DiscountController::class, 'getFields']);
    Route::resource('promotion', PromotionController::class);
    Route::get('promotions/data', [PromotionController::class, 'getData'])->name('promotions.data');
    Route::resource('keuangan', KeuanganController::class);
    Route::resource('feedback', FeedbackController::class);
    Route::resource('review', ReviewController::class);

    Route::resource('user', UserController::class);
    Route::resource('notifications', NotificationController::class)->except(['create', 'edit', 'show']);
    // Route::get('jadwal/search', [JadwalController::class, 'search'])->name('jadwal.search');
});

// Route::get('/provinces', [ProvinceController::class, 'getProvinces']);


require __DIR__.'/auth.php';
