@extends('layouts.app')

@section('content')

<section id="basic-horizontal-layouts">
    <div class="row d-flex justify-content-center">
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center position-relative">
                    <a href="{{ route('users.index') }}" class="btn btn-outline-secondary btn-sm ms-auto">Back</a>
                    <h4 class="card-title position-absolute top-50 start-50 translate-middle">
                        Create User
                    </h4>
                </div>

                <div class="card-body">
                   <form class="form form-horizontal add-user-form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <!-- Name -->
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3"><label class="col-form-label" for="name">Name</label></div>
                                    <div class="col-sm-9"><input type="text" id="name" name="name" class="form-control" placeholder="Enter name"></div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3"><label class="col-form-label" for="email">Email</label></div>
                                    <div class="col-sm-9"><input type="email" id="email" name="email" class="form-control" placeholder="Enter email"></div>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3"><label class="col-form-label" for="phone">Phone</label></div>
                                    <div class="col-sm-9"><input type="text" id="phone" name="phone" class="form-control" placeholder="Enter phone"></div>
                                </div>
                            </div>

                            <!-- Password -->
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3"><label class="col-form-label" for="password">Password</label></div>
                                    <div class="col-sm-9"><input type="password" id="password" name="password" class="form-control" placeholder="Enter password"></div>
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3"><label class="col-form-label" for="image">Image</label></div>
                                    <div class="col-sm-9"><input type="file" id="image" name="image" class="form-control"></div>
                                </div>
                            </div>

                              <!-- Unique Code -->
                            <div class="col-12">
                                <div class="mb-1 row align-items-center">
                                    <div class="col-sm-3">
                                        <label class="col-form-label" for="unique_code">Unique Code</label>
                                    </div>
                                    <div class="col-sm-9">
                                        <input type="text" id="unique_code" name="unique_code" class="form-control">
                                    </div>
                                </div>
                            </div>



                            <!-- Date of Birth -->
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3"><label class="col-form-label" for="dob">Date of Birth</label></div>
                                    <div class="col-sm-9"><input type="date" id="dob" name="dob" class="form-control"></div>
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3"><label class="col-form-label" for="gender">Gender</label></div>
                                    <div class="col-sm-9">
                                        <select name="gender" id="gender" class="form-control">
                                            <option value="">-- Select Gender --</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                            <option value="other">Other</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Nationality -->
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3"><label class="col-form-label" for="nationality">Nationality</label></div>
                                    <div class="col-sm-9"><input type="text" id="nationality" name="nationality" class="form-control" placeholder="Enter nationality"></div>
                                </div>
                            </div>

                            <!-- Country of Residence -->
                            <div class="col-12">
                                <div class="mb-1 row">
                                    <div class="col-sm-3"><label class="col-form-label" for="country">Country of Residence</label></div>
                                    <div class="col-sm-9"><input type="text" id="country" name="country" class="form-control" placeholder="Enter country of residence"></div>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="col-sm-12 d-flex justify-content-center">
                                <button type="submit" class="btn btn-primary me-1" id="submitBtn">
                                    <span class="spinner-border spinner-border-sm d-none" id="submitLoader"></span> Submit
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
    
     $('#email').on('input', function () {
            this.value = this.value.toLowerCase();
        });
        
         $('.add-user-form').on('submit', function(e) {
        e.preventDefault();
        $('.error-message').remove();
        $('#submitBtn').prop('disabled', true);
        $('#submitLoader').removeClass('d-none');

        let formData = new FormData();
        formData.append('_token', '{{ csrf_token() }}');
        formData.append('name', $('#name').val());
        formData.append('email', $('#email').val());
        formData.append('phone', $('#phone').val());
        formData.append('role', 'user');
        formData.append('address', $('#address').val());
        formData.append('password', $('#password').val());
        formData.append('unique_code', $('#unique_code').val());
        formData.append('dob', $('#dob').val());
        formData.append('gender', $('#gender').val());
        formData.append('nationality', $('#nationality').val());
        formData.append('country_of_residence', $('#country_of_residence').val());

        // Append image only if selected
        if ($('#image')[0].files.length > 0) {
            formData.append('image', $('#image')[0].files[0]);
        }

        $.ajax({
            type: 'POST',
            url: '{{ route("users.store") }}',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                $('#submitBtn').prop('disabled', false);
                $('#submitLoader').addClass('d-none');

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'User created successfully',
                }).then(() => {
                    window.location.href = "{{ route('users.index') }}"; // or refresh or redirect
                });
            },
            error: function(xhr) {
                $('#submitBtn').prop('disabled', false);
                $('#submitLoader').addClass('d-none');

                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    for (const [key, messages] of Object.entries(errors)) {
                        let input = $('#' + key);
                        input.after(`<div class="text-danger error-message">${messages[0]}</div>`);
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
