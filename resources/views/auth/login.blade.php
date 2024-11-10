<x-admin-layout>
    <!-- Session Status -->
    <main class="main-content  mt-0">
        <section>
            <div class="page-header min-vh-100">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-7 d-flex flex-column mx-lg-0 mx-auto">
                            <div class="card card-plain login_s">
                                <div class="card-header pb-0 text-start">
                                    <h4 class="font-weight-bolder">Sign In</h4>
                                    <p class="mb-0">Enter your email and password to sign in</p>
                                </div>
                                <div class="card-body">
                                    <x-auth-session-status class="mb-4" :status="session('status')" />
                                    <form method="POST" role="form" action="{{ route('login') }}">
                                        @csrf
                                        <div class="mb-4">
                                            <!-- Email Address -->
                                            <div>
                                                <x-input-label for="email" :value="__('Email')" />
                                                <x-text-input id="email"
                                                    class="block mt-1 w-full form-control form-control-lg" type="email"
                                                    name="email" :value="old('email')" required autofocus
                                                    autocomplete="username" />
                                                <x-input-error :messages="$errors->get('email')" class="error_message" />
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <x-input-label for="password" :value="__('Password')" />

                                            <x-text-input id="password"
                                                class="block mt-1 w-full form-control form-control-lg" type="password"
                                                name="password" required autocomplete="current-password" />

                                            <x-input-error :messages="$errors->get('password')" class="error_message" />
                                        </div>
                                        <!-- <div class="form-check form-switch">
                                            <label for="remember_me" class="inline-flex items-center">
                                                <input id="remember_me" type="checkbox"
                                                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
                                                    name="remember">
                                                <span
                                                    class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                                            </label>
                                        </div> -->
                                        <div class="text-center">
                                            {{-- @if (Route::has('password.request'))
                                            <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                                                href="{{ route('password.request') }}">
                                            {{ __('Forgot your password?') }}
                                            </a>
                                            @endif --}}
                                            <button type="submit" class="btn btn-lg btn-primary btn-lg w-100 mt-1 mb-0 mt-0">{{ __('Log in') }}</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div
                            class="col-6 d-lg-flex d-none h-100 my-auto pe-0 position-absolute top-0 end-0 text-center justify-content-center flex-column">
                            <div class="position-relative bg-gradient-primary h-100 m-3 px-7 border-radius-lg d-flex flex-column justify-content-center overflow-hidden"
                                style="background-image: url('{{asset('img/signin-ill.jpg')}}');
          background-size: cover;">
                                <span class="mask bg-gradient-primary opacity-6"></span>
                                <h4 class="mt-5 text-white font-weight-bolder position-relative">"Attention is the new
                                    currency"</h4>
                                <p class="text-white position-relative">The more effortless the writing looks, the more
                                    effort the writer actually put into the process.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</x-admin-layout>