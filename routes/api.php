<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//for Main categories

Route::post('exportDatabase', 'AdminController@exportDatabase');
Route::post('importDatabase', 'AdminController@importDatabase');


Route::post('add-people', 'AdminController@addPeople');
Route::post('delete-people/', 'AdminController@deletePeople');
Route::Post('get-people', 'AdminController@getPeople');
Route::post('get-user-single', 'AdminController@getSinglePeople');
Route::post('people/export', 'AdminController@exportPeople');
Route::post('people/exportQr', 'AdminController@exportPeopleQr');
Route::Post('people/import', 'AdminController@importPeople');
Route::Post('peoples-count', 'AdminController@getPeoplesCount');
Route::Post('get-questions', 'AdminController@getQuestions');
Route::post('download-sample-file', 'AdminController@downloadSampleFile');
Route::post('download-import-sample-file', 'AdminController@downloadImportSampleFile');
Route::post('download/qr-code', 'AdminController@generateAndSaveQRCode');
Route::Post('add-category', 'AdminController@addCategory');
Route::Post('get-category', 'AdminController@getCategory');
Route::post('delete-category/', 'AdminController@deleteCategory');
Route::Post('add-admin', 'AdminController@addAdmin');
Route::Post('get-admin', 'AdminController@getAdmin');
Route::post('delete-admin/', 'AdminController@deleteAdmin');
Route::post('change-password/', 'AdminController@changePassword');
Route::post('people/bulk-delete/', 'AdminController@bulkDeleteUser');
Route::Post('people/import-excel', 'AdminController@importPeopleExcel');
Route::post('get-category-single', 'AdminController@getSingleCategory');

Route::Post('add-google-user', 'GoogleUserController@addGoogleUser');
Route::Post('get-google-user', 'GoogleUserController@getGoogleUser');
Route::post('delete-google-user', 'GoogleUserController@deleteGoogleUser');
Route::post('get-google-user-single', 'GoogleUserController@getSingleGooglePeople');
Route::post('googleUser/bulk-delete', 'GoogleUserController@bulkDeleteGoogleUser');
Route::Post('googleUser/import-excel', 'GoogleUserController@importGoogleExcel');
Route::post('download-google-sample-file', 'GoogleUserController@downloadGoogleSampleFile');
Route::post('download-google-import-sample-file', 'GoogleUserController@downloadImportGoogleSampleFile');
Route::post('download/google-qr-code', 'GoogleUserController@generateAndSaveQRCode');
Route::post('googleUser/export', 'GoogleUserController@exportGoogleUser');
Route::post('googleUser/exportQr', 'GoogleUserController@exportGoogleUserQr');
Route::Post('googleUser/import', 'GoogleUserController@importGoogleUser');

Route::Post('get-user-data', 'SiteController@get_user_data');
Route::Post('get-google-user-data', 'SiteController@get_google_user_data');

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
})->middleware('auth:api');
