

<style>
    .sidenav-normal{
        color:brown;
    }
</style>

<aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="meni-close-icon fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0     d-xl-none"
            aria-hidden="true" id="iconSidenav">
        </i>
        <a class="navbar-brand m-0" href="{{route('admin.dashboard')}}">
            <img src="{{asset('img/Group 5610.jpg')}}" class="navbar-brand-img h-100" alt="main_logo">
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.dashboard')}}">
                    <div
                        class="icon icon-shape icon-sm border-radius-md text-center d-flex align-items-center justify-content-center">
                        <i class="ni ni-tv-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#dashboardsExamples"
                    class="nav-link {{Request::routeIs('admin.users.*') ? '' : 'collapsed'}}"
                    aria-controls="dashboardsExamples" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="ni ni-circle-08 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Users</span>
                </a>
                <div class="collapse {{Request::routeIs('admin.users.*') ? 'show' : ''}}" id="dashboardsExamples"
                    style="">
                    <ul class="nav ms-4">
                        <li class="nav-item {{Request::routeIs('admin.users.index') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.users.index') ? 'active' : ''}}"
                                href="{{route('admin.users.index')}}">
                                <span class="sidenav-normal"> Users List </span>
                            </a>
                        </li>
                        <!-- <li class="nav-item {{Request::routeIs('admin.users.create') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.users.create') ? 'active' : ''}}"
                                href="{{route('admin.users.create')}}">
                                <span class="sidenav-normal"> <strong>Add User </strong></span>
                            </a>
                        </li> -->
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#bannerSection"
                    class="nav-link {{Request::routeIs('admin.banners.*') ? '' : 'collapsed'}}"
                    aria-controls="bannerSection" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="ni ni-air-baloon text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Banner</span>
                </a>
                <div class="collapse {{Request::routeIs('admin.banners.*') ? 'show' : ''}}" id="bannerSection" style="">
                    <ul class="nav ms-4">
                        <li class="nav-item {{Request::routeIs('admin.banners.index') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.banners.index') ? 'active' : ''}}"
                                href="{{route('admin.banners.index')}}">
                                <span class="sidenav-normal"> List </span>
                            </a>
                        </li>
                        <!-- <li class="nav-item {{Request::routeIs('admin.banners.create') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.banners.create') ? 'active' : ''}}"
                                href="{{route('admin.banners.create')}}">
                                <span class="sidenav-normal"> Add Banner </span>
                            </a>
                        </li> -->
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#projectSection"
                    class="nav-link {{Request::routeIs('admin.projects.*') ? '' : 'collapsed'}}"
                    aria-controls="projectSection" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="ni ni-air-baloon text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Projects</span>
                </a>
                <div class="collapse {{Request::routeIs('admin.projects.*') ? 'show' : ''}}" id="projectSection" style="">
                    <ul class="nav ms-4">
                        <li class="nav-item {{Request::routeIs('admin.projects.index') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.projects.index') ? 'active' : ''}}"
                                href="{{route('admin.projects.index')}}">
                                <span class="sidenav-normal"> List </span>
                            </a>
                        </li>
                        <li class="nav-item {{Request::routeIs('admin.projects.create') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.projects.create') ? 'active' : ''}}"
                                href="{{route('admin.projects.create')}}">
                                <span class="sidenav-normal"> Add Projects </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
          
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#categorySection"
                    class="nav-link {{Request::routeIs('admin.categories.*') ? '' : 'collapsed'}}"
                    aria-controls="categorySection" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="ni ni-bag-17 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Category</span>
                </a>
                <div class="collapse {{Request::routeIs('admin.categories.*') ? 'show' : ''}}" id="categorySection" style="">
                    <ul class="nav ms-4">
                        <li class="nav-item {{Request::routeIs('admin.categories.index') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.categories.index') ? 'active' : ''}}"
                                href="{{route('admin.categories.index')}}">
                                <span class="sidenav-normal"> List </span>
                            </a>
                        </li>
                        <li class="nav-item {{Request::routeIs('admin.categories.create') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.categories.create') ? 'active' : ''}}"
                                href="{{route('admin.categories.create')}}">
                                <span class="sidenav-normal"> Add Category </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <!-- <li class="nav-item">
                <a data-bs-toggle="collapse" href="#subcategorySection"
                    class="nav-link {{Request::routeIs('admin.subcategories.*') ? '' : 'collapsed'}}"
                    aria-controls="subcategorySection" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="ni ni-bag-17 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Sub-Category</span>
                </a>
                <div class="collapse {{Request::routeIs('admin.subcategories.*') ? 'show' : ''}}" id="subcategorySection" style="">
                    <ul class="nav ms-4">
                        <li class="nav-item {{Request::routeIs('admin.subcategories.index') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.subcategories.index') ? 'active' : ''}}"
                                href="{{route('admin.subcategories.index')}}">
                                <span class="sidenav-normal"> List </span>
                            </a>
                        </li>
                        <li class="nav-item {{Request::routeIs('admin.subcategories.create') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.subcategories.create') ? 'active' : ''}}"
                                href="{{route('admin.subcategories.create')}}">
                                <span class="sidenav-normal"> Add SubCategory </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li> -->
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#brandSection"
                    class="nav-link {{Request::routeIs('admin.helpsupport.*') ? '' : 'collapsed'}}"
                    aria-controls="brandSection" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="ni ni-badge text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Enquiry</span>
                </a>
                <div class="collapse {{Request::routeIs('admin.helpsupport.*') ? 'show' : ''}}" id="brandSection" style="">
                    <ul class="nav ms-4">
                        <li class="nav-item {{Request::routeIs('admin.helpsupport.index') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.helpsupport.index') ? 'active' : ''}}"
                                href="{{route('admin.helpsupport.index')}}">
                                <span class="sidenav-normal"> List </span>
                            </a>
                        </li>
                        <!-- <li class="nav-item {{Request::routeIs('admin.helpsupport.create') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.helpsupport.create') ? 'active' : ''}}"
                                href="{{route('admin.helpsupport.create')}}">
                                <span class="sidenav-normal"><strong> Add Brand </strong></span>
                            </a>
                        </li> -->
                    </ul>
                </div>
            </li>
            <!-- <li class="nav-item">
                <a data-bs-toggle="collapse" href="#auctiontypeSection"
                    class="nav-link {{Request::routeIs('admin.news.*') ? '' : 'collapsed'}}"
                    aria-controls="auctiontypeSection" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="ni ni-basket text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">StayUpTodate</span>
                </a>
                <div class="collapse {{Request::routeIs('admin.news.*') ? 'show' : ''}}" id="auctiontypeSection" style="">
                    <ul class="nav ms-4">
                        <li class="nav-item {{Request::routeIs('admin.news.index') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.news.index') ? 'active' : ''}}"
                                href="{{route('admin.news.index')}}">
                                <span class="sidenav-normal"> List </span>
                            </a>
                        </li>
                        {{-- <li class="nav-item {{Request::routeIs('admin.auctiontypes.create') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.auctiontypes.create') ? 'active' : ''}}"
                                href="{{route('admin.auctiontypes.create')}}">
                                <span class="sidenav-normal"> Add AuctionType </span>
                            </a>
                        </li> --}}
                    </ul>
                </div>
            </li> -->
            <!-- <li class="nav-item">
                <a data-bs-toggle="collapse" href="#bidvaluesSection"
                    class="nav-link {{Request::routeIs('admin.bidvalues.*') ? '' : 'collapsed'}}"
                    aria-controls="bidvaluesSection" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="ni ni-box-2 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Bid Values</span>
                </a>
                <div class="collapse {{Request::routeIs('admin.bidvalues.*') ? 'show' : ''}}" id="bidvaluesSection" style="">
                    <ul class="nav ms-4">
                        <li class="nav-item {{Request::routeIs('admin.bidvalues.index') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.bidvalues.index') ? 'active' : ''}}"
                                href="{{route('admin.bidvalues.index')}}">
                                <span class="sidenav-normal"> List </span>
                            </a>
                        </li>
                        <li class="nav-item {{Request::routeIs('admin.bidvalues.create') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.bidvalues.create') ? 'active' : ''}}"
                                href="{{route('admin.bidvalues.create')}}">
                                <span class="sidenav-normal"> Add Bid Values </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li> -->
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#productSection"
                    class="nav-link {{Request::routeIs('admin.products.*') ? '' : 'collapsed'}}"
                    aria-controls="productSection" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="ni ni-book-bookmark text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Product Management</span>
                </a>
                <div class="collapse {{Request::routeIs('admin.products.*') ? 'show' : ''}}" id="productSection" style="">
                    <ul class="nav ms-4">
                        <li class="nav-item {{Request::routeIs('admin.products.index') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.products.index') ? 'active' : ''}}"
                                href="{{route('admin.products.index')}}">
                                <span class="sidenav-normal"> List </span>
                            </a>
                        </li>
                        <li class="nav-item {{Request::routeIs('admin.products.create') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.products.create') ? 'active' : ''}}"
                                href="{{route('admin.products.create')}}">
                                <span class="sidenav-normal"> Add ProductAuction </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#bidrequestSection"
                    class="nav-link {{Request::routeIs('admin.bidrequests.*') ? '' : 'collapsed'}}"
                    aria-controls="bidrequestSection" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="ni ni-ui-04 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">BidRequest</span>
                </a>
                <div class="collapse {{Request::routeIs('admin.bidrequests.*') ? 'show' : ''}}" id="bidrequestSection" style="">
                    <ul class="nav ms-4">
                        <li class="nav-item {{Request::routeIs('admin.bidrequests.index') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.bidrequests.index') ? 'active' : ''}}"
                                href="{{route('admin.bidrequests.index')}}">
                                <span class="sidenav-normal"> List </span>
                            </a>
                        </li>
                        <!-- <li class="nav-item {{Request::routeIs('admin.bidrequests.create') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.bidrequests.create') ? 'active' : ''}}"
                                href="{{route('admin.bidrequests.create')}}">
                                <span class="sidenav-normal"> Add Blog </span>
                            </a>
                        </li> -->
                    </ul>
                </div>
            </li>
            <!-- <li class="nav-item">
                <a data-bs-toggle="collapse" href="#blogSection"
                    class="nav-link {{Request::routeIs('admin.blogs.*') ? '' : 'collapsed'}}"
                    aria-controls="blogSection" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="ni ni-ui-04 text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Blogs</span>
                </a>
                <div class="collapse {{Request::routeIs('admin.blogs.*') ? 'show' : ''}}" id="blogSection" style="">
                    <ul class="nav ms-4">
                        <li class="nav-item {{Request::routeIs('admin.blogs.index') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.blogs.index') ? 'active' : ''}}"
                                href="{{route('admin.blogs.index')}}">
                                <span class="sidenav-normal"> List </span>
                            </a>
                        </li>
                        <li class="nav-item {{Request::routeIs('admin.blogs.create') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.blogs.create') ? 'active' : ''}}"
                                href="{{route('admin.blogs.create')}}">
                                <span class="sidenav-normal"> Add Blog </span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li> -->
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#pageSection"
                    class="nav-link {{Request::routeIs('admin.pages.*') ? '' : 'collapsed'}}"
                    aria-controls="pageSection" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="ni ni-badge text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Pages</span>
                </a>
                <div class="collapse {{Request::routeIs('admin.pages.*') ? 'show' : ''}}" id="pageSection" style="">
                    <ul class="nav ms-4">
                        <li class="nav-item {{Request::routeIs('admin.pages.index') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.pages.index') ? 'active' : ''}}"
                                href="{{route('admin.pages.index')}}">
                                <span class="sidenav-normal"> List </span>
                            </a>
                        </li>
                        <!-- <li class="nav-item {{Request::routeIs('admin.pages.create') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.pages.create') ? 'active' : ''}}"
                                href="{{route('admin.pages.create')}}">
                                <span class="sidenav-normal"><strong> Add Pages </strong></span>
                            </a>
                        </li> -->
                    </ul>
                </div>
            </li>
            <!-- <li class="nav-item">
                <a data-bs-toggle="collapse" href="#pagesExamples"
                    class="nav-link {{Request::routeIs('admin.countries.*') || Request::routeIs('admin.contact-us-subjects.*') || Request::routeIs('admin.states.*')  ? '' : 'collapsed'}}"
                    aria-controls="pagesExamples" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="ni ni-ungroup text-warning text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Site Settings</span>
                </a>
                <div class="collapse {{Request::routeIs('admin.countries.*') || Request::routeIs('admin.contact-us-subjects.*') || Request::routeIs('admin.states.*')  ? 'show' : ''}}"
                    id="pagesExamples" style="">
                    <ul class="nav ms-4">
                        <li class="nav-item ">
                            <a class="nav-link {{Request::routeIs('admin.countries.*') ? '' : 'collapsed'}}"
                                data-bs-toggle="collapse" aria-expanded="false" href="#profileExample">
                                <span class="sidenav-normal"> Countries <b class="caret"></b></span>
                            </a>
                            <div class="collapse {{Request::routeIs('admin.countries.*') ? 'show' : ''}}"
                                id="profileExample" style="">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item {{Request::routeIs('admin.countries.index') ? 'active' : ''}}">
                                        <a class="nav-link {{Request::routeIs('admin.countries.index') ? 'active' : ''}}"
                                            href="{{route('admin.countries.index')}}">
                                            <span class="sidenav-normal"> List </span>
                                        </a>
                                    </li>
                                  
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link {{Request::routeIs('admin.states.*') ? '' : 'collapsed'}}"
                                data-bs-toggle="collapse" aria-expanded="false" href="#usersExample">
                                <span class="sidenav-normal"> States <b class="caret"></b></span>
                            </a>
                            <div class="collapse {{Request::routeIs('admin.states.*') ? 'show' : ''}}"
                                id="usersExample">
                                <ul class="nav nav-sm flex-column">
                                    <li class="nav-item {{Request::routeIs('admin.states.index') ? 'active' : ''}}">
                                        <a class="nav-link {{Request::routeIs('admin.states.index') ? 'active' : ''}}"
                                            href="{{route('admin.states.index')}}">
                                            <span class="sidenav-normal"> List </span>
                                        </a>
                                    </li>
                                  
                                </ul>
                            </div>
                        </li>
                     
                    </ul>
                </div>
            </li> -->
             <li class="nav-item">
                <a data-bs-toggle="collapse" href="#settingSection"
                    class="nav-link {{Request::routeIs('admin.settings.*') ? '' : 'collapsed'}}"
                    aria-controls="settingSection" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="ni ni-app text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Settings</span>
                </a>
                <div class="collapse {{Request::routeIs('admin.settings.*') ? 'show' : ''}}" id="settingSection" style="">
                    <ul class="nav ms-4">
                        <li class="nav-item {{Request::routeIs('admin.settings.index') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.settings.index') ? 'active' : ''}}"
                                href="{{route('admin.settings.index')}}">
                                <span class="sidenav-normal"> List </span>
                            </a>
                        </li>
                        <!-- <li class="nav-item {{Request::routeIs('admin.settings.create') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.settings.create') ? 'active' : ''}}"
                                href="{{route('admin.settings.create')}}">
                                <span class="sidenav-normal"> Add Settings </span>
                            </a>
                        </li> -->
                    </ul>
                </div>
            </li>
            <!-- <li class="nav-item">
                <a data-bs-toggle="collapse" href="#languageSection"
                    class="nav-link {{Request::routeIs('admin.language.*') ? '' : 'collapsed'}}"
                    aria-controls="languageSection" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="ni ni-app text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Language</span>
                </a>
                <div class="collapse {{Request::routeIs('admin.language.*') ? 'show' : ''}}" id="languageSection" style="">
                    <ul class="nav ms-4">
                        <li class="nav-item {{Request::routeIs('admin.language.index') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.language.index') ? 'active' : ''}}"
                                href="{{route('admin.language.index')}}">
                                <span class="sidenav-normal"> List </span>
                            </a>
                        </li>
                       
                    </ul>
                </div>
            </li> -->
            
            <li class="nav-item">
                <a data-bs-toggle="collapse" href="#contactusSection"
                    class="nav-link {{Request::routeIs('admin.contact-us.*') ? 'active' : ''}}"
                    aria-controls="contactusSection" role="button" aria-expanded="false">
                    <div class="icon icon-shape icon-sm text-center d-flex align-items-center justify-content-center">
                        <i class="ni ni-air-baloon text-primary text-sm opacity-10"></i>
                    </div>
                    <span class="nav-link-text ms-1">Contact Us</span>
                </a>
                <div class="collapse {{Request::routeIs('admin.contact-us.*') ? 'show' : ''}}" id="contactusSection" style="">
                    <ul class="nav ms-4">
                        <li class="nav-item {{Request::routeIs('admin.contact-us.index') ? 'active' : ''}}">
                            <a class="nav-link {{Request::routeIs('admin.contact-us.index') ? 'active' : ''}}"
                                href="{{route('admin.contact-us.index')}}">
                                <span class="sidenav-normal"> List </span>
                            </a>
                        </li>
                       
                    </ul>
                </div>
                
            </li>
            
        </ul>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
 $(document).ready(function() {
        $(".menu-icon").click(function() {
            $("#sidenav-main").toggleClass('menu_open');
        });
        $("#iconSidenav").click(function() {
            $("#sidenav-main").removeClass('menu_open');
        });
    });
</script>
    </div>
    

</aside>