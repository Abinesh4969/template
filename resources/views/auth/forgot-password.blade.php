<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light" data-sidebar-size="lg" data-mode="light" data-topbar="light" data-skin="default" data-navbar="sticky" data-content="fluid" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Forgot Password | Aetheinfi - Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta content="Minimal Admin & Dashboard Template" name="description">
    <meta content="Themesdesign" name="author">
    <link rel="shortcut icon" href="{{ asset('app-assets/images/favicon.ico') }}">
    <script src="{{ asset('app-assets/js/layout.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('app-assets/css/tailwind2.css') }}">
</head>

<body class="flex items-center justify-center min-h-screen px-4 py-16 bg-cover bg-auth-pattern dark:bg-auth-pattern-dark dark:text-zink-100 font-public">

    <div class="mb-0 border-none shadow-none xl:w-2/3 card bg-white/70 dark:bg-zink-500/70">
        <div class="grid grid-cols-1 gap-0 lg:grid-cols-12">
            <div class="lg:col-span-5">
                <div class="!px-12 !py-12 card-body h-full flex flex-col">

                    <div class="my-auto">
                        <div class="text-center">
                            <h4 class="mb-2 text-custom-500 dark:text-custom-500">Forgot Password?</h4>
                            <p class="mb-8 text-slate-500 dark:text-zink-200">Reset your Aetheinfi password</p>
                        </div>

                        {{-- Session Status --}}
                        @if (session('status'))
                            <div class="px-4 py-3 mb-6 text-sm text-green-500 border border-transparent rounded-md bg-green-50 dark:bg-green-400/20">
                                {{ session('status') }}
                            </div>
                        @endif

                        {{-- Info Message --}}
                        <div class="px-4 py-3 mb-6 text-sm text-yellow-500 border border-transparent rounded-md bg-yellow-50 dark:bg-yellow-400/20">
                            Provide your email address, and instructions will be sent to you
                        </div>

                        <form method="POST" action="{{ route('password.email') }}" autocomplete="off">
                            @csrf

                            <div>
                                <label for="email" class="inline-block mb-2 text-base font-medium">Email</label>
                                <input type="email" 
                                       name="email" 
                                       id="email" 
                                       value="{{ old('email') }}" 
                                       class="form-input dark:bg-zink-600/50 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" 
                                       required 
                                       autofocus 
                                       placeholder="Enter email">
                                @error('email')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-8">
                                <button type="submit" 
                                        class="w-full text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                    Send Reset Link
                                </button>
                            </div>

                            <div class="mt-4 text-center">
                                <p class="mb-0">Wait, I remember my password... 
                                    <a href="{{ route('login') }}" class="underline fw-medium text-custom-500"> Click here </a> 
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Right Side Image / Branding --}}
            <div class="mx-2 mt-2 mb-2 border-none shadow-none lg:col-span-7 card bg-white/60 dark:bg-zink-500/60">
                <div class="!px-10 !pt-10 h-full !pb-0 card-body flex flex-col">
                    <div class="flex items-center justify-between gap-3">
                        <div class="grow">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('app-assets/images/logo-light.png') }}" alt="" class="hidden h-6 dark:block">
                                <img src="{{ asset('app-assets/images/logo-dark.png') }}" alt="" class="block h-6 dark:hidden">
                            </a>
                        </div>
                    </div>
                    <div class="mt-auto">
                        <img src="{{ asset('app-assets/images/img-01.png') }}" alt="" class="md:max-w-[32rem] mx-auto">
                    </div>
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
