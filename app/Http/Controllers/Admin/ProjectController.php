<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\ProjectDataTable;

use Auth;
use App\Traits\ImageTrait;
use App\Models\Project;
use App\Models\Product;
use App\Models\Category;
use App\Models\Auctiontype;
use Illuminate\Support\Str;
use GoogleTranslate;
use App\Models\Language;





class ProjectController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(ProjectDataTable $dataTable)
    {
        return $dataTable->with('auctiontype')->render('admin.projects.index');
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $auctiontype = Auctiontype::where('status', 1)->get();
        // $categories = Category::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();

        return view('admin.projects.create',compact('auctiontype','categories'));
    }

    /**
     * Store a newly created resource in storage.
     */


    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar'      =>'required|string|max:255',
            'image_path' => 'required|image|mimes:jpeg,png,jpg|max:2048', 
            'status' => 'required|boolean',
            'start_date_time' =>'required|date_format:Y-m-d H:i|after_or_equal:now', 
            'is_trending'    => 'boolean',
            'auction_type_id' => 'required',
            'buyers_premium'  =>'required',
            'category_id'     => 'required',
            'deposit_amount' =>'',
            'end_date_time'   => 'required|date_format:Y-m-d H:i|after:start_date_time',
            
        ]);
        $lastLot = Project::orderBy('id', 'desc')->first();
        $lastLotNumber = $lastLot ? intval(substr($lastLot->type, 2)) : 0;
        $identifier = sprintf('%04d', $lastLotNumber + 1);
        $lotNumber = 'P-' . $identifier;
      
        if (strtotime($data['end_date_time']) <= strtotime($data['start_date_time'])) {
            return redirect()->back()->withErrors(['end_date_time' => 'End date and time must be greater than start date and time.'])->withInput();
        }
        $data['type'] = $lotNumber;

        if (!array_key_exists('is_trending', $data)) {
            $data['is_trending'] = false; 
        }
        $data['slug'] = $this->getUniqueSlug($data['name']);

        if($request->hasFile('image_path')){
            $data['image_path'] = $this->verifyAndUpload($request, 'image_path', null, 'projects');
        }

            $pro = Project::create($data);

    
        
        return redirect()->route('admin.projects.index')->with('success', 'Project Created Successfully!');
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
    public function edit(Project $project)
    {
        $auctiontype = Auctiontype::where('status', 1)->get();
        $categories = Category::where('status', 1)->get();
        return view('admin.projects.edit',compact('auctiontype','project','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'name_ar'      =>'required|string|max:255',
            'image_path' => '', 
            'status' => 'required|boolean',
            'start_date_time' =>'required',
            'end_date_time'   => [
                'required',
                'date_format:Y-m-d H:i',
                function ($attribute, $value, $fail) use ($request) {
                    if (strtotime($value) <= strtotime($request->start_date_time)) {
                        $fail('End date and time must be greater than start date and time.');
                    }
                },
            ],
            'is_trending'    => 'boolean',
            'auction_type_id' => 'required',
            'buyers_premium'   => 'required',
            'category_id'      =>'required',
            'deposit_amount' =>'',
        ]);

        // Generate the slug
        // $data['slug'] = $this->getUniqueSlug($data['name']);
       
        // Upload the image
        if($request->hasFile('image_path')){
            $data['image_path'] = $this->verifyAndUpload($request, 'image_path', null, 'projects');
        }
        $data['is_trending']= $request->get('is_trending',0) ? 1 : 0;

        $project->update($data);
        
        return redirect()->route('admin.projects.index')->with('success', 'Project Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $pro = Product::where('project_id', $project->id)->get();
        $projects =Project::where('type',$project->type)->get();

        foreach ($pro as $product) {
            $product->delete();
        }
        foreach ($projects as $proj) {
            $proj->delete();
        }
        return redirect()->route('admin.projects.index')->with('success', 'Project deleted successfully');
    }

    protected function getUniqueSlug($name)
    {
        $slug = Str::slug($name); 
        // Check if the slug is already taken
        $count = Project::where('slug', $slug)->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1); // Append a number to make it unique
        }

        return $slug;
    }
}
