<?php

namespace App\Imports;

use App\Models\People;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\DB;

class PeopleImportExcel implements ToModel, WithChunkReading
{
    // protected $category_id;

    // public function __construct($category_id)
    // {
    //     $this->category_id = $category_id;
    // }

    public function model(array $row)
    {
        // Skip the header row manually
        if ($row[0] === 'Email') {
            return [];
        }
        $Password = Hash::make($row[1]);

        $data = [
            'email' => $row[0], // Email
            'plain_password' => $row[1], // Password
            'password' => $Password,
            'q1' => config('constants.QUESTION_1'), // q1
            'a1' => $row[2], // a1
            'q2' => config('constants.QUESTION_2'), // q2
            'a2' => $row[3], // a2
            'q3' => config('constants.QUESTION_3'), // q3
            'a3' => $row[4], // a3
            'date_of_birth' => $row[5], // Date Of Birth
            'recovery_email' => $row[9], // Recovery Email
            // 'first_name' => $row[6], // First Name
            // 'last_name' => $row[7], // Last Name
            // 'page_url' => $row[8], // Page URL
            // 'barcode_url' => $row[9], // Barcode URL
            // 'category_id' => $this->category_id,
        ];

        $people = People::updateOrCreate(
            ['profile_id' => $row[8]],
            $data
        );
        // Return the People model instance
        return $people;
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
