<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\ContactUsSubjectController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\BlogController;
use App\Mail\MailgunTest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AuctiontypeController;
use App\Http\Controllers\Admin\SubcategoryController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BidvalueController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\BidrequestController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\HelpsupportController;
use App\Http\Controllers\Frontend\HomepageController;
use App\Http\Controllers\Frontend\DashboardController;
use App\Http\Controllers\Frontend\ProductWishController;
use App\Http\Controllers\Frontend\LangController;
use App\Http\Controllers\Frontend\BiddingController;
use App\Http\Controllers\Frontend\UserCategoryController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\MyFatoorahController;







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

// Route::get('/', function () {
//     return view('frontend.homepage');
// });

Route::get('/send-test',function(){
    Mail::to('elkhouly@gmail.com')->send(new MailgunTest('hi this is test message from laravel app'));
    return 'message sent succefully';
});
Route::get('/refer', [HomepageController::class, 'deeplink'])->name('refer');
Route::get('/paymentSuccess', [HomepageController::class,'paymentSuccess'])->name('paymentSuccess');
Route::get('/', [HomepageController::class,'homepage'])->name('homepage');
Route::get('contact-us', [HomepageController::class,'contactus'])->name('contact-us');
Route::get('privacy-policy', [HomepageController::class,'privacy'])->name('privacy-policy');
Route::get('terms-conditions', [HomepageController::class,'terms'])->name('terms-conditions');
Route::get('about-us', [HomepageController::class,'about'])->name('about-us');
// for mobile app
Route::get('termsconditions', [HomepageController::class,'termsconditions'])->name('termsconditions');
Route::get('privacypolicy', [HomepageController::class,'privacypolicy'])->name('privacypolicy');
Route::post('/mark-as-read/{notificationId}', [HomepageController::class,'markAsRead']);
//

Route::get('products-list', [HomepageController::class,'productlist'])->name('products-list');
Route::get('/projects/{auction_type_slug}', [HomepageController::class,'projectByAuctionType'])->name('projects.by_auction_type');
Route::get('/products/{slug}', [HomepageController::class,'productsByProject'])->name('productsByProject');
Route::get('pastauction', [HomepageController::class,'pastauction'])->name('pastauction');
Route::get('invoice', [HomepageController::class,'invoice'])->name('invoice');
Route::get('download-invoice',[DashboardController::class,'downloadInvoice'])->name('download-invoice');
// changes 01 may
Route::get('/productslive/{slug}', [HomepageController::class,'productsByProjectlive'])->name('productsByProjectlive');

// /webview live auction
Route::get('/productslive/{user_id}/{auction_id}/{project_id}', [HomepageController::class,'productsByProjectlivemobile'])->name('productsByProjectlivemobile');



// based on categorys
Route::get('/category/{categories_slug}', [HomepageController::class,'projectByCategory'])->name('projectByCategory');

Route::get('/categories/index', [UserCategoryController::class,'index'])->name('categories.index');

Route::get('/live-search', [HomepageController::class, 'liveSearch'])->name('live.search');


Route::get('/productsdetail/{slug}', [HomepageController::class,'productsdetail'])->name('productsdetail');
Route::get('signin', [HomepageController::class,'login'])->name('signin');
Route::post('loggedin', [HomepageController::class,'loggedin'])->name('loggedin');
Route::get('register', [HomepageController::class,'registration'])->name('register');
Route::post('registerTemp', [HomepageController::class,'registerTemp'])->name('registerTemp');
Route::post('registration', [HomepageController::class,'register'])->name('registration');
Route::post('verify-otp', [HomepageController::class,'verifyOTP'])->name('verify-otp');
Route::post('resend_otp',[HomepageController::class, 'resend_otp'])->name('resend_otp');
Route::get('/sendOtpForgetPassword', [HomepageController::class, 'sendOtpForgetPassword'])->name('sendOtpForgetPassword');
Route::get('/verifyOtpForgetPassword', [HomepageController::class, 'verifyOtpForgetPassword'])->name('verifyOtpForgetPassword');
Route::get('/updateNewPassword', [HomepageController::class, 'updateNewPassword'])->name('updateNewPassword');
Route::post('/subscribe', [HomepageController::class, 'subscribe'])->name('subscribe');
Route::post('/contactus', [HomepageController::class, 'contacstus'])->name('contactus');
Route::get('lang/home', [LangController::class, 'index']);
Route::get('lang/change', [LangController::class, 'change'])->name('changeLang');
Route::get('currency/change', [LangController::class, 'currencychange'])->name('currencychange');

Route::get('get-states/{countryId}', [BiddingController::class,'getStates'])->name('get-states');
Route::get('get-cities/{stateId}', [BiddingController::class,'getCities'])->name('get-cities');




// Route::get('/login/google', [SocialController::class,'redirectToGoogle']);
// Route::get('/login/google/callback', [SocialController::class,'handleGoogleCallback']);
// user Authenticated
Route::group(['middleware' => 'auth'],function(){
    Route::post('/validate-current-password', [DashboardController::class, 'validateCurrentPassword']);

    Route::get('/userdashboard', [DashboardController::class, 'userdashboard'])->name('userdashboard');
    Route::post('/profileupdate',[DashboardController::class,'profileupdate'])->name('profileupdate');
    Route::get('/logout',[DashboardController::class,'logout'])->name('logouts');
    Route::get('/changepassword',[DashboardController::class,'changepassword']);
    Route::post('/change-password',[DashboardController::class,'changePass'])->name('change-password');
    Route::get('/useraddress',[DashboardController::class,'useraddress'])->name('useraddress');
    Route::get('/auction',[DashboardController::class,'auction'])->name('auction');

    Route::post('adduseraddress', [DashboardController::class, 'adduseraddress'])->name('adduseraddress');
    Route::get('/addresseedit/{id}', [DashboardController::class, 'addresseedit'])->name('addresseedit');

    Route::get('/addressesprimary/{id}', [DashboardController::class, 'primary'])->name('addresses.primary');

    Route::get('/addressesdelete/{id}', [DashboardController::class,'delete'])->name('addresses.delete');
    Route::post('/addresses/update/{id}', [DashboardController::class, 'update'])->name('addresses.update');


    Route::get('/getwishlist',[DashboardController::class,'getwishlist'])->name('getwishlist');
    Route::post('/wishlist/add', [ProductWishController::class,'addToWishlist'])->name('addToWishlist');
    Route::post('/wishlist/remove', [ProductWishController::class,'removeFromWishlist'])->name('removeFromWishlist');
    Route::post('/store-bid-request', [DashboardController::class, 'bidstore'])->name('store.bid.request');
    Route::post('/bidplaced', [DashboardController::class, 'bidplaced'])->name('bidplaced');
    Route::post('/bidingplaced', [BiddingController::class, 'bidingplaced'])->name('bidingplaced');
    Route::get('checkout', [BiddingController::class,'checkout'])->name('checkout');
    // Route::post('/bidingplaced', [BiddingController::class, 'bidingplaced'])->name('bidingplaced');
    // Route::post('/paynow', [DashboardController::class, 'paynow'])->name('paynow');
    // Route::post('/myfatoorah/pay', [MyFatoorahController::class, 'index'])->name('myfatoorah.pay');        Route::post('/myfatoorah/callback', [MyFatoorahController::class, 'callback'])->name('myfatoorah.callback');
    // 02 may
    // مسار لإنشاء الفاتورة والدفع
// Route::post('/myfatoorah/pay', [MyFatoorahController::class, 'index'])->name('myfatoorah.pay');
Route::match(['get', 'post'], '/myfatoorah/pay', [MyFatoorahController::class, 'index'])->name('myfatoorah.pay');


// مسار لمعالجة الرد (callback) من MyFatoorah
Route::get('/myfatoorah/callback', [MyFatoorahController::class, 'callback'])->name('myfatoorah.callback');
    Route::post('/bidingplacedlive', [BiddingController::class, 'bidingplacedlive'])->name('bidingplacedlive');

});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// admin
Route::middleware(['user'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('get-categories/{auction}', [ProductController::class,'getcategories'])->name('get-categories');

Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('adlang', [LangController::class, 'index']);
    Route::get('adlang/change', [LangController::class, 'change'])->name('changeLang');
    Route::resource('users', UserController::class);
    Route::delete('admin/users/{id}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::post('updateStatususer/{id}', [UserController::class, 'updateStatususer'])->name('updateStatususer');
    // Route::post('destroy/{id}', [UserController::class, 'destroy'])->name('destroy');
    Route::resource('countries', CountryController::class);
    Route::resource('states', StateController::class);
    Route::resource('blogs', BlogController::class);
    Route::resource('contact-us', ContactUsController::class);
    Route::resource('contact-us-subjects', ContactUsSubjectController::class);
    Route::resource('pages', PageController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('subcategories', SubcategoryController::class);
    Route::resource('auctiontypes', AuctiontypeController::class);
    Route::resource('brands', BrandController::class);
    Route::resource('products', ProductController::class);
    Route::post('/products/{product}/approve', [ProductController::class, 'approve'])->name('products.approve');
    Route::post('/products/{product}/reject', [ProductController::class, 'reject'])->name('products.reject');

    Route::get('products/get-project/{auction}', [ProductController::class,'getprojects'])->name('products/get-project');
    Route::get('products/remove/{id}', [ProductController::class, 'deleteImage'])->name('admin.deleteImage');

    Route::resource('bidvalues', BidvalueController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('projects', ProjectController::class);
    Route::resource('news', NewsController::class);
    Route::delete('admin/news/{id}', [NewsController::class, 'destroy'])->name('admin.news.destroy');
    Route::resource('bidrequests', BidrequestController::class);
    Route::post('update-status', [BidrequestController::class, 'updateStatus'])->name('bidrequests.updateStatus');
    
    Route::post('bid-placed/update-status', [\App\Http\Controllers\Admin\BidPlacedController::class, 'updateStatus'])
    ->name('bid-placed.update-status');

    Route::resource('bid-placed', \App\Http\Controllers\Admin\BidPlacedController::class);

    Route::resource('language', LanguageController::class);
    Route::get('/profilesetting', [HomeController::class, 'profilesetting'])->name('profilesetting');
    Route::get('/profilesettingupdate', [HomeController::class, 'profilesettingupdate'])->name('profilesettingupdate');
    Route::resource('helpsupport', HelpsupportController::class);



});


// Route::get('/add-product', function () {
//     if (!auth()->check()) {
//         return redirect()->route('login');
//     }
//     return view('frontend.products.add_products');  // يمكنك تغيير هذا لعرض الصفحة التي تريدها
//     // return "test";  // يمكنك تغيير هذا لعرض الصفحة التي تريدها
// });

Route::middleware('auth')->group(function () {
    Route::get('/add-product', [FrontendProductController::class, 'create'])->name('frontend.product.create');
    Route::post('/add-product', [FrontendProductController::class, 'store'])->name('frontend.product.store');
    Route::get('/user/products', [FrontendProductController::class, 'userProducts'])->name('user.products');
    Route::get('/user/products/{id}/details', [FrontendProductController::class, 'productDetails'])->name('user.products.details');

});

require __DIR__.'/auth.php';
