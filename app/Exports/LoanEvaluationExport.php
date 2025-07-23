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
        if (! $evaluations instanceof \Illuminate\Support\Collection) {
            $evaluations = collect([$evaluations]);
        }

        // Pastikan isinya bukan nested Collection
        $this->evaluations = $evaluations->flatten(1)->filter(function ($item) {
            return $item instanceof \App\Models\LoanEvaluation;
        });
    }

    public function collection()
    {
        return $this->evaluations->map(function ($eval) {
            $loan = $eval->loan;
            return [
                $loan->user->name,
                $loan->user->profile->nomor_rekening ?? '-',
                $loan->pendapatan,
                $loan->jumlah_tanggungan,
                $loan->jaminan,
                $loan->angsuran,
                $loan->jumlah_pinjaman,
                $eval->nilai_wp,
                $eval->normalized_wp,
                $loan->status,
            ];
        });
    }

    public function headings(): array
    {
        return ['Nama', 'No Rekening', 'Pendapatan', 'Tanggungan', 'Jaminan', 'Angsuran', 'Pinjaman', 'Nilai WP', 'WP Normalisasi', 'Status'];
    }
}
