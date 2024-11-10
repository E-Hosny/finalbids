<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\NewsDataTable;
use App\Models\News;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(NewsDataTable $dataTable)
    {
        return $dataTable->render('admin.news.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
 
    public function destroy(Request $request, $id)
    {
        $user = News::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'Enquiry deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'Enquiry not  found'], 404);
        }
    }

  
}
