@include('frontend.layouts.header')

<!-- تضمين Bootstrap CSS -->
<!-- تضمين Font Awesome للأيقونات -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<!-- تضمين Lightbox CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">

<style>
    .product-image {
        transition: transform 0.3s ease;
        cursor: pointer;
    }
    .product-image:hover {
        transform: scale(1.05);
    }
    .badge-custom {
        font-size: 0.9rem;
        padding: 0.5rem 1rem;
    }
    .product-info-item {
        padding: 1rem;
        border-bottom: 1px solid #eee;
        transition: background-color 0.3s ease;
    }
    .product-info-item:hover {
        background-color: #f8f9fa;
    }
    .image-gallery {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        margin-top: 1rem;
    }
    .image-container {
        position: relative;
        padding-top: 100%;
        overflow: hidden;
        border-radius: 0.5rem;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .image-container img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<div class="bg-light py-5" @if(session('locale') === 'ar') dir="rtl" @else dir="ltr" @endif>
    <div class="container">
        <!-- Navigation Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                {{-- <li class="breadcrumb-item">
                    <a href="{{ route('home') }}" class="text-decoration-none">
                        <i class="fas fa-home"></i>
                        {{ session('locale') === 'ar' ? 'الرئيسية' : 'Home' }}
                    </a>
                </li> --}}
                <li class="breadcrumb-item">
                    <a href="{{ route('user.products') }}" class="text-decoration-none">
                        <i class="fas fa-boxes"></i>
                        {{ session('locale') === 'ar' ? 'منتجاتي' : 'My Products' }}
                    </a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ session('locale') === 'ar' ? 'تفاصيل المنتج' : 'Product Details' }}
                </li>
            </ol>
        </nav>

        <div class="row">
            <!-- Product Images Gallery -->
            <div class="col-lg-6 mb-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title mb-3">
                            <i class="fas fa-images me-2"></i>
                            {{ session('locale') === 'ar' ? 'معرض الصور' : 'Image Gallery' }}
                        </h5>
                        
                        @if($product->images->count() > 0)
                            <div class="image-gallery">
                                @foreach($product->images as $image)
                                    <a href="{{ asset($image->image_path) }}" 
                                       data-lightbox="product-gallery" 
                                       data-title="{{ session('locale') === 'ar' ? strip_tags($product->title_ar) : strip_tags($product->title) }}">
                                        <div class="image-container">
                                            <img src="{{ asset($image->image_path) }}" 
                                                 alt="Product Image" 
                                                 class="product-image">
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                            <small class="text-muted mt-2 d-block">
                                <i class="fas fa-info-circle me-1"></i>
                                {{ session('locale') === 'ar' ? 'انقر على الصور للتكبير' : 'Click images to enlarge' }}
                            </small>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-image fa-3x text-muted mb-3"></i>
                                <p class="text-muted">
                                    {{ session('locale') === 'ar' ? 'لا توجد صور متاحة' : 'No images available' }}
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="card-title mb-0">
                                {{ session('locale') === 'ar' ? strip_tags($product->title_ar) : strip_tags($product->title) }}
                            </h3>
                            <span class="badge bg-primary badge-custom">
                                #{{ $product->id }}
                            </span>
                        </div>

                        <div class="product-info-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">
                                    <i class="fas fa-tag me-2"></i>
                                    {{ session('locale') === 'ar' ? 'السعر' : 'Price' }}
                                </span>
                                <h4 class="mb-0">
                                    {{ number_format($product->reserved_price, 2) }}
                                    <small class="text-muted">{{ session('locale') === 'ar' ? 'ريال' : 'SAR' }}</small>
                                </h4>
                            </div>
                        </div>

                        <div class="product-info-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">
                                    <i class="fas fa-info-circle me-2"></i>
                                    {{ session('locale') === 'ar' ? 'الحالة' : 'Status' }}
                                </span>
                                @switch($product->status)
                                    @case('new')
                                        <span class="badge bg-warning badge-custom">
                                            <i class="fas fa-star me-1"></i>
                                            {{ session('locale') === 'ar' ? 'جديد' : 'New' }}
                                        </span>
                                        @break
                                    @case('open')
                                        <span class="badge bg-success badge-custom">
                                            <i class="fas fa-check-circle me-1"></i>
                                            {{ session('locale') === 'ar' ? 'مفتوح' : 'Open' }}
                                        </span>
                                        @break
                                    @case('suspended')
                                        <span class="badge bg-secondary badge-custom">
                                            <i class="fas fa-pause-circle me-1"></i>
                                            {{ session('locale') === 'ar' ? 'معلق' : 'Suspended' }}
                                        </span>
                                        @break
                                    @case('closed')
                                        <span class="badge bg-dark badge-custom">
                                            <i class="fas fa-times-circle me-1"></i>
                                            {{ session('locale') === 'ar' ? 'مغلق' : 'Closed' }}
                                        </span>
                                        @break
                                @endswitch
                            </div>
                        </div>

                        <div class="product-info-item">
                            <span class="text-muted">
                                <i class="fas fa-align-left me-2"></i>
                                {{ session('locale') === 'ar' ? 'الوصف' : 'Description' }}
                            </span>
                            <p class="mt-2 mb-0">
                                {{ session('locale') === 'ar' ? strip_tags($product->description_ar) : strip_tags($product->description) }}
                            </p>
                        </div>

                        <div class="product-info-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted">
                                    <i class="far fa-calendar-alt me-2"></i>
                                    {{ session('locale') === 'ar' ? 'تاريخ الإضافة' : 'Added Date' }}
                                </span>
                                <span>{{ $product->created_at->format('Y-m-d') }}</span>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="d-flex gap-2 mt-4">
                            <a href="{{ route('user.products') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>
                                {{ session('locale') === 'ar' ? 'العودة للقائمة' : 'Back to List' }}
                            </a>
                            {{-- <a href="#" class="btn btn-primary">
                                <i class="fas fa-edit me-2"></i>
                                {{ session('locale') === 'ar' ? 'تعديل المنتج' : 'Edit Product' }}
                            </a>
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash-alt me-2"></i>
                                {{ session('locale') === 'ar' ? 'حذف المنتج' : 'Delete Product' }}
                            </button> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
{{-- <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">
                    {{ session('locale') === 'ar' ? 'تأكيد الحذف' : 'Confirm Delete' }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ session('locale') === 'ar' ? 'هل أنت متأكد من حذف هذا المنتج؟' : 'Are you sure you want to delete this product?' }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ session('locale') === 'ar' ? 'إلغاء' : 'Cancel' }}
                </button>
                <form action="{{ route('product.delete', $product->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        {{ session('locale') === 'ar' ? 'حذف' : 'Delete' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div> --}}

<!-- تضمين Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- تضمين Lightbox JavaScript -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<script>
// تهيئة Lightbox
lightbox.option({
    'resizeDuration': 200,
    'wrapAround': true,
    'albumLabel': "{{ session('locale') === 'ar' ? 'صورة %1 من %2' : 'Image %1 of %2' }}"
});
</script>

@include('frontend.layouts.footer')
@include('frontend.products.script.addToWishListScript')