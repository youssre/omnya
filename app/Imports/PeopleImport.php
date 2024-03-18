<?php

namespace App\Imports;

use App\Models\People;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
// use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PeopleImport implements ToModel, WithChunkReading
{
    protected $category_id;
    protected $import_enable_recovery;
    protected $is_logo_enable;
    protected $duplicateData = [];

    public function __construct($category_id, $import_enable_recovery, $is_logo_enable)
    {
        $this->category_id = $category_id;
        $this->import_enable_recovery = $import_enable_recovery;
        $this->is_logo_enable = $is_logo_enable;
    }

    public function model(array $row)
    {

        // Skip the header row manually
        if ($row[0] === 'Email') {
            return [];
        }
        // Check for duplicate data
        $existingRecord = People::where(
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
            'q1' => config('constants.QUESTION_1'), // q1
            'a1' => $row[2], // a1
            'q2' => config('constants.QUESTION_2'), // q2
            'a2' => $row[3], // a2
            'q3' => config('constants.QUESTION_3'), // q3
            'a3' => $row[4], // a3
            'date_of_birth' => $row[5], // Date Of Birth
            // 'first_name' => $row[6], // First Name
            // 'last_name' => $row[7], // Last Name
            'recovery_email' => $row[6], // Recovery Emails
            'category_id' => $this->category_id,
            'is_recovery_enable' => $this->import_enable_recovery,
            'is_logo_enable' => $this->is_logo_enable,
        ];
        // Import the unique data
        // new People($data);

        $Password = Hash::make($row[1]);

        // Create a new People instance and save it to the database
        $people = People::create($data);

        $randomString = $this->generateRandomString(7);
        $CryptId = $people->id . $randomString;

        $url = url('/') . '/view-user/' . $CryptId;

        // Update the People model with additional data
        $people->update([
            'page_url' => str_replace(' ', '-', strtolower($url)),
            'profile_id' => $CryptId,
            'password' => $Password,
            'barcode_url' => url('/') . '/qr-code/' . $people->email,
        ]);
        return $people;
    }

    public function rules(): array
    {
        return [
            'email' => Rule::unique('peoples', 'email'),
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
