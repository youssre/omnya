<?php

use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('generate-mailbox', function () {
    require_once public_path('mailbox/src/config.php');
    require_once public_path('mailbox/src/backend-libs/autoload.php');
    require_once public_path('mailbox/src/user.php');
    require_once public_path('mailbox/src/imap_client.php');
    require_once public_path('mailbox/src/controller.php');
    require_once public_path('mailbox/src/router.php');

    $imapClient = new ImapClient($config['imap']['url'], $config['imap']['username'], $config['imap']['password']);

    $router = new Router($_SERVER['REQUEST_METHOD'], $_GET['action'] ?? NULL, $_GET, $_POST, $_SERVER['QUERY_STRING']??NULL, $config);
    $controller = $router->route();
    $controller->setViewHandler(new ServerRenderViewHandler());
    $controller->invoke($imapClient);

    $imapClient->delete_old_messages($config['delete_messages_older_than']);
});

//Route::get('/', function () {
//    return redirect('/login');
////    return view('reports.timetable');
//});

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
