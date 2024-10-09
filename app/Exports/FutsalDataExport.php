<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class FutsalDataExport implements FromCollection, WithHeadings, WithMapping
{
    protected $futsalData;

    public function __construct($futsalData)
    {
        $this->futsalData = $futsalData;
    }

    public function collection()
    {
        return $this->futsalData;
    }

    public function headings(): array
    {
        return [
            'Name Futsal',
            'Provinsi',
            'Kota',
            'Alamat',
            'Fasilitas',
            'Harga',
            'Total Lapangan',
            'Total Jadwal',
            'Total Jadwal Booked',
            'Total Booking',
            'Pendapatan',
        ];
    }

    public function map($row): array
    {
        return [
            $row['futsal_name'],
            $row['futsal_province'],
            $row['futsal_regency'],
            $row['futsal_alamat'],
            $row['futsal_facilities'],
            $row['futsal_price'],
            $row['total_fields'],
            $row['total_schedules'],
            $row['total_booked_schedules'],
            $row['total_bookings'],
            $row['total_revenue'],
        ];
    }
}