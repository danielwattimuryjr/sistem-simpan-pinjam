<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Models\Loan;
use App\Models\LoanEvaluation;
use App\Models\Criteria;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LoanEvaluationMultiSheetExport;
use Illuminate\Support\Facades\Auth;
use App\Services\LoanEvaluator;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
            $pendingEvaluations = LoanEvaluation::with('loan.user.profile')
                ->whereHas('loan', fn ($q) => $q->where('status', 'pending'))
                ->get()
                ->sortByDesc('batch_number') // urutkan batch baru dulu
                ->groupBy(function ($evaluation) {
                    return $evaluation->criteria_hash . '|' . $evaluation->batch_number;
                });

            $criteriaDetails = Criteria::get();

            return view('pinjaman.get-all-pinjaman', [
                'activeBatches' => $pendingEvaluations,
                'criteriaDetails' => $criteriaDetails,
            ]);
        } else {
            $loans = Auth::user()->loans()->with(['user.profile', 'evaluation'])->get();
            return view('pinjaman.get-all-pinjaman', compact('loans'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pinjaman.post-pinjaman');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLoanRequest $request)
    {
        $validated = $request->validated();

        $loan = Auth::user()->loans()->create($validated);

        app(LoanEvaluator::class)->evaluate($loan);

        $flashMessage = 'Data pinjaman berhasil diajukan';

        return to_route('pinjaman.index')->with('success', $flashMessage);
    }
    
    public function normalize(Request $request)
    {
        try {
            $hash = $request->input('criteria_hash');
            $batch = $request->input('batch_number');

            if (!$hash || !$batch) {
                return redirect()->back()->with('error', 'Hash atau batch tidak ditemukan.');
            }

            $evaluations = LoanEvaluation::where('criteria_hash', $hash)
                ->where('batch_number', $batch)
                ->whereNull('normalized_wp')
                ->whereHas('loan', fn($q) => $q->where('status', 'pending'))
                ->get();

            if ($evaluations->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada data yang bisa dinormalisasi untuk batch ini.');
            }

            (new LoanEvaluator())->normalizeEvaluations($evaluations);

            return redirect()->back()->with('success', 'Normalisasi berhasil untuk batch #' . $batch);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function approve(Loan $loan)
    {
        abort_unless(Auth::user()->hasRole('admin'), 403);

        if ($loan->status !== 'pending') {
            return back()->with('error', 'Pinjaman ini sudah diproses.');
        }

        $loan->update(['status' => 'approved']);
        return back()->with('success', 'Pinjaman berhasil disetujui.');
    }

    public function reject(Loan $loan)
    {
        abort_unless(Auth::user()->hasRole('admin'), 403);
        
        if ($loan->status !== 'pending') {
            return back()->with('error', 'Pinjaman ini sudah diproses.');
        }

        $loan->update(['status' => 'rejected']);
        return back()->with('success', 'Pinjaman berhasil ditolak.');
    }

    public function exportOne($evaluationId, $type)
    {
        $evaluations = LoanEvaluation::with('loan.user.profile')
            ->find($evaluationId);

        $criterias = Criteria::all();

        $filename = 'evaluasi_pinjaman_' . now()->format('Ymd_His');

        if (in_array($type, ['csv', 'xlsx'])) {
            return Excel::download(
                new LoanEvaluationMultiSheetExport($evaluations, $criterias),
                "$filename.$type"
            );
        }

        if ($type === 'pdf') {
            $pdf = PDF::loadView('exports.pdf-evaluations', [
                'evaluations' => [$evaluations],
            ]);

            return $pdf->download("$filename.pdf");
        }

        abort(404);
    }

    public function history() {
        $loans = LoanEvaluation::with('loan.user.profile')
            ->whereHas('loan', fn ($q) => $q->where('status','<>','pending'))
            ->get()
            ->sortByDesc('batch_number');
            
        return view('pinjaman.history-pinjaman', [
            'loans' => $loans,
        ]);
    }

    public function exportAll($type)
    {
        $evaluations = LoanEvaluation::with('loan.user.profile')
            ->whereHas('loan', fn ($q) => $q->where('status','<>','pending'))
            ->orderByDesc('batch_number')
            ->get();
        $criterias = Criteria::all();
        $filename = 'evaluasi_semua_pinjaman_' . now()->format('Ymd_His');

        if (in_array($type, ['csv', 'xlsx'])) {
            return Excel::download(
                new LoanEvaluationMultiSheetExport($evaluations, $criterias),
                "$filename.$type"
            );
        }

        if ($type === 'pdf') {
            $pdf = PDF::loadView('exports.pdf-evaluations', [
                'evaluations' => $evaluations,
            ]);
            return $pdf->download("$filename.pdf");
        }

        abort(404);
    }
}
