<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg" data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>Sign In | Aetheinfi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta content="Minimal Admin & Dashboard Template" name="description">
    <meta content="Themesdesign" name="author">
    <link rel="shortcut icon" href="{{ asset('app-assets/images/logo/darklogo.png') }}">
    <script src="{{ asset('app-assets/js/layout.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('app-assets/css/tailwind2.css') }}">
</head>

<body class="flex items-center justify-center min-h-screen px-4 py-16 bg-cover bg-auth-pattern dark:bg-auth-pattern-dark dark:text-zink-100 font-public">

<div class="mb-0 border-none shadow-none xl:w-2/3 card bg-white/70 dark:bg-zink-500/70">
    <div class="grid grid-cols-1 gap-0 lg:grid-cols-12">
        <div class="lg:col-span-5">
            <div class="!px-12 !py-12 card-body">
                <div class="text-center">
                    <h4 class="mb-2 text-purple-500 dark:text-purple-500">Welcome Back !</h4>
                    <p class="text-slate-500 dark:text-zink-200">Sign in to continue</p>
                </div>

                <!-- Laravel Login Form -->
                <form method="POST" action="{{ route('login') }}" class="mt-10">
                    @csrf

                    <!-- Session Status -->
                    @if (session('status'))
                        <div class="px-4 py-3 mb-3 text-sm text-green-500 border border-green-200 rounded-md bg-green-50 dark:bg-green-400/20 dark:border-green-500/50">
                            {{ session('status') }}
                        </div>
                    @endif

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="inline-block mb-2 text-base font-medium">Email</label>
                        <input type="email" name="email" id="email"
                               value="{{ old('email') }}"
                               required autofocus autocomplete="username"
                               class="form-input dark:bg-zink-600/50 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500
                               dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                        @error('email')
                            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="inline-block mb-2 text-base font-medium">Password</label>
                        <input type="password" name="password" id="password"
                               required autocomplete="current-password"
                               class="form-input dark:bg-zink-600/50 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500
                               dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                        @error('password')
                            <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center gap-2 mt-4">
                        <input id="remember_me" type="checkbox" name="remember"
                               class="border rounded-sm appearance-none size-4 bg-slate-100 border-slate-200
                               dark:bg-zink-600/50 dark:border-zink-500 checked:bg-custom-500 checked:border-custom-500">
                        <label for="remember_me" class="inline-block text-base font-medium align-middle cursor-pointer">
                            Remember me
                        </label>
                    </div>

                    <!-- Forgot Password -->
                    <div class="flex items-center justify-between mt-6">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               class="text-sm text-gray-600 underline hover:text-gray-900 dark:hover:text-custom-500">
                                Forgot your password?
                            </a>
                        @endif
                    </div>

                    <!-- Submit -->
                    <div class="mt-10">
                        <button type="submit"
                                class="w-full text-white btn bg-custom-500 border-custom-500 hover:bg-custom-600 hover:border-custom-600">
                            Sign In
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Side Image / Branding -->
        <div class="mx-2 mt-2 mb-2 border-none shadow-none lg:col-span-7 card bg-white/60 dark:bg-zink-500/60">
            <div class="!px-10 !pt-10 h-full !pb-0 card-body flex flex-col">
                <div class="flex items-center justify-between gap-3">
                    <div class="grow">
                        <a href="/">
                            <img src="{{ asset('app-assets/images/logo/lightlogo.png') }}" style="" alt="" class="hidden h-32 dark:block">
                            <img src="{{ asset('app-assets/images/logo/darklogo.png') }}" alt="" class="block h-32 dark:hidden">
                        </a>
                    </div>
                </div>
                <!-- <div class="mt-auto">
                    <img src="{{ asset('app-assets/images/img-01.png') }}" alt="" class="md:max-w-[32rem] mx-auto">
                </div> -->
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('app-assets/libs/choices.js/public/assets/scripts/choices.min.js') }}"></script>
<script src="{{ asset('app-assets/libs/@popperjs/core/umd/popper.min.js') }}"></script>
<script src="{{ asset('app-assets/libs/tippy.js/tippy-bundle.umd.min.js') }}"></script>
<script src="{{ asset('app-assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('app-assets/libs/prismjs/prism.js') }}"></script>
<script src="{{ asset('app-assets/libs/lucide/umd/lucide.js') }}"></script>
<script src="{{ asset('app-assets/js/tailwick.bundle.js') }}"></script>
<script src="{{ asset('app-assets/js/pages/auth-login.init.js') }}"></script>

</body>
</html>
