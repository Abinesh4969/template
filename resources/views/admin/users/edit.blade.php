@extends('layouts.app')

@section('content')

<section id="basic-horizontal-layouts">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center position-relative">
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm ms-auto">Back</a>
                    <h4 class="card-title position-absolute top-50 start-50 translate-middle">
                        Edit User
                    </h4>
                </div>

                <div class="card-body">
                   <form class="update-user-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="user_id" value="{{ $user->id }}">

                        <!-- Name -->
                        <div class="mb-1">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}">
                        </div>

                        <!-- Email -->
                        <div class="mb-1">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}">
                        </div>

                        <!-- Phone -->
                        <div class="mb-1">
                            <label for="phone" class="form-label">Phone (e.g., +91...)</label>
                            <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}">
                        </div>

                        <!-- Address -->
                        <div class="mb-1">
                            <label for="address" class="form-label">Address</label>
                            <textarea name="address" id="address" class="form-control">{{ $user->address }}</textarea>
                        </div>

                        <!-- Image -->
                        <div class="mb-1">
                            <label for="image" class="form-label">Profile Image</label>
                            <input type="file" name="image" id="image" class="form-control">
                          @if($user->getFirstMedia('profile_image'))
                            @php
                                $media = $user->getFirstMedia('profile_image');
                            @endphp
                            <img src="{{ asset('storage/app/public/' . $media->id . '/' . $media->file_name) }}" width="80" height="80" style="object-fit: cover;margin-top:10px">
                            @endif

                        </div>

                        <!-- Submit -->
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <span class="spinner-border spinner-border-sm d-none" id="submitLoader"></span>
                                Update
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@pushOnce('script')
<script>
$(document).ready(function () {
    $('.update-user-form').on('submit', function (e) {
        e.preventDefault();
        $('.error-message').remove();
        $('#submitBtn').prop('disabled', true);
        $('#submitLoader').removeClass('d-none');

        var formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('_method', 'PUT');
        formData.append('name', $('#name').val());
        formData.append('email', $('#email').val());
        formData.append('phone', $('#phone').val());
        //formData.append('status', $('#editStatus').is(':checked') ? 1 : 0);

        var image = $('#image')[0].files[0];
        if (image) {
            formData.append('image', image);
        }

        var id = $('#user_id').val();

        $.ajax({
            url: '{{ url("admin/users") }}/' + id,
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                $('#submitBtn').prop('disabled', false);
                $('#submitLoader').addClass('d-none');

                Swal.fire({
                    title: 'Updated!',
                    text: 'User updated successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = '{{ route("users.index") }}';
                });
            },
            error: function (response) {
                $('#submitBtn').prop('disabled', false);
                $('#submitLoader').addClass('d-none');

                if (response.status === 422) {
                    const errors = response.responseJSON.errors;
                    $.each(errors, function (key, value) {
                        const field = $('[name="' + key + '"]');
                        if (field.length) {
                            field.after('<span class="error-message text-danger d-block mt-1">' + value[0] + '</span>');
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.responseJSON?.message || 'Something went wrong.',
                        icon: 'error'
                    });
                }
            }
        });
    });
});
</script>
@endPushOnce
