<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\BidvalueDataTable;
use App\Models\Bidvalue;


class BidvalueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BidvalueDataTable $dataTable)
    {
        return $dataTable->render('admin.bidvalues.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.bidvalues.create');
    }

    private function calculateIncrement($bidvalue)
    {
        if ($bidvalue >= 5 && $bidvalue < 100) {
            return 5;
        } elseif ($bidvalue >= 100 && $bidvalue < 250) {
            return 10;
        } elseif ($bidvalue >= 250 && $bidvalue < 500) {
            return 25;
        } elseif ($bidvalue >= 500 && $bidvalue < 1000) {
            return 50;
        } elseif ($bidvalue >= 1000 && $bidvalue < 3000) {
            return 100;
        } elseif ($bidvalue >= 3000 && $bidvalue < 5000) {
            return 200;
        } elseif ($bidvalue >= 5000 && $bidvalue < 10000) {
            return 500;
        } elseif ($bidvalue >= 10000 && $bidvalue < 20000) {
            return 1000;
        } else {
            return 2000;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'bidvalue' => 'required|numeric',
            'status' => 'required|boolean',
        ]);
    
        $bidvalue = $request->input('bidvalue');
        $increment = $this->calculateIncrement($bidvalue);
    
        $validatedData = [
            'bidvalue' => $bidvalue,
            'increment' => $increment,
            'cal_amount' => $bidvalue +$increment,
            'status' => $request->input('status'),
        ];
        $previouscalamount = Bidvalue::max('cal_amount');

        if ($bidvalue < $previouscalamount) {
            return redirect()->back()->withErrors(['bidvalue' => 'The bid value must be greater than or equal to the calculated amount of the previous bid value.']);
        }
    
        $bid = Bidvalue::create($validatedData);
    
        return redirect()->route('admin.bidvalues.index')->with('success', 'BidValue created successfully!');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bidvalue $bidvalue)
    {
        return view('admin.bidvalues.edit', compact('bidvalue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bidvalue $bidvalue)
    {
        $data = $request->validate([
            'bidvalue' => 'required|numeric',
            'status' => 'required|boolean',
        ]);

        $bidvalue = $request->input('bidvalue');
        $increment = $this->calculateIncrement($bidvalue);
    
        $validatedData = [
            'bidvalue' => $bidvalue,
            'increment' => $increment,
            'cal_amount' => $bidvalue +$increment,
            'status' => $request->input('status'),
        ];
        $previouscalamount = Bidvalue::max('cal_amount');

        if ($bidvalue < $previouscalamount) {
            return redirect()->back()->withErrors(['bidvalue' => 'The bid value must be greater than or equal to the calculated amount of the previous bid value.']);
        }
        $bidvalue->update($data);
        
        return redirect()->route('admin.bidvalues.index')->with('success', 'bidvalue updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bidvalue $bidvalue)
    {
        $bidvalue->delete();
        return redirect()->route('admin.bidvalues.index')->with('success', 'bidvalue deleted successfully');
    }


}
