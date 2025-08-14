@extends('layouts.app')

@section('content')
<section id="basic-horizontal-layouts">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center position-relative">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm ms-auto">Back</a>
                    <h4 class="card-title position-absolute top-50 start-50 translate-middle">Edit districts</h4>
                </div>
                <div class="card-body">
                    <form class="form form-horizontal edit-districts-form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <!-- State Dropdown -->
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="state_id">State</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <select name="state_id" id="state_id" class="form-control">
                                            <option value="">-- Select State --</option>
                                            @foreach($states as $state)
                                                <option value="{{ $state->id }}" {{ $districts->state_id == $state->id ? 'selected' : '' }}>
                                                    {{ $state->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- districts Name -->
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="districts_name">districts Name</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="districts_name" name="districts_name" class="form-control" value="{{ $districts->name }}">
                                    </div>
                                </div>
                            </div>

                            <!-- Status Checkbox -->
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label">Status</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" id="editStatus" class="form-check-input" {{ $districts->status ? 'checked' : '' }}>
                                            <label class="form-check-label" for="editStatus">Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-sm-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary me-1" id="submitBtn">
                                    <span class="spinner-border spinner-border-sm d-none" role="status" id="submitLoader"></span>
                                    Update
                                </button>
                            </div>
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
    $('.edit-districts-form').on('submit', function(e) {
        e.preventDefault();
        $('.error-message').remove();
        $('#submitBtn').prop('disabled', true);
        $('#submitLoader').removeClass('d-none');

        let formData = new FormData();
        formData.append('state_id', $('#state_id').val());
        formData.append('districts_name', $('#districts_name').val());
        formData.append('status', $('#editStatus').is(':checked') ? 1 : 0);
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
                $('#submitLoader').addClass('d-none');

                Swal.fire({
                    title: 'Updated!',
                    text: response.message || 'districts updated successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    location.href = "{{ route('districts.index') }}";
                });
            },
            error: function(response) {
                $('#submitBtn').prop('disabled', false);
                $('#submitLoader').addClass('d-none');

                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        const field = $('[name="' + key + '"]');
                        if (field.length) {
                            field.after('<span class="error-message text-danger d-block mt-1">' + value[0] + '</span>');
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
