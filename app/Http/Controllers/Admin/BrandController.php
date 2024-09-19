<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use App\Traits\ImageTrait;
use Illuminate\Support\Str;
use App\DataTables\BrandDataTable;
use App\Models\Brand;



class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(BrandDataTable $dataTable)
    {
        return $dataTable->render('admin.brands.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.brands.create');
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
        ]);
        // Generate the slug
        $data['slug'] = $this->getUniqueSlug($data['name']);
        $blog = Brand::create($data);

        return redirect()->route('admin.brands.index')->with('success', 'Brand created successfully!');
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
    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|boolean', 
        ]);

        // Generate the slug
        $data['slug'] = $this->getUniqueSlug($data['name']);
        $brand->update($data);
        
        return redirect()->route('admin.brands.index')->with('success', 'Brand updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Brand deleted successfully');
    }


    protected function getUniqueSlug($name)
    {
        $slug = Str::slug($name); 

        // Check if the slug is already taken
        $count = Brand::where('slug', $slug)->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1); 
        }

        return $slug;
    }
}
