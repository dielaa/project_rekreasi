<?php

namespace App\Exports;

use App\Models\Promo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class PromoExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $rowNumber = 0;

    public function collection()
    {
        return Promo::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Name',
            'Percent',
            'Start Date',
            'End Date',
        ];
    }

    public function map($data): array
    {
        return [
            ++$this->rowNumber,
            $data->name,
            $data->percent,
            $data->start_date,
            $data->end_date
        ];
    }
}
