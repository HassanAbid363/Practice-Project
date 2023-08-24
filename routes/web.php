<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\MemberController;


Route::get('expenses',[App\Http\Controllers\ExpenseController::class, 'index']);

Route::get('expenses/create',[App\Http\Controllers\ExpenseController::class, 'create']);
Route::post('expenses/create/store', [App\Http\Controllers\ExpenseController::class, 'store']);

Route::get('expenses/{id}/edit',[App\Http\Controllers\ExpenseController::class, 'edit']);
Route::post('expenses/{id}/edit/store', [App\Http\Controllers\ExpenseController::class, 'storeEdit']);

Route::get('/expensein/{expense_name}', [App\Http\Controllers\ExpenseController::class, 'amountIn',]);
Route::post('expenses/in', [App\Http\Controllers\ExpenseController::class, 'storeAmountIn',]);

Route::get('/expenseout/{expense_name}', [App\Http\Controllers\ExpenseController::class, 'amountOut',]);
Route::post('expenses/out', [App\Http\Controllers\ExpenseController::class, 'storeAmountOut',]);


Route::resource('member', MemberController::class);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('login');

//Route for Home Page
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route for Users Page
Route::get('/users', [App\Http\Controllers\UsersController::class, 'index'])->name('users');

//Route for Updating Expense Form
Route::get('/updateexpenseform/{id}', [App\Http\Controllers\ExpenseController::class, 'updateexpenseform',])->name('updateexpenseform');

//Route for Updating Data of Existing Expense Form
Route::post('/updateexpense/{id}', [App\Http\Controllers\ExpenseController::class, 'update',]);

//view
Route::get('viewtransactions/{expense_name}/{id}', [App\Http\Controllers\ExpenseController::class, 'viewTransactions',]);

Route::post('/transactionfollowers', [App\Http\Controllers\ExpenseController::class, 'storeTransactionFollowers']);

Route::get('/removetransactionfollowertag', [App\Http\Controllers\ExpenseController::class, 'removeFollowerTag']);

//Route for Updating User Form
Route::get('/updateuserform/{id}', [App\Http\Controllers\UsersController::class, 'updateUserForm',]);

//Route for Updating Data of Existing User Form
Route::post('/updateuser/{id}', [App\Http\Controllers\UsersController::class, 'updateUser',]);

//Route for Changing User Status
//Route::post('/changeuserstatus/{id}', [App\Http\Controllers\UsersController::class, 'changeUserStatus',]);
Route::get('changeStatus', [App\Http\Controllers\UsersController::class, 'changeUserStatus',]);

//Route for showing expense w.r.t to user that has been clicked on
Route::get('/expenseperuser/{id}', [App\Http\Controllers\ExpenseController::class, 'expensePerUser',]);

//route for testing CRUD
Route::get('test', [IndexController::class,'index']);

Auth::routes();
