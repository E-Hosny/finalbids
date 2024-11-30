<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\LanguageDataTable;
use App\Traits\ImageTrait;
use App\Models\Language;




class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use ImageTrait;
    
    public function index(LanguageDataTable $dataTable)
    {
        return $dataTable->render('admin.language.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.language.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'short_name' => 'required|string',
            'image_path' => 'required|image|max:2048',
            'status' => 'required|boolean', 
        ]);
        if ($request->hasFile('image_path')) {
            $data['image_path'] = $this->verifyAndUpload($request, 'image_path');
        }
        // Generate the slug
        $lang = Language::create($data);

        return redirect()->route('admin.language.index')->with('success', 'Language created successfully!');
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
    public function edit(Language $language)
    {
        return view('admin.language.edit', compact('language'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Language $language)
    {
        $data = $request->validate([
            'name' => 'string|max:255',
            'short_name' => 'string',
            'status' => 'boolean', 
        ]);

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $this->verifyAndUpload($request, 'image_path');
        }
    
        $language->update($data);
        
        return redirect()->route('admin.language.index')->with('success', 'Language updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Language $language)
    {
        $language->delete();
        return redirect()->route('admin.language.index')->with('success', 'language deleted successfully');
    }
}
