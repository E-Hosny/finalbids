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
use App\Models\User;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Traits\ImageTrait;
use Auth;
use Illuminate\Validation\Rules;
use GoogleTranslate;
use App\Models\Language;
use App\Models\BidPlaced;
use Illuminate\Support\Facades\Validator;
use Imagecow\Libs\ImageCompressor;
use Spatie\ImageOptimizer\OptimizerChainFactory;
use Illuminate\Support\Facades\Image;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductApproved;
use App\Mail\ProductRejected;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

use App\Mail\AuctionWinnerAdminMail;
use App\Mail\AuctionWinnerUserMail;
use GuzzleHttp\Client;
use Carbon\Carbon;






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
     * الموافقة على المنتج.
     */
    // public function approve(Product $product)
    // {
    //     $product->approval_status = 'approved';
    //     $product->rejection_reason = null;
    //     $product->save();

    //     // إرسال بريد إلكتروني للعميل
    //     Mail::to($product->user->email)->send(new ProductApproved($product));

    //     return response()->json(['message' => 'Product approved successfully.']);
    // }
    public function approve(Product $product)
{
    try {
        $product->approval_status = 'approved';
        $product->rejection_reason = null;
        $product->save();

        Log::info('Product approved successfully.', ['product_id' => $product->id]);

        // إرسال البريد الإلكتروني باستخدام الطوابير
        Mail::to($product->user->email)->queue(new ProductApproved($product));

        return response()->json(['message' => 'Product approved successfully.']);
    } catch (\Exception $e) {
        Log::error('Error approving product.', [
            'product_id' => $product->id,
            'error' => $e->getMessage(),
        ]);

        // return response()->json(['message' => 'An error occurred while approving the product.'], 500);
        return response()->json([
            'message' => 'Product approved successfully.',
            'updatedProduct' => $product,
        ]);
        
    }
}


    /**
     * رفض المنتج مع سبب الرفض.
     */
    // public function reject(Request $request, Product $product)
    // {
    //     $request->validate([
    //         'rejection_reason' => 'required|string|max:255',
    //     ]);

    //     $product->approval_status = 'rejected';
    //     $product->rejection_reason = $request->input('rejection_reason');
    //     $product->save();

    //     // إرسال بريد إلكتروني للعميل
    //     Mail::to($product->user->email)->send(new ProductRejected($product));

    //     return response()->json(['message' => 'Product rejected successfully.']);
    // }
    // public function reject(Request $request, Product $product)
    // {
    //     $request->validate([
    //         'rejection_reason' => 'required|string|max:255',
    //     ]);
    
    //     try {
    //         // بدء معاملة قاعدة البيانات
    //         \DB::beginTransaction();
    
    //         $product->approval_status = 'rejected';
    //         $product->rejection_reason = $request->input('rejection_reason');
    //         $product->save();
    
    //         // التحقق من وجود مستخدم مرتبط بالمنتج
    //         if ($product->user && $product->user->email) {
    //             // إرسال البريد الإلكتروني باستخدام الطوابير
    //             Mail::to($product->user->email)->queue(new ProductRejected($product));
                
    //         } else {
    //             // تسجيل تحذير في السجلات
    //             Log::warning('Product does not have an associated user or user email is missing.', [
    //                 'product_id' => $product->id,
    //             ]);
    //         }
    
    //         // إنهاء المعاملة
    //         \DB::commit();
    
    //         // تحميل العلاقات اللازمة لعرض المنتج في DataTable
    //         $product->load('user', 'auctiontype', 'project');
    
    //         // إعداد حالة الموافقة بتنسيق HTML
    //         $product->approval_status_badge = '<span class="badge badge-danger">Rejected</span>';
    
    //         return response()->json([
    //             'message' => 'Product rejected successfully.',
    //             'updatedProduct' => $product,
    //         ]);
    //     } catch (\Exception $e) {
    //         // إلغاء المعاملة في حالة حدوث خطأ
    //         \DB::rollBack();
    
    //         Log::error('Error rejecting product.', [
    //             'product_id' => $product->id,
    //             'error' => $e->getMessage(),
    //         ]);
    
    //         return response()->json(['message' => 'An error occurred while rejecting the product.'], 500);
    //     }
    // }
    
    public function reject(Request $request, Product $product)
{
    $request->validate([
        'rejection_reason' => 'required|string|max:255',
    ]);

    try {
        // بدء معاملة قاعدة البيانات
        \DB::beginTransaction();

        $product->approval_status = 'rejected';
        $product->rejection_reason = $request->input('rejection_reason');
        $product->save();

        // التحقق من وجود مستخدم مرتبط بالمنتج
        if ($product->user && $product->user->email) {
            // إرسال البريد الإلكتروني باستخدام الطوابير
            Mail::to($product->user->email)->queue(new ProductRejected($product));
        } else {
            // تسجيل تحذير في السجلات
            Log::warning('Product does not have an associated user or user email is missing.', [
                'product_id' => $product->id,
            ]);
        }

        // إنهاء المعاملة
        \DB::commit();

        // تحميل العلاقات اللازمة لعرض المنتج في DataTable
        $product->load('user', 'auctiontype', 'project');

        // إعداد البيانات المحدثة لإرجاعها إلى الواجهة الأمامية
        $updatedProduct = $product->toArray();
        $updatedProduct['approval_status'] = '<span class="badge badge-danger">Rejected</span>';
        $updatedProduct['action'] = view('admin.products.action', [
            'id' => $product->id,
            'approval_status' => $product->approval_status,
        ])->render();

        return response()->json([
            'message' => 'Product rejected successfully.',
            'updatedProduct' => $updatedProduct,
        ]);
    } catch (\Exception $e) {
        // إلغاء المعاملة في حالة حدوث خطأ
        \DB::rollBack();

        Log::error('Error rejecting product.', [
            'product_id' => $product->id,
            'error' => $e->getMessage(),
        ]);

        return response()->json(['message' => 'An error occurred while rejecting the product.'], 500);
    }
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
    public function store(Request $request)
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
            'project_id'    => 'required',
            'reserved_price' => 'required',
            'description' => 'required',
            'description_ar' => 'required',
            'is_popular' => 'boolean',
            'image_path.*' => 'required|image|mimes:jpeg,png,jpg',
            'end_price' =>'required',
            'start_price' => 'required',
            'minsellingprice' => '',
            'status' => 'required|in:new,open,suspended,closed',
             'is_published' => 'boolean',
             
             
        ]);
          // Check if any files are present
          if (!$request->hasFile('image_path')) {
            $request->validate([
                'image_path.*' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
        }
      
        $lastLot = Product::orderBy('id', 'desc')->first();
        $lastLotNumber = $lastLot ? intval(substr($lastLot->lot_no, 4)) : 0; 
        $identifier = sprintf('%03d', $lastLotNumber + 1); 
        $lotNumber = 'Lot-' . $identifier;
        $data['lot_no'] = $lotNumber;

        
        $data['slug'] = $this->getUniqueSlug($data['title']);
        $data['approval_status'] = 'approved';
       
       if ($request->has('start_price')) {
        $data['start_price'] = $request->input('start_price');
        } else {
            $data['start_price'] = null; 
        }
        if ($request->has('is_popular')) {
            $data['is_popular'] = $request->input('is_popular');
        } else {
            $data['is_popular'] = false; 
        }
      
        $data['is_published'] = $request->input('is_published', 0); // القيمة الافتراضية

         // Check if any files are present
            if (!$request->hasFile('image_path')) {
                $validator = Validator::make([], []);
                $validator->errors()->add('image_path.0', 'At least one image is required.');
                return redirect()->back()->withErrors($validator)->withInput();
            }

        $pro = Product::create($data);

        // if ($request->hasFile('image_path')) {
        //     foreach ($request->file('image_path') as $file) {
        //         $filename = date('YmdHi') . "-" . uniqid() . "." . $file->extension();
        //         $filePath = public_path('product/gallery') . '/' . $filename;

        //         // Resize the image  
        //         list($width, $height) = getimagesize($file);
        //         $newWidth = 728;
        //         $newHeight = 521;
        //         $imageResized = imagecreatetruecolor($newWidth, $newHeight);
        //         $imageTmp = imagecreatefromjpeg($file);
        //         imagecopyresampled($imageResized, $imageTmp, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
        //         imagejpeg($imageResized, $filePath);

        //         // Save image path to the database
        //         $url = asset('product/gallery/' . $filename);
        //         Gallery::create([
        //             'product_id' => $pro->id,
        //             'image_path' => $url,
        //             'lot_no'     => $pro->lot_no,
        //         ]);
        //     }
        // }
        if ($request->hasFile('image_path')) {
            foreach ($request->file('image_path') as $file) {
                $filename = date('YmdHi') . "-" . uniqid() . "." . $file->extension();
                $filePath = $file->move(public_path('product/gallery'), $filename);
                $url = asset('product/gallery/' . $filename);
    
                Gallery::create([
                    'product_id' => $pro->id,
                    'image_path' => $url,
                    'lot_no'     => $pro->lot_no,
                ]);
            }
        }
        
    
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

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
    //         'project_id' => 'required',
    //         'reserved_price' => 'required',
    //         'description' => 'required',
    //         'description_ar' => 'required',
    //         'is_popular' => 'boolean',
    //         'end_price' => 'required',
    //         'start_price' => 'required',
    //         'minsellingprice' => 'nullable',
    //         'status' => 'required|in:new,open,suspended,closed',
    //         'is_published' => 'boolean', // التحقق من القيم
    //         'image_path.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    //     ]);
    
    //     // تعيين القيم الافتراضية
    //     $data['is_popular'] = $request->get('is_popular', 0) ? 1 : 0;
    //     $data['is_published'] = $request->input('is_published', 0); // القيمة الافتراضية

    
    //     // تحديث المنتج
    //     $product->update($data);
    
    //     // إذا تم تحميل صور جديدة
    //     if ($request->hasFile('image_path')) {
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
        'is_published' => 'boolean',
        'image_path.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // تعيين القيم الافتراضية
    $data['is_popular'] = $request->get('is_popular', 0) ? 1 : 0;
    $data['is_published'] = $request->input('is_published', 0);

    // تحديث المنتج
    $product->update($data);

    // تحقق من حالة المنتج الجديدة
    if ($data['status'] === 'closed') {
        $this->handleAuctionClosure($product);
    }

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
 * معالجة إغلاق المنتج.
 */
// private function handleAuctionClosure(Product $product)
// {
//     try {
//         DB::transaction(function () use ($product) {
//             // الحصول على جميع المزايدات المقبولة للمنتج
//             $bids = BidPlaced::where('product_id', $product->id)
//                 ->where('status', 1) // نأخذ فقط المزايدات المقبولة
//                 ->get();

//             if ($bids->isEmpty()) {
//                 return; // لا توجد مزايدات مقبولة
//             }

//             // الحصول على أعلى قيمة مزايدة
//             $highestBidAmount = $bids->max('bid_amount');

//             // تحديد المزايدة الفائزة (أعلى قيمة)
//             $winningBids = $bids->where('bid_amount', $highestBidAmount);

//             // تعيين الفائز
//             foreach ($winningBids as $bid) {
//                 $bid->update(['status' => 3]); // تعيين حالة الفائز
//             }

//             // تعيين باقي المزايدات كخاسرة
//             BidPlaced::where('product_id', $product->id)
//                 ->where('status', 1)
//                 ->where('bid_amount', '<', $highestBidAmount)
//                 ->update(['status' => 4]); // تعيين حالة الخاسر

//         });

//         Log::info('تم معالجة إغلاق المزاد بنجاح', [
//             'product_id' => $product->id
//         ]);

//     } catch (\Exception $e) {
//         Log::error('خطأ في معالجة إغلاق المزاد', [
//             'product_id' => $product->id,
//             'error' => $e->getMessage()
//         ]);
//         throw $e;
//     }
// }

// private function handleAuctionClosure(Product $product)
// {
//     try {
//         DB::transaction(function () use ($product) {
//             // الحصول على المزايدات المقبولة
//             $bids = BidPlaced::where('product_id', $product->id)
//                 ->where('status', 1)
//                 ->get();

//             if ($bids->isEmpty()) {
//                 Log::info('No bids found for product', ['product_id' => $product->id]);
//                 return; // لا توجد مزايدات
//             }

//             // أعلى مزايدة
//             $highestBid = $bids->sortByDesc('bid_amount')->first();
//             $winningUser = $highestBid->user;
//             $winningAmount = $highestBid->bid_amount;

//             // تحديث حالة الفائز
//             $highestBid->update(['status' => 3]);

//             // تحديث باقي المزايدات كخاسرة
//             BidPlaced::where('product_id', $product->id)
//                 ->where('status', 1)
//                 ->where('id', '!=', $highestBid->id)
//                 ->update(['status' => 4]);

//             // تحديث تاريخ المنتج
//             $product->updated_at = now();
//             $product->save();

//             // إعداد رابط الدفع
//             $paymentLink = "https://example-payment-link.com";

//             // إرسال بريد للإدارة
//             try {
//                 $adminEmail = 'elkhouly@gmail.com'; // استبدل بالإيميل الفعلي
//                 Mail::to($adminEmail)->send(new AuctionWinnerAdminMail(
//                     $winningUser->first_name,
//                     $product->title,
//                     $product->image_path ?? 'No Image',
//                     $winningAmount,
//                     $product->auction_end_date,
//                     $winningUser->email
//                 ));
//                 Log::info('Email sent to admin', ['admin_email' => $adminEmail]);
//             } catch (\Exception $e) {
//                 Log::error('Error sending email to admin', [
//                     'product_id' => $product->id,
//                     'error' => $e->getMessage(),
//                 ]);
//             }

//             // إرسال بريد للمستخدم الفائز
//             try {
//                 Mail::to($winningUser->email)->send(new AuctionWinnerUserMail(
//                     $winningUser->first_name,
//                     $product->title,
//                     $product->image_path ?? 'No Image',
//                     $winningAmount,
//                     $product->auction_end_date,
//                     $paymentLink
//                 ));
//                 Log::info('Email sent to user', ['user_email' => $winningUser->email]);
//             } catch (\Exception $e) {
//                 Log::error('Error sending email to user', [
//                     'product_id' => $product->id,
//                     'error' => $e->getMessage(),
//                 ]);
//             }

//             // إرسال رسالة SMS
//             try {
//                 $client = new \GuzzleHttp\Client();
//                 $body = "تهانينا! لقد فزت بمزاد {$product->title}. تحقق من بريدك لمزيد من التفاصيل.";
//                 $response = $client->post('https://api.taqnyat.sa/v1/messages', [
//                     'headers' => [
//                         'Authorization' => 'Bearer c933affa6c2314484d105c45a0e1adc7',
//                         'Content-Type' => 'application/json',
//                     ],
//                     'json' => [
//                         'recipients' => '966' . ltrim($winningUser->phone, '0'),
//                         'body' => $body,
//                         'sender' => "MazadBid",
//                     ],
//                 ]);

//                 if ($response->getStatusCode() == 200) {
//                     Log::info('SMS sent to user', ['phone' => $winningUser->phone]);
//                 } else {
//                     Log::warning('Failed to send SMS', [
//                         'phone' => $winningUser->phone,
//                         'response' => $response->getBody()->getContents(),
//                     ]);
//                 }
//             } catch (\Exception $e) {
//                 Log::error('Error sending SMS to user', [
//                     'product_id' => $product->id,
//                     'error' => $e->getMessage(),
//                 ]);
//             }
//         });
//     } catch (\Exception $e) {
//         Log::error('Error in auction closure', [
//             'product_id' => $product->id,
//             'error' => $e->getMessage(),
//         ]);
//         throw $e;
//     }
// }

// private function handleAuctionClosure(Product $product)
// {
//     $processId = (string) Str::uuid();
    
//     try {
//         DB::transaction(function () use ($product, $processId) {
//             Log::info("[Auction Closure] Starting auction closure process", [
//                 'process_id' => $processId,
//                 'product_id' => $product->id,
//                 'product_title' => $product->title
//             ]);

//             // تحديث حالة المنتج
//             $product->status = 'closed';
//             $product->auction_end_date = now();
//             $product->save();

//             // الحصول على المزايدات المقبولة
//             $bids = BidPlaced::where('product_id', $product->id)
//                 ->where('status', 1)
//                 ->get();

//             if ($bids->isEmpty()) {
//                 Log::info("[Auction Closure] No bids found", [
//                     'process_id' => $processId,
//                     'product_id' => $product->id
//                 ]);
//                 return;
//             }

//             // تحديد أعلى مزايدة
//             $highestBid = $bids->sortByDesc('bid_amount')->first();
//             $winningUser = User::findOrFail($highestBid->user_id); // التأكد من وجود المستخدم
//             $winningAmount = $highestBid->bid_amount;

//             // تحديث حالة المزايدة الفائزة
//             $highestBid->update([
//                 'status' => 3,
//                 'won_at' => now()
//             ]);

//             Log::info("[Auction Closure] Winner determined", [
//                 'process_id' => $processId,
//                 'bid_id' => $highestBid->id,
//                 'user_id' => $winningUser->id,
//                 'amount' => $winningAmount
//             ]);

//             // تحديث المزايدات الخاسرة
//             $losingBidsCount = BidPlaced::where('product_id', $product->id)
//                 ->where('status', 1)
//                 ->where('id', '!=', $highestBid->id)
//                 ->update(['status' => 4]);

//             Log::info("[Auction Closure] Losing bids updated", [
//                 'process_id' => $processId,
//                 'losing_bids_count' => $losingBidsCount
//             ]);

//             // إعداد رابط الدفع
//             $paymentLink = $this->generatePaymentLink($highestBid);

//             // إرسال البريد للإدارة
//             try {
//                 $adminEmail = config('mail.admin_address', 'admin@mazadbid.com');
//                 Mail::to($adminEmail)->queue(new AuctionWinnerAdminMail([
//                     'winner_name' => $winningUser->first_name,
//                     'winner_email' => $winningUser->email,
//                     'winner_phone' => $winningUser->phone,
//                     'product_title' => $product->title,
//                     'product_image' => $product->image_path ?? null,
//                     'winning_amount' => $winningAmount,
//                     'auction_end_date' => $product->auction_end_date
//                 ]));

//                 Log::info("[Email] Admin notification sent", [
//                     'process_id' => $processId,
//                     'admin_email' => $adminEmail
//                 ]);
//             } catch (\Exception $e) {
//                 Log::error("[Email] Failed to send admin notification", [
//                     'process_id' => $processId,
//                     'error' => $e->getMessage(),
//                     'trace' => $e->getTraceAsString()
//                 ]);
//             }

//             // إرسال البريد للمستخدم الفائز
//             try {
//                 Mail::to($winningUser->email)->queue(new AuctionWinnerUserMail([
//                     'name' => $winningUser->first_name,
//                     'product_title' => $product->title,
//                     'product_image' => $product->image_path ?? null,
//                     'winning_amount' => $winningAmount,
//                     'auction_end_date' => $product->auction_end_date,
//                     'payment_link' => $paymentLink
//                 ]));

//                 Log::info("[Email] Winner notification sent", [
//                     'process_id' => $processId,
//                     'winner_email' => $winningUser->email
//                 ]);
//             } catch (\Exception $e) {
//                 Log::error("[Email] Failed to send winner notification", [
//                     'process_id' => $processId,
//                     'error' => $e->getMessage(),
//                     'trace' => $e->getTraceAsString()
//                 ]);
//             }

//             // إرسال SMS
//             try {
//                 if ($winningUser->phone) {
//                     $message = sprintf(
//                         "مبروك! لقد فزت بمزاد %s بمبلغ %s ريال. يرجى مراجعة بريدك الإلكتروني للتفاصيل.",
//                         $product->title,
//                         number_format($winningAmount, 2)
//                     );

//                     $response = $this->sendSMS($winningUser->phone, $message);

//                     Log::info("[SMS] Winner notification sent", [
//                         'process_id' => $processId,
//                         'phone' => $winningUser->phone,
//                         'response' => $response
//                     ]);
//                 }
//             } catch (\Exception $e) {
//                 Log::error("[SMS] Failed to send SMS", [
//                     'process_id' => $processId,
//                     'error' => $e->getMessage(),
//                     'trace' => $e->getTraceAsString()
//                 ]);
//             }

//             Log::info("[Auction Closure] Process completed successfully", [
//                 'process_id' => $processId,
//                 'product_id' => $product->id
//             ]);
//         });
//     } catch (\Exception $e) {
//         Log::error("[Auction Closure] Critical error", [
//             'process_id' => $processId,
//             'product_id' => $product->id,
//             'error' => $e->getMessage(),
//             'trace' => $e->getTraceAsString()
//         ]);
//         throw $e;
//     }
// }

// private function generatePaymentLink($bid)
// {
//     // يمكنك تعديل هذه الدالة حسب نظام الدفع الخاص بك
//     return route('payment.show', ['bid' => $bid->id]);
// }

// private function sendSMS($phone, $message)
// {
//     $client = new \GuzzleHttp\Client();
    
//     $response = $client->post('https://api.taqnyat.sa/v1/messages', [
//         'headers' => [
//             'Authorization' => 'Bearer c933affa6c2314484d105c45a0e1adc7',
//             'Content-Type' => 'application/json',
//         ],
//         'json' => [
//             'recipients' => '966' . ltrim($phone, '0'),
//             'body' => $message,
//             'sender' => "MazadBid",
//         ],
//     ]);

//     return json_decode($response->getBody(), true);
// }
// private function handleAuctionClosure(Product $product)
// {
//     try {
//         DB::transaction(function () use ($product) {
//             // الحصول على بريد الإدارة من .env
//             $adminEmail = env('ADMIN_EMAIL', 'default-admin@example.com'); // قيمة افتراضية إذا لم تكن موجودة
            
//             // باقي الكود...
//             Log::info('Auction closure details:', [
//                 'admin_email' => $adminEmail,
//                 // بيانات أخرى...
//             ]);

//             // إرسال بريد للإدارة
//             // Mail::to($adminEmail)->send(new AuctionWinnerAdminMail(
//             // ));
//         });
//     } catch (\Exception $e) {
//         Log::error('Error in auction closure', [
//             'product_id' => $product->id,
//             'error' => $e->getMessage(),
//         ]);
//         throw $e;
//     }
// }
private function handleAuctionClosure(Product $product)
{
    try {
        DB::transaction(function () use ($product) {
            // الحصول على المزايدات المقبولة
            $bids = BidPlaced::where('product_id', $product->id)
                ->where('status', 1)
                ->get();

            if ($bids->isEmpty()) {
                Log::info('No bids found for product', [
                    'product_id' => $product->id,
                ]);
                return; // لا توجد مزايدات
            }

            // أعلى مزايدة
            $highestBid = $bids->sortByDesc('bid_amount')->first();
            $winningUserId = $highestBid->user_id;
            $winningAmount = $highestBid->bid_amount;

            // جلب بيانات المستخدم الفائز باستخدام user_id
            $winningUser = \App\Models\User::find($winningUserId);

            if (!$winningUser) {
                Log::error('Winning user not found', [
                    'user_id' => $winningUserId,
                ]);
                return;
            }

            // جلب بريد الإدارة من .env
            $adminEmail = env('ADMIN_EMAIL', 'ebrahimhosny511@gmail.com'); // قيمة افتراضية

            // إعداد البيانات للطباعة في ملف log
            $logData = [
                'product' => [
                    'product_id' => $product->id,
                    'product_title' => $product->title,
                    'product_status' => $product->status,
                    'auction_end_date' => $product->auction_end_date,
                ],
                'winning_user' => [
                    'user_id' => $winningUser->id ?? 'N/A',
                    'user_name' => $winningUser->first_name ?? 'N/A',
                    'user_email' => $winningUser->email ?? 'N/A',
                    'user_phone' => $winningUser->phone ?? 'N/A',
                ],
                'winning_bid' => [
                    'amount' => $winningAmount,
                ],
                'admin_email' => $adminEmail,
            ];

            // طباعة البيانات في ملف log
            Log::info('Auction closure details:', $logData);

            // تحديث تاريخ المنتج
            $product->auction_end_date = now();
            $product->save();

            // إرسال بريد للإدارة
            Mail::to($adminEmail)->send(new AuctionWinnerAdminMail([
                'winner_name' => $winningUser->first_name,
                'product_title' => $product->title,
                'product_image' => $product->image_path ?? 'No Image',
                'winning_amount' => $winningAmount,
                'auction_end_date' => $product->auction_end_date,
                'winner_email' => $winningUser->email,
                'winner_phone' => $winningUser->phone,
            ]));

           
            // إرسال بريد للمستخدم الفائز
            Mail::to($winningUser->email)->send(new AuctionWinnerUserMail([
                'name' => $winningUser->first_name,
                'product_title' => $product->title,
                'product_image' => $product->image_path ?? 'No Image',
                'winning_amount' => $winningAmount,
                'auction_end_date' => $product->auction_end_date,
                // 'payment_link' => "https://payment-link.com", // استبدل برابط الدفع الفعلي
                'payment_link' => route('myfatoorah.pay', ['bid_place_id' => $highestBid->id]),

            ]));

            $this->sendSMS($highestBid->user->phone, 'تهانينا! لقد فزت بمزاد المنتج.');

            
        });
    } catch (\Exception $e) {
        Log::error('Error in auction closure', [
            'product_id' => $product->id,
            'error' => $e->getMessage(),
        ]);
        throw $e;
    }
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
            // 'body' => $message,
            'body' => "تهانينا! لقد فزت بمزاد . تحقق من بريدك لمزيد من التفاصيل.",
            'sender' => 'MazadBid',
        ],
    ]);

    return $response->getStatusCode() == 200;
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
}
