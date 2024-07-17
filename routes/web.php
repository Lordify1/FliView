
<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProductImagesController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CustomerShippingInfoController;
use App\Http\Controllers\CookieController;
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
    return view('index');
})->name('index');


Route::get('/dashboard',[UserController::class, 'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/my_shipping_info', [CustomerShippingInfoController::class, 'edit'])->name('shipping.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/myshop', [ShopController::class, 'my_shop'])->name('shop.edit');
});

Route::middleware('auth')->group(function () {
    Route::get('/my_shipping_info', [CustomerShippingInfoController::class, 'edit'])->name('shipping.edit');
    Route::post('/my_shipping_info', [CustomerShippingInfoController::class, 'store'])->name('shipping.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/shop', [ShopController::class, 'edit'])->name('shop.create');
    Route::post('/shop', [ShopController::class, 'store'])->name('shop.store');
    Route::post('/myshop', [ShopController::class, 'update'])->name('shop.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/myshop', [ShopController::class, 'my_shop'])->name('shop.edit');

    //orders start

    Route::get('/orders', [OrderController::class, 'view_my_orders'])->name('orders.view');
    Route::post('/conclude', [OrderController::class, 'conclude'])->name('orders.conclude');
    Route::post('/pend', [OrderController::class, 'pend'])->name('orders.pend');

    //orders end
});

// lga route start

Route::post('/get_lga_by_state', [ProfileController::class, 'lgabystate'])->name('state_lga');

// lga route end

// email verification start

Route::get('/test_email', [ProfileController::class, 'testemail'])->name('test');
Route::post('/test_email', [ProfileController::class, 'logmail'])->name('mail');
Route::get('/verify_email', [RegisteredUserController::class, 'new_token'])->name('email_resend');
Route::post("/new_token", [RegisteredUserController::class, 'the_new_token'])->name("resend_regmail");

// email verification end

Route::middleware('auth')->group(function () {
    Route::get('/product', [ProductController::class, 'edit'])->name('product.create');
    Route::post('/product', [ProductController::class, 'store'])->name('product.store');
    Route::get('/myproduct/{id}', [ProductController::class, 'redo'])->name('product.edit');
    Route::post('/myproduct/{id}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/delete/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    Route::delete('my_product_image', [ProductImagesController::class, 'delete_image'])->name('image.destroy');
    // Route::get('/myproduct', [ProductController::class, 'my_product'])->name('product.edit');
});

Route::middleware('auth')->group(function () {
    Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('cart.add');
    Route::get('cart', [CartController::class, 'cartItems'])->name('cart.view');
    Route::delete('/delete-from-cart', [CartController::class, 'removeFromCart'])->name('cart.delete');
    Route::delete('/destroy-from-cart', [CartController::class, 'destroyFromCart'])->name('item.destroy');
});


//email verify start
Route::get('/verify_email/{token}',[RegisteredUserController::class, 'email_verify'])->name("verify_email");
// email verify end

Route::get('/index',[UserController::class, 'index'])->name("index");
Route::get('/all_shops',[ShopController::class, 'all_shops'])->name("all_shops");
Route::get('/shop/{fdl}',[ShopController::class, 'this_shop'])->name("this_shop");
Route::get('/all_products',[ProductController::class, 'all_products'])->name("all_products");
Route::get('/contact',[UserController::class, 'contact_us'])->name("contact");
Route::get('/product/{id}', [ProductController::class, 'this_product'])->name('product.this');

//All about reviews

Route::post('/product/{id}',[ReviewController::class, 'store'])->name("review.store");
//All about reviews

//All about chat

Route::get('shop_contact/{name}', [ChatController::class, 'contact_shop'])->name('contact.view');

//All about chat end

//All about order

Route::post('/send_my_order', [OrderController::class, 'store'])->name('order.store');

//All about order end


Route::get('/shop_search', [ShopController::class, 'search_shops'])->name('shop.search');
Route::get('/shop_products_search', [ProductController::class, 'search_shop_products'])->name('shop.search_items');
Route::get('all_products_search', [ProductController::class, 'search_all_products'])->name('all_products.search');
Route::get('/products/{category}', [ProductController::class, 'product_category_show'])->name('products.category');


// admin end start 

Route::get("/admin/login", [AdminController::class, "admin_login"]);
Route::post("block_user", [AdminController::class, "block_user"])->name("block_user");
Route::post("unblock_user", [AdminController::class, "unblock_user"])->name("unblock_user");
Route::post("block_shop", [AdminController::class, "block_shop"])->name("block_shop");
Route::post("unblock_shop", [AdminController::class, "unblock_shop"])->name("unblock_shop");
Route::post("block_product", [AdminController::class, "block_product"])->name("block_product");
Route::post("unblock_product", [AdminController::class, "unblock_product"])->name("unblock_product");
// admin end end



// Forgot password start

Route::get("reset_password", [ResetPasswordController::class, "get"])->name("password_page");

// Forgot password end


//cookie play
Route::post('/cookie', [CookieController::class, 'index'])->name('namecookie');
Route::get('/test', [CookieController::class, 'test']);
Route::get('/cookieget', [CookieController::class, 'get']);
Route::get('/cookiedestroy', [CookieController::class, 'destroy']);


Route::get('/api', [ApiCOntroller::class, 'index']);
Route::post('/pay', [ApiController::class, 'initiatePayment'])->name('payup');

require __DIR__.'/auth.php';