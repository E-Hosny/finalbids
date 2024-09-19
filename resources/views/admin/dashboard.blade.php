<style type="text/css">
     nav[aria-label="breadcrumb"] ol {
    display: none;
}
</style>
<x-admin-layout>
    <main class="main-content position-relative border-radius-lg ">
        @include('admin.include.navbar')
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card dashboard_itm">
                        <div class="card-body p-3">
                        <a href="{{route('admin.users.index')}}">
                            <div class="row">
                                <div class="col-8">
                                    <div class="numbers">
                                    <h6 class="text-sm mb-0 text-uppercase font-weight-bold">No of Users</h6>  
                                   <h5 class="font-weight-bolder">
                                           {{$users}}
                                        </h5>
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-primary shadow-primary text-center rounded-circle">
                                        <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                               
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card dashboard_itm">
                        <div class="card-body p-3">
                        <a href="{{route('admin.projects.index')}}">
                            <div class="row">
                              
                                <div class="col-8">
                                    <div class="numbers">
                                        <h6 class="text-sm mb-0 text-uppercase font-weight-bold">No Of Projects</h6>
                                         <h5 class="font-weight-bolder">
                                           {{$projects}}
                                        </h5>
                                        
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-danger shadow-danger text-center rounded-circle">
                                        <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                               
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
                    <div class="card dashboard_itm">
                        <div class="card-body p-3">
                        <a href="{{route('admin.products.index')}}">
                            <div class="row">
                            
                                <div class="col-8">
                                    <div class="numbers">
                                        <h6 class="text-sm mb-0 text-uppercase font-weight-bold">No Of Products</h6>
                                       <h5 class="font-weight-bolder">
                                           {{$products}}
                                        </h5>  
                                      
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-success shadow-success text-center rounded-circle">
                                        <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                              
                            </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-sm-6">
                    <div class="card dashboard_itm">
                        <div class="card-body p-3">
                            <div class="row">
                            <a href="{{route('admin.categories.index')}}">
                                <div class="col-8">
                                    <div class="numbers">
                                        <h6 class="text-sm mb-0 text-uppercase font-weight-bold">Categories</h6>
                                       <h5 class="font-weight-bolder">
                                           {{$cats}}
                                        </h5></a>
                                      
                                    </div>
                                </div>
                                <div class="col-4 text-end">
                                    <div
                                        class="icon icon-shape bg-gradient-warning shadow-warning text-center rounded-circle">
                                        <i class="ni ni-cart text-lg opacity-10" aria-hidden="true"></i>
                                    </div>
                                </div>
                            </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-admin-layout>