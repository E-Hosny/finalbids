@include('frontend.layouts.header')

<!-- تضمين Bootstrap CSS -->
<!-- تضمين Font Awesome للأيقونات -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
    .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .product-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
    .status-badge {
        font-size: 0.85rem;
        padding: 0.5em 0.8em;
    }
    .table-responsive {
        border-radius: 0.5rem;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .action-buttons .btn {
        margin: 0.2rem;
    }
    .stats-card {
        border-left: 4px solid;
        transition: transform 0.3s ease;
    }
    .stats-card:hover {
        transform: translateX(5px);
    }
</style>

<div class="bg-light py-5" @if(session('locale') === 'ar') dir="rtl" @else dir="ltr" @endif>
    <div class="container">
        <!-- Header Section -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="mb-0">
                <i class="fas fa-box-open me-2"></i>
                {{ session('locale') === 'ar' ? 'منتجاتي' : 'My Products' }}
            </h2>
            <a href="{{ route('frontend.product.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>
                {{ session('locale') === 'ar' ? 'إضافة منتج جديد' : 'Add New Product' }}
            </a>
        </div>

        @if($products->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-5">
                <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                <h3 class="text-muted">
                    {{ session('locale') === 'ar' ? 'لا توجد منتجات مضافة' : 'No Products Added' }}
                </h3>
                <p class="text-muted mb-4">
                    {{ session('locale') === 'ar' ? 'ابدأ بإضافة منتجك الأول' : 'Start by adding your first product' }}
                </p>
                <a href="{{ route('frontend.product.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus-circle me-2"></i>
                    {{ session('locale') === 'ar' ? 'إضافة منتج الآن' : 'Add Product Now' }}
                </a>
            </div>
        @else
            <!-- Products Statistics -->
            <div class="row mb-4">
                <div class="col-md-3 mb-3">
                    <div class="stats-card card border-0" style="border-left-color: #0d6efd !important;">
                        <div class="card-body">
                            <h6 class="card-title text-muted mb-0">
                                {{ session('locale') === 'ar' ? 'إجمالي المنتجات' : 'Total Products' }}
                            </h6>
                            <h3 class="mt-2 mb-0">{{ $products->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stats-card card border-0" style="border-left-color: #198754 !important;">
                        <div class="card-body">
                            <h6 class="card-title text-muted mb-0">
                                {{ session('locale') === 'ar' ? 'المنتجات النشطة' : 'Active Products' }}
                            </h6>
                            <h3 class="mt-2 mb-0">{{ $products->where('status', 'open')->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stats-card card border-0" style="border-left-color: #ffc107 !important;">
                        <div class="card-body">
                            <h6 class="card-title text-muted mb-0">
                                {{ session('locale') === 'ar' ? 'منتجات جديدة' : 'New Products' }}
                            </h6>
                            <h3 class="mt-2 mb-0">{{ $products->where('status', 'new')->count() }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stats-card card border-0" style="border-left-color: #dc3545 !important;">
                        <div class="card-body">
                            <h6 class="card-title text-muted mb-0">
                                {{ session('locale') === 'ar' ? 'منتجات مغلقة' : 'Closed Products' }}
                            </h6>
                            <h3 class="mt-2 mb-0">{{ $products->where('status', 'closed')->count() }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Table -->
            <div class="card border-0">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">{{ session('locale') === 'ar' ? 'اسم المنتج' : 'Product Name' }}</th>
                                    <th class="border-0">{{ session('locale') === 'ar' ? 'السعر' : 'Price' }}</th>
                                    <th class="border-0">{{ session('locale') === 'ar' ? 'الحالة' : 'Status' }}</th>
                                    <th class="border-0">{{ session('locale') === 'ar' ? 'تاريخ الإضافة' : 'Added Date' }}</th>
                                    <th class="border-0">{{ session('locale') === 'ar' ? 'الإجراءات' : 'Actions' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                    <tr class="align-middle">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($product->image_path)
                                                    <img src="{{ asset($product->image_path) }}" 
                                                         alt="Product Image" 
                                                         class="rounded me-2" 
                                                         style="width: 40px; height: 40px; object-fit: cover;">
                                                @else
                                                    <div class="rounded me-2 bg-secondary d-flex align-items-center justify-content-center" 
                                                         style="width: 40px; height: 40px;">
                                                        <i class="fas fa-image text-white"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <h6 class="mb-0">{{ session('locale') === 'ar' ? $product->title_ar : $product->title }}</h6>
                                                    <small class="text-muted">ID: #{{ $product->id }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <strong>{{ number_format($product->reserved_price, 2) }}</strong>
                                            <small class="text-muted">{{ session('locale') === 'ar' ? 'ريال' : 'SAR' }}</small>
                                        </td>
                                        <td>
                                            @switch($product->status)
                                                @case('new')
                                                    <span class="badge bg-warning status-badge">
                                                        <i class="fas fa-star me-1"></i>
                                                        {{ session('locale') === 'ar' ? 'جديد' : 'New' }}
                                                    </span>
                                                    @break
                                                @case('open')
                                                    <span class="badge bg-success status-badge">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        {{ session('locale') === 'ar' ? 'مفتوح' : 'Open' }}
                                                    </span>
                                                    @break
                                                @case('suspended')
                                                    <span class="badge bg-secondary status-badge">
                                                        <i class="fas fa-pause-circle me-1"></i>
                                                        {{ session('locale') === 'ar' ? 'معلق' : 'Suspended' }}
                                                    </span>
                                                    @break
                                                @case('closed')
                                                    <span class="badge bg-dark status-badge">
                                                        <i class="fas fa-times-circle me-1"></i>
                                                        {{ session('locale') === 'ar' ? 'مغلق' : 'Closed' }}
                                                    </span>
                                                    @break
                                                @default
                                                    <span class="badge bg-danger status-badge">
                                                        <i class="fas fa-question-circle me-1"></i>
                                                        {{ session('locale') === 'ar' ? 'غير معروف' : 'Unknown' }}
                                                    </span>
                                            @endswitch
                                        </td>
                                        <td>
                                            <small class="text-muted">
                                                <i class="far fa-calendar-alt me-1"></i>
                                                {{ $product->created_at->format('Y-m-d') }}
                                            </small>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="{{ route('user.products.details', $product->id) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i>
                                                    {{ session('locale') === 'ar' ? 'عرض' : 'View' }}
                                                </a>
                                                {{-- <a href="#" class="btn btn-sm btn-outline-success">
                                                    <i class="fas fa-edit me-1"></i>
                                                    {{ session('locale') === 'ar' ? 'تعديل' : 'Edit' }}
                                                </a>
                                                <button type="button" class="btn btn-sm btn-outline-danger">
                                                    <i class="fas fa-trash me-1"></i>
                                                    {{ session('locale') === 'ar' ? 'حذف' : 'Delete' }}
                                                </button> --}}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
        @if(method_exists($products, 'links'))
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
        @endif
        @endif
    </div>
</div>

<!-- تضمين Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- سكريبت للتأكيد قبل الحذف -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const deleteButtons = document.querySelectorAll('.btn-outline-danger');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            if (confirm('{{ session('locale') === 'ar' ? 'هل أنت متأكد من حذف هذا المنتج؟' : 'Are you sure you want to delete this product?' }}')) {
                // قم بتنفيذ عملية الحذف هنا
            }
        });
    });
});
</script>

@include('frontend.layouts.footer')
@include('frontend.products.script.addToWishListScript')