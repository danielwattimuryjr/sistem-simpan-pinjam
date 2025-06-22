<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCriteriaRequest;
use App\Http\Requests\UpdateCriteriaRequest;
use App\Models\Criteria;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $criterias = Criteria::with('scores')->get();

        return view('criterias.get-all-criterias', ['criterias' => $criterias]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('criterias.post-criterias');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCriteriaRequest $request)
    {
        $validated = $request->validated();

        $criteria = Criteria::create([
            'name'      => $validated['name'],
            'category'  => $validated['category'],
            'weight'    => $validated['weight'],
            'table_reference'   => $validated['table_reference'],
            'column_reference'  => $validated['column_reference']
        ]);
        foreach ($validated['scores'] as $row) {
            $criteria->scores()->create([
                'criteria_name'     => $criteria->name,
                'criteria_category' => $criteria->category,
                'criteria_weight'   => $criteria->weight,
                'batas_bawah'       => $row['batas_bawah'],
                'score'             => $row['skor'],
                'table_reference'   => $criteria->table_reference,
                'column_reference'  => $criteria->column_reference
            ]);
        }

        $flashMessage = "Data faktor penilaian berhasil ditambahkan";

        return to_route('criterias.index')->with('success', $flashMessage);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Criteria $criteria)
    {
        $criteria->load('scores');

        return view('criterias.put-criterias', ['criteria' => $criteria]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCriteriaRequest $request, Criteria $criteria)
    {
        $validated = $request->validated();

        $criteria->update([
            'name'              => $validated['name'],
            'category'          => $validated['category'],
            'weight'            => $validated['weight'],
            'table_reference'   => $validated['table_reference'],
            'column_reference'  => $validated['column_reference']
        ]);
        $criteria->scores()->delete();
        foreach ($validated['scores'] as $row) {
            $criteria->scores()->create([
                'criteria_name'     => $criteria->name,
                'criteria_category' => $criteria->category,
                'criteria_weight'   => $criteria->weight,
                'batas_bawah'       => $row['batas_bawah'],
                'score'             => $row['skor'],
                'table_reference'   => $criteria->table_reference,
                'column_reference'  => $criteria->column_reference
            ]);
        }

        $flashMessage = "Data faktor penilaian berhasil diperbarui";

        return to_route('criterias.index')->with('success', $flashMessage);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Criteria $criteria)
    {
        $criteria->delete();

        $flashMessage = "Data faktor penilaian berhasil dihapus";

        return to_route('criterias.index')->with('success', $flashMessage);
    }
}
