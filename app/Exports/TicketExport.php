<?php

namespace App\Exports;

use App\Models\Ticket;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class TicketExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    private $rowNumber = 0;

    public function collection()
    {
        return Ticket::all();
    }

    public function headings(): array
    {
        return [
            'No',
            'Name',
            'Price',
            'Promo',
            'Final Price',
            'Start Date',
            'End Date',
        ];
    }

    public function map($data): array
    {
        if ($data->promo_id) {
            $originalPrice = $data->price;
            $discount = $data->promo ? ($originalPrice * $data->promo->percent / 100) : 0;
            $data->promo_id = $data->promo->percent . '%';
            $data->finalPrice = 'Rp' . number_format($originalPrice - $discount, 0, ',', '.');
        } else {
            $data->promo_id = 0;
            $data->finalPrice = 'Rp' . number_format($data->price, 0, ',', '.');
        }
        return [
            ++$this->rowNumber,
            $data->name,
            'Rp' . number_format($data->price, 0, ',', '.'),
            $data->promo_id,
            $data->finalPrice,
            $data->start_date,
            $data->end_date
        ];
    }
}
