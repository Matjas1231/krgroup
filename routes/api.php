<?php

use App\Http\Controllers\Api\V1\CurrencyController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'v1',
    'controller' => CurrencyController::class,
    'middleware' => 'auth:sanctum'
], function () {
    Route::get('/currencies', 'index');
    Route::post('/currencies', 'store');
});

Route::post('/v1/create-user', function () {
    $credentials = [
        'email' => 'admin@admin.com',
        'password' => 'zaq1@WSX'
    ];

    if (Auth::attempt($credentials)) {
        $user = Auth::user();
        $user->tokens()->delete();
        $user->delete();
    }

    if (!Auth::attempt($credentials)) {
        $user = new User();
        $user->name = 'Admin';
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);
        $user->save();


        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            $adminToken = $user->createToken('admin-token', ['create']);
            $readToken = $user->createToken('read-token', ['read']);

            return [
                'admin' => $adminToken->plainTextToken,
                'read' => $readToken->plainTextToken
            ];
        }
    }
});
