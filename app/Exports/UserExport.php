<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class UserExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
        private $rowNumber = 0;

    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Name',
            'Email',
            'Role',
        ];
    }

    public function map($data): array
    {
        return [
            ++$this->rowNumber,
            $data->name,
            $data->email,
            $data->role
        ];
    }
}
