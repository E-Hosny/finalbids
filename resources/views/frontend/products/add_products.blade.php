@include('frontend.layouts.header')

<!-- تضمين Bootstrap CSS -->
<!-- تضمين Font Awesome للأيقونات -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

<style>
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    .img-preview {
        max-width: 150px;
        max-height: 150px;
        object-fit: cover;
        margin: 5px;
        border-radius: 5px;
    }
    .upload-area {
        border: 2px dashed #dee2e6;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        background-color: #f8f9fa;
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .upload-area:hover {
        border-color: #0d6efd;
        background-color: #e9ecef;
    }
    .preview-container {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }
</style>

<div class="bg-light min-vh-100 py-5">
    <div class="container" @if(session('locale') === 'ar') dir="rtl" @else dir="ltr" @endif>
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <!-- عنوان الصفحة -->
                        <h2 class="text-center mb-4">
                            {{ session('locale') === 'ar' ? 'إضافة منتج جديد' : 'Add New Product' }}
                        </h2>

                        <!-- رسالة النجاح -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- نموذج إضافة المنتج -->
                        <form action="{{ route('frontend.product.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <!-- قسم العناوين -->
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="form-group">
                                        <label for="title" class="form-label">
                                            {{ session('locale') === 'ar' ? 'العنوان (إنجليزي)' : 'Title (English)' }}
                                        </label>
                                        <input type="text" name="title" id="title" class="form-control" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title_ar" class="form-label">
                                            {{ session('locale') === 'ar' ? 'العنوان (عربي)' : 'Title (Arabic)' }}
                                        </label>
                                        <input type="text" name="title_ar" id="title_ar" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <!-- السعر المحجوز -->
                            <div class="form-group mb-4">
                                <label for="reserved_price" class="form-label">
                                    {{ session('locale') === 'ar' ? 'السعر المحجوز' : 'Reserved Price' }}
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" name="reserved_price" id="reserved_price" class="form-control" required>
                                </div>
                            </div>

                            <!-- قسم الوصف -->
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="form-group">
                                        <label for="description" class="form-label">
                                            {{ session('locale') === 'ar' ? 'الوصف (إنجليزي)' : 'Description (English)' }}
                                        </label>
                                        <textarea name="description" id="description" class="form-control" rows="4" required></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="description_ar" class="form-label">
                                            {{ session('locale') === 'ar' ? 'الوصف (عربي)' : 'Description (Arabic)' }}
                                        </label>
                                        <textarea name="description_ar" id="description_ar" class="form-control" rows="4" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- قسم الصور -->
                            <div class="form-group mb-4">
                                <label class="form-label">
                                    {{ session('locale') === 'ar' ? 'الصور' : 'Images' }}
                                </label>
                                <div class="upload-area" id="dropZone">
                                    <i class="fas fa-cloud-upload-alt fa-3x text-muted mb-3"></i>
                                    <p class="mb-2">
                                        {{ session('locale') === 'ar' ? 'اسحب وأفلت الصور هنا أو' : 'Drag and drop images here or' }}
                                    </p>
                                    <label for="image_path" class="btn btn-outline-primary mb-0">
                                        {{ session('locale') === 'ar' ? 'اختر الصور' : 'Choose Images' }}
                                    </label>
                                    <input type="file" name="image_path[]" id="image_path" class="d-none" multiple accept="image/*">
                                    <p class="text-muted small mt-2">
                                        {{ session('locale') === 'ar' ? 'PNG، JPG حتى 10 ميجابايت' : 'PNG, JPG up to 10MB' }}
                                    </p>
                                </div>
                                <div id="previewContainer" class="preview-container"></div>
                            </div>

                            <!-- زر الإضافة -->
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-plus-circle me-2"></i>
                                    {{ session('locale') === 'ar' ? 'إضافة المنتج' : 'Add Product' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- تضمين Bootstrap JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- سكريبت معاينة الصور -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const dropZone = document.getElementById('dropZone');
    const fileInput = document.getElementById('image_path');
    const previewContainer = document.getElementById('previewContainer');

    // منع السلوك الافتراضي للمتصفح عند السحب والإفلات
    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, preventDefaults, false);
    });

    function preventDefaults(e) {
        e.preventDefault();
        e.stopPropagation();
    }

    // تغيير مظهر منطقة الإفلات عند السحب
    ['dragenter', 'dragover'].forEach(eventName => {
        dropZone.addEventListener(eventName, highlight, false);
    });

    ['dragleave', 'drop'].forEach(eventName => {
        dropZone.addEventListener(eventName, unhighlight, false);
    });

    function highlight(e) {
        dropZone.classList.add('border-primary', 'bg-light');
    }

    function unhighlight(e) {
        dropZone.classList.remove('border-primary', 'bg-light');
    }

    // معالجة إفلات الملفات
    dropZone.addEventListener('drop', handleDrop, false);

    function handleDrop(e) {
        const dt = e.dataTransfer;
        const files = dt.files;
        handleFiles(files);
    }

    // معالجة اختيار الملفات عبر زر الاختيار
    fileInput.addEventListener('change', function() {
        handleFiles(this.files);
    });

    function handleFiles(files) {
        previewContainer.innerHTML = ''; // مسح المعاينات السابقة
        
        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'img-preview';
                    previewContainer.appendChild(img);
                }
                
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>

@include('frontend.layouts.footer')
@include('frontend.products.script.addToWishListScript')