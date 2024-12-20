<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ProductDataTable;
use App\Http\Controllers\Controller;
use App\Models\Auctiontype;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Product;
use App\Models\Project;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\ImageTrait;
use Auth;
use Illuminate\Validation\Rules;
use GoogleTranslate;
use App\Models\Language;
use Illuminate\Support\Facades\Validator;
use Imagecow\Libs\ImageCompressor;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Facades\Image;


use Illuminate\Support\Facades\Mail;
use App\Models\BidPlaced;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;






class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ProductDataTable $dataTable)
    {
        return $dataTable->render('admin.products.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::where('status', 1)->get();
        $projectCategoryIds = $projects->pluck('category_id')->toArray();
        $auctiontype = Auctiontype::where('status', 1)->get();
        // $categories = Category::whereIn('id', $projectCategoryIds)->get();
        return view('admin.products.create', compact( 'auctiontype','projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'title_ar' => 'required|string|max:255',
    //         'auction_type_id' => 'required',
    //         'auction_end_date' => [
    //             '',
              
    //             function ($attribute, $value, $fail) use ($request) {
    //                 $auctionTypeId = $request->input('auction_type_id');
    //                 if ($auctionTypeId == 2) {
    //                     return; 
    //                 }
    //                 $projectId = $request->input('project_id');
    
    //                 $project = Project::find($projectId);
    
    //                 if (!$project) {
    //                     $fail('Invalid project selected.');
    //                     return;
    //                 }
    
    //                 $startDate = $project->start_date_time;
    //                 $endDate = $project->end_date_time;
    
    //                 if ($value < $startDate) {
    //                     $fail("The $attribute must not be less than the project start date and time ($startDate).");
    //                 } elseif ($value > $endDate) {
    //                     $fail("The $attribute must not be greater than the project end date and time ($endDate).");
    //                 }
    //             },
    //         ],
    //         'project_id'    => 'required',
    //         'reserved_price' => 'required',
    //         'description' => 'required',
    //         'description_ar' => 'required',
    //         'is_popular' => 'boolean',
    //         'image_path.*' => 'required|image|mimes:jpeg,png,jpg',
    //         'end_price' =>'required',
    //         'start_price' => 'required',
    //         'minsellingprice' => '',
    //         'status' => 'required|in:new,open,suspended,closed',
    //          'is_published' => 'boolean',
    //     ]);
    //       // Check if any files are present
    //       if (!$request->hasFile('image_path')) {
    //         $request->validate([
    //             'image_path.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    //         ]);
    //     }
      
      
    // $lastLot = Product::orderBy('id', 'desc')->first();
    // $lastLotNumber = $lastLot ? intval(substr($lastLot->lot_no, 4)) : 0;
    // $identifier = sprintf('%03d', $lastLotNumber + 1);
    // $lotNumber = 'Lot-' . $identifier;
    // $data['lot_no'] = $lotNumber;

    // // تحقق من أن قيمة lot_no تم تعيينها بشكل صحيح
    // if (empty($data['lot_no'])) {
    //     return redirect()->back()->withErrors(['error' => 'Failed to generate a valid lot number. Please try again.'])->withInput();
    // }
        
    //     $data['slug'] = $this->getUniqueSlug($data['title']);
       
    //    if ($request->has('start_price')) {
    //     $data['start_price'] = $request->input('start_price');
    //     } else {
    //         $data['start_price'] = null; 
    //     }
    //     if ($request->has('is_popular')) {
    //         $data['is_popular'] = $request->input('is_popular');
    //     } else {
    //         $data['is_popular'] = false; 
    //     }
      
    //     $data['is_published'] = $request->input('is_published', 0); // القيمة الافتراضية

    //      // Check if any files are present
    //         if (!$request->hasFile('image_path')) {
    //             $validator = Validator::make([], []);
    //             $validator->errors()->add('image_path.0', 'At least one image is required.');
    //             return redirect()->back()->withErrors($validator)->withInput();
    //         }

    //     $pro = Product::create($data);

       
    //     if ($request->hasFile('image_path')) {
    //         foreach ($request->file('image_path') as $file) {
    //             $filename = date('YmdHi') . "-" . uniqid() . "." . $file->extension();
    //             $filePath = $file->move(public_path('product/gallery'), $filename);
    //             $url = asset('product/gallery/' . $filename);
    
    //             Gallery::create([
    //                 'product_id' => $pro->id,
    //                 'image_path' => $url,
    //                 'lot_no'     => $pro->lot_no,
    //             ]);
    //         }
    //     }
        
    
    //     return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    // }
    // public function store(Request $request)
    // {
    //     // التحقق من صحة البيانات المدخلة
    //     $data = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'title_ar' => 'required|string|max:255',
    //         'auction_type_id' => 'required',
    //         'auction_end_date' => [
    //             'required',
    //             function ($attribute, $value, $fail) use ($request) {
    //                 $auctionTypeId = $request->input('auction_type_id');
    //                 if ($auctionTypeId == 2) {
    //                     return; // تجاوز التحقق إذا كان نوع المزاد خاصًا.
    //                 }
    //                 $projectId = $request->input('project_id');
    //                 $project = Project::find($projectId);
    
    //                 if (!$project) {
    //                     $fail('Invalid project selected.');
    //                     return;
    //                 }
    
    //                 $startDate = $project->start_date_time;
    //                 $endDate = $project->end_date_time;
    
    //                 if ($value < $startDate) {
    //                     $fail("The $attribute must not be less than the project start date and time ($startDate).");
    //                 } elseif ($value > $endDate) {
    //                     $fail("The $attribute must not be greater than the project end date and time ($endDate).");
    //                 }
    //             },
    //         ],
    //         'project_id' => 'required',
    //         'reserved_price' => 'required',
    //         'description' => 'required',
    //         'description_ar' => 'required',
    //         'is_popular' => 'boolean',
    //         'image_path.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //         'end_price' => 'required',
    //         'start_price' => 'required',
    //         'minsellingprice' => 'nullable',
    //         'status' => 'required|in:new,open,suspended,closed',
    //         'is_published' => 'boolean',
    //     ]);
    
    //     // **توليد قيمة lot_no بشكل إجباري**
    //     $lastLot = Product::orderBy('id', 'desc')->first();
    //     $lastLotNumber = $lastLot ? intval(substr($lastLot->lot_no, 4)) : 0;
    //     $identifier = sprintf('%03d', $lastLotNumber + 1);
    //     $data['lot_no'] = 'Lot-' . $identifier;
    
    //     // **إنشاء slug فريد**
    //     $data['slug'] = $this->getUniqueSlug($data['title']);
    
    //     // تعيين القيم الافتراضية
    //     $data['is_popular'] = $request->input('is_popular', false);
    //     $data['is_published'] = $request->input('is_published', false);
    
    //     // التحقق من وجود الصور
    //     if (!$request->hasFile('image_path')) {
    //         return redirect()->back()->withErrors(['image_path' => 'At least one image is required.'])->withInput();
    //     }
    
    //     // **إنشاء المنتج**
    //     try {
    //         $product = Product::create($data);
    
    //         // رفع الصور وحفظها
    //         foreach ($request->file('image_path') as $file) {
    //             $filename = date('YmdHi') . "-" . uniqid() . "." . $file->extension();
    //             $filePath = $file->move(public_path('product/gallery'), $filename);
    //             $url = asset('product/gallery/' . $filename);
    
    //             Gallery::create([
    //                 'product_id' => $product->id,
    //                 'image_path' => $url,
    //                 'lot_no' => $product->lot_no,
    //             ]);
    //         }
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withErrors(['error' => 'Failed to save product. ' . $e->getMessage()])->withInput();
    //     }
    
    //     // **إعادة التوجيه مع رسالة نجاح**
    //     return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    // }
    public function store(Request $request)
{
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'title_ar' => 'required|string|max:255',
        'auction_type_id' => 'required',
        'auction_end_date' => [
            'required',
            function ($attribute, $value, $fail) use ($request) {
                $auctionTypeId = $request->input('auction_type_id');
                if ($auctionTypeId == 2) {
                    return; 
                }
                $projectId = $request->input('project_id');
                $project = Project::find($projectId);

                if (!$project) {
                    $fail('Invalid project selected.');
                    return;
                }

                $startDate = $project->start_date_time;
                $endDate = $project->end_date_time;

                if ($value < $startDate) {
                    $fail("The $attribute must not be less than the project start date and time ($startDate).");
                } elseif ($value > $endDate) {
                    $fail("The $attribute must not be greater than the project end date and time ($endDate).");
                }
            },
        ],
        'project_id' => 'required',
        'reserved_price' => 'required',
        'description' => 'required',
        'description_ar' => 'required',
        'is_popular' => 'boolean',
        'image_path.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'end_price' => 'required',
        'start_price' => 'required',
        'minsellingprice' => 'nullable',
        'status' => 'required|in:new,open,suspended,closed',
        'is_published' => 'boolean',
    ]);

    // **توليد lot_no**
    $lastLot = Product::orderBy('id', 'desc')->first();
    $lastLotNumber = $lastLot ? intval(substr($lastLot->lot_no, 4)) : 0;
    $identifier = sprintf('%03d', $lastLotNumber + 1);
    $data['lot_no'] = 'Lot-' . $identifier;

    // **إضافة user_id**
    $data['user_id'] = Auth::id();

    // **إنشاء slug**
    $data['slug'] = $this->getUniqueSlug($data['title']);

    // إنشاء المنتج
    try {
        $product = Product::create($data);

        // التعامل مع الصور
        if ($request->hasFile('image_path')) {
            foreach ($request->file('image_path') as $file) {
                $filename = date('YmdHi') . "-" . uniqid() . "." . $file->extension();
                $filePath = $file->move(public_path('product/gallery'), $filename);
                $url = asset('product/gallery/' . $filename);

                Gallery::create([
                    'product_id' => $product->id,
                    'image_path' => $url,
                    'lot_no' => $product->lot_no,
                ]);
            }
        }
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'Failed to save product. ' . $e->getMessage()])->withInput();
    }

    // إعادة التوجيه مع رسالة نجاح
    return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
}

    
    // public function store(Request $request)
    // {
    //     $data = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'title_ar' => 'required|string|max:255',
    //         'auction_type_id' => 'required',
    //         'auction_end_date' => [
    //             '',
              
    //             function ($attribute, $value, $fail) use ($request) {
    //                 $auctionTypeId = $request->input('auction_type_id');
    //                 if ($auctionTypeId == 2) {
    //                     return; 
    //                 }
    //                 $projectId = $request->input('project_id');
    
    //                 $project = Project::find($projectId);
    
    //                 if (!$project) {
    //                     $fail('Invalid project selected.');
    //                     return;
    //                 }
    
    //                 $startDate = $project->start_date_time;
    //                 $endDate = $project->end_date_time;
    
    //                 if ($value < $startDate) {
    //                     $fail("The $attribute must not be less than the project start date and time ($startDate).");
    //                 } elseif ($value > $endDate) {
    //                     $fail("The $attribute must not be greater than the project end date and time ($endDate).");
    //                 }
    //             },
    //         ],
    //         'project_id'    => 'required',
    //         'reserved_price' => 'required',
    //         'description' => 'required',
    //         'description_ar' => 'required',
    //         'is_popular' => 'boolean',
    //         'image_path.*' => 'required|image|mimes:jpeg,png,jpg',
    //         'end_price' =>'required',
    //         'start_price' => 'required',
    //         'minsellingprice' => '',
    //         'status' => 'required|in:new,open,suspended,closed',
    //         'is_published' => 'boolean', // التحقق من القيم
            
    //     ]);
    //       // Check if any files are present
    //       if (!$request->hasFile('image_path')) {
    //         $request->validate([
    //             'image_path.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    //         ]);
    //     }
      
    //     $lastLot = Product::orderBy('id', 'desc')->first();
    //     $lastLotNumber = $lastLot ? intval(substr($lastLot->lot_no, 4)) : 0; 
    //     $identifier = sprintf('%03d', $lastLotNumber + 1); 
    //     $lotNumber = 'Lot-' . $identifier;
    //     $data['lot_no'] = $lotNumber;

        
    //     $data['slug'] = $this->getUniqueSlug($data['title']);
       
    //    if ($request->has('start_price')) {
    //     $data['start_price'] = $request->input('start_price');
    //     } else {
    //         $data['start_price'] = null; 
    //     }
    //     if ($request->has('is_popular')) {
    //         $data['is_popular'] = $request->input('is_popular');
    //     } else {
    //         $data['is_popular'] = false; 
    //     }

    //     $data['is_published'] = $request->input('is_published', 0); // القيمة الافتراضية

      
    //      // Check if any files are present
    //         if (!$request->hasFile('image_path')) {
    //             $validator = Validator::make([], []);
    //             $validator->errors()->add('image_path.0', 'At least one image is required.');
    //             return redirect()->back()->withErrors($validator)->withInput();
    //         }

    //     $pro = Product::create($data);

    //     // if ($request->hasFile('image_path')) {
    //     //     foreach ($request->file('image_path') as $file) {
    //     //         $filename = date('YmdHi') . "-" . uniqid() . "." . $file->extension();
    //     //         $filePath = public_path('product/gallery') . '/' . $filename;

    //     //         // Resize the image
    //     //         list($width, $height) = getimagesize($file);
    //     //         $newWidth = 728;
    //     //         $newHeight = 521;
    //     //         $imageResized = imagecreatetruecolor($newWidth, $newHeight);
    //     //         $imageTmp = imagecreatefromjpeg($file);
    //     //         imagecopyresampled($imageResized, $imageTmp, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    //     //         imagejpeg($imageResized, $filePath);

    //     //         // Save image path to the database
    //     //         $url = asset('product/gallery/' . $filename);
    //     //         Gallery::create([
    //     //             'product_id' => $pro->id,
    //     //             'image_path' => $url,
    //     //             'lot_no'     => $pro->lot_no,
    //     //         ]);
    //     //     }
    //     // }
    //     if ($request->hasFile('image_path')) {
    //         foreach ($request->file('image_path') as $file) {
    //             $filename = date('YmdHi') . "-" . uniqid() . "." . $file->extension();
    //             $filePath = $file->move(public_path('product/gallery'), $filename);
    //             $url = asset('product/gallery/' . $filename);
    
    //             Gallery::create([
    //                 'product_id' => $pro->id,
    //                 'image_path' => $url,
    //                 'lot_no'     => $pro->lot_no,
    //             ]);
    //         }
    //     }
        
    
    //     return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    // }
       
//     public function store(Request $request)
// {
//     // التحقق من صحة البيانات المدخلة
//     $data = $request->validate([
//         'title' => 'required|string|max:255',
//         'title_ar' => 'required|string|max:255',
//         'auction_type_id' => 'required',
//         'auction_end_date' => [
//             'required',
//             function ($attribute, $value, $fail) use ($request) {
//                 $auctionTypeId = $request->input('auction_type_id');
//                 if ($auctionTypeId == 2) {
//                     return; // تجاوز التحقق إذا كان نوع المزاد خاصًا.
//                 }
//                 $projectId = $request->input('project_id');
//                 $project = Project::find($projectId);

//                 if (!$project) {
//                     $fail('Invalid project selected.');
//                     return;
//                 }

//                 $startDate = $project->start_date_time;
//                 $endDate = $project->end_date_time;

//                 if ($value < $startDate) {
//                     $fail("The $attribute must not be less than the project start date and time ($startDate).");
//                 } elseif ($value > $endDate) {
//                     $fail("The $attribute must not be greater than the project end date and time ($endDate).");
//                 }
//             },
//         ],
//         'project_id' => 'required',
//         'reserved_price' => 'required',
//         'description' => 'required',
//         'description_ar' => 'required',
//         'is_popular' => 'boolean',
//         'image_path.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
//         'end_price' => 'required',
//         'start_price' => 'required',
//         'minsellingprice' => 'nullable',
//         'status' => 'required|in:new,open,suspended,closed',
//         'is_published' => 'boolean',
//     ]);

//     // توليد قيمة lot_no
//     $lastLot = Product::orderBy('id', 'desc')->first();
//     $lastLotNumber = $lastLot ? intval(substr($lastLot->lot_no, 4)) : 0;
//     $identifier = sprintf('%03d', $lastLotNumber + 1);
//     $lotNumber = 'Lot-' . $identifier;
//     $data['lot_no'] = $lotNumber;

//     // تحقق من أن قيمة lot_no تم تعيينها بشكل صحيح
//     if (empty($data['lot_no'])) {
//         return redirect()->back()->withErrors(['error' => 'Failed to generate a valid lot number. Please try again.'])->withInput();
//     }

//     // توليد slug فريد
//     $data['slug'] = $this->getUniqueSlug($data['title']);

//     // تحديد القيم الافتراضية
//     $data['is_popular'] = $request->input('is_popular', false);
//     $data['is_published'] = $request->input('is_published', false);

//     // إنشاء المنتج
//     try {
//         $pro = Product::create($data);

//         // التعامل مع الصور
//         if ($request->hasFile('image_path')) {
//             foreach ($request->file('image_path') as $file) {
//                 $filename = date('YmdHi') . "-" . uniqid() . "." . $file->extension();
//                 $filePath = $file->move(public_path('product/gallery'), $filename);
//                 $url = asset('product/gallery/' . $filename);

//                 // حفظ الصورة في جدول المعرض
//                 Gallery::create([
//                     'product_id' => $pro->id,
//                     'image_path' => $url,
//                     'lot_no' => $pro->lot_no,
//                 ]);
//             }
//         }

//         return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
//     } catch (\Exception $e) {
//         return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
//     }
// }


    // public function store(Request $request)
    // {
    //     // تحقق البيانات المدخلة
    //     $data = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'title_ar' => 'required|string|max:255',
    //         'auction_type_id' => 'required|integer',
    //         'auction_end_date' => [
    //             'required',
    //             function ($attribute, $value, $fail) use ($request) {
    //                 $auctionTypeId = $request->input('auction_type_id');
    //                 if ($auctionTypeId == 2) {
    //                     return; // لا تحقق إذا كان نوع المزاد معينًا.
    //                 }
    //                 $projectId = $request->input('project_id');
    //                 $project = Project::find($projectId);
    
    //                 if (!$project) {
    //                     $fail('Invalid project selected.');
    //                     return;
    //                 }
    
    //                 $startDate = $project->start_date_time;
    //                 $endDate = $project->end_date_time;
    
    //                 if ($value < $startDate) {
    //                     $fail("The $attribute must not be less than the project start date and time ($startDate).");
    //                 } elseif ($value > $endDate) {
    //                     $fail("The $attribute must not be greater than the project end date and time ($endDate).");
    //                 }
    //             },
    //         ],
    //         'project_id' => 'required|integer',
    //         'reserved_price' => 'required|numeric',
    //         'description' => 'required|string',
    //         'description_ar' => 'required|string',
    //         'is_popular' => 'boolean',
    //         'image_path.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //         'end_price' => 'required|numeric',
    //         'start_price' => 'required|numeric',
    //         'minsellingprice' => 'nullable|numeric',
    //         'status' => 'required|in:new,open,suspended,closed',
    //         'is_published' => 'boolean',
    //     ]);
    
    //     // إعداد الحقول الإضافية
    //     $data['is_published'] = $request->has('is_published') ? 1 : 0;
    
    //     // حساب قيمة lot_no
    //     $lastLot = Product::orderBy('id', 'desc')->first();
    //     $lastLotNumber = $lastLot ? intval(substr($lastLot->lot_no, 4)) : 0;
    //     $identifier = sprintf('%03d', $lastLotNumber + 1);
    //     $lotNumber = 'Lot-' . $identifier;
    //     $data['lot_no'] = $lotNumber;
    
    //     // إنشاء slug فريد
    //     $data['slug'] = $this->getUniqueSlug($data['title']);
    
    //     // إعداد قيمة is_popular
    //     $data['is_popular'] = $request->get('is_popular', 0) ? 1 : 0;
    
    //     try {
    //         // إنشاء المنتج
    //         $pro = Product::create($data);
    
    //         // التعامل مع الصور
    //         if ($request->hasFile('image_path')) {
    //             foreach ($request->file('image_path') as $file) {
    //                 $filename = date('YmdHi') . "-" . uniqid() . "." . $file->extension();
    //                 $filePath = $file->move(public_path('product/gallery'), $filename);
    //                 $url = asset('product/gallery/' . $filename);
    
    //                 // إنشاء السجل في جدول Gallery
    //                 Gallery::create([
    //                     'product_id' => $pro->id,
    //                     'image_path' => $url,
    //                     'lot_no' => $pro->lot_no,
    //                 ]);
    //             }
    //         }
    
    //         return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    //     } catch (\Exception $e) {
    //         return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
    //     }
    // }
        

    /**
     * Display the specified resource.
     */
    // 
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
       
        $projects = Project::where('status', 1)->get();
        $projectCategoryIds = $projects->pluck('category_id')->toArray();
        $auctiontype = Auctiontype::where('status', 1)->get();
        $galleryImages = Gallery::where('product_id', $product->id)->get();

        return view('admin.products.edit', compact('projects', 'projectCategoryIds', 'auctiontype','product', 'galleryImages'));
    }

    // public function update(Request $request, Product $product)
    // {
    //     $data = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'title_ar' => 'required|string|max:255',
    //         'auction_type_id' => 'required',
    //         'auction_end_date' => [
    //             '',
               
    //             function ($attribute, $value, $fail) use ($request) {
    //                 $auctionTypeId = $request->input('auction_type_id');
    //                 if ($auctionTypeId == 2) {
    //                     return; 
    //                 }
    //                 $projectId = $request->input('project_id');
    
    //                 $project = Project::find($projectId);
    
    //                 if (!$project) {
    //                     $fail('Invalid project selected.');
    //                     return;
    //                 }
    
    //                 $startDate = $project->start_date_time;
    //                 $endDate = $project->end_date_time;
    
    //                 if ($value < $startDate) {
    //                     $fail("The $attribute must not be less than the project start date and time ($startDate).");
    //                 } elseif ($value > $endDate) {
    //                     $fail("The $attribute must not be greater than the project end date and time ($endDate).");
    //                 }
    //             },
    //         ],
    //         'project_id'    => 'required',
    //         'reserved_price' => 'required',
    //         'description' => 'required',
    //         'description_ar' => 'required',
    //         'is_popular' => 'boolean',
    //         'end_price' =>'required',
    //         'start_price' => 'required',
    //         'minsellingprice' => '',
    //         'status' => 'required|in:new,open,suspended,closed', // التحقق من الحالة
    //         'is_published' => 'boolean',

    //     ]);
    //          // Check if any files are present
    //          if (!$request->hasFile('image_path')) {
    //             $request->validate([
    //                 'image_path.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    //             ]);
    //         }

       
    //     $data['is_popular']= $request->get('is_popular',0) ? 1 : 0;

    //     $product->update($data);
    //     if ($request->hasFile('image_path')) {
    //         foreach ($request->file('image_path') as $file) {
    //             $filename = date('YmdHi') . "-" . uniqid() . "." . $file->extension();
    //             $filePath = $file->move(public_path('product/gallery'), $filename);
    //             $url = asset('product/gallery/' . $filename);
    
    //             Gallery::create([
    //                 'product_id' => $product->id,
    //                 'image_path' => $url,
    //                 'lot_no'     => $product->lot_no,
    //             ]);
    //         }
    //     }
        
    //     return redirect()->route('admin.products.index')->with('success', 'Product Updated Successfully!');
    // }
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'auction_type_id' => 'required',
            'auction_end_date' => [
                '',
                function ($attribute, $value, $fail) use ($request) {
                    $auctionTypeId = $request->input('auction_type_id');
                    if ($auctionTypeId == 2) {
                        return;
                    }
                    $projectId = $request->input('project_id');
    
                    $project = Project::find($projectId);
    
                    if (!$project) {
                        $fail('Invalid project selected.');
                        return;
                    }
    
                    $startDate = $project->start_date_time;
                    $endDate = $project->end_date_time;
    
                    if ($value < $startDate) {
                        $fail("The $attribute must not be less than the project start date and time ($startDate).");
                    } elseif ($value > $endDate) {
                        $fail("The $attribute must not be greater than the project end date and time ($endDate).");
                    }
                },
            ],
            'project_id' => 'required',
            'reserved_price' => 'required',
            'description' => 'required',
            'description_ar' => 'required',
            'is_popular' => 'boolean',
            'end_price' => 'required',
            'start_price' => 'required',
            'minsellingprice' => 'nullable',
            'status' => 'required|in:new,open,suspended,closed',
            'is_published' => 'boolean', // التحقق من القيم
            'image_path.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
    
        // تعيين القيم الافتراضية
        $data['is_popular'] = $request->get('is_popular', 0) ? 1 : 0;
        $data['is_published'] = $request->input('is_published', 0); // القيمة الافتراضية
    
        // تحديث المنتج
        $product->update($data);
    
        // إذا تم تحميل صور جديدة
        if ($request->hasFile('image_path')) {
            foreach ($request->file('image_path') as $file) {
                $filename = date('YmdHi') . "-" . uniqid() . "." . $file->extension();
                $filePath = $file->move(public_path('product/gallery'), $filename);
                $url = asset('product/gallery/' . $filename);
    
                Gallery::create([
                    'product_id' => $product->id,
                    'image_path' => $url,
                    'lot_no' => $product->lot_no,
                ]);
            }
        }
    
        return redirect()->route('admin.products.index')->with('success', 'Product Updated Successfully!');
    }
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    public function getcategories(Request $request, $auction)
    {
        $subcategories = Category::where('auction_type_id', $auction)->where('lang_id','en')->get();
        return response()->json($subcategories);
    }

    public function getprojects(Request $request, $project)
    {
        $currentDateTime = now();
        $projects = Project::where('auction_type_id', $project)->where('end_date_time', '>=', $currentDateTime)->get();
        return response()->json($projects);
    }



    protected function getUniqueSlug($title)
    {
        $slug = Str::slug($title);

        // Check if the slug is already taken
        $count = Product::where('slug', $slug)->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        return $slug;
    }


    public function deleteImage($id)
    {
        $image = Gallery::where('id',$id)->first();    
        if ($image) {            
            $image->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false, 'message' => 'Image not found.'], 404);
    }
    public function closeAuction(Request $request)
    {
        $product = Product::find($request->product_id);
    
        if (!$product || $product->is_closed) {
            return response()->json(['success' => false, 'message' => 'Auction not found or already closed.']);
        }
    
        $product->is_closed = true;
        $product->save();
    
        $highestBid = BidPlaced::where('product_id', $product->id)
            ->orderBy('bid_amount', 'desc')
            ->first();
    
        if ($highestBid) {
            $this->notifyWinner($highestBid);
            $highestBid->mail_sent = 1;
            $highestBid->save();
        }
    
        return response()->json(['success' => true, 'message' => 'Auction closed and winner notified.']);
    }
    

    private function sendNotifications($highestBid)
    {
        $this->sendSMS($highestBid->user->phone, 'تهانينا! لقد فزت بمزاد المنتج.');
        Mail::send('emails.auction-won', ['bid' => $highestBid], function ($message) use ($highestBid) {
            $message->from('sales@bid.sa', 'Bid Auctions');
            $message->to($highestBid->user->email);
            $message->subject('تهانينا! لقد فزت بمزاد المنتج.');
        });
    }

    private function sendSMS($phone, $message)
    {
        $client = new Client();
        $url = 'https://api.taqnyat.sa/v1/messages';

        $response = $client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer c933affa6c2314484d105c45a0e1adc7',
            ],
            'json' => [
                // 'recipients' => [$phone],
                'recipients' => '966' . ltrim($phone, '0'),
                'body' => $message,
                'sender' => 'MazadBid',
            ],
        ]);

        return $response->getStatusCode() == 200;
    }
}
