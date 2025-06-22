<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ProductTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        // Contoh data untuk template
        return [
            [
                'name' => 'Contoh Produk 1',
                'description' => 'Deskripsi produk contoh',
                'price' => 100000,
                'category_id' => 1,
                'stock' => 50,
            ],
            [
                'name' => 'Contoh Produk 2',
                'description' => 'Deskripsi produk contoh kedua',
                'price' => 150000,
                'category_id' => 1,
                'stock' => 25,
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'name',
            'description',
            'price',
            'category_id',
            'stock',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
