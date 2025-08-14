<!DOCTYPE html>
<html lang="en" class="light scroll-smooth group">

<head>
    <meta charset="utf-8">
    <title>Register | Aetheinfi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Aetheinfi Registration" name="description">
    <meta content="Themesdesign" name="author">
  <link rel="shortcut icon" href="{{ asset('app-assets/images/favicon.ico') }}">
    <script src="{{ asset('app-assets/js/layout.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('app-assets/css/tailwind2.css') }}">
</head>

<body class="flex items-center justify-center min-h-screen px-4 py-16 bg-cover bg-auth-pattern dark:bg-auth-pattern-dark dark:text-zink-100 font-public">

    <div class="mb-0 border-none shadow-none xl:w-2/3 card bg-white/70 dark:bg-zink-500/70">
        <div class="grid grid-cols-1 gap-0 lg:grid-cols-12">
            <!-- Registration Form -->
            <div class="lg:col-span-5">
                <div class="!px-10 !py-12 card-body">
                    <h2 class="mb-6 text-2xl font-bold text-center text-slate-700 dark:text-zink-100">Create Your Account</h2>

                    <form method="POST" action="#">
                        @csrf

                        <!-- Name -->
                        <div class="mb-4">
                            <label for="name" class="inline-block mb-2 text-base font-medium">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                                class="form-input dark:bg-zink-600/50 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:focus:border-custom-500 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            @error('name')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="inline-block mb-2 text-base font-medium">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                                class="form-input dark:bg-zink-600/50 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:focus:border-custom-500 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            @error('email')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label for="password" class="inline-block mb-2 text-base font-medium">Password</label>
                            <input type="password" id="password" name="password" required autocomplete="new-password"
                                class="form-input dark:bg-zink-600/50 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:focus:border-custom-500 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            @error('password')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-4">
                            <label for="password_confirmation" class="inline-block mb-2 text-base font-medium">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                                class="form-input dark:bg-zink-600/50 border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:focus:border-custom-500 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            @error('password_confirmation')
                                <div class="mt-1 text-sm text-red-500">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Terms & Submit -->
                        <p class="italic text-15 text-slate-500 dark:text-zink-200 mb-6">
                            By registering you agree to the Aetheinfi <a href="#" class="underline">Terms of Use</a>.
                        </p>

                        <div>
                            <button type="submit"
                                class="w-full text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:ring focus:ring-custom-100 active:ring active:ring-custom-100">
                                Register
                            </button>
                        </div>
                    </form>

                    <div class="mt-8 text-center">
                        <p class="text-slate-500 dark:text-zink-200">
                            Already have an account? 
                            <a href="{{ route('login') }}"
                                class="font-semibold underline text-custom-500 hover:text-custom-600">
                                Login
                            </a>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Right Side Illustration -->
            <div class="mx-2 mt-2 mb-2 border-none shadow-none lg:col-span-7 card bg-white/60 dark:bg-zink-500/60">
                <div class="!px-10 !pt-10 h-full !pb-0 card-body flex flex-col">
                    <div class="flex items-center justify-between gap-3">
                        <div class="grow">
                            <a href="/">         
                                <img src="{{ asset('app-assets/images/logo-light.png') }}" alt="Logo" class="hidden h-6 dark:block">
                                <img src="{{ asset('app-assets/images/logo-dark.png') }}" alt="Logo" class="block h-6 dark:hidden">
                            </a>
                        </div>
                        <!-- Language dropdown (optional) -->
                    </div>
                    <div class="mt-auto">
                        
                        <img src="{{ asset('app-assets/images/img-01.png') }}" alt="" class="md:max-w-[32rem] mx-auto">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->

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
