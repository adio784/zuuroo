<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\OrderController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\AirtimeController;
use App\Http\Controllers\PaystackController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminFunctController;
use App\Http\Controllers\DingController;
use App\Http\Controllers\KycController;
use App\Http\Controllers\MessageDebtorsCondtroller;
use App\Http\Controllers\SystemAdminController;
use App\Http\Controllers\ServicesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('our_service', function () {
    return view('user-services');
});
Route::get('about_us', function () {
    return view('user-about');
});
Route::get('contact_us', function () {
    return view('contact_us');
});

Route::get('/home', function () {
    return view('app.user.home');
});



// Temporary Links ------------------------------------------------------------------>



//
// #################################### ---------------------------------------------->

Route::get('Countries', [CountryController::class, 'index']);
Route::get('/data_products', [UserController::class, 'data_products']);
Route::get('/airtime_products', [UserController::class, 'airtime_products']);
Route::get('/getToken', [UserController::class, 'getToken']);
Route::post('/verifyWebhookPayment', [PaystackController::class, 'verifyWebhookPaystack']);
Route::post('/verifyMonifyWebhookPayment', [PaystackController::class, 'verifyMonifyWebhookPayment']);
Route::get('/verifyRecurryInit', [PaystackController::class, 'verifyRecurryInit']);
Auth::routes(['verify' => true]);


Route::group(['middleware' => ['auth', 'verified']], function () {
    // User Ajax Links ---------------------------------------------------------------->
    Route::get('getCountries', [CountryController::class, 'index']);

    Route::get('/transactions', [UserController::class, 'transactions']);
    Route::get('/data_transactions', [UserController::class, 'data_transactions']);
    Route::get('/airtime_transactions', [UserController::class, 'airtime_transactions']);
    Route::get('/datas', [UserController::class, 'datas']);
    Route::get('/airtimes', [UserController::class, 'airtimes']);
    Route::get('/fund_histories', [UserController::class, 'fund_histories']);
    Route::get('/getToken', [DataController::class, 'createData']);
    Route::get('/paid_loans', [UserController::class, 'loans']);
    Route::get('/out_loans', [UserController::class, 'out_loans']);
    Route::get('/supports', [UserController::class, 'supports']);
    Route::get('/faqs', [UserController::class, 'faqs']);
    Route::get('/user_profile', [UserController::class, 'userProfile']);
    Route::get('/notifications', [UserController::class, 'notifications']);
    Route::get('/mobile', [UserController::class, 'mobile_view'])->name('mobile');
    Route::get('/verify_mobile', [UserController::class, 'view_mverify']);
    Route::get('/create_pin', [UserController::class, 'pin'])->name('create_pin');
    Route::get('/kyc', [UserController::class, 'country'])->name('country');
    Route::get('/pay_outstanding', [UserController::class, 'pay_outstanding'])->name('pay_outstanding');


    Route::post('/datas', [DataController::class, 'createData']);
    Route::post('/airtimes', [AirtimeController::class, 'createAirtime']);
    Route::post('/funds', [PaystackController::class, 'processPayment']);
    Route::post('/mobile', [UserController::class, 'mobile']);
    Route::post('/verify_otp', [UserController::class, 'verify_otp']);
    Route::post('/sendOTP', [UserController::class, 'sendOTP']);
    Route::post('/create_pin', [UserController::class, 'create_pin']);
    Route::post('/country', [KycController::class, 'verify_country']);
    Route::post('/update_password', [UserController::class, 'update_password']);
    Route::post('/update_phoneNumber', [UserController::class, 'update_phoneNumber']);
    Route::post('/initialize_transaction', [UserController::class, 'initialize_transaction']);


    Route::get('user_loanreceipt/{id}', [UserController::class, 'user_loan_receipt']);
    Route::get('/postpayment_callback.php', [PaystackController::class, 'verfifyPayment']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/funds', [UserController::class, 'funds']);
    Route::get('/abts', [UserController::class, 'abts']);

    Route::get('/request-api', [UserController::class, 'request_api']);

    Route::get('/clear-cache', function() {
        $output = new \Symfony\Component\Console\Output\BufferedOutput;
        \Illuminate\Support\Facades\Artisan::call('cache:clear', $output);
        dd($output->fetch());
    });
});


// Administrative Route
Route::get('/admin_register', [AdminController::class, 'admin_register'])->name('admin_register')->middleware('AlreadyLoggedAdmin');
Route::get('/admin_login', [AdminController::class, 'admin_login'])->name('admin_login')->middleware('AlreadyLoggedAdmin');
Route::get('/admin_dashboard', [AdminController::class, 'admin_dashboard'])->middleware('isLoggedAdmin');
Route::get('signout', [AdminController::class, 'signout'])->name('signout');


Route::post('/admin_login', [AdminController::class, 'login']);
Route::post('/admin_register', [AdminController::class, 'create']);

Route::group([ 'middleware' => ['isLoggedAdmin'] ], function () {
    Route::get('add_admin', [SystemAdminController::class, 'add_admin'])->name('add_admin');
    Route::get('manage_admins', [SystemAdminController::class, 'index'])->name('manage_admins');
    Route::get('remove_admin_page/{id}', [SystemAdminController::class, 'remove_admin_page']);


    Route::get('manage_country_page', [AdminDashboardController::class, 'manage_country'])->name('manage_country_page');
    Route::get('manage_networks_page', [AdminDashboardController::class, 'manage_networks'])->name('manage_networks_page');
    Route::get('manage_products_page', [AdminDashboardController::class, 'manage_products'])->name('manage_products_page');
    Route::get('manage_productsCat_page', [AdminDashboardController::class, 'manage_productsCat'])->name('manage_productsCat_page');
    Route::get('manage_airtime', [AdminDashboardController::class, 'manage_airtime'])->name('manage_airtime');
    Route::get('manage_data', [AdminDashboardController::class, 'manage_data'])->name('manage_data');
    Route::get('view_services', [AdminDashboardController::class, 'view_services'])->name('view_services');

    Route::get('data_history_page', [AdminDashboardController::class, 'data_history'])->name('data_history_page');
    Route::get('fund_transaction_history', [AdminDashboardController::class, 'fund_transaction'])->name('fund_transaction_history');
    Route::get('airtime_history_page', [AdminDashboardController::class, 'airtime_history'])->name('airtime_history_page');
    Route::get('repayment_history_page', [AdminDashboardController::class, 'repayment_history'])->name('repayment_history_page');
    Route::get('manage_users_page', [AdminDashboardController::class, 'manage_users'])->name('manage_users_page');
    Route::get('loan_payment_method_page', [AdminDashboardController::class, 'loan_payment'])->name('loan_payment_method_page');
    Route::get('loan_limit_page', [AdminDashboardController::class, 'loan_limit'])->name('loan_limit_page');
    Route::get('loan_period_page', [AdminDashboardController::class, 'loan_period'])->name('loan_period_page');
    Route::get('loan_interest_page', [AdminDashboardController::class, 'loan_interest'])->name('loan_interest_page');
    Route::get('paystack_record', [AdminDashboardController::class, 'paystack_record'])->name('paystack_record');
    Route::get('monnify_record', [AdminDashboardController::class, 'monnify_record'])->name('monnify_record');
    Route::get('dingconnect_record', [DingController::class, 'dingconnect_record'])->name('dingconnect_record');
    Route::get('loan_repayment', [AdminDashboardController::class, 'loan_repayment'])->name('loan_repayment');




    Route::get('manage_users_kyc', [AdminDashboardController::class, 'manage_users_kyc'])->name('manage_users_kyc');
    Route::get('view_kyc_info/{id}', [AdminDashboardController::class, 'view_kyc_info']);
    Route::get('approve_kyc/{id}', [KycController::class, 'approve_kyc']);
    Route::post('query_kyc', [KycController::class, 'query_kyc']);

    Route::get('sms_debtors_page', [AdminDashboardController::class, 'sms_debtors'])->name('sms_debtors_page');
    Route::get('set_pricing_page', [AdminDashboardController::class, 'set_pricing'])->name('set_pricing_page');
    Route::get('manage_pricing_page', [AdminDashboardController::class, 'manage_pricing'])->name('manage_pricing_page');
    Route::get('manage_faq', [AdminDashboardController::class, 'manage_faq'])->name('manage_faq');
    Route::get('support_page', [AdminDashboardController::class, 'support_page'])->name('support_page');
    Route::get('term_conditions', [AdminDashboardController::class, 'term_conditions'])->name('term_conditions');
    Route::get('terms_andConditions', [AdminDashboardController::class, 'terms_andConditions'])->name('terms_andConditions');
    Route::get('admin_profile', [AdminDashboardController::class, 'admin_profile'])->name('admin_profile');
    Route::get('admin_notification', [AdminDashboardController::class, 'admin_notification'])->name('admin_notification');
    Route::get('user_transaction_page/{id}', [AdminDashboardController::class, 'user_transaction']);
    Route::get('manage_debtors', [AdminDashboardController::class, 'manage_debtors'])->name('manage_debtors');
    Route::get('manage_users_funds', [AdminDashboardController::class, 'manage_users_funds'])->name('manage_users_funds');
    Route::get('view_users_funds', [AdminDashboardController::class, 'view_users_funds'])->name('view_users_funds');



    Route::get('edit_product/{id}', [AdminDashboardController::class, 'editProduct']);
    Route::get('view_user_info/{id}', [AdminDashboardController::class, 'view_user']);
    Route::get('activateService/{id}', [ServicesController::class, 'activateService']);
    Route::get('deactivateService/{id}', [ServicesController::class, 'deactivateService']);
    Route::get('activateOService/{id}', [ServicesController::class, 'activateLService']);
    Route::get('deactivateOService/{id}', [ServicesController::class, 'deactivateLService']);
    Route::get('make_admin_page/{id}', [SystemAdminController::class, 'make_admin_page']);
    Route::get('disable_users_page/{id}', [AdminDashboardController::class, 'disable_user']);
    Route::get('activate_users_page/{id}', [AdminDashboardController::class, 'activate_user']);
    Route::get('verify_users_page/{id}', [AdminDashboardController::class, 'verify_user']);
    Route::get('loans_transaction_history', [AdminDashboardController::class, 'loans_transaction'])->name('loans_transaction_history');
    Route::get('all_transaction_history', [AdminDashboardController::class, 'all_transaction_history'])->name('all_transaction_history');
    Route::get('data_transaction_history', [AdminDashboardController::class, 'data_transaction_history'])->name('data_transaction_history');
    Route::get('airtime_transaction_history', [AdminDashboardController::class, 'airtime_transaction_history'])->name('airtime_transaction_history');
    Route::get('transaction_receipt/{id}', [AdminDashboardController::class, 'transaction_receipt']);
    Route::get('payment_receipt/{id}', [AdminDashboardController::class, 'payment_receipt']);
    Route::get('loan_receipt/{id}', [AdminDashboardController::class, 'loan_receipt']);
    Route::get('repayment_transaction_history', [AdminDashboardController::class, 'repayment_transaction_history'])->name('repayment_transaction_history');
    Route::get('late_loan_payment', [AdminDashboardController::class, 'late_loan_payment'])->name('late_loan_payment');
    Route::get('loan_record', [AdminDashboardController::class, 'loan_record'])->name('loan_record');
    Route::get('paid_loan', [AdminDashboardController::class, 'paid_loan'])->name('paid_loan');
    Route::get('activate_admin/{id}', [SystemAdminController::class, 'activate_admin']);
    Route::get('disable_admin/{id}', [SystemAdminController::class, 'disable_admin']);
    Route::get('activateProduct/{id}', [ProductController::class, 'activateProduct']);
    Route::get('deactivateProduct/{id}', [ProductController::class, 'deactivateProduct']);


    Route::get('isLoan/{id}', [AdminFunctController::class, 'isLoan']);
    Route::get('isLoanlimit/{id}', [AdminFunctController::class, 'isLoanlimit']);
    Route::get('activateRepay/{id}', [AdminFunctController::class, 'activateRepay']);
    Route::get('delete_country/{id}', [AdminFunctController::class, 'delete_country']);
    Route::get('toggle_countryStatus/{id}', [AdminFunctController::class, 'toggle_countryStatus']);
    Route::get('toggle_NetworkStatus/{id}', [AdminFunctController::class, 'toggle_NetworkStatus']);
    Route::get('delete_network/{id}', [AdminFunctController::class, 'delete_network']);
    Route::get('delete_productCat/{id}', [AdminFunctController::class, 'delete_productCat']);
    Route::get('delete_product/{id}', [AdminFunctController::class, 'delete_product']);
    Route::get('delete_support/{id}', [AdminFunctController::class, 'deleteSsupportPage']);
    Route::get('delete_faq/{id}', [AdminFunctController::class, 'delete_faq']);
    Route::get('delete_terms/{id}', [AdminFunctController::class, 'delete_terms']);
    Route::get('delete_loanLimit/{id}', [AdminFunctController::class, 'delete_loanLimit']);

    // 08055616287
    Route::post('update_product', [AdminFunctController::class, 'update'])->name('update_product');
    Route::post('add_admin', [SystemAdminController::class, 'create_admin']);
    Route::post('add_user_fund', [SystemAdminController::class, 'add_user_fund'])->name('add_user_fund');
    Route::post('change_admin_password', [SystemAdminController::class, 'change_admin_password']);
    Route::post('change_user_password', [AdminFunctController::class, 'change_user_password']);
    Route::post('manage_faq', [AdminFunctController::class, 'add_faq']);
    Route::post('support_page', [AdminFunctController::class, 'supportPage']);
    Route::post('terms', [AdminFunctController::class, 'terms'])->name('terms');
    Route::post('add_network', [AdminFunctController::class, 'manage_networks'])->name('add_network');
    Route::post('add_product', [AdminFunctController::class, 'add_product'])->name('add_product');
    Route::post('add_country', [AdminFunctController::class, 'add_country'])->name('add_country');
    Route::post('add_loanLimit', [AdminFunctController::class, 'add_loanLimit'])->name('add_loanLimit');
    Route::post('message_debtors', [MessageDebtorsCondtroller::class, 'message_debtors'])->name('message_debtors');
    Route::post('product_price_perc', [AdminFunctController::class, 'product_price_perc'])->name('product_price_perc');
    Route::post('product_price_data', [AdminFunctController::class, 'product_price_data'])->name('product_price_data');
    Route::post('set_productLimit', [AdminFunctController::class, 'set_productLimit'])->name('set_productLimit');
    Route::post('add_service', [ServicesController::class, 'addService'])->name('add_service');

});
