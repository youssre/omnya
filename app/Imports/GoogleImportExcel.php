<?php

namespace App\Imports;

use App\Models\GoogleUser;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class GoogleImportExcel implements ToModel, WithChunkReading
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
            'recovery_email' => $row[5], // Recovery Email
        ];

        $GoogleUser = GoogleUser::updateOrCreate(
            ['profile_id' => $row[4]],
            $data
        );
        // Return the GoogleUser model instance
        return $GoogleUser;
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
