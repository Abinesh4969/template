@extends('layouts.app')

@section('content')
<!-- bread crumb start-->
<div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
    <div class="grow">
        <h5 class="text-16">Districts</h5>
    </div>
    <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
        <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  
            before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 
            before:text-slate-400 dark:text-zink-200">
            <a href="{{ route('districts.index') }}" class="text-slate-400 dark:text-zink-200">Districts</a>
        </li>
        <li class="text-slate-700 dark:text-zink-100">
            Edit
        </li>
    </ul>
</div>
<!-- bread crumb End -->

<!-- Wrapper for Centered Form -->
<div class="flex justify-center p-5 mt-2">
    <div class="w-full sm:w-full md:w-3/4 lg:w-2/3 xl:w-1/2 2xl:w-2/5">
        <div class="card">
            <div class="card-header">
                <div class="flex items-center justify-between p-6 border-b border-slate-200 dark:border-slate-700">
                    <h2 class="text-xl font-semibold text-slate-800 dark:text-slate-100">Edit District</h2>
                    <a href="{{ url()->previous() }}" 
                        class="text-white btn bg-slate-500 border-slate-500 hover:text-white hover:bg-slate-600 
                        hover:border-slate-600 focus:text-white focus:bg-slate-600 focus:border-slate-600 
                        focus:ring focus:ring-slate-100 active:text-white active:bg-slate-600 
                        active:border-slate-600 active:ring active:ring-slate-100 dark:ring-slate-400/10">
                        Back
                    </a>
                </div>
            </div>

            <div class="card-body">
                <form class="add-new-data flex flex-col items-center" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="p-6 space-y-6 w-full">

                        <!-- State Dropdown -->
                        <div class="space-y-2 w-full">
                            <label for="state_id" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                                State
                            </label>
                            <select id="state_id" name="state_id"
                                class="form-select bg-white border-slate-200 dark:border-zink-500 focus:outline-none 
                                focus:border-custom-500 dark:bg-zink-700 dark:text-zink-100 
                                placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                <option value="">-- Select State --</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}" {{ $districts->state_id == $state->id ? 'selected' : '' }}>
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- District Name -->
                        <div class="space-y-2 w-full">
                            <label for="districts_name" class="block text-sm font-medium text-slate-700 dark:text-slate-300">
                                District Name
                            </label>
                            <input type="text" id="districts_name" name="districts_name"
                                value="{{ $districts->name }}"
                                placeholder="Enter district name"
                                class="form-input bg-white border-slate-200 dark:border-zink-500 focus:outline-none 
                                focus:border-custom-500 dark:bg-zink-700 dark:text-zink-100 
                                placeholder:text-slate-400 dark:placeholder:text-zink-200">
                        </div>

                        <!-- Status -->
                        <div class="space-y-2 w-full">
                            <div class="flex items-center">
                                <div class="relative inline-block w-10 align-middle transition duration-200 ease-in ltr:mr-2 rtl:ml-2">
                                    <input type="checkbox" id="addStatus" 
                                        class="absolute block size-5 transition duration-300 ease-linear border-2 
                                        border-slate-200 dark:border-zink-500 rounded-full appearance-none cursor-pointer 
                                        bg-white/80 dark:bg-zink-600 peer/published checked:bg-white dark:checked:bg-white 
                                        ltr:checked:right-0 rtl:checked:left-0 checked:bg-none checked:border-custom-500 
                                        dark:checked:border-custom-500 after:absolute after:text-slate-500 dark:after:text-zink-200 
                                        after:content-['\eb99'] after:text-xs after:inset-0 after:flex after:items-center 
                                        after:justify-center after:font-remix checked:after:text-custom-500 
                                        dark:checked:after:text-custom-500 checked:after:content-['\eb7b']" 
                                        {{ $districts->status ? 'checked' : '' }}>
                                    <label for="addStatus" 
                                        class="block h-5 overflow-hidden duration-300 ease-linear border rounded-full cursor-pointer 
                                        border-slate-200 dark:border-zink-500 bg-slate-200 dark:bg-zink-600 
                                        peer-checked/published:bg-custom-500 peer-checked/published:border-custom-500"></label>
                                </div>
                                <label for="addStatus" class="inline-block text-base font-medium cursor-pointer">Status</label>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex justify-center mt-6 w-full">
                        <button type="submit" id="submitBtn" 
                            class="flex items-center justify-center gap-2 text-white px-6 py-2.5 text-sm font-medium 
                            rounded-md transition-all duration-200 bg-custom-500 hover:bg-custom-600 
                            focus:ring focus:ring-custom-100 disabled:opacity-70 w-full">
                            <span id="submitLoader" class="hidden inline-block border-2 rounded-full size-4 animate-spin 
                            border-l-transparent border-white"></span>
                            Update
                        </button>
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
    $('.add-new-data').on('submit', function(e) {
        e.preventDefault();
        $('.error-message').remove();
        $('#submitBtn').prop('disabled', true);
        $('#submitLoader').removeClass('hidden');

        let formData = new FormData();
        formData.append('state_id', $('#state_id').val());
        formData.append('districts_name', $('#districts_name').val());
        formData.append('status', $('#addStatus').is(':checked') ? 1 : 0);
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT');

        $.ajax({
            url: '{{ route("districts.update", $districts->id) }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#submitBtn').prop('disabled', false);
                $('#submitLoader').addClass('hidden');

                Swal.fire({
                    title: 'Updated!',
                    text: response.message || 'District updated successfully.',
                    icon: 'success',
                    customClass: {
                        confirmButton: 'text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20',
                    },
                    buttonsStyling: false,
                }).then(() => {
                    window.location.href = "{{ route('districts.index') }}";
                });
            },
            error: function(response) {
                $('#submitBtn').prop('disabled', false);
                $('#submitLoader').addClass('hidden');

                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        const field = $('[name="' + key + '"]');
                        if (field.length) {
                            field.after('<span class="error-message text-red-500 text-sm mt-1 block">' + value[0] + '</span>');
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.responseJSON?.message || 'Something went wrong. Please try again.',
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
