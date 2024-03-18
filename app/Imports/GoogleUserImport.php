<?php

namespace App\Imports;

use App\Models\GoogleUser;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class GoogleUserImport implements ToModel, WithChunkReading
{
    protected $duplicateData = [];
    protected $category_id;
    protected $import_enable_recovery;
    protected $is_logo_enable;


    public function __construct($category_id, $import_enable_recovery, $is_logo_enable)
    {
        $this->category_id = $category_id;
        $this->is_logo_enable = $is_logo_enable;
        $this->import_enable_recovery = $import_enable_recovery;
    }

    public function model(array $row)
    {

        // Skip the header row manually
        if ($row[0] === 'Email') {
            return [];
        }
        // Check for duplicate data
        $existingRecord = GoogleUser::where(
            'email',
            $row[0]
        )->first();

        if ($existingRecord) {
            // Handle duplicate data (e.g., log or store it)
            $this->duplicateData[] = $row;

            // Return null to skip importing the duplicate row
            return null;
        }

        $data = [
            'email' => $row[0], // Email
            'plain_password' => $row[1], // Password
            'category_id' => $this->category_id,
            'is_recovery_enable' => $this->import_enable_recovery,
            'is_logo_enable' => $this->is_logo_enable,
            'recovery_email' => $row[2], // Recovery Emails
        ];
        // Import the unique data
        // new GoogleUser($data);

        $Password = Hash::make($row[1]);

        // Create a new GoogleUser instance and save it to the database
        $GoogleUser = GoogleUser::create($data);

        $randomString = $this->generateRandomString(7);
        $CryptId = $GoogleUser->id . $randomString;

        $url = url('/') . '/view-google-user/' . $CryptId;

        // Update the GoogleUser model with additional data
        $GoogleUser->update([
            'page_url' => str_replace(' ', '-', strtolower($url)),
            'profile_id' => $CryptId,
            'password' => $Password,
            'barcode_url' => url('/') . '/google-qr-code/' . $GoogleUser->email,
        ]);
        return $GoogleUser;
    }

    public function rules(): array
    {
        return [
            'email' => Rule::unique('google_users', 'email'),
            // Add validation rules for other columns
        ];
    }

    public function getDuplicateData()
    {
        return $this->duplicateData;
    }

    public function generateRandomString($length = 10)
    {
        $characters = '0123456789';
        $randomString = substr(str_shuffle($characters), 0, $length);
        return $randomString;
    }

    public function chunkSize(): int
    {
        return 200; // Adjust the chunk size as needed
    }
}
