<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LoanEvaluationMultiSheetExport implements WithMultipleSheets
{
    protected $evaluations;
    protected $criterias;

    public function __construct($evaluations, $criterias)
    {
        $this->evaluations = $evaluations;
        $this->criterias = $criterias;
    }

    public function sheets(): array
    {
        return [
            new LoanEvaluationExport($this->evaluations),
            new CriteriaExport($this->criterias),
        ];
    }
}
