@include('frontend.layouts.header')




<section class="categories py-5">
    <div class="container mx-auto">
        <h1 class="fw-bold">{{ session('locale')=='en' ? 'Departments' : 'الفئات' }}</h1>
        <div class="row py-4 gy-3">
            @foreach ($categories as $category )


            <div class="col-xl-6">
                <div class="categories-card">
                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                            <a href="{{ url('category', $category->slug) }}">
                                <img class="" src="{{ asset('img/users/' . $category->image_path) }}" alt="category-img">
                            </a>
                        </div>
                        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 col-xl-8  px-4">
                            <h2 class="py-1 ">{{session('locale')=='en'? $category->name : $category->name_ar }}</h2>
                            <p class="py-0 my-0">
                                {{ session('locale')=='en'? 'this category have most of old and the best old electoric in our country
                                 ' :
                                '.تحتوي هذه الفئة على معظم وأفضل المنتخبات القديمة في بلادنا
                                ' }}
                            </p>
                            <p class="py-2 my-0">{{ session('locale')=='en' ? 'OPEN FOR BIDDING' : 'مفتوح للمزايدة' }}</p>
                            <p class="my-color py-1 my-0">
                                {{ session('locale') == 'en' ? 'View ' . $category->projects_count . ' Lots' : 'عرض ' . $category->projects_count . ' قطعة للمزايدة ' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach


        </div>

    </div>

</section>









@include('frontend.layouts.footer')

<style>
    .categories .container{
        width: 90%;
    }
    .categories-card{
        border: 1px solid #d3d3d3;
    }
    .categories-card img{
    object-fit: cover;
    height: auto;
    width: 100%;
   }

</style>
