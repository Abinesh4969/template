@extends('layouts.app')

@section('content')
<!-- Bread crumb start -->
<div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
    <div class="grow">
        <h5 class="text-16">Users</h5>
    </div>
    <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
        <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  
            before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 
            before:text-slate-400 dark:text-zink-200">
            <a href="{{ route('users.index') }}" class="text-slate-400 dark:text-zink-200">Users</a>
        </li>
        <li class="text-slate-700 dark:text-zink-100">Edit</li>
    </ul>
</div>
<!-- Bread crumb End -->

<!-- Wrapper -->
<div class="flex justify-center p-5 mt-2">
    <div class="w-full sm:w-full md:w-3/4 lg:w-2/3 xl:w-1/2 2xl:w-2/5">
        <div class="card">
            <div class="card-header">
                <div class="flex items-center justify-between p-6 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-100">Edit User</h2>
                    <a href="{{ route('users.index') }}" 
                        class="text-white btn bg-slate-500 border-slate-500 hover:text-white hover:bg-slate-600 
                        hover:border-slate-600 focus:text-white focus:bg-slate-600 focus:border-slate-600 
                        focus:ring focus:ring-slate-100 active:text-white active:bg-slate-600 
                        active:border-slate-600 active:ring active:ring-slate-100 dark:ring-slate-400/10">
                        Back
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form class="update-user-form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="user_id" value="{{ $user->id }}">

                    <div class="p-6 space-y-6">

                        <!-- Row 1: Name + Email -->
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="w-full">
                                <label for="name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Name</label>
                                <input type="text" id="name" name="name" value="{{ $user->name }}" placeholder="Enter name"
                                    class="form-input w-full bg-white border-slate-200 dark:border-zink-500 focus:outline-none 
                                    focus:border-custom-500 dark:bg-zink-700 dark:text-zink-100 
                                    placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            </div>
                            <div class="w-full">
                                <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email</label>
                                <input type="email" id="email" name="email" value="{{ $user->email }}" placeholder="Enter email"
                                    class="form-input w-full bg-white border-slate-200 dark:border-zink-500 focus:outline-none 
                                    focus:border-custom-500 dark:bg-zink-700 dark:text-zink-100 
                                    placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            </div>
                        </div>

                        <!-- Row 2: Phone + Password -->
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="w-full">
                                <label for="phone" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Phone</label>
                                <input type="text" id="phone" name="phone" value="{{ $user->phone }}" placeholder="Enter phone"
                                    class="form-input w-full bg-white border-slate-200 dark:border-zink-500 focus:outline-none 
                                    focus:border-custom-500 dark:bg-zink-700 dark:text-zink-100 
                                    placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            </div>
                            <div class="w-full">
                                <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
                                <input type="password" id="password" name="password" placeholder="Enter new password"
                                    class="form-input w-full bg-white border-slate-200 dark:border-zink-500 focus:outline-none 
                                    focus:border-custom-500 dark:bg-zink-700 dark:text-zink-100 
                                    placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            </div>
                        </div>

                        <!-- Row 3: Unique Code + Gender -->
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="w-full">
                                <label for="unique_code" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Unique Code</label>
                                <input type="text" id="unique_code" name="unique_code" value="{{ $user->unique_code }}" placeholder="Enter unique code"
                                    class="form-input w-full bg-white border-slate-200 dark:border-zink-500 focus:outline-none 
                                    focus:border-custom-500 dark:bg-zink-700 dark:text-zink-100 
                                    placeholder:text-slate-400 dark:placeholder:text-zink-200">
                            </div>
                            <div class="w-full">
                                <label for="gender" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Gender</label>
                                <select id="gender" name="gender"
                                    class="form-select w-full bg-white border-slate-200 dark:border-zink-500 focus:outline-none 
                                    focus:border-custom-500 dark:bg-zink-700 dark:text-zink-100">
                                    <option value="">-- Select Gender --</option>
                                    <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ $user->gender == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 4: Image + Status -->
                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="w-full">
                                <label for="image" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Profile Image @if($user->getFirstMedia('profile_image'))
                                    @php $media = $user->getFirstMedia('profile_image'); @endphp
                                   (<a target="_blank" href="{{ asset('storage/app/public/' . $media->id . '/' . $media->file_name) }}">view</a>)
                                    @endif</label>
                                <input type="file" id="image" name="image"
                                    class="form-input w-full bg-white border-slate-200 dark:border-zink-500 focus:outline-none 
                                    focus:border-custom-500 dark:bg-zink-700 dark:text-zink-100 file:mr-4 file:py-2 file:px-4 
                                    file:rounded file:border-0 file:text-sm file:font-semibold 
                                    file:bg-custom-500 file:text-white hover:file:bg-custom-600">
                               
                            </div>
                        </div>
                        
                        <!-- Submit -->
                        <div class="flex justify-center mt-6">
                            <button type="submit" id="submitBtn" 
                                class="flex items-center justify-center gap-2 text-white px-6 py-2.5 text-sm font-medium 
                                rounded-md transition-all duration-200 bg-custom-500 hover:bg-custom-600 
                                focus:ring focus:ring-custom-100 disabled:opacity-70">
                                <span id="submitLoader" class="hidden inline-block border-2 rounded-full size-4 animate-spin 
                                border-l-transparent border-white"></span>
                                Update
                            </button>
                        </div>
                    </div>
                </form>
            </div>
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

    $('.update-user-form').on('submit', function(e) {
        e.preventDefault();
        $('.error-message').remove();
        $('#submitBtn').prop('disabled', true);
        $('#submitLoader').removeClass('hidden');

        let formData = new FormData(this);
        formData.append('status', $('#status').is(':checked') ? 1 : 0);
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT');

        let id = $('#user_id').val();

        $.ajax({
            url: '{{ url("admin/users") }}/' + id,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
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
                    window.location.href = "{{ route('users.index') }}";
                });
            },
            error: function(xhr) {
                $('#submitBtn').prop('disabled', false);
                $('#submitLoader').addClass('hidden');

                if (xhr.status === 422) {
                    $.each(xhr.responseJSON.errors, function(key, value) {
                        const field = $('[name="' + key + '"]');
                        if (field.length) {
                            field.after('<span class="error-message text-red-500 text-sm mt-1 block">' + value[0] + '</span>');
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: xhr.responseJSON?.message || 'Something went wrong. Please try again.',
                        icon: 'error',
                        confirmButtonText: 'Try Again'
                    });
                }
            }
        });
    });
});
</script>
@endPushOnce
