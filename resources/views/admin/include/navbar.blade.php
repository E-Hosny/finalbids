        <!-- Navbar -->
    <style>
     .testlang{
        width:8rem;
     }

    </style>
        <nav class="navbar navbar-main navbar-expand-lg px-0 shadow-none border-radius-xl " id="navbarBlur"
            data-scroll="false">
            <div class="container-fluid">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
                        <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white"
                                href="{{route('admin.dashboard')}}">Dashboard</a></li>
                        <li class="breadcrumb-item text-sm text-white active" aria-current="page">
                            <a href="{{route($link ?? 'admin.dashboard')}}">{{$module ?? "Dashboard"}}</a>
                        </li>
                    </ol>
                    <h6 class="font-weight-bolder text-white mb-0">{{$page ?? "Dashboard"}}</h6>
                </nav>
                  <div class="menu-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M128 102.4c0-14.138 11.462-25.6 25.6-25.6h332.8c14.138 0 25.6 11.462 25.6 25.6S500.538 128 486.4 128H153.6c-14.138 0-25.6-11.463-25.6-25.6zm358.4 128H25.6C11.462 230.4 0 241.863 0 256c0 14.138 11.462 25.6 25.6 25.6h460.8c14.138 0 25.6-11.462 25.6-25.6 0-14.137-11.462-25.6-25.6-25.6zm0 153.6H256c-14.137 0-25.6 11.462-25.6 25.6 0 14.137 11.463 25.6 25.6 25.6h230.4c14.138 0 25.6-11.463 25.6-25.6 0-14.138-11.462-25.6-25.6-25.6z" fill="#ffffff" opacity="1" data-original="#000000" class=""></path></g></svg>
                        </div>
                <div class="navbar_righr" id="navbar">
                    <div class="ms-md-auto pe-md-3 d-flex align-items-center">
                    </div>
                    <ul class="navbar-nav  justify-content-end">
                      
                        <!-- <li class="nav-item dropdown pe-2 d-flex align-items-center">
                            <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-bell cursor-pointer"></i>
                            </a>
                            <ul class="dropdown-menu  dropdown-menu-end  px-2 py-3 me-sm-n4"
                                aria-labelledby="dropdownMenuButton">
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="{{asset('img/team-2.jpg')}}" class="avatar avatar-sm  me-3 ">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New message</span> from Laur
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    13 minutes ago
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="mb-2">
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="my-auto">
                                                <img src="{{asset('img/small-logos/logo-spotify.svg')}}"
                                                    class="avatar avatar-sm bg-gradient-dark  me-3 ">
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    <span class="font-weight-bold">New album</span> by Travis Scott
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    1 day
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item border-radius-md" href="javascript:;">
                                        <div class="d-flex py-1">
                                            <div class="avatar avatar-sm bg-gradient-secondary  me-3  my-auto">
                                                <svg width="12px" height="12px" viewBox="0 0 43 36" version="1.1"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    xmlns:xlink="http://www.w3.org/1999/xlink">
                                                    <title>credit-card</title>
                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                        <g transform="translate(-2169.000000, -745.000000)"
                                                            fill="#FFFFFF" fill-rule="nonzero">
                                                            <g transform="translate(1716.000000, 291.000000)">
                                                                <g transform="translate(453.000000, 454.000000)">
                                                                    <path class="color-background"
                                                                        d="M43,10.7482083 L43,3.58333333 C43,1.60354167 41.3964583,0 39.4166667,0 L3.58333333,0 C1.60354167,0 0,1.60354167 0,3.58333333 L0,10.7482083 L43,10.7482083 Z"
                                                                        opacity="0.593633743"></path>
                                                                    <path class="color-background"
                                                                        d="M0,16.125 L0,32.25 C0,34.2297917 1.60354167,35.8333333 3.58333333,35.8333333 L39.4166667,35.8333333 C41.3964583,35.8333333 43,34.2297917 43,32.25 L43,16.125 L0,16.125 Z M19.7083333,26.875 L7.16666667,26.875 L7.16666667,23.2916667 L19.7083333,23.2916667 L19.7083333,26.875 Z M35.8333333,26.875 L28.6666667,26.875 L28.6666667,23.2916667 L35.8333333,23.2916667 L35.8333333,26.875 Z">
                                                                    </path>
                                                                </g>
                                                            </g>
                                                        </g>
                                                    </g>
                                                </svg>
                                            </div>
                                            <div class="d-flex flex-column justify-content-center">
                                                <h6 class="text-sm font-weight-normal mb-1">
                                                    Payment successfully completed
                                                </h6>
                                                <p class="text-xs text-secondary mb-0">
                                                    <i class="fa fa-clock me-1"></i>
                                                    2 days
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </li> -->
                        <li>
                        <!-- <div class="col-md-6 testlang">
                        <select class="form-select changeLang">
                            <option value="en" {{ session()->get('locale') == 'en' ? 'selected' : '' }}>English</option>
                            <option value="ar" {{ session()->get('locale') == 'ar' ? 'selected' : '' }}>Arabic</option>
                            
                        </select>
                       </div> -->
                      </li>
                        <li class="nav-item d-flex nav_admin align-items-center">
                           <!-- <x-dropdown-link :href="route('admin.profilesetting')" class="log_out">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22">
                                          <path id="setting" d="M44.109,21.118a2.239,2.239,0,0,1,0-4,1.616,1.616,0,0,0,.768-2.073,10.8,10.8,0,0,0-1.679-2.741,1.848,1.848,0,0,0-2.3-.413,2.6,2.6,0,0,1-2.458,0,2.289,2.289,0,0,1-1.224-2,1.7,1.7,0,0,0-1.529-1.663,12.415,12.415,0,0,0-3.367,0A1.7,1.7,0,0,0,30.8,9.9a2.293,2.293,0,0,1-1.226,2,2.6,2.6,0,0,1-2.458,0,1.848,1.848,0,0,0-2.3.414,11.083,11.083,0,0,0-.945,1.312,10.9,10.9,0,0,0-.735,1.424,1.618,1.618,0,0,0,.766,2.077,2.239,2.239,0,0,1,0,4,1.616,1.616,0,0,0-.768,2.073,10.778,10.778,0,0,0,1.679,2.741,1.848,1.848,0,0,0,2.3.413,2.6,2.6,0,0,1,2.458,0,2.3,2.3,0,0,1,1.226,2,1.7,1.7,0,0,0,1.527,1.663,12.417,12.417,0,0,0,3.367,0,1.7,1.7,0,0,0,1.527-1.661,2.286,2.286,0,0,1,1.224-2,2.6,2.6,0,0,1,2.458,0,1.847,1.847,0,0,0,2.3-.414,11.148,11.148,0,0,0,.945-1.311,10.876,10.876,0,0,0,.735-1.424,1.617,1.617,0,0,0-.765-2.076Zm-7.093-.365A3.425,3.425,0,0,1,34.9,22.276a3.644,3.644,0,0,1-2.637-.327,3.167,3.167,0,0,1-1.272-4.464,3.525,3.525,0,0,1,3.016-1.633,3.622,3.622,0,0,1,1.732.437,3.167,3.167,0,0,1,1.272,4.464Z" transform="translate(-23.005 -8.119)" fill="#fff" fill-rule="evenodd"/>
                                        </svg>
                                </x-dropdown-link> -->
                            <form method="POST" class="nav-link text-white font-weight-bold px-0"
                                action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')" class="log_out" onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22">
                                      <g id="layer1" transform="translate(-0.529 -291.179)">
                                        <path id="path52" d="M11.517,291.179a1.1,1.1,0,0,0-1.089,1.118v8.842a1.1,1.1,0,1,0,2.2,0V292.3a1.1,1.1,0,0,0-1.113-1.118Zm6.418,2.216a1.06,1.06,0,0,0-.107,0,1.106,1.106,0,0,0-.61,1.951,8.8,8.8,0,1,1-11.409.032,1.109,1.109,0,0,0,.122-1.558A1.1,1.1,0,0,0,4.38,293.7a11.082,11.082,0,0,0,7.155,19.479,11.082,11.082,0,0,0,7.106-19.512,1.1,1.1,0,0,0-.7-.272Z" transform="translate(0 0)" fill="#fff"/>
                                      </g>
                                    </svg>
                                </x-dropdown-link>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


    <script type="text/javascript">
    
    var url = "{{ route('changeLang') }}";
    
    $(".changeLang").change(function(){
        window.location.href = url + "?lang="+ $(this).val();
    });
    
</script>
        
        <!-- End Navbar -->