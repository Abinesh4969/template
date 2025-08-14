@extends('layouts.app')

@section('content')

<section id="basic-horizontal-layouts">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center position-relative">
                    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-sm ms-auto">Back</a>
                    <h4 class="card-title position-absolute top-50 start-50 translate-middle">Add State</h4>
                </div>

                <div class="card-body">
                    <form class="form form-horizontal add-new-data" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <!-- State Name -->
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="state_name">State Name</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="state_name" name="state_name" class="form-control" placeholder="Enter state name">
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
                                            <input type="checkbox" checked id="addStatus" class="form-check-input">
                                            <label class="form-check-label" for="addStatus">Active</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="col-sm-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary me-1" id="submitBtn">
                                    <span class="spinner-border spinner-border-sm d-none" role="status" id="submitLoader"></span>
                                    Submit
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
    $('.add-new-data').on('submit', function(e) {
        e.preventDefault();
        $('.error-message').remove();
        $('#submitBtn').prop('disabled', true);
        $('#submitLoader').removeClass('d-none');

        let formData = new FormData();
        formData.append('state_name', $('#state_name').val());
        formData.append('status', $('#addStatus').is(':checked') ? 1 : 0);
        formData.append('_token', '{{ csrf_token() }}');

        $.ajax({
            url: '{{ route("states.store") }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                $('#submitBtn').prop('disabled', false);
                $('#submitLoader').addClass('d-none');
                $('.add-new-data')[0].reset();
                $('.data-table').DataTable().ajax.reload();

               Swal.fire('Success!', 'State has been added successfully.', 'success')
                .then(() => {
                    window.location.href = "{{ route('states.index') }}";
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
