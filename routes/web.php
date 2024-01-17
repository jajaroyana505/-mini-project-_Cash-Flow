<?php

use App\Http\Controllers\TransactionController;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Type;
use Illuminate\Database\Events\TransactionCommitted;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [TransactionController::class, 'index']);
Route::post('/', [TransactionController::class, 'store']);
Route::delete('/{id}', [TransactionController::class, 'destroy']);



Route::get('/get-categories', function () {
    $categories = Category::where('type_id', request('id'))->get();
    // $categories = Category::all();
    return response()->json($categories);
});
Route::get('/get-types', function () {
    $categories = Type::all();
    return response()->json($categories);
});

Route::get('/get-transactions', function () {
    $transaction = Transaction::all();
    return response()->json($transaction);
});
