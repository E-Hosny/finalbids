<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\CountriesDataTable;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(CountriesDataTable $dataTable)
    {
        return $dataTable->render('admin.countries.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phonecode' => 'required|string|max:10',
            'status' => 'required|boolean',
        ]);

        Country::create($data);

        return redirect()->route('admin.countries.index')->with('success', 'Country created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        return view('admin.countries.show', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Country $country)
    {
        return view('admin.countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Country $country)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'phonecode' => 'required|string|max:10',
            'status' => 'required|boolean',
        ]);

        $country->update($data);

        return redirect()->route('admin.countries.index')->with('success', 'Country updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Country $country)
    {
        $country->delete();
        return redirect()->route('admin.countries.index')->with('success', 'Country deleted successfully.');
    }
}