<?php

namespace App\Exports;

use App\Models\UsherCollection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsherCollectionsExport implements FromCollection, WithHeadings
{
    /**
     * Return a collection of usher collections for export.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return UsherCollection::select('date_time', 'usher_name', 'collection_type', 'amount', 'signature')->get();
    }

    /**
     * Define the headings for the Excel sheet.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Date & Time',
            'Usher Name',
            'Collection Type',
            'Amount',
            'Signature',
        ];
    }
}
