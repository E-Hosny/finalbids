<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\DataTables\BlogDataTable;
use App\Models\Blog;
use App\Models\User;
use Auth;
use App\Traits\ImageTrait;

class BlogController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(BlogDataTable $dataTable)
    {
        return $dataTable->render('admin.blogs.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $admins = User::whereRole(1)->get();
        return view('admin.blogs.create', get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Example image validation
            'status' => 'required|boolean', // Example status validation
        ]);
        // Generate the slug
        $data['slug'] = $this->getUniqueSlug($data['title']);
        // Upload the image
        if($request->hasFile('image')){
            $data['image'] = $this->verifyAndUpload($request, 'image', null, 'blogs');
        }
        $data['author'] = Auth::id();
        $blog = Blog::create($data);

        return redirect()->route('admin.blogs.index')->with('success', 'Blog created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        return view('admin.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $admins = User::whereRole(1)->get();
        return view('admin.blogs.edit', compact(['blog', 'admins']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Example image validation
            'status' => 'required|boolean', // Example status validation
        ]);

        // Generate the slug
        $data['slug'] = $this->getUniqueSlug($data['title']);

        // Upload the image
        if($request->hasFile('image')){
            $data['image'] = $this->verifyAndUpload($request, 'image', null, 'blogs');
        }

        $blog->update($data);
        
        return redirect()->route('admin.blogs.index')->with('success', 'Blog updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        return redirect()->route('admin.blogs.index')->with('success', 'Blog deleted successfully');
    }

    protected function getUniqueSlug($title)
    {
        $slug = Str::slug($title); // Generate the slug

        // Check if the slug is already taken
        $count = Blog::where('slug', $slug)->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1); // Append a number to make it unique
        }

        return $slug;
    }
}