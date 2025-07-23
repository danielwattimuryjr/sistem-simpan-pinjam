<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\Criteria;
use App\Models\CriteriaScore;
use App\Models\LoanEvaluation;
use Illuminate\Support\Collection;

class LoanEvaluator
{
    public function evaluate(Loan $loan, ?Carbon $evaluatedAt = null): LoanEvaluation
    {
        $criterias = Criteria::with('scores')->get();
        $evaluatedAt = $evaluatedAt ?? now();
        $logSum = 0;
        $details = [];

        // 1. Hitung criteria_hash
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

        // 2. Ambil batch_number terakhir dari loan_evaluations dengan criteria_hash ini
        $lastBatch = LoanEvaluation::max('batch_number') ?? 0;

        $batchNumber = 1;

        if ($lastBatch > 0) {
            // 3. Cek apakah masih ada loan yang "pending" di batch terakhir dan criteria_hash ini
            $stillPending = LoanEvaluation::where('criteria_hash', $criteriaHash)
                ->where('batch_number', $lastBatch)
                ->whereHas('loan', fn($q) => $q->where('status', 'pending'))
                ->exists();

            $batchNumber = $stillPending ? $lastBatch : $lastBatch + 1;
        }

        // 4. Proses nilai WP seperti biasa
        foreach ($criterias as $criteria) {
            $value = $loan->{$criteria->column_reference};

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

            $logSum += log($normalized) * $criteria->weight;
        }

        $nilai_wp = exp($logSum);

        return LoanEvaluation::updateOrCreate(
            ['loan_id' => $loan->id],
            [
                'nilai_wp'      => $nilai_wp,
                'normalized_wp' => null,
                'details'       => $details,
                'criteria_hash' => $criteriaHash,
                'evaluated_at'  => $evaluatedAt,
                'batch_number'  => $batchNumber,
            ]
        );
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
