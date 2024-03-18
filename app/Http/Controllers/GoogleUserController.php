<?php

namespace App\Http\Controllers;

// use DB;

use App\Exports\GoogleUserExport;
use App\Imports\GoogleImportExcel;
use App\Imports\GoogleUserImport;
use App\Imports\GoogleUserImportExcel;
use App\Models\GoogleUser;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use ZipArchive;
use Illuminate\Support\Facades\Validator;

class GoogleUserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    }

    //GoogleUsers

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789';
        $randomString = substr(str_shuffle($characters), 0, $length);
        return $randomString;
    }

    public function addGoogleUser(Request $request)
    {
        $requestArray = $request->all();

        // $requestData = $request->validate([
        //     'first_name' => 'required',
        //     'last_name' => 'required',
        // ]);

        $GoogleUserData = [
            'category_id' => $requestArray['category_id'],
            'is_recovery_enable' => $requestArray['enable_recovery'],
            'is_logo_enable' => $requestArray['is_logo_enable'],
            'recovery_email' => $requestArray['recovery_email'],
            'email' => $requestArray['email'],
            'plain_password' => $requestArray['plain_password'],
            'created_at' => Carbon::now()
        ];

        $GoogleUserId = $request->formId ? $this->updateGoogleUser($request->formId, $GoogleUserData) : $this->createGoogleUser($GoogleUserData);

        return response()->json(['message' => 'success']);
    }

    private function createGoogleUser($data)
    {
        $data['password'] = Hash::make($data['plain_password']);
        $GoogleUser = GoogleUser::create($data);
        $this->generateUrl($GoogleUser);
        return $GoogleUser->id;
    }

    private function updateGoogleUser($id, $data)
    {
        GoogleUser::where('id', $id)->update($data);
        return $id;
    }

    private function generateUrl($GoogleUser)
    {
        $randomString = $this->generateRandomString(7);
        $CryptId = $GoogleUser->id . $randomString;

        $url = url('/') . '/view-google-user/' . $CryptId;

        GoogleUser::where('id', $GoogleUser->id)->update([
            'page_url' => str_replace(' ', '-', strtolower($url)),
            'profile_id' => $CryptId,
            'barcode_url' => url('/') . '/google-qr-code/' . $GoogleUser->email,
        ]);
    }

    public function generateAndSaveQRCode(Request $request)
    {
        $data = $request->all();
        $return_array = [];
        $url = $data['page_url'];

        $explode_barcode = explode('/', $data['barcode_url']);
        $return_array['downloadLink'] = url('/') . asset('../storage/app/public/GoogleUserQrCode/' . $explode_barcode[2]);
        $return_array['fileName'] = $explode_barcode[2];
        return response()->json(['return_array' => $return_array]);
    }

    public function exportGoogleUserQr(Request $persons)
    {
        $GoogleUser = GoogleUser::whereIn('id', $persons)->get()->toArray();
        $pathToSave = storage_path('app/public/GoogleUserQrZip');

        // $pathToSave = public_path('storage/QrZip');

        // Ensure the destination directory exists, and if not, create it
        if (!File::exists($pathToSave)) {
            File::makeDirectory($pathToSave, 0755, true);
        }

        $zipFileName = 'GoogleUserQr-' . time() . '.zip';
        $fullZipFilePth = $pathToSave . '/GoogleUserQr-' . time() . '.zip';
        $zip = new ZipArchive;
        if ($zip->open($fullZipFilePth, ZipArchive::CREATE) === TRUE) {
            if (sizeof($GoogleUser) > 0) {
                foreach ($GoogleUser as $pKey => $person) {
                    $filePath = $this->generateQRCode($person['email']);
                    $zip->addFile($filePath['filePath'] . '/' . $filePath['fileName'], $filePath['fileName']); // Add the file to the zip
                }
            }
            $zip->close();

            $downloadLink = asset('../storage/app/public/GoogleUserQrZip/' . $zipFileName);

            return response()->json(['downloadLink' => $downloadLink, 'fileName' => $zipFileName]);
        } else {
            return response()->json(['return_array' => "Failed to create zip file."]);
        }
    }

    public function generateQRCode($profile_id)
    {
        // return $profile_id;
        $return_array = [];
        $GoogleUser = GoogleUser::where('email', $profile_id)->first()->toArray();
        $fileName = $profile_id . '.png';
        $fileExist = storage_path('GoogleUserQrCode/' . $fileName);
        $filePath = storage_path('GoogleUserQrCode');

        if (File::exists($fileExist)) {
            return array('filePath' => $filePath, 'fileName' => $fileName);
            // return $filePath;
        } else {
            // The file doesn't exist
            $qrCode = QrCode::size(300)->format('png')->generate($GoogleUser['page_url']);

            $pathToSave = storage_path('GoogleUserQrCode/');
            if (!File::exists($pathToSave)) {
                File::makeDirectory($pathToSave, 0755, true);
            }

            file_put_contents($pathToSave . '/' . $fileName, $qrCode);
            // $filePath = 'storage/GoogleUserQrCode/' . $fileName;
            $filePath = storage_path('GoogleUserQrCode');

            return array('filePath' => $filePath, 'fileName' => $fileName);
        }
    }

    public function exportGoogleUser(Request $persons)
    {

        // Fetch data from the GoogleUser model
        $GoogleUser = GoogleUser::whereIn('id', $persons)->get()->toArray();

        $data = [
            ['Email', 'Password', 'Page Url', 'QR Url', 'Serial Number', 'Recovery Email'],
        ];

        foreach ($GoogleUser as $pKey => $person) {
            $data[$pKey + 1] = [
                $person['email'],
                $person['plain_password'],
                $person['page_url'],
                $person['barcode_url'],
                $person['profile_id'],
                $person['recovery_email'],
            ];
        }

        // Determine the destination directory
        $pathToSave = public_path('storage/GoogleUserExcel');

        // Ensure the destination directory exists, and if not, create it
        if (!File::exists($pathToSave)) {
            File::makeDirectory($pathToSave, 0755, true);
        }
        $current_date = Carbon::now()->format('Y-m-d H-i-s');
        // Generate the Excel file using the "GoogleUserExport" class
        // $filePath = 'GoogleUserExcel/' . $current_date . '.xlsx';
        // Excel::store(new GoogleUserExport($data), $filePath, 'public');

        $fileName = $current_date . '.xlsx';
        $filePath = 'GoogleUserExcel/' . $fileName;
        $storagePath = storage_path('app/public/' . $filePath);

        // Save the Excel file using Excel::store()
        Excel::store(new GoogleUserExport($data), $filePath, 'public');

        // Move the file to the desired location
        $fileName = $current_date . '.xlsx';

        // Provide the download link for the user
        $return_array['downloadLink'] = asset('../storage/app/public/GoogleUserExcel/' . $fileName);
        $return_array['fileName'] = $fileName;

        return response()->json(['return_array' => $return_array]);
    }

    public function importGoogleUser(Request $request)
    {

        $originalFileName = $request->file('file')->getClientOriginalName();
        $fileNameWithoutSpaces = Str::slug(pathinfo($originalFileName, PATHINFO_FILENAME), '-');
        $extension = $request->file('file')->getClientOriginalExtension();

        $extension_array = ['xlsx', 'xls', 'csv'];
        $cleanedFileName = $fileNameWithoutSpaces . '.' . $extension;
        if (!in_array($extension, $extension_array)) {
            return response()->json(['errors' => 'The file must be a file of type: xlsx, xls, csv.'], 400);
        }

        $validator = Validator::make($request->all(), [
            'category_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Get the category ID
        $category_id = $request->input('category_id');
        $import_enable_recovery = $request->input('import_enable_recovery');
        $is_logo_enable = $request->input('is_logo_enable');

        // Get the duplicate records file path
        $import = new GoogleUserImport($category_id, $import_enable_recovery, $is_logo_enable);
        $importedData = Excel::import($import, $request->file('file'));

        $duplicateData = $import->getDuplicateData();
        if (isset($duplicateData) && sizeof($duplicateData) > 0) {
            foreach ($duplicateData as $key => $val) {
                $data[] = [
                    'email' => $val[0],
                    'password' => $val[1],
                    'profile_id' => $val[2],
                ];
            }
            $filePath = $this->exportDuplicateGoogleUser($duplicateData);
        }
        // Return a response with the import results and the duplicate records file path
        return response()->json([
            'message' => 'Data imported successfully',
            'duplicateRecordsFilePath' => $data ?? [],
            'filePath' => $filePath ?? '',
        ]);
    }

    public function exportDuplicateGoogleUser($duplicateData)
    {
        // Fetch data from the GoogleUser model

        // Determine the destination directory
        $pathToSave = public_path('storage/googleUserDuplicateData');

        // Ensure the destination directory exists, and if not, create it
        if (!File::exists($pathToSave)) {
            File::makeDirectory($pathToSave, 0755, true);
        }
        $current_date = Carbon::now()->format('Y-m-d H-i-s');
        // Generate the Excel file using the "GoogleUserExport" class
        // $filePath = 'excel/' . $current_date . '.xlsx';
        // Excel::store(new GoogleUserExport($data), $filePath, 'public');

        $fileName = $current_date . '-googleUserDuplicateData.xlsx';
        $filePath = 'googleUserDuplicateData/' . $fileName;
        $storagePath = storage_path('app/public/' . $filePath);

        // Save the Excel file using Excel::store()
        Excel::store(new GoogleUserExport($duplicateData), $filePath, 'public');

        // Move the file to the desired location
        $fileName = $current_date . '-googleUserDuplicateData.xlsx';

        // Provide the download link for the user
        $return_array['downloadLink'] = asset('../storage/app/public/googleUserDuplicateData/' . $fileName);
        $return_array['fileName'] = $fileName;

        return ['filePath' => $return_array];
    }

    public function importGoogleExcel(Request $request)
    {

        Excel::import(new GoogleImportExcel, $request->file('file'));

        return response()->json(['message' => 'Data imported successfully']);
    }

    public function downloadGoogleSampleFile()
    {
        $filePath = asset('../storage/app/public/omnya-google-sample-file.xlsx');
        return response()->json($filePath);
    }

    public function downloadImportGoogleSampleFile()
    {
        $filePath = asset('../storage/app/public/omnya-google-import-sample-file.xlsx');
        return response()->json($filePath);
    }

    public function bulkDeleteGoogleUser(Request $request)
    {
        $data = $request->all();
        if (sizeof($data) > 0) {
            foreach ($data as $key => $val) {
                $google_users = DB::table('google_users')->where('id', $val)->delete();
            }
        }
        return response()->json(['message' => 'Success']);
    }

    public function getGoogleUser(Request $request)
    {
        $data = $request->all();

        $perPage = $data['perPage'] ?? 10;
        $page = $data['page'] ?? 1;
        $search = $data['search'] ?? '';

        $Jdata = isset($data['serverParams']) ? json_decode($data['serverParams']) : null;
        $orderBy = isset($Jdata) && $Jdata->sort[0]->type != 'none' ? $Jdata->sort[0]->type : 'asc';
        $orderField = isset($Jdata) ? $Jdata->sort[0]->field : 'google_users.id';


        $filters = [
            'category_id',
            'recovery_email',
            'email',
            'profile_id',
        ];

        $query = GoogleUser::query();
        $query->select(
            'google_users.*',
            'categories.category_name',
            DB::raw('CONCAT(google_users.profile_id, ".png") as download_file')
        );
        $query->leftJoin('categories', 'google_users.category_id', '=', 'categories.id');

        foreach ($filters as $filter) {
            if (isset($data[$filter]) && !empty($data[$filter])) {
                $query->where($filter, 'like', '%' . $data[$filter] . '%');
            }
        }


        if (isset($data['from']) && !empty($data['from'])) {
            $query->where('google_users.created_at', '>=', $data['from'] . ' 00:00:00');
        }

        if (isset($data['to']) && !empty($data['to'])) {
            $query->where('google_users.created_at', '<=', $data['to'] . ' 23:59:59');
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('google_users.recovery_email', 'like', '%' . $search . '%');
                $q->orWhere('google_users.email', 'like', '%' . $search . '%');
                $q->orWhere('categories.category_name', 'like', '%' . $search . '%');
                $q->orWhere('google_users.profile_id', 'like', '%' . $search . '%');
                // Add more columns to search as needed
            });
        }
        $query->orderBy($orderField, $orderBy);
        $items = ($perPage < 0)
            ? $query->paginate(1000000, ['*'], 'page', $page)
            : $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json($items);
    }

    public function deleteGoogleUser(Request $request)
    {

        $Admin = DB::table('google_users')->where('id', $request->id)->delete();
        return response()->json(['message' => 'success']);
    }

    public function getSingleGooglePeople(Request $request)
    {
        $data = DB::table('google_users')->where('profile_id', $request->profile_id)->first();
        return response()->json($data);
    }
}
