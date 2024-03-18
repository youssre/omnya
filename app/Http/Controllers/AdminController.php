<?php

namespace App\Http\Controllers;

// use DB;

use App\Exports\PeopleExport;
use App\Imports\PeopleImport;
use App\Imports\PeopleImportExcel;
use App\Models\People;
use App\Models\Category;
use App\Models\GoogleUser;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Illuminate\Support\Facades\Validator;
use Spatie\DbDumper\Databases\MySql;

class AdminController extends Controller
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

    //peoples

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789';
        $randomString = substr(str_shuffle($characters), 0, $length);
        return $randomString;
    }

    public function addPeople(Request $request)
    {
        $requestArray = $request->all();

        // $requestData = $request->validate([
        //     'first_name' => 'required',
        //     'last_name' => 'required',
        // ]);

        $peopleData = [
            'category_id' => $requestArray['category_id'],
            // 'first_name' => $requestData['first_name'],
            // 'last_name' => $requestData['last_name'],
            'email' => $request->email,
            'is_recovery_enable' => $request->enable_recovery,
            'is_logo_enable' => $request->is_logo_enable,
            'recovery_email' => $request->recovery_email,
            'plain_password' => $request->password,
            'date_of_birth' => $request->date_of_birth,
            // 'q1' => $requestArray['q1'],
            'q1' => config('constants.QUESTION_1'),
            'a1' => $requestArray['a1'],
            // 'q2' => $requestArray['q2'],
            'q2' => config('constants.QUESTION_2'),
            'a2' => $requestArray['a2'],
            // 'q3' => $requestArray['q3'],
            'q3' => config('constants.QUESTION_3'),
            'a3' => $requestArray['a3'],
        ];

        $peopleId = $request->formId ? $this->updatePeople($request->formId, $peopleData) : $this->createPeople($peopleData);

        return response()->json(['message' => 'success']);
    }

    private function createPeople($data)
    {
        $data['password'] = Hash::make($data['plain_password']);
        $people = People::create($data);
        $this->generateUrl($people);
        return $people->id;
    }

    private function updatePeople($id, $data)
    {
        People::where('id', $id)->update($data);
        return $id;
    }

    private function generateUrl($people)
    {
        $randomString = $this->generateRandomString(7);
        $CryptId = $people->id . $randomString;

        $url = url('/') . '/view-user/' . $CryptId;

        People::where('id', $people->id)->update([
            'page_url' => str_replace(' ', '-', strtolower($url)),
            'profile_id' => $CryptId,
            'barcode_url' => url('/') . '/qr-code/' . $people->email,

        ]);
    }

    public function generateAndSaveQRCode(Request $request)
    {
        $data = $request->all();
        $return_array = [];
        $url = $data['page_url'];

        $explode_barcode = explode('/', $data['barcode_url']);
        $return_array['downloadLink'] = url('/') . asset('../storage/app/public/QrCode/' . $explode_barcode[2]);
        $return_array['fileName'] = $explode_barcode[2];
        return response()->json(['return_array' => $return_array]);
    }

    public function exportPeopleQr(Request $persons)
    {
        $people = People::whereIn('id', $persons)->get()->toArray();
        $pathToSave = storage_path('app/public/QrZip');

        // $pathToSave = public_path('storage/QrZip');

        // Ensure the destination directory exists, and if not, create it
        if (!File::exists($pathToSave)) {
            File::makeDirectory($pathToSave, 0755, true);
        }

        $zipFileName = 'PeopleQr-' . time() . '.zip';
        $fullZipFilePth = $pathToSave . '/PeopleQr-' . time() . '.zip';
        $zip = new ZipArchive;
        if ($zip->open($fullZipFilePth, ZipArchive::CREATE) === TRUE) {
            if (sizeof($people) > 0) {
                foreach ($people as $pKey => $person) {
                    $filePath = $this->generateQRCode($person['email']);
                    $zip->addFile($filePath['filePath'] . '/' . $filePath['fileName'], $filePath['fileName']); // Add the file to the zip
                }
            }
            $zip->close();

            $downloadLink = asset('../storage/app/public/QrZip/' . $zipFileName);

            return response()->json(['downloadLink' => $downloadLink, 'fileName' => $zipFileName]);
        } else {
            return response()->json(['return_array' => "Failed to create zip file."]);
        }
    }

    public function generateQRCode($profile_id)
    {
        // return $profile_id;
        $return_array = [];
        $people = People::where('email', $profile_id)->first()->toArray();
        $fileName = $profile_id . '.png';
        $fileExist = storage_path('QrCode/' . $fileName);
        $filePath = storage_path('QrCode');

        if (File::exists($fileExist)) {
            return array('filePath' => $filePath, 'fileName' => $fileName);
            // return $filePath;
        } else {
            // The file doesn't exist
            $qrCode = QrCode::size(300)->format('png')->generate($people['page_url']);

            $pathToSave = storage_path('QrCode/');
            if (!File::exists($pathToSave)) {
                File::makeDirectory($pathToSave, 0755, true);
            }

            file_put_contents($pathToSave . '/' . $fileName, $qrCode);
            // $filePath = 'storage/QrCode/' . $fileName;
            $filePath = storage_path('QrCode');

            return array('filePath' => $filePath, 'fileName' => $fileName);
        }
    }

    public function exportPeople(Request $persons)
    {

        // Fetch data from the People model
        $people = People::whereIn('id', $persons)->get()->toArray();

        $data = [
            ['Email', 'Password',  config('constants.QUESTION_1'), config('constants.QUESTION_2'), config('constants.QUESTION_3'), 'Date Of Birth', 'Page Url', 'QR Url', 'Serial Number', 'Recovery Email'],
        ];

        foreach ($people as $pKey => $person) {
            $data[$pKey + 1] = [
                $person['email'],
                $person['plain_password'],
                $person['a1'],
                $person['a2'],
                $person['a3'],
                $person['date_of_birth'],
                // $person['first_name'],
                // $person['last_name'],
                $person['page_url'],
                $person['barcode_url'],
                $person['profile_id'],
                $person['recovery_email'],
            ];
        }

        // Determine the destination directory
        $pathToSave = public_path('storage/excel');

        // Ensure the destination directory exists, and if not, create it
        if (!File::exists($pathToSave)) {
            File::makeDirectory($pathToSave, 0755, true);
        }
        $current_date = Carbon::now()->format('Y-m-d H-i-s');
        // Generate the Excel file using the "PeopleExport" class
        // $filePath = 'excel/' . $current_date . '.xlsx';
        // Excel::store(new PeopleExport($data), $filePath, 'public');

        $fileName = $current_date . '.xlsx';
        $filePath = 'excel/' . $fileName;
        $storagePath = storage_path('app/public/' . $filePath);

        // Save the Excel file using Excel::store()
        Excel::store(new PeopleExport($data), $filePath, 'public');

        // Move the file to the desired location
        $fileName = $current_date . '.xlsx';

        // Provide the download link for the user
        $return_array['downloadLink'] = asset('../storage/app/public/excel/' . $fileName);
        $return_array['fileName'] = $fileName;

        return response()->json(['return_array' => $return_array]);
    }

    public function importPeople(Request $request)
    {

        $originalFileName = $request->file('file')->getClientOriginalName();
        $fileNameWithoutSpaces = Str::slug(pathinfo($originalFileName, PATHINFO_FILENAME), '-');
        $extension = $request->file('file')->getClientOriginalExtension();

        $extension_array = ['xlsx', 'xls', 'csv'];
        $cleanedFileName = $fileNameWithoutSpaces . '.' . $extension;
        if (!in_array($extension, $extension_array)) {
            return response()->json(['errors' => 'The file must be a file of type: xlsx, xls, csv.'], 400);
        }
        // Validate the request
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
        $import = new PeopleImport($category_id, $import_enable_recovery, $is_logo_enable);

        $importedData = Excel::import($import, $request->file('file'));

        $duplicateData = $import->getDuplicateData();
        if (isset($duplicateData) && sizeof($duplicateData) > 0) {
            foreach ($duplicateData as $key => $val) {
                $data[] = [
                    'email' => $val[0],
                    'password' => $val[1],
                    'a1' => $val[2],
                    'a2' => $val[3],
                    'a3' => $val[4],
                    'date_of_birth' => $val[5],
                    // 'first_name' => $val[6],
                    // 'last_name' => $val[7],
                ];
            }
            $filePath = $this->exportDuplicatePeople($duplicateData);
        }
        // Return a response with the import results and the duplicate records file path
        return response()->json([
            'message' => 'Data imported successfully',
            'duplicateRecordsFilePath' => $data ?? [],
            'filePath' => $filePath ?? '',
        ]);
    }

    public function exportDuplicatePeople($duplicateData)
    {
        // Fetch data from the People model

        // Determine the destination directory
        $pathToSave = public_path('storage/duplicateData');

        // Ensure the destination directory exists, and if not, create it
        if (!File::exists($pathToSave)) {
            File::makeDirectory($pathToSave, 0755, true);
        }
        $current_date = Carbon::now()->format('Y-m-d H-i-s');
        // Generate the Excel file using the "PeopleExport" class
        // $filePath = 'excel/' . $current_date . '.xlsx';
        // Excel::store(new PeopleExport($data), $filePath, 'public');

        $fileName = $current_date . '-duplicateData.xlsx';
        $filePath = 'duplicateData/' . $fileName;
        $storagePath = storage_path('app/public/' . $filePath);

        // Save the Excel file using Excel::store()
        Excel::store(new PeopleExport($duplicateData), $filePath, 'public');

        // Move the file to the desired location
        $fileName = $current_date . '-duplicateData.xlsx';

        // Provide the download link for the user
        $return_array['downloadLink'] = asset('../storage/app/public/duplicateData/' . $fileName);
        $return_array['fileName'] = $fileName;

        return ['filePath' => $return_array];
    }

    public function importPeopleExcel(Request $request)
    {
        Excel::import(new PeopleImportExcel, $request->file('file'));

        return response()->json(['message' => 'Data imported successfully']);
    }

    public function getPeople(Request $request)
    {
        $data = $request->all();

        $perPage = $data['perPage'] ?? 10;
        $page = $data['page'] ?? 1;
        $search = $data['search'] ?? '';

        $Jdata = isset($data['serverParams']) ? json_decode($data['serverParams']) : null;
        $orderBy = isset($Jdata) && $Jdata->sort[0]->type != 'none' ? $Jdata->sort[0]->type : 'asc';
        $orderField = isset($Jdata) ? $Jdata->sort[0]->field : 'id';

        $filters = [
            'category_id', 'id', 'date_of_birth', 'email', 'page_url', 'profile_id', 'recovery_email'
        ];

        $query = People::query();
        $query->select('peoples.*', 'categories.category_name', DB::raw('CONCAT(peoples.profile_id, ".png") as download_file'));
        $query->leftJoin('categories', 'peoples.category_id', '=', 'categories.id');

        foreach ($filters as $filter) {
            if (isset($data[$filter]) && !empty($data[$filter])) {
                $query->where($filter, 'like', '%' . $data[$filter] . '%');
            }
        }

        if (isset($data['from']) && !empty($data['from'])) {
            $query->where('peoples.created_at', '>=', $data['from'] . ' 00:00:00');
        }

        if (isset($data['to']) && !empty($data['to'])) {
            $query->where('peoples.created_at', '<=', $data['to'] . ' 23:59:59');
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->Where('peoples.id', 'like', '%' . $search . '%')
                    // ->orWhere('peoples.last_name', 'like', '%' . $search . '%')
                    ->orWhere('peoples.profile_id', 'like', '%' . $search . '%')
                    ->orWhere('peoples.page_url', 'like', '%' . $search . '%')
                    ->orWhere('peoples.email', 'like', '%' . $search . '%')
                    ->orWhere('peoples.recovery_email', 'like', '%' . $search . '%')
                    ->orWhere('peoples.date_of_birth', 'like', '%' . $search . '%')
                    ->orWhere('categories.category_name', 'like', '%' . $search . '%');
                // Add more columns to search as needed
            });
        }
        $query->orderBy($orderField, $orderBy);
        // $items = $query->toSql();
        $items = ($perPage < 0)
            ? $query->paginate(1000000, ['*'], 'page', $page)
            : $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json($items);
    }


    public function deletePeople(Request $request)
    {

        $category = DB::table('peoples')->where('id', $request->id)->delete();
        return response()->json(['message' => 'success']);
    }

    public function getSinglePeople(Request $request)
    {
        $data = DB::table('peoples')->where('profile_id', $request->profile_id)->first();
        return response()->json($data);
    }

    public function getPeoplesCount(Request $request)
    {

        // $thresholdTimestamp = Carbon::now()->subSeconds(15)->timestamp;
        $thresholdTimestamp = Carbon::now()->subDays(1)->timestamp;

        // delete QR Code
        collect(Storage::disk('QrCode')->listContents())->each(function ($file) use ($thresholdTimestamp) {
            // Check if the file's timestamp is less than the threshold timestamp
            if ($file['timestamp'] < $thresholdTimestamp) {
                // Delete the file
                Storage::disk('QrCode')->delete($file['path']);
            }
        });

        // delete Excel
        collect(Storage::disk('Excel')->listContents())->each(function ($file) use ($thresholdTimestamp) {
            // Check if the file's timestamp is less than the threshold timestamp
            if ($file['timestamp'] < $thresholdTimestamp) {
                // Delete the file
                Storage::disk('Excel')->delete($file['path']);
            }
        });

        // delete DuplicateExcel Data
        collect(Storage::disk('DuplicateExcel')->listContents())->each(function ($file) use ($thresholdTimestamp) {
            // Check if the file's timestamp is less than the threshold timestamp
            if ($file['timestamp'] < $thresholdTimestamp) {
                // Delete the file
                Storage::disk('DuplicateExcel')->delete($file['path']);
            }
        });

        // delete QrZip Data
        collect(Storage::disk('QrZip')->listContents())->each(function ($file) use ($thresholdTimestamp) {
            // Check if the file's timestamp is less than the threshold timestamp
            if ($file['timestamp'] < $thresholdTimestamp) {
                // Delete the file
                Storage::disk('QrZip')->delete($file['path']);
            }
        });




        // google user data delete


        // delete QR Code
        collect(Storage::disk('GoogleQrCode')->listContents())->each(function ($file) use ($thresholdTimestamp) {
            // Check if the file's timestamp is less than the threshold timestamp
            if ($file['timestamp'] < $thresholdTimestamp) {
                // Delete the file
                Storage::disk('GoogleQrCode')->delete($file['path']);
            }
        });

        // delete Excel
        collect(Storage::disk('GoogleUserExcel')->listContents())->each(function ($file) use ($thresholdTimestamp) {
            // Check if the file's timestamp is less than the threshold timestamp
            if ($file['timestamp'] < $thresholdTimestamp) {
                // Delete the file
                Storage::disk('GoogleUserExcel')->delete($file['path']);
            }
        });

        // delete googleUserDuplicateData Data
        collect(Storage::disk('googleUserDuplicateData')->listContents())->each(function ($file) use ($thresholdTimestamp) {
            // Check if the file's timestamp is less than the threshold timestamp
            if ($file['timestamp'] < $thresholdTimestamp) {
                // Delete the file
                Storage::disk('googleUserDuplicateData')->delete($file['path']);
            }
        });

        // delete GoogleUserQrZip Data
        collect(Storage::disk('GoogleUserQrZip')->listContents())->each(function ($file) use ($thresholdTimestamp) {
            // Check if the file's timestamp is less than the threshold timestamp
            if ($file['timestamp'] < $thresholdTimestamp) {
                // Delete the file
                Storage::disk('GoogleUserQrZip')->delete($file['path']);
            }
        });

        $peoples = DB::table('peoples')
            ->select('peoples.*')
            ->get()->count();

        $google_users = DB::table('google_users')
            ->select('google_users.*')
            ->get()->count();

        $data['peoples'] = $peoples;
        $data['google_users'] = $google_users;
        return response()->json($data);
    }

    public function downloadSampleFile()
    {
        $filePath = asset('../storage/app/public/omnya-sample-file.xlsx');
        return response()->json($filePath);
    }

    public function downloadImportSampleFile()
    {
        $filePath = asset('../storage/app/public/omnya-import-sample-file.xlsx');
        return response()->json($filePath);
    }

    public function addCategory(Request $request)
    {
        $requestArray = $request->all();
        $fileUrl = $filepath = $fileName = '';
        $categoryData = [];
        // Check if the 'image' field exists in the request
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension();
            $extension_array = ['png', 'jpg', 'jpeg', 'jfif', 'pjpeg', 'pjp', 'gif'];

            if (!in_array($extension, $extension_array)) {
                return response()->json(['errors' => 'The file must be a file of type: png, jpg, jpeg, jfif, pjpeg, pjp, gif.'], 400);
            }

            // Generate a unique file name
            $fileName = Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME), '-') . '.' . $extension;

            // Save the file to the storage folder (public/category_image)
            $filePath = $file->storeAs('public/category_image', $fileName);

            // The above line will store the file in storage/app/public/category_image

            // Get the public URL for the stored file
            $fileUrl = asset(str_replace('public/', 'storage/', $filePath));
            $filepath = 'category_image/' . $fileName;
            $categoryData['image'] = $filepath;
        }

        // Validate and save other form data
        $requestData = $request->validate([
            'category_name' => 'required',
        ]);

        $categoryData['category_name'] = $requestArray['category_name'];
        $categoryData['description'] = $requestArray['description'];

        $category = Category::updateOrCreate(
            [
                'category_name' => $requestArray['category_name'],
            ],
            $categoryData
        );

        return response()->json(['message' => 'success', 'file_path' => $fileUrl, 'file_name' => $fileName]);
    }

    public function getCategory(Request $request)
    {
        $data = $request->all();

        $perPage = $data['params']['perPage'] ?? 10000000;
        $page = $data['params']['page'] ?? 1;
        $search = $data['params']['search'] ?? '';
        $serverParams = $data['params']['serverParams'] ?? '';
        $orderBy = $serverParams['sort'][0]['type'] ?? 'asc';
        $orderField = $serverParams['sort'][0]['field'] ?? 'id';

        $filters = [
            'category_name'
        ];

        $query = Category::query();
        $query->select('*');

        foreach ($filters as $filter) {
            if (isset($data[$filter]) && !empty($data[$filter])) {
                $query->where($filter, 'like', '%' . $data[$filter] . '%');
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('category_name', 'like', '%' . $search . '%');
                // Add more columns to search as needed
            });
        }

        $query->orderBy($orderField, $orderBy);
        $items =  $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json($items);
    }

    public function getSingleCategory(Request $request)
    {
        $data = DB::table('categories')->where('id', $request->id)->first();
        return response()->json($data);
    }

    public function deleteCategory(Request $request)
    {

        $category = DB::table('categories')->where('id', $request->id)->delete();
        return response()->json(['message' => 'success']);
    }


    public function addAdmin(Request $request)
    {
        $requestArray = $request->all();

        $requestArray['password'] = Hash::make($requestArray['password']);

        $requestData = $request->validate([
            'name' => 'required',
            'email' => 'required',
        ]);

        $data = [
            'name' => $requestArray['name'],
            'email' => $requestArray['email'],
            'password' => $requestArray['password'],
            'remember_token' => 'apwcR9Q5Ko',
            'email_verified_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];

        DB::table('users')->insert($data); // Use the insert method

        return response()->json(['message' => 'success']);
    }

    public function getAdmin(Request $request)
    {
        $data = $request->all();

        $perPage = $data['params']['perPage'] ?? 10;
        $page = $data['params']['page'] ?? 1;
        $search = $data['params']['search'] ?? '';
        $serverParams = $data['params']['serverParams'] ?? '';
        $orderBy = $serverParams['sort'][0]['type'] ?? 'asc';
        $orderField = $serverParams['sort'][0]['field'] ?? 'id';

        $filters = [
            'name',
            'email',
        ];

        $query = User::query();
        $query->select('*');

        foreach ($filters as $filter) {
            if (isset($data[$filter]) && !empty($data[$filter])) {
                $query->where($filter, 'like', '%' . $data[$filter] . '%');
            }
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
                $q->where('email', 'like', '%' . $search . '%');
                // Add more columns to search as needed
            });
        }
        $query->orderBy($orderField, $orderBy);
        $items = ($perPage < 0)
            ? $query->paginate(1000000, ['*'], 'page', $page)
            : $query->paginate($perPage, ['*'], 'page', $page);

        return response()->json($items);
    }

    public function deleteAdmin(Request $request)
    {

        $Admin = DB::table('users')->where('id', $request->id)->delete();
        return response()->json(['message' => 'success']);
    }

    public function changePassword(Request $request)
    {
        $requestArray = $request->all();

        $passwordData = [
            'password' =>  Hash::make($requestArray['password'])
        ];

        $user = User::find(Auth::user()->id);

        if ($user) {
            $user->update($passwordData);
        }
        return response()->json(['message' => 'success']);
    }

    public function bulkDeleteUser(Request $request)
    {
        $data = $request->all();
        if (sizeof($data) > 0) {
            foreach ($data as $key => $val) {
                $peoples = DB::table('peoples')->where('id', $val)->delete();
            }
        }
        return response()->json(['message' => 'Success']);
    }

    public function exportDatabase()
    {
        // ENTER THE RELEVANT INFO BELOW
        $mysqlHostName = env('DB_HOST');
        $mysqlUserName = env('DB_USERNAME');
        $mysqlPassword = env('DB_PASSWORD');
        $DbName = env('DB_DATABASE');
        $backup_name = "mybackup.sql";
        $tables = [
            "categories", "google_users", "peoples", "users"
        ]; // here your tables...

        $connect = new \PDO("mysql:host=$mysqlHostName;dbname=$DbName;charset=utf8", "$mysqlUserName", "$mysqlPassword", array(\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
        $get_all_table_query = "SHOW TABLES";
        $statement = $connect->prepare($get_all_table_query);
        $statement->execute();
        $result = $statement->fetchAll();

        $output = '';

        foreach ($tables as $table) {
            $show_table_query = "SHOW CREATE TABLE " . $table . "";
            $statement = $connect->prepare($show_table_query);
            $statement->execute();
            $show_table_result = $statement->fetchAll();

            foreach ($show_table_result as $show_table_row) {
                $output .= "\n\n" . $show_table_row["Create Table"] . ";\n\n";
            }

            $select_query = "SELECT * FROM " . $table . "";
            $statement = $connect->prepare($select_query);
            $statement->execute();
            $total_row = $statement->rowCount();

            for ($count = 0; $count < $total_row; $count++) {
                $single_result = $statement->fetch(\PDO::FETCH_ASSOC);
                $table_column_array = array_keys($single_result);
                $table_value_array = array_values($single_result);

                // Iterate through the values and replace empty strings with NULL
                foreach ($table_value_array as $key => $value) {
                    if ($table === 'users' && $table_column_array[$key] === 'updated_at' && $value === '') {
                        $table_value_array[$key] = 'NULL';
                    } else {
                        $table_value_array[$key] = "'" . $value . "'";
                    }
                }

                $output .= "\nINSERT INTO $table (";
                $output .= "" . implode(", ", $table_column_array) . ") VALUES (";
                $output .= "" . implode(", ", $table_value_array) . ");\n";
            }
        }

        // Define the file name and path within the storage directory
        $file_name = 'database_backup_on_' . date('y-m-d_H_i_s') . '.sql';
        $file_path = 'public/backups/' . $file_name;

        // Save the backup to the specified storage path
        Storage::put($file_path, $output);

        // Provide a download link to the saved backup
        $filePath = asset('../storage/app/public/backups/' . $file_name);
        return response()->json(['downloadLink' => $filePath, 'fileName' => $file_name]);
        // return response()->json($filePath);
    }


    public function importDatabase(Request $request)
    {
        $request->validate([
            'sqlFile' => 'required', // Adjust the file size limit as needed
        ]);

        if ($request->hasFile('sqlFile')) {
            if ($request->file('sqlFile')->isValid()) {
                $file = $request->file('sqlFile');
                $fileName = 'import.sql'; // You can use a dynamic name or generate a unique one
                $file->storeAs('temporary', $fileName); // Store in a temporary location
                return $this->importSQLFile();
                return response()->json(['message' => 'File uploaded successfully']);
            }
        } else {
            return response()->json(['error' => 'Please select a SQL file for upload'], 422);
        }
        return response()->json(['error' => 'File upload failed'], 422);
    }

    public function importSQLFile()
    {
        // Path to the uploaded SQL file
        $path = storage_path('app/temporary/import.sql');

        // Get the SQL content from the file
        $sql = file_get_contents($path);

        // Disable foreign key checks to avoid issues when dropping tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        $tables = [
            "categories", "google_users", "peoples", "users"
        ]; // Define the specific tables to drop

        // Drop the specified tables
        foreach ($tables as $table) {
            DB::statement("DROP TABLE IF EXISTS $table");
        }

        // Re-enable foreign key checks
        // DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Import the SQL file
        try {
            DB::unprepared($sql);
            return response()->json(['message' => 'SQL file imported successfully']);
        } catch (Exception $e) {
            return response()->json(['error' => 'SQL file import failed'], 500);
        }
    }
}
