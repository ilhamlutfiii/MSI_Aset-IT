<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\PinjamController;
use App\Http\Controllers\AsetReviewController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MaintenanceController;
use \UniSharp\LaravelFilemanager\Lfm;
use Illuminate\Support\Facades\Auth;

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

// CACHE CLEAR ROUTE
Route::get('cache-clear', function () {
    Artisan::call('optimize:clear');
    session()->flash('success', 'Cache Berhasil Dibersihkan.');
    return redirect()->back();
})->name('cache.clear');


// STORAGE LINKED ROUTE
Route::get('storage-link', [AdminController::class, 'storageLink'])->name('storage.link');


Auth::routes(['login' => true]);

Route::get('user/login', [FrontendController::class, 'login'])->name('login.form');
Route::post('user/login', [FrontendController::class, 'loginSubmit'])->name('login.submit');
Route::get('user/logout', [FrontendController::class, 'logout'])->name('user.logout');
// Socialite
Route::get('login/{provider}/', [LoginController::class, 'redirect'])->name('login.redirect');
Route::get('login/{provider}/callback/', [LoginController::class, 'Callback'])->name('login.callback');

Route::get('/', [FrontendController::class, 'home'])->name('home');

// Frontend Routes
Route::get('/home', [FrontendController::class, 'index']);
Route::get('/about-us', [FrontendController::class, 'aboutUs'])->name('about-us');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact/message', [MessageController::class, 'store'])->name('contact.store');
Route::get('aset-detail/{slug}', [FrontendController::class, 'asetDetail'])->name('aset-detail');
Route::post('/aset/search', [FrontendController::class, 'asetSearch'])->name('aset.search');
Route::get('/aset-cat/{slug}', [FrontendController::class, 'asetCat'])->name('aset-cat');
Route::get('/aset-sub-cat/{slug}/{sub_slug}', [FrontendController::class, 'asetSubCat'])->name('aset-sub-cat');
Route::get('/aset-brand/{slug}', [FrontendController::class, 'asetBrand'])->name('aset-brand');
// Cart section
Route::get('/add-to-cart/{slug}', [CartController::class, 'addToCart'])->name('add-to-cart')->middleware('user');
Route::post('/add-to-cart', [CartController::class, 'singleAddToCart'])->name('single-add-to-cart')->middleware('user');
Route::get('cart-delete/{id}', [CartController::class, 'cartDelete'])->name('cart-delete');
Route::post('cart-update', [CartController::class, 'cartUpdate'])->name('cart.update');

Route::get('/keranjang', function () {
    return view('frontend.pages.cart');
})->name('cart');
Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout')->middleware('user');
// Wishlist
Route::get('/wishlist', function () {
    return view('frontend.pages.wishlist');
})->name('wishlist');
Route::get('/wishlist/{slug}', [WishlistController::class, 'wishlist'])->name('add-to-wishlist')->middleware('user');
Route::get('wishlist-delete/{id}', [WishlistController::class, 'wishlistDelete'])->name('wishlist-delete');
Route::post('cart/pinjam', [PinjamController::class, 'store'])->name('cart.pinjam');
Route::get('/income', [PinjamController::class, 'incomeChart'])->name('aset.pinjam.income');
Route::get('/aset-grids', [FrontendController::class, 'asetGrids'])->name('aset-grids');
Route::get('/aset-lists', [FrontendController::class, 'asetLists'])->name('aset-lists');
Route::match(['get','post'],'/filter','FrontendController@asetFilter')->name('asetit.filter');

// Blog
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/blog-detail/{slug}', [FrontendController::class, 'blogDetail'])->name('blog.detail');
Route::get('/blog/search', [FrontendController::class, 'blogSearch'])->name('blog.search');
Route::post('/blog/filter', [FrontendController::class, 'blogFilter'])->name('blog.filter');
Route::get('blog-cat/{slug}', [FrontendController::class, 'blogByCategory'])->name('blog.category');
Route::get('blog-tag/{slug}', [FrontendController::class, 'blogByTag'])->name('blog.tag');

// NewsLetter
Route::post('/subscribe', [FrontendController::class, 'subscribe'])->name('subscribe');

// aset Review
Route::resource('/review', 'AsetReviewController');
Route::post('aset/{slug}/review', [AsetReviewController::class, 'store'])->name('review.store');
Route::get('aset/review/show/{id}', [AsetReviewController::class, 'show'])->name('review.show');




// Backend section start

Route::group(['prefix' => '/admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');
    // user route
    Route::resource('users', 'UsersController');
    // unit 
    Route::resource('units', 'UnitController');
    // jabatan 
    Route::resource('jabatans', 'JabatanController');
    // bidang 
    Route::resource('bidangs', 'BidangController');
    // fungsi 
    Route::resource('fungsis', 'FungsiController');
    // maintenance 
    Route::resource('maintenance', 'MaintenanceController');
    
    Route::get('aset/maintenance', [MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::get('aset/maintenance/show/{id}', [MaintenanceController::class, 'show'])->name('maintenance.show');
    Route::resource('/maintenance', 'MaintenanceController');
    Route::get('aset/maintenance/maintenance-logs/{id}', [MaintenanceController::class, 'indexLog'])->name('maintenance.indexLog');

    // Profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('admin-profile');
    Route::post('/profile/{id}', [AdminController::class, 'profileUpdate'])->name('profile-update');
    // Category
    Route::resource('/category', 'CategoryController');
    // aset
    Route::resource('/aset', 'AsetController');
    // Ajax for sub category
    Route::post('/category/{id}/child', 'CategoryController@getChildByParent');
    // Message
    Route::resource('/message', 'MessageController');
    Route::get('/message/five', [MessageController::class, 'messageFive'])->name('messages.five');

    // pinjam
    Route::resource('/pinjam', 'PinjamController');
    Route::post('/pinjam/return/{id}', [PinjamController::class, 'return'])->name('pinjam.return');

    // Settings
    Route::get('settings', [AdminController::class, 'settings'])->name('settings');
    Route::post('setting/update', [AdminController::class, 'settingsUpdate'])->name('settings.update');

    // Notification
    Route::get('/notification/{id}', [NotificationController::class, 'show'])->name('admin.notification');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('all.notification');
    Route::delete('/notification/{id}', [NotificationController::class, 'delete'])->name('notification.delete');
    // Password Change
    Route::get('change-password', [AdminController::class, 'changePassword'])->name('change.password.form');
    Route::post('change-password', [AdminController::class, 'changPasswordStore'])->name('change.password');
});


// User section start
Route::group(['prefix' => '/user', 'middleware' => ['user']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('user');
    // Profile
    Route::get('/profile', [HomeController::class, 'profile'])->name('user-profile');
    Route::post('/profile/{id}', [HomeController::class, 'profileUpdate'])->name('user-profile-update');
    //  user pinjam
    Route::get('/pinjam', "HomeController@PinjamIndex")->name('user.pinjam.index');
    Route::get('/pinjam/show/{id}', "HomeController@pinjamShow")->name('user.pinjam.show');
    Route::delete('/pinjam/delete/{id}', [HomeController::class, 'userPinjamDelete'])->name('user.pinjam.delete');
    // user asetReview
    Route::get('/user-review', [HomeController::class, 'asetReviewIndex'])->name('user.asetreview.index');
    Route::delete('/user-review/delete/{id}', [HomeController::class, 'asetReviewDelete'])->name('user.asetreview.delete');
    Route::get('/user-review/edit/{id}', [HomeController::class, 'asetReviewEdit'])->name('user.asetreview.edit');
    Route::get('/user-review/show/{id}', [HomeController::class, 'asetReviewShow'])->name('user.asetreview.show');
    Route::patch('/user-review/update/{id}', [HomeController::class, 'asetReviewUpdate'])->name('user.asetreview.update');

    //  user bantuan
    Route::get('/bantuan', "HomeController@bantuanIndex")->name('user.bantuan.index');
    Route::post('/bantuan/repair', "HomeController@bantuanStore")->name('user.bantuan.store');
    Route::get('/bantuan/show/{id}', "HomeController@bantuanShow")->name('user.bantuan.show');
    Route::get('/bantuan/kontak', "HomeController@bantuanKontak")->name('user.bantuan.kontak');
    Route::delete('/bantuan/delete/{id}', [HomeController::class, 'userBantuanDelete'])->name('user.bantuan.delete');

    // Password Change
    Route::get('change-password', [HomeController::class, 'changePassword'])->name('user.change.password.form');
    Route::post('change-password', [HomeController::class, 'changPasswordStore'])->name('change.password');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    Lfm::routes();
});
