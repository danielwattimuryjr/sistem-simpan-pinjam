<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Models\Loan;
use App\Models\LoanEvaluation;
use App\Models\Criteria;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LoanEvaluationExport;
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
          $groupedEvaluations = LoanEvaluation::with('loan.user.profile')
            ->get()
            ->sortByDesc('evaluated_at')
            ->groupBy(function ($evaluation) {
                return $evaluation->criteria_hash . '|' . $evaluation->evaluated_at;
            });


            $activeBatches = $groupedEvaluations->filter(function ($evaluations) {
                return $evaluations->contains(fn ($e) => $e->loan->status === 'pending');
            });

            $archivedBatches = $groupedEvaluations->filter(function ($evaluations) {
                return $evaluations->every(fn ($e) => $e->loan->status !== 'pending');
            });

            return view('pinjaman.get-all-pinjaman', compact('activeBatches', 'archivedBatches'));
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
        $batchEvaluatedAt = now();

        app(LoanEvaluator::class)->evaluate($loan, $batchEvaluatedAt);

        $flashMessage = 'Data pinjaman berhasil diajukan';

        return to_route('pinjaman.index')->with('success', $flashMessage);
    }

    /**
     * Display the specified resource.
     */
    public function show(Loan $loan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Loan $loan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLoanRequest $request, Loan $loan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Loan $loan)
    {
        $loan->delete();

        $flashMessage = 'Data pinjaman berhasil dihapus';

        return to_route('pinjaman.index')->with('success', $flashMessage);
    }

    /**
     * Update loan status to cancel
     */
    public function cancel(Loan $loan)
    {
        $loan->update(['status' => 'canceled']);

        $flashMessage = 'Pengajuan pinjaman berhasil dibatalkan';

        return to_route('pinjaman.index')->with('success', $flashMessage);
    }
    
    public function normalize(Request $request)
    {
        try {
            $hash = $request->input('criteria_hash');

            if (!$hash) {
                return redirect()->back()->with('error', 'Hash tidak ditemukan.');
            }

            $evaluations = LoanEvaluation::where('criteria_hash', $hash)
                ->where('normalized_wp', null)
                ->whereHas('loan', fn($q) => $q->where('status', 'pending'))
                ->get();

            if ($evaluations->isEmpty()) {
                return redirect()->back()->with('error', 'Tidak ada data yang bisa dinormalisasi pada batch ini.');
            }

            // Jalankan normalisasi hanya untuk yang memenuhi syarat
            (new LoanEvaluator())->normalizeEvaluations($evaluations);

            return redirect()->back()->with('success', 'Normalisasi berhasil untuk versi kriteria ini.');
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

    public function export($hash, $type)
    {
        $evaluations = LoanEvaluation::with('loan.user.profile')
            ->where('criteria_hash', $hash)
            ->get();

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
                'evaluations' => $evaluations,
                'hash' => $hash,
            ]);

            return $pdf->download("$filename.pdf");
        }

        abort(404);
    }
}
