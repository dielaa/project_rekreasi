<?php

namespace App\Exports;

use App\Models\Facility;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FacilityExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $rowNumber = 0;
    public function collection()
    {
        return Facility::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Name',
            'Location',
            'Description',
            'Capacity',
            'Operational',
            'Status'
        ];
    }
    public function map($data): array
    {
        return [
            ++$this->rowNumber,
            $data->name,
            $data->location,
            $data->description,
            $data->capacity,
            $data->operational_hours,
            $data->status
        ];
    }
}
