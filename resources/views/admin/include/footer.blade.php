@if (Auth::check())
<footer class="footer pt-3">
    <div class="container-fluid">
        <x-slot name="footer">
            <div class="row align-items-center justify-content-lg-between">
                <div class="col-lg-6 mb-lg-0 mb-4">
                    <div class="copyright text-center text-sm text-muted text-lg-start">
                        © <script>
                        document.write(new Date().getFullYear())
                        </script>,
                        made with <i class="fa fa-heart"></i> by
                        <a href="https://www.jploft.com/" class="font-weight-bold" target="_blank">Jploft</a>
                        for a better web.
                    </div>
                </div>
                <div class="col-lg-6">
                    <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                        <li class="nav-item">
                            <a href="https://www.jploft.com/" class="nav-link text-muted" target="_blank">Jploft</a>
                        </li>
                        <li class="nav-item">
                            <a href="https://www.jploft.com/about-us" class="nav-link text-muted" target="_blank">About
                                Us</a>
                        </li>
                    </ul>
                </div>
            </div>
        </x-slot>
    </div>
</footer>
@endif