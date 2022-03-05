<?php

use App\invoices;
use Illuminate\Support\Facades\Route;

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

/*Route::get('/', function () {
    return view('auth.register');
});
*/


//Auth::routes();

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

//invoices

Route::resource('invoices', 'InvoicesController');
Route::post('update/{id}', 'InvoicesController@update')->name('invoices.update');
Route::get('/statuse_show/{id}','InvoicesController@show')->name('statuse_show');


Route::post('/Status_Update/{id}', 'InvoicesController@Status_Update')->name('Status_Update');



Route::get('invoice_Paid', 'InvoicesController@invoice_Paid');

Route::get('invoice_unPaid', 'InvoicesController@Invoice_unPaid');

Route::get('invoice_partial', 'InvoicesController@Invoice_Partial');

Route::resource('Archef', 'ArchefController');

Route::get('Print_invoice/{id}', 'InvoicesController@Print_invoice')->name('Print_invoice');
//invoices Attachments
Route::resource('InvoiceAttachments', 'InvoiceAttachmentsController');



//sections
Route::resource('sections', 'SectionsController');

//products
Route::resource('products', 'ProductsController');
//invoices
Route::get('/section/{id}', 'InvoicesController@getproducts');
//invoicess Details
Route::get('/invoices_dealse/{id}', 'InvoicesDetalisController@edit');

Route::get('View_file/{invoice_number}/{file_name}', 'InvoicesDetalisController@open_file');

Route::get('download/{invoice_number}/{file_name}', 'InvoicesDetalisController@Download' );

Route::post('delete_file', 'InvoicesDetalisController@destroy')->name('delete_file');


// Spatie Permission

Route::group(['middleware' => ['auth']], function () {

    Route::resource('roles', 'RoleController');

    Route::resource('users', 'UserController');
});

//Invoice Report
Route::get('invoices_report', 'Reports_Invoic@index');

Route::post('Search_invoices', 'Reports_Invoic@Search_invoices');
//Reports Cstomer
Route::get('customers_report', 'Report_customer@index');

Route::post('Search_customers', 'Report_customer@Search_customers');

//Notification

Route::get('MarkAsRead_all', 'InvoicesController@MarkAsRead_all')->name('MarkAsRead_all');
Route::get('unreadNotifications_count', 'InvoicesController@unreadNotifications_count')->name('unreadNotifications_count');

Route::get('unreadNotifications', 'InvoicesController@unreadNotifications')->name('unreadNotifications');


Route::get('/{page}', 'AdminController@index');



