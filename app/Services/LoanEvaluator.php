<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\Criteria;
use App\Models\CriteriaScore;
use App\Models\LoanEvaluation;
use Illuminate\Support\Collection;

class LoanEvaluator
{
    public function evaluate(Loan $loan): LoanEvaluation
    {
        $criterias = Criteria::with('scores')->get(); 
        $details = [];
        $logSum = 0;
        $evaluatedAt = $evaluatedAt ?? now();

        $criteriaHash = sha1(json_encode(
            $criterias->map(function ($c) {
                return [
                    'name' => $c->name,
                    'category' => $c->category,
                    'weight' => $c->weight,
                    'scores' => $c->scores->map(fn($s) => [
                        'batas_bawah' => $s->batas_bawah,
                        'score' => $s->score,
                    ])->toArray(),
                ];
            })->toArray()
        ));

        foreach ($criterias as $criteria) {
            // Ambil nilai dari kolom di tabel loans (misal: pendapatan, jaminan, dll)
            $value = $loan->{$criteria->column_reference};

            // Cari skor dari tabel criteria_scores
            $score = CriteriaScore::where('criteria_id', $criteria->id)
                ->where('batas_bawah', '<=', $value)
                ->orderByDesc('batas_bawah')
                ->first()?->score ?? 1;

            $details[] = [
                'criteria_id' => $criteria->id,
                'name' => $criteria->name,
                'category' => $criteria->category,
                'weight' => $criteria->weight,
                'score' => $score,
                'value' => $value,
            ];

            $normalized = $criteria->category === 'cost'
                ? (1 / $score)
                : $score;

            // WP pakai logaritma untuk menghindari underflow
            $logSum += log($normalized) * $criteria->weight;
        }

        $nilai_wp = exp($logSum);

        // Simpan ke database (replace if already exists)
        $evaluation = LoanEvaluation::updateOrCreate(
            ['loan_id' => $loan->id],
            [
                'nilai_wp'      => $nilai_wp,
                'normalized_wp' => null,
                'details'       => $details,
                'criteria_hash' => $criteriaHash,
                'evaluated_at' => $evaluatedAt,
            ]
        );

        return $evaluation;
    }

    public function normalizeEvaluations(Collection $evaluations)
    {
        $total = $evaluations->sum('nilai_wp');

        foreach ($evaluations as $evaluation) {
            $normalized = $total > 0 ? $evaluation->nilai_wp / $total : 0;

            $evaluation->update([
                'normalized_wp' => $normalized,
            ]);
        }
    }

    public function getLatestEvaluatedAt()
    {
        return LoanEvaluation::max('evaluated_at');
    }
}
