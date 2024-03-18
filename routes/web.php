<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
    //return view('reports.timetable');
});

Route::get('/view-user/{profile_id}', function () {
    return view('layouts.app');
});

Route::get('/view-google-user/{profile_id}', function () {
    return view('layouts.app');
});

Route::get('/add-admin-user', [SiteController::class, 'addAdminUser']);

Route::get('/qr-code/{profile_id}', [SiteController::class, 'generateQRCode']);
Route::get('/google-qr-code/{profile_id}', [SiteController::class, 'generateGoogleQRCode']);
// ->middleware('throttle:rate_limit,100'); // Change rate_limit to the desired number

Auth::routes([
    'register' => false, // Register Routes...
    'reset' => false, // Reset Password Routes...
    'verify' => false, // Email Verification Routes...
]);

//Auth::routes();

Route::get('/{any}', [App\Http\Controllers\HomeController::class, 'index'])->where('any', '.*');
