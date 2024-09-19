<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\StatesDataTable;
use App\Models\Country;
use App\Models\State;
use App\Traits\ImageTrait;

class StateController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(StatesDataTable $dataTable)
    {
        return $dataTable->render('admin.states.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $countries = Country::where('status', 1)->get(['id','name']);
        return view('admin.states.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if($request->hasFile('image')){
            $data['image'] = $this->verifyAndUpload($request, 'image', null, 'states');
        }
        State::create($data);

        return redirect()->route('admin.states.index')->with('success', 'State created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(State $state)
    {
        return view('admin.states.show', compact('state'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(State $state)
    {
        $countries = Country::where('status', 1)->get(['id','name']);
        return view('admin.states.edit', get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, State $state)
    {
        $data = $request->validate([
            'country_id' => 'required|exists:countries,id',
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        if($request->hasFile('image')){
            $data['image'] = $this->verifyAndUpload($request, 'image', $state->image, 'states');
        }
        $state->update($data);

        return redirect()->route('admin.states.index')->with('success', 'State updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(State $state)
    {
        $state->delete();
        return redirect()->route('states.index')->with('success', 'State deleted successfully.');
    }
}