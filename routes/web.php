<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Controller;
use App\Http\Controllers\HomeController;

use App\Http\Controllers\Auth\AdminLoginController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\Admin\ChildCategoryController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductAttributeController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\OfferSectionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ReturnPolicyController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ShippingController;
use App\Http\Controllers\Admin\ReportController;

use App\Http\Controllers\Front\WishlistController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\AccountController;
use App\Http\Controllers\Front\PlaceOrderController;

use App\Http\Controllers\Payment\PaypalController;
use App\Http\Controllers\Payment\StripeController;
use App\Http\Controllers\Payment\RazorpayController;
use App\Http\Controllers\Payment\BankTransferController;
use App\Http\Controllers\Payment\CodController;
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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes(['verify'=>true]);
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/admin', [AdminLoginController::class, 'showLoginForm'])->name('admin.login.form');
Route::post('/admin', [AdminLoginController::class,'adminLogin'])->name('admin.login');

    Route::prefix('user')->group(function () {
        Route::get('category/{id}',[HomeController::class, 'category_wise_product']);
        Route::get('subcategory/{id}',[HomeController::class, 'subcategory_wise_product']);
        Route::post('subcategory/{id}',[HomeController::class, 'subcategory_wise_product']);
        Route::get('childcategory/{id}',[HomeController::class, 'childcategory_wise_product']);
        Route::post('childcategory/{id}',[HomeController::class, 'childcategory_wise_product']);
        Route::get('product/{id}',[HomeController::class, 'get_product_page']);
        Route::get('page/{slug}',[HomeController::class, 'get_pages_byslug']);
        
        // static pages
        Route::get('contact-us',[HomeController::class, 'contactus_page']);
        Route::post('contact-us',[HomeController::class, 'getConnect']);

        Route::get('about-us',[HomeController::class, 'aboutus']);
        Route::get('term-and-condition',[HomeController::class, 'tnc_page']);
        Route::get('faq',[HomeController::class, 'faq_page']);
        Route::post('subscription',[HomeController::class, 'subscription']);
        Route::get('search/product/filter',[HomeController::class,'search_products'])->name('search.products');

        
        Route::group(['middleware' => ['auth','verified']], function () {
            
            Route::resource('add-to-cart',CartController::class);
            Route::get('update-qty-to-cart',[CartController::class,'update']);
            Route::get('wishlist',[WishlistController::class, 'index'])->name('wishlist');
            Route::get('add-to-wishlist/{id}',[WishlistController::class, 'AddtoWishlist']);
            Route::get('remove-to-wishlist/{id}',[WishlistController::class, 'RemovetoWishlist']);

            Route::post('user-rating',[HomeController::class,'save_user_rating'])->name('save.rating');
            Route::post('edit-user-rating/{id}',[HomeController::class,'update_user_rating'])->name('update.rating');

            Route::get('checkout',[CheckoutController::class,'index'])->name('checkout.step1');
            Route::get('/get/country/state/{country_id}',[CheckoutController::class,'get_state_by_country'])->name('country.wise.state');
            Route::post('checkout-user-shipping-address',[AccountController::class,'save_shipping_address']);
            Route::post('add/billing/address',[CheckoutController::class,'add_billing_address']);

            Route::post('cod/checkout', [CodController::class,'payviacod'])->name('cod.checkout');

            Route::post('paypal', [PaypalController::class,'payment'])->name('paypal');
            Route::get('paypal/cancel', [PaypalController::class,'cancel'])->name('paypal.cancel');
            Route::get('paypal/success', [PaypalController::class,'success'])->name('paypal.success');

            Route::post('stripe', [StripeController::class,'stripePost'])->name('stripe.post');

            Route::post('razorpay/payment', [RazorpayController::class, 'store'])->name('razorpay.payment.store');
            
            Route::get('order-complete-thankyou-page', [PlaceOrderController::class, 'order_complete'])->name('order.done');

            Route::post('bank/transfer', [BankTransferController::class, 'payProcess'])->name('bank.transfer.process');

            Route::get('my-account', [AccountController::class, 'dashboard'])->name('my.account');
            Route::get('my-bank-account', [AccountController::class, 'my_bank_account'])->name('my.bank.account');
            Route::post('my-bank-account', [AccountController::class, 'save_bank_account'])->name('save.bank.detail');

            Route::get('my-shipping-address', [AccountController::class, 'my_shipping_add'])->name('my.ship.address');
            Route::get('my-orders', [AccountController::class, 'my_orders'])->name('my.orders');

            Route::post('cancel/order/item/{item_id}', [AccountController::class, 'cancel_order_item'])->name('user.cancel.item');

            Route::get('/view/order/{order_id}', [AccountController::class, 'view_orders'])->name('order.view');

            Route::post('profile/update', [AccountController::class, 'user_profile_update'])->name('profile.update');
            Route::post('profile/password/update', [AccountController::class, 'user_password_update'])->name('profile.pass.upd');

            Route::get('return/product/{id}',[AccountController::class,'returnWindow'])->name('return.window');
            Route::post('/return/product/processed/{id}',[AccountController::class,'returnProcessed'])->name('return.process');

            
        });
    });

Route::group(['middleware' => ['is_admin', 'auth','verified']], function () {
    Route::prefix('admin')->group(function () {

        Route::get("home", [AdminController::class,'index'])->name('admin.home');
        
        Route::get("general-setting", [SettingController::class,'index'])->name('admin.general.setting');
        Route::post("general-setting", [SettingController::class,'general_store'])->name('admin.general.setting.save');

        Route::get("pages-setting", [SettingController::class,'pages_index'])->name('admin.pages.setting');
        Route::post("pages-setting/{page_name}", [SettingController::class,'pages_store'])->name('admin.pages.setting.save');

        Route::resource("faq", FaqController::class);
        Route::post('quickupdate/faq/{id}', [FaqController::class,'faqUpdate'])->name('faq.quick.update');

        Route::get("email-setting", [SettingController::class,'email_setting_index'])->name('admin.email.setting');
        Route::post("email-setting", [SettingController::class,'email_setting_store'])->name('admin.email.setting.save');

        Route::get("social-setting", [SettingController::class,'social_setting_index'])->name('admin.social.setting');
        Route::post("social-setting", [SettingController::class,'social_setting_store'])->name('admin.social.setting.save');

        Route::get("payment-setting", [SettingController::class,'payment_index'])->name('admin.payment.setting');
        Route::post("paypal-setting", [SettingController::class,'paypal_setting'])->name('paypal.setting.update');
        Route::post("stripe-setting", [SettingController::class,'stripe_setting'])->name('stripe.setting.update');
        Route::post("razorpay-setting", [SettingController::class,'razorpay_setting'])->name('rpay.setting.update');
        Route::post("bank_details", [SettingController::class,'bank_details_setting'])->name('bank_details.setting.update');
        Route::get("footer-menus",[SettingController::class,'footer_menu_setting'])->name('admin.footer.menu');
        Route::post("footer-menus/{id}",[SettingController::class,'footer_menu_setting_db'])->name('admin.footer.menu');
        Route::get("banners-setting",[SettingController::class,'banners_setting'])->name('admin.banners.setting');
        Route::post("banners-setting",[SettingController::class,'banners_setting_db']);

        Route::resource("topcategory", CategoryController::class);
        Route::post("quickupdate/topcategory/{id}", [CategoryController::class,'status_update'])->name('topcat.status.update');

        Route::resource("subcategory", SubCategoryController::class);
        Route::post("quickupdate/subcategory/{id}", [SubCategoryController::class,'status_update'])->name('subcat.status.update');

        Route::resource("childcategory", ChildCategoryController::class);
        Route::post("quickupdate/childcategory/{id}", [ChildCategoryController::class,'status_update'])->name('childcat.status.update');


        Route::get("subcatdropdown", [ChildCategoryController::class,'get_subcat_api'])->name('subcat.dropdown');

        Route::resource("menu", MenuController::class);
        Route::get("menulistapi", [MenuController::class,'menu_list_api']);
        Route::post("quickupdate/menu/{id}", [MenuController::class,'status_update'])->name('menu.status.update');
    
        Route::resource("product", ProductController::class);
        Route::get("productlistapi", [ProductController::class,'product_list_api']);
        Route::post("quickupdate/product/status/{id}", [ProductController::class,'status_update'])->name('product.status.update');
        Route::get("product/photo/delete/api", [ProductController::class,'product_photo_delete_api']);
        Route::get("product/cat/attributes", [ProductController::class,'product_cat_attribute_api']);
        Route::get("products/import", [ProductController::class,'product_import'])->name('admin.product.import');
        Route::post("products/import", [ProductController::class,'product_import_db']);
        
        Route::get("childcatdropdown", [ChildCategoryController::class,'get_childcat_api'])->name('childcat.dropdown');

        Route::resource("attributes", ProductAttributeController::class);
        
        Route::resource("page", PageController::class);
        Route::post('quickupdate/page/{id}', [PageController::class,'pageStatusUpdate'])->name('page.quick.update');
    
        Route::resource("slider", SliderController::class);
        Route::resource("service", ServiceController::class);
        Route::resource("offers", OfferSectionController::class);
        Route::resource("users", UserController::class);
        Route::get('quickupdate/user/status/{id}',[UserController::class,'status_update'])->name('user.status.update');

        Route::resource("return-policy", ReturnPolicyController::class);
        Route::resource("shipping", ShippingController::class);
        Route::get('/shipping_update', [ShippingController::class,'shipping']);
        
        Route::get("subscribers", [SubscriptionController::class,'index'])->name('admin.subs');
        Route::post("subscriptions-delete/{id}", [SubscriptionController::class,'delete']);

        Route::get("review", [ReviewController::class,'index'])->name('admin.reviews');
        Route::post("review-delete/{id}", [ReviewController::class,'delete']);

        Route::get('all/orders',[OrderController::class,'all_orders'])->name('all.orders');
        Route::get('all/orders/edit/{orderid}',[OrderController::class,'all_orders_edit'])->name('all.orders.edit');
        Route::get('/fullorder/generate/invoice/{orderid}',[OrderController::class,'full_order_invoice_pdf'])->name('full.order.invoice');
        Route::get('/order/invoice/pdf/{invoice_id}',[OrderController::class,'single_prod_invoice'])->name('order.invoice.pdf');
        Route::get('update/orderstatus/{id}',[OrderController::class,'updateStatus'])->name('update.order');
        Route::get('manual/orderpayconfirm/{orderid}',[OrderController::class,'updatepayconfirm'])->name('update.payement.order');

        Route::get('all/completed/orders',[OrderController::class,'all_completed_order'])->name('all.completed.order');

        Route::get('all/return/orders',[OrderController::class,'all_return_orders'])->name('all.return.order');
        Route::get('get/return/order/detail/{id}',[OrderController::class,'view_return_order_detail'])->name('return.order.detail');
        Route::get('/show/update/return/order/{id}', [OrderController::class,'show_update_return_order_detail'])->name('return.order.show');
        Route::post('update/returnOrder/{id}', [OrderController::class,'update_return_order_detail'])->name('return.order.update');


        Route::get('all/cancel/orders',[OrderController::class,'all_cancel_orders'])->name('all.cancel.order');
        Route::post('update/cancel/order/status/{id}',[OrderController::class,'update_cancel_order_status'])->name('single.can.order');
        
        Route::post('cancel/orders/item/{item_id}',[OrderController::class,'cancel_product'])->name('cancel.item');
        
        Route::get('reports/sale',[ReportController::class,'sale_report'])->name('sale.report');
        Route::get('reports/stock',[ReportController::class,'stock_report'])->name('stock.report');
        Route::get('reports/sale/api',[ReportController::class,'sale_report_api'])->name('sale.report.api');

    });
});