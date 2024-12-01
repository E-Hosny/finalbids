<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\Mail\AdminProductAddedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;



class ProductController extends Controller
{
    // عرض صفحة إضافة المنتج
    public function create()
    {
        return view('frontend.products.add_products');
    }

   


// public function store(Request $request)
// {
//     // التحقق من المدخلات
//     $data = $request->validate([
//         'title' => 'required|string|max:255',
//         'title_ar' => 'required|string|max:255',
//         'reserved_price' => 'nullable|numeric',
//         'description' => 'required|string',
//         'description_ar' => 'required|string',
//         'image_path.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
//     ]);

//     // توليد قيمة فريدة لـ `lot_no`
//     $lastProduct = Product::orderBy('id', 'desc')->first();
//     $lastLotNumber = $lastProduct ? intval(substr($lastProduct->lot_no, 4)) : 0;
//     $newLotNumber = $lastLotNumber + 1;
//     $lotNo = 'Lot-' . sprintf('%03d', $newLotNumber);
//     $slug = $this->getUniqueSlug($data['title']);

//     // إنشاء المنتج
//     $product = Product::create([
//         'title' => $data['title'],
//         'title_ar' => $data['title_ar'],
//         // 'reserved_price' => $data['reserved_price'],
//         'reserved_price' => '0',
//         'description' => $data['description'],
//         'description_ar' => $data['description_ar'],
//         'lot_no' => $lotNo,
//         'slug' => $slug,
//         'user_id' => auth()->id(), // تعيين المستخدم الحالي
//         'status' => 'new', // حالة المنتج في انتظار التفعيل
//     ]);
//     $data['slug'] = Str::slug($data['title'], '-'); // تحديث الـ slug
    


//     // رفع الصور إذا وُجدت
//     if ($request->hasFile('image_path')) {
//         foreach ($request->file('image_path') as $file) {
//             $filename = date('YmdHi') . '-' . uniqid() . '.' . $file->extension();
//             $file->move(public_path('product/gallery'), $filename);

//             // حفظ الصورة في جدول Gallery مع تعيين lot_no
//             Gallery::create([
//                 'product_id' => $product->id,
//                 'image_path' => asset('product/gallery/' . $filename),
//                 'lot_no' => $product->lot_no,
//             ]);
//         }
//     }

//     // إعادة التوجيه مع رسالة نجاح
//     return redirect()->route('frontend.product.create')
//         ->with('success', session('locale') === 'ar' 
//             ? 'تم إضافة المنتج بنجاح، انتظر حتى يتم التفعيل.' 
//             : 'Product added successfully, please wait for approval.');
// }

// public function store(Request $request)
// {
//     // التحقق من المدخلات
//     $data = $request->validate([
//         'title' => 'required|string|max:255',
//         'title_ar' => 'required|string|max:255',
//         'reserved_price' => 'nullable|numeric',
//         'description' => 'required|string',
//         'description_ar' => 'required|string',
//         'image_path.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
//     ]);

//     // توليد قيمة فريدة لـ `lot_no`
//     $lastProduct = Product::orderBy('id', 'desc')->first();
//     $lastLotNumber = $lastProduct ? intval(substr($lastProduct->lot_no, 4)) : 0;
//     $newLotNumber = $lastLotNumber + 1;
//     $lotNo = 'Lot-' . sprintf('%03d', $newLotNumber);
//     $slug = $this->getUniqueSlug($data['title']);

//     // إنشاء المنتج
//     $product = Product::create([
//         'title' => $data['title'],
//         'title_ar' => $data['title_ar'],
//         'reserved_price' => '0',
//         'description' => $data['description'],
//         'description_ar' => $data['description_ar'],
//         'lot_no' => $lotNo,
//         'slug' => $slug,
//         'user_id' => auth()->id(),
//         'status' => 'new',
//     ]);

//     // رفع الصور إذا وُجدت
//     if ($request->hasFile('image_path')) {
//         foreach ($request->file('image_path') as $file) {
//             $filename = date('YmdHi') . '-' . uniqid() . '.' . $file->extension();
//             $file->move(public_path('product/gallery'), $filename);

//             Gallery::create([
//                 'product_id' => $product->id,
//                 'image_path' => asset('product/gallery/' . $filename),
//                 'lot_no' => $product->lot_no,
//             ]);
//         }
//     }

//     // إرسال البريد الإلكتروني للمسؤول
//     try {
//         Mail::to(env('ADMIN_EMAIL'))->send(new AdminProductAddedMail($product));
//     } catch (\Exception $e) {
//         Log::error('Failed to send product added email: ' . $e->getMessage());
//     }

//     // إعادة التوجيه مع رسالة نجاح
//     return redirect()->route('frontend.product.create')
//         ->with('success', session('locale') === 'ar' 
//             ? 'تم إضافة المنتج بنجاح، انتظر حتى يتم التفعيل.' 
//             : 'Product added successfully, please wait for approval.');
// }

public function store(Request $request)
{
    $data = $request->validate([
        'title' => 'required|string|max:255',
        'title_ar' => 'required|string|max:255',
        'reserved_price' => 'nullable|numeric',
        'description' => 'required|string',
        'description_ar' => 'required|string',
        'image_path.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $lastProduct = Product::orderBy('id', 'desc')->first();
    $lastLotNumber = $lastProduct ? intval(substr($lastProduct->lot_no, 4)) : 0;
    $newLotNumber = $lastLotNumber + 1;
    $lotNo = 'Lot-' . sprintf('%03d', $newLotNumber);
    $slug = $this->getUniqueSlug($data['title']);

    $product = Product::create([
        'title' => $data['title'],
        'title_ar' => $data['title_ar'],
        'reserved_price' => '0',
        'description' => $data['description'],
        'description_ar' => $data['description_ar'],
        'lot_no' => $lotNo,
        'slug' => $slug,
        'user_id' => auth()->id(),
        'status' => 'new',
    ]);

    if ($request->hasFile('image_path')) {
        foreach ($request->file('image_path') as $file) {
            $filename = date('YmdHi') . '-' . uniqid() . '.' . $file->extension();
            $file->move(public_path('product/gallery'), $filename);

            Gallery::create([
                'product_id' => $product->id,
                'image_path' => asset('product/gallery/' . $filename),
                'lot_no' => $product->lot_no,
            ]);
        }
    }

    try {
        Mail::to(env('ADMIN_EMAIL'))->send(new AdminProductAddedMail($product));
    } catch (\Exception $e) {
        Log::error('Failed to send product added email: ' . $e->getMessage());
    }

    return redirect()->route('frontend.product.create')
        ->with('success', 'Product added successfully, please wait for approval.');
}

    // توليد slug فريد للعنوان
    // protected function getUniqueSlug($title)
    // {
    //     $slug = Str::slug($title);
    //     $count = Product::where('slug', $slug)->count();

    //     return $count > 0 ? $slug . '-' . ($count + 1) : $slug;
    // }
    protected function getUniqueSlug($title)
{
    $slug = Str::slug($title); // تحويل العنوان إلى slug
    $count = Product::where('slug', 'LIKE', "{$slug}%")->count(); // البحث عن slugs مشابهة

    return $count > 0 ? $slug . '-' . ($count + 1) : $slug; // إضافة رقم إذا وُجد slug مشابه
}


    public function userProducts()
    {
        // جلب المنتجات الخاصة بالمستخدم الحالي
        $products = Product::where('user_id', auth()->id())->get();

        // إرسال البيانات إلى العرض
        return view('frontend.products.user_products', compact('products'));
    }

public function productDetails($id)
{
    // التحقق من أن المنتج يخص المستخدم الحالي
    $product = Product::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

    // إرسال البيانات إلى العرض
    return view('frontend.products.product_details', compact('product'));
}


}
