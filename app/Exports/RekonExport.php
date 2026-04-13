<?php

namespace App\Exports;

use App\Models\RekonKas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class RekonExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Mengambil semua data rekon beserta info pembuatnya
        return RekonKas::with('creator')->latest()->get();
    }

    /**
    * Header untuk file Excel
    */
    public function headings(): array
    {
        return [
            'No',
            'Tanggal Rekon',
            'Kas Awal',
            'Masuk',
            'Keluar',
            'Kas Aktual',
            'Selisih',
            'Status',
            'Oleh',
        ];
    }

    /**
    * Mapping data agar rapi per kolom
    */
    public function map($rekon): array
    {
        static $no = 1;
        return [
            $no++,
            $rekon->rekon_date,
            $rekon->opening_cash,
            $rekon->cash_income,
            $rekon->operational_cash,
            $rekon->actual_cash,
            $rekon->difference,
            strtoupper($rekon->status),
            $rekon->creator->name ?? 'System',
        ];
    }
}