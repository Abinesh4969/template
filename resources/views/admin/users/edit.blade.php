@extends('layouts.app')

@section('content')
<!-- breadcrumb start -->
<div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
    <div class="grow">
        <h5 class="text-16">Users</h5>
    </div>
    <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
        <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1 
            before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
            <a href="{{ route('users.index') }}" class="text-slate-400 dark:text-zink-200">Users</a>
        </li>
        <li class="text-slate-700 dark:text-zink-100">
            Edit
        </li>
    </ul>
</div>
<!-- breadcrumb end -->

<div class="flex justify-center p-4 mt-2">
    <div class="w-full sm:w-full md:w-3/4 lg:w-2/3 xl:w-1/2 2xl:w-2/5">
        <div class="bg-white dark:bg-slate-900 rounded-lg shadow-lg border border-slate-200 dark:border-slate-700">
            <div class="flex items-center justify-between p-6 border-b border-slate-200 dark:border-slate-700">
                <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-100">Edit User</h2>
                <a href="{{ route('users.index') }}" 
                   class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 bg-slate-100 
                   dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 
                   border border-slate-300 dark:border-slate-600">
                    Back
                </a>
            </div>

            <form class="update-user-form" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" id="user_id" value="{{ $user->id }}">

                <div class="p-6 space-y-6">
                    <!-- Name -->
                    <div class="space-y-2">
                        <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Name
                        </label>
                        <input type="text" name="name" id="name" value="{{ $user->name }}"
                            placeholder="Enter name"
                            class="w-full px-3 py-2.5 text-sm border rounded-md transition-colors duration-200 
                            border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 
                            dark:bg-zink-700 dark:text-zink-100 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                    </div>

                    <!-- Email -->
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Email
                        </label>
                        <input type="email" name="email" id="email" value="{{ $user->email }}"
                            placeholder="Enter email"
                            class="w-full px-3 py-2.5 text-sm border rounded-md transition-colors duration-200 
                            border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 
                            dark:bg-zink-700 dark:text-zink-100 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                    </div>

                    <!-- Phone -->
                    <div class="space-y-2">
                        <label for="phone" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Phone (e.g., +91...)
                        </label>
                        <input type="text" name="phone" id="phone" value="{{ $user->phone }}"
                            placeholder="Enter phone"
                            class="w-full px-3 py-2.5 text-sm border rounded-md transition-colors duration-200 
                            border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 
                            dark:bg-zink-700 dark:text-zink-100 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                    </div>

                    <!-- Address -->
                    <div class="space-y-2">
                        <label for="address" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Address
                        </label>
                        <textarea name="address" id="address" rows="3"
                            class="w-full px-3 py-2.5 text-sm border rounded-md transition-colors duration-200 
                            border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 
                            dark:bg-zink-700 dark:text-zink-100 placeholder:text-slate-400 dark:placeholder:text-zink-200">{{ $user->address }}</textarea>
                    </div>

                    <!-- Image -->
                    <div class="space-y-2">
                        <label for="image" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                            Profile Image
                        </label>
                        <input type="file" name="image" id="image"
                            class="w-full px-3 py-2.5 text-sm border rounded-md transition-colors duration-200 
                            border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 
                            dark:bg-zink-700 dark:text-zink-100">
                        @if($user->getFirstMedia('profile_image'))
                            @php $media = $user->getFirstMedia('profile_image'); @endphp
                            <img src="{{ asset('storage/app/public/' . $media->id . '/' . $media->file_name) }}" 
                                 alt="Profile" class="mt-3 w-20 h-20 rounded-md object-cover border">
                        @endif
                    </div>
                </div>

                <div class="flex items-center justify-center p-6 border-t border-slate-200 dark:border-slate-700 
                    bg-slate-50 dark:bg-slate-800/50 rounded-b-lg">
                    <button type="submit" id="submitBtn" 
                        class="flex items-center justify-center gap-2 text-white px-6 py-2.5 text-sm font-medium 
                        rounded-md transition-all duration-200 bg-custom-500 hover:bg-custom-600 focus:ring 
                        focus:ring-custom-100 disabled:opacity-70">
                        <span id="submitLoader" class="hidden inline-block border-2 rounded-full size-4 
                        animate-spin border-l-transparent border-white"></span>
                        Update
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
    $('.update-user-form').on('submit', function (e) {
        e.preventDefault();
        $('.error-message').remove();
        $('#submitBtn').prop('disabled', true);
        $('#submitLoader').removeClass('hidden');

        let formData = new FormData(this);
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT');

        let id = $('#user_id').val();

        $.ajax({
            url: '{{ url("admin/users") }}/' + id,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#submitBtn').prop('disabled', false);
                $('#submitLoader').addClass('hidden');

                Swal.fire({
                    title: 'Updated!',
                    text: response.message || 'User updated successfully.',
                    icon: 'success',
                    customClass: {
                        confirmButton: 'text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600',
                    },
                    buttonsStyling: false,
                }).then(() => {
                    window.location.href = '{{ route("users.index") }}';
                });
            },
            error: function (response) {
                $('#submitBtn').prop('disabled', false);
                $('#submitLoader').addClass('hidden');

                if (response.status === 422) {
                    const errors = response.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        const field = $('[name="' + key + '"]');
                        if (field.length) {
                            field.after('<span class="error-message text-red-500 text-sm mt-1 block">' + value[0] + '</span>');
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.responseJSON?.message || 'Something went wrong.',
                        icon: 'error',
                        customClass: {
                            confirmButton: 'text-white btn bg-red-500 border-red-500 hover:text-white hover:bg-red-600',
                        },
                        buttonsStyling: false
                    });
                }
            }
        });
    });
});
</script>
@endPushOnce
