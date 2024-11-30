<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\AuctiontypeDataTable;
use Auth;
use App\Traits\ImageTrait;
use Illuminate\Support\Str;
use App\Models\Auctiontype;



class AuctiontypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AuctiontypeDataTable $dataTable)
    {
        return $dataTable->render('admin.auctiontype.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.auctiontype.create');
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
        $blog = Auctiontype::create($data);

        return redirect()->route('admin.auctiontypes.index')->with('success', 'Auctiontype created successfully!');
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
    public function edit(Auctiontype $auctiontype)
    {
        return view('admin.auctiontype.edit', compact('auctiontype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,Auctiontype $auctiontype)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|boolean', 
        ]);

        // Generate the slug
        $data['slug'] = $this->getUniqueSlug($data['name']);
        $auctiontype->update($data);
        
        return redirect()->route('admin.auctiontypes.index')->with('success', 'Auctiontype updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Auctiontype $auctiontype)
    {
        $auctiontype->delete();
        return redirect()->route('admin.auctiontypes.index')->with('success', 'Auctiontype deleted successfully');
    }

    protected function getUniqueSlug($name)
    {
        $slug = Str::slug($name); // Generate the slug

        // Check if the slug is already taken
        $count = Auctiontype::where('slug', $slug)->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        return $slug;
    }
}
