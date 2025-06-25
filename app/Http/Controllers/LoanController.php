<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLoanRequest;
use App\Http\Requests\UpdateLoanRequest;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;
use App\Services\LoanEvaluator;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasRole('admin')) {
        $loans = \App\Models\Loan::with(['user.profile', 'evaluation'])
            ->whereHas('evaluation')
            ->get()
            ->sortByDesc(fn($loan) => $loan->evaluation->normalized_wp ?? 0)
            ->values();
        } else {
            $loans = Auth::user()->loans()->with(['user.profile', 'evaluation'])->get();
        }

        return view('pinjaman.get-all-pinjaman', compact('loans'));
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
    
    public function normalize()
    {
        (new LoanEvaluator())->normalizeAllEvaluations();

        return redirect()->back()->with('success', 'Normalisasi berhasil!');
    }

    public function approve(Loan $loan)
    {
        $loan->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Pinjaman disetujui.');
    }

    public function reject(Loan $loan)
    {
        $loan->update(['status' => 'rejected']);
        return redirect()->back()->with('success', 'Pinjaman ditolak.');
    }
}
