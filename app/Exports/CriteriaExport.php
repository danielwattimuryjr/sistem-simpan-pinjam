<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CriteriaExport implements FromCollection, WithHeadings
{
    protected $criterias;

    public function __construct($criterias)
    {
        $this->criterias = $criterias;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->criterias->map(function ($c) {
            return [
                'Nama Kriteria' => $c->name,
                'Kategori' => ucfirst($c->category),
                'Bobot' => $c->weight,
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama Kriteria', 'Kategori', 'Bobot'];
    }
}
