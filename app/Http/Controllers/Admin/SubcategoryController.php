<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Category;
use App\DataTables\SubcategoryDataTable;
use Auth;
use App\Traits\ImageTrait;
use Illuminate\Support\Str;



class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SubcategoryDataTable $dataTable)
    {
        return $dataTable->render('admin.subcategories.index');
    }
   
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category=Category::where('status',1)->get();
        return view('admin.subcategories.create',compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|boolean',
            'category_id' =>'required',
        ]);
        // Generate the slug
        $data['slug'] = $this->getUniqueSlug($data['name']);
        $blog = Subcategory::create($data);

        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory created successfully!');
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
    public function edit(Subcategory $subcategory)
    {
        $category=Category::where('status',1)->get();
        return view('admin.subcategories.edit', compact('subcategory','category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|boolean', 
            'category_id' =>'required',
        ]);

        // Generate the slug
        $data['slug'] = $this->getUniqueSlug($data['name']);
        $subcategory->update($data);
        
        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('admin.subcategories.index')->with('success', 'Subcategory deleted successfully');
    }

    protected function getUniqueSlug($name)
    {
        $slug = Str::slug($name); // Generate the slug

        // Check if the slug is already taken
        $count = Subcategory::where('slug', $slug)->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        return $slug;
    }
}
