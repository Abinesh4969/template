@extends('layouts.app')

@section('content')
<!-- bread crumb start-->
<div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
    <div class="grow">
        <h5 class="text-16">Users</h5>
    </div>
    <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
        <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1 before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
            <a href="{{ route('users.index') }}" class="text-slate-400 dark:text-zink-200">Users</a>
        </li>
        <li class="text-slate-700 dark:text-zink-100">Create</li>
    </ul>
</div>
<!-- bread crumb End -->

<div class="flex justify-center p-4 mt-2">
    <div class="w-full sm:w-full md:w-3/4 lg:w-2/3 xl:w-1/2 2xl:w-2/5">
        <div class="bg-white dark:bg-slate-900 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700">
            
            <!-- Header -->
            <div class="flex items-center justify-between p-6 border-b border-slate-200 dark:border-slate-700">
                <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-100">Create User</h2>
                <a href="{{ route('users.index') }}" 
                   class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 border border-slate-300 dark:border-slate-600">
                    Back
                </a>
            </div>

            <!-- Form -->
            <form class="add-user-form" enctype="multipart/form-data">
                @csrf
                <div class="p-6 space-y-6">
                    <!-- Two column grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Name -->
                        <div class="space-y-2">
                            <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Name</label>
                            <input type="text" id="name" name="name" placeholder="Enter name"
                                class="w-full px-3 py-2.5 text-sm border rounded-md border-slate-200 dark:border-zink-500 focus:border-custom-500 dark:bg-zink-700 dark:text-zink-100">
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                            <input type="email" id="email" name="email" placeholder="Enter email"
                                class="w-full px-3 py-2.5 text-sm border rounded-md border-slate-200 dark:border-zink-500 focus:border-custom-500 dark:bg-zink-700 dark:text-zink-100">
                        </div>

                        <!-- Phone -->
                        <div class="space-y-2">
                            <label for="phone" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Phone</label>
                            <input type="text" id="phone" name="phone" placeholder="Enter phone"
                                class="w-full px-3 py-2.5 text-sm border rounded-md border-slate-200 dark:border-zink-500 focus:border-custom-500 dark:bg-zink-700 dark:text-zink-100">
                        </div>

                        <!-- Password -->
                        <div class="space-y-2">
                            <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
                            <input type="password" id="password" name="password" placeholder="Enter password"
                                class="w-full px-3 py-2.5 text-sm border rounded-md border-slate-200 dark:border-zink-500 focus:border-custom-500 dark:bg-zink-700 dark:text-zink-100">
                        </div>

                        <!-- Image -->
                        <div class="space-y-2">
                            <label for="image" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Image
                            </label>
                            <input type="file" id="image" name="image"
                                class="block w-full text-xs text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 
                                    dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400">
                        </div>

                        <!-- Unique Code -->
                        <div class="space-y-2">
                            <label for="unique_code" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Unique Code</label>
                            <input type="text" id="unique_code" name="unique_code" placeholder="Enter unique code"
                                class="w-full px-3 py-2.5 text-sm border rounded-md border-slate-200 dark:border-zink-500 focus:border-custom-500 dark:bg-zink-700 dark:text-zink-100">
                        </div>

                        <!-- Date of Birth -->
                        <div class="space-y-2">
                            <label for="dob" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Date of Birth</label>
                            <input type="date" id="dob" name="dob"
                                class="w-full px-3 py-2.5 text-sm border rounded-md border-slate-200 dark:border-zink-500 focus:border-custom-500 dark:bg-zink-700 dark:text-zink-100">
                        </div>

                        <!-- Gender -->
                        <div class="space-y-2">
                            <label for="gender" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Gender</label>
                            <select id="gender" name="gender"
                                class="w-full px-3 py-2.5 text-sm border rounded-md border-slate-200 dark:border-zink-500 focus:border-custom-500 dark:bg-zink-700 dark:text-zink-100">
                                <option value="">-- Select Gender --</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="other">Other</option>
                            </select>
                        </div>

                        <!-- Nationality -->
                        <div class="space-y-2">
                            <label for="nationality" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Nationality</label>
                            <input type="text" id="nationality" name="nationality" placeholder="Enter nationality"
                                class="w-full px-3 py-2.5 text-sm border rounded-md border-slate-200 dark:border-zink-500 focus:border-custom-500 dark:bg-zink-700 dark:text-zink-100">
                        </div>

                        <!-- Country of Residence -->
                        <div class="space-y-2">
                            <label for="country_of_residence" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Country of Residence</label>
                            <input type="text" id="country_of_residence" name="country_of_residence" placeholder="Enter country"
                                class="w-full px-3 py-2.5 text-sm border rounded-md border-slate-200 dark:border-zink-500 focus:border-custom-500 dark:bg-zink-700 dark:text-zink-100">
                        </div>

                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex items-center justify-center p-6 border-t border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 rounded-b-lg">
                    <button type="submit" id="submitBtn" 
                        class="flex items-center justify-center gap-2 text-white px-6 py-2.5 text-sm font-medium rounded-md transition-all duration-200 bg-custom-500 hover:bg-custom-600 focus:ring focus:ring-custom-100 disabled:opacity-70">
                        <span id="submitLoader" class="hidden inline-block border-2 rounded-full size-4 animate-spin border-l-transparent border-white"></span>
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@pushOnce('script')
<script>
$(document).ready(function () {
    $('#email').on('input', function () {
        this.value = this.value.toLowerCase();
    });

    $('.add-user-form').on('submit', function(e) {
        e.preventDefault();
        $('.error-message').remove();
        $('#submitBtn').prop('disabled', true);
        $('#submitLoader').removeClass('hidden');

        let formData = new FormData(this);

        formData.append('role', 'user');
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            type: 'POST',
            url: '{{ route("users.store") }}',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#submitBtn').prop('disabled', false);
                $('#submitLoader').addClass('hidden');
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'User created successfully',
                }).then(() => {
                    window.location.href = "{{ route('users.index') }}";
                });
            },
            error: function(xhr) {
                $('#submitBtn').prop('disabled', false);
                $('#submitLoader').addClass('hidden');

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    for (const [key, messages] of Object.entries(errors)) {
                        let input = $('[name="' + key + '"]');
                        if (input.length) {
                            input.after(`<span class="error-message text-red-500 text-sm mt-1 block">${messages[0]}</span>`);
                        }
                    }
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Something went wrong. Please try again later.',
                    });
                }
            }
        });
    });
});
</script>
@endPushOnce
