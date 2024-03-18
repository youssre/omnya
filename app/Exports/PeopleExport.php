<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;

class PeopleExport implements FromCollection
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }
}
