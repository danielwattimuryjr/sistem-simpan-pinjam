<?php

namespace App\Exports;

use App\Models\LoanEvaluation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LoanEvaluationExport implements FromCollection, WithHeadings
{
    protected $evaluations;

    public function __construct($evaluations)
    {
        $this->evaluations = $evaluations;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->evaluations->map(function ($eval) {
            $loan = $eval->loan;
            return [
                'Nama' => $loan->user->name,
                'No Rekening' => $loan->user->profile->nomor_rekening,
                'Pendapatan' => $loan->pendapatan,
                'Tanggungan' => $loan->jumlah_tanggungan,
                'Jaminan' => $loan->jaminan,
                'Pinjaman' => $loan->jumlah_pinjaman,
                'Nilai WP' => $eval->nilai_wp,
                'WP Normalisasi' => $eval->normalized_wp,
                'Status' => $loan->status,
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama', 'No Rekening', 'Pendapatan', 'Tanggungan', 'Jaminan', 'Pinjaman', 'Nilai WP', 'WP Normalisasi', 'Status'];
    }
}
