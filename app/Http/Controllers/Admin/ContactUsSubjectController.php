<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ContactUsSubject;
use App\DataTables\ContactUsSubjectDataTable;

class ContactUsSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ContactUsSubjectDataTable $dataTable)
    {
        return $dataTable->render('admin.contact-us-subjects.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.contact-us-subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'sort_desc' => 'required|string'
        ]);

        ContactUsSubject::create($validatedData);

        return redirect()->route('admin.contact-us-subjects.index')->with('success', 'Subject created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactUsSubject $contact_us_subject)
    {
        return view('admin.contact-us-subjects.edit', compact('contact_us_subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactUsSubject $contact_us_subject)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'sort_desc' => 'required|string'
        ]);

        $contact_us_subject->update($validatedData);
        return redirect()->route('admin.contact-us-subjects.index')->with('success', 'Subject updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactUsSubject $contact_us_subject)
    {
        $contact_us_subject->delete();
        return redirect()->route('admin.contact-us-subjects.index')->with('success', 'Subject deleted successfully');
    }
}