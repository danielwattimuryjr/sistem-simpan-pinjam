<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\Criteria;
use App\Models\CriteriaScore;
use App\Models\LoanEvaluation;

class LoanEvaluator
{
  public function evaluate(Loan $loan): LoanEvaluation
  {
      $criterias = Criteria::all();
      $details = [];
      $logSum = 0;

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
              'nilai_wp' => $nilai_wp,
              'details' => $details,
          ]
      );

      return $evaluation;
  }

  public function normalizeAllEvaluations(): void
  {
      $evaluations = \App\Models\LoanEvaluation::all();

      $total = $evaluations->sum('nilai_wp');

      foreach ($evaluations as $eval) {
          $normalized = $eval->nilai_wp / $total;

          $eval->normalized_wp = $normalized;
          $eval->save();
      }
  }
}
