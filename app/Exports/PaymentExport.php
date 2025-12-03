<?php

namespace App\Exports;

use App\Models\Payment;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class PaymentExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $rowNumber = 0;

    public function collection()
    {
        return Payment::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Type',
        ];
    }

    public function map($data): array
    {
        return [
            ++$this->rowNumber,
            $data->type_payment
        ];
    }
}
