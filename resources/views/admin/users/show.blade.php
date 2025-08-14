@extends('layouts.app')
@section('content')
<div class="content-body">
    <section class="app-user-view">
        <div class="row">
            <!-- User Sidebar -->
            <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
                <!-- User Card -->
                <div class="card">
                    <div class="card-body">
                        <div class="user-avatar-section">
                            <div class="d-flex align-items-center flex-column">
                             @php
                                $media = $user->getFirstMedia('profile_image');
                                @endphp

                                @if($media)
                                <img class="img-fluid rounded mt-3 mb-2"
                                    src="{{ asset('storage/app/public/' . $media->id . '/' . $media->file_name) }}"
                                    height="110" width="110" alt="User avatar" />
                                @else
                                <img class="img-fluid rounded mt-3 mb-2"
                                    src="{{ asset('app-assets/images/unkownimage.png') }}"
                                    height="110" width="110" alt="Default avatar" />
                             @endif

                                <div class="user-info text-center">
                                    <h4>{{ $user->name }} </h4>
                                    <span class="badge bg-light-secondary">{{ ucfirst($user->role) }}</span>
                                </div>
                            </div>
                        </div>
                        <h4 class="fw-bolder border-bottom pb-50 mb-1">Details</h4>
                        <div class="info-container">
                            <ul class="list-unstyled">
                                
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Unique Code:</span>
                                    <span>{{ $user->unique_code ?? 'N/A' }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Username:</span>
                                    <span>{{ $user->name ?? 'N/A' }}</span>
                                </li>
                                 
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Email:</span>
                                    <span>{{ $user->email }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Role:</span>
                                    <span>{{ ucfirst($user->role) }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Phone:</span>
                                    <span>{{ $user->phone ?? 'N/A' }}</span>
                                </li>
                                <li class="mb-75">
                                    <span class="fw-bolder me-25">Created:</span>
                                    <span>{{ $user->created_at->format('M d, Y') }}</span>
                                </li>
                            </ul>
                            <div class="d-flex justify-content-center pt-2">
                                <!-- <a href="javascript:;" class="btn btn-primary me-1" data-bs-target="#editUser" data-bs-toggle="modal">Edit</a> -->
                                <!-- <a href="javascript:;" class="btn btn-outline-danger suspend-user" data-user-id="{{ $user->id }}">
                                    {{ $user->status == 'suspended' ? 'Activate' : 'Suspend' }}
                                </a> -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /User Card -->
            </div>
            <!--/ User Sidebar -->

            <!-- User Content -->
            <!-- <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
                
                <ul class="nav nav-pills mb-2" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-enquiries-tab" data-bs-toggle="pill" data-bs-target="#pills-enquiries" type="button" role="tab" aria-controls="pills-enquiries" aria-selected="true">
                            <i data-feather="user" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">Enquiries</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-general-enquiries-tab" data-bs-toggle="pill" data-bs-target="#pills-general-enquiries" type="button" role="tab" aria-controls="pills-general-enquiries" aria-selected="false">
                            <i data-feather="lock" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">General Enquiries</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-subscriptions-tab" data-bs-toggle="pill" data-bs-target="#pills-subscriptions" type="button" role="tab" aria-controls="pills-subscriptions" aria-selected="false">
                            <i data-feather="bookmark" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">Subscriptions</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="pills-reports-tab" data-bs-toggle="pill" data-bs-target="#pills-reports" type="button" role="tab" aria-controls="pills-reports" aria-selected="false">
                            <i data-feather="bell" class="font-medium-3 me-50"></i>
                            <span class="fw-bold">Reports</span>
                        </button>
                    </li>
                </ul>
             

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-enquiries" role="tabpanel" aria-labelledby="pills-enquiries-tab">
                        <div class="card">
                            <div class="card-body">
                                <table id="enquiry-table" class="table data-table table-bordered"></table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-general-enquiries" role="tabpanel" aria-labelledby="pills-general-enquiries-tab">
                        <div class="card">
                            <div class="card-body">
                                <table id="general-enquiry-table" class="table data-table table-bordered"></table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-subscriptions" role="tabpanel" aria-labelledby="pills-subscriptions-tab">
                        <div class="card">
                            <div class="card-body">
                                <table id="subscription-table" class="table data-table table-bordered"></table>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="pills-reports" role="tabpanel" aria-labelledby="pills-reports-tab">
                        <div class="card">
                            <div class="card-body">
                                <table id="report-table" class="table data-table table-bordered"></table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </section>

    <!-- Edit User Modal -->
    <div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5 px-sm-5 pt-50">
                    <div class="text-center mb-2">
                        <h1 class="mb-1">Edit User Information</h1>
                        <p>Updating user details will receive a privacy audit.</p>
                    </div>
                    <form id="editUserForm" class="row gy-1 pt-75" action="" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="name">Full Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ $user->name }}" required />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="username">Username</label>
                            <input type="text" id="username" name="username" class="form-control" value="{{ $user->username }}" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="email">Email:</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ $user->email }}" required />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="status">Status</label>
                            <select id="status" name="status" class="form-select">
                                <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="suspended" {{ $user->status == 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="{{ $user->phone }}" />
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label" for="role">Role</label>
                            <select id="role" name="role" class="form-select">
                                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="moderator" {{ $user->role == 'moderator' ? 'selected' : '' }}>Moderator</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label" for="address">Address</label>
                            <textarea id="address" name="address" class="form-control" rows="3">{{ $user->address }}</textarea>
                        </div>
                        <div class="col-12 text-center mt-2 pt-50">
                            <button type="submit" class="btn btn-primary me-1">Update User</button>
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Edit User Modal -->
</div>

@pushOnce('script')
<script>
const userId = {{ $user->id }};
</script>

<script>
$(document).ready(function() {
    // Initialize Feather icons
    if (feather) {
        feather.replace({
            width: 14,
            height: 14
        });
    }
    
    // Store DataTable instances
    let tables = {};
    
    // Initialize first tab table (Enquiries)
    initializeEnquiriesTable();
    
    // Tab switching event
    $('#pills-tab button').on('shown.bs.tab', function (e) {
        let targetTab = $(e.target).attr('data-bs-target');
        
        switch(targetTab) {
            case '#pills-enquiries':
                if (!tables.enquiries) {
                    initializeEnquiriesTable();
                }
                break;
            case '#pills-general-enquiries':
                if (!tables.generalEnquiries) {
                    initializeGeneralEnquiriesTable();
                }
                break;
            case '#pills-subscriptions':
                if (!tables.subscriptions) {
                    initializeSubscriptionsTable();
                }
                break;
            case '#pills-reports':
                if (!tables.reports) {
                    initializeReportsTable();
                }
                break;
        }
        
        // Adjust column sizes for visible table
        setTimeout(function() {
            if (tables.enquiries && targetTab === '#pills-enquiries') {
                tables.enquiries.columns.adjust().draw();
            }
            if (tables.generalEnquiries && targetTab === '#pills-general-enquiries') {
                tables.generalEnquiries.columns.adjust().draw();
            }
            if (tables.subscriptions && targetTab === '#pills-subscriptions') {
                tables.subscriptions.columns.adjust().draw();
            }
            if (tables.reports && targetTab === '#pills-reports') {
                tables.reports.columns.adjust().draw();
            }
        }, 100);
    });
    
    // 1. Enquiry Table
    function initializeEnquiriesTable() {
        tables.enquiries = $('#enquiry-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
             url: "{{ url('/admin/user-tab-data/enquiries') }}/" + userId,
             type: 'GET'
            },
            columns: [
                { data: 'id', name: 'id', title: 'ID' },
                { data: 'user_name', name: 'user_name', title: 'User' },
                { data: 'listing_type', name: 'listing_type', title: 'Listing Type' },
                { data: 'listing_title', name: 'listing_title', title: 'Listing Title' },
                { data: 'email', name: 'email', title: 'Email' },
                { data: 'mobile', name: 'mobile', title: 'Mobile' },
                { data: 'message', name: 'message', title: 'Message' },
                { data: 'created_at', name: 'created_at', title: 'Date' },
            
            ],
            drawCallback: function() {
                feather.replace();
            }
        });
    }

    // 2. General Enquiry Table
    function initializeGeneralEnquiriesTable() {
        tables.generalEnquiries = $('#general-enquiry-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
             url: "{{ url('/admin/user-tab-data/general-enquiries') }}/" + userId,
             type: 'GET'
            },
            columns: [
                { data: 'id', name: 'id', title: 'ID' },
                { data: 'name', name: 'name', title: 'Name' },
                { data: 'email', name: 'email', title: 'Email' },
                { data: 'mobile', name: 'mobile', title: 'Mobile' },
                { data: 'whatsapp', name: 'whatsapp', title: 'WhatsApp' },
                { data: 'message', name: 'message', title: 'Message' },
                { data: 'created_at', name: 'created_at', title: 'Date' },
                
            ],
            drawCallback: function() {
                feather.replace();
            }
        });
    }

    // 3. Subscriptions Table
    function initializeSubscriptionsTable() {
        tables.subscriptions = $('#subscription-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
               url: "{{ url('/admin/user-tab-data/subscriptions') }}/" + userId,
               type: 'GET'
            },
            columns: [
                { data: 'id', name: 'id', title: 'ID' },
                { data: 'user', name: 'user', title: 'User' },
                { data: 'plan_name', name: 'plan_name', title: 'Plan' },
                { data: 'starts_at', name: 'starts_at', title: 'Start Date' },
                { data: 'ends_at', name: 'ends_at', title: 'End Date' },
                { data: 'created_at', name: 'created_at', title: 'Created' },
               
            ],
            drawCallback: function() {
                feather.replace();
            }
        });
    }

    // 4. Reports Table
    function initializeReportsTable() {
        tables.reports = $('#report-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ url('/admin/user-tab-data/reports') }}/" + userId,
                type: 'GET'
            },
            columns: [
                { data: 'id', name: 'id', title: 'ID' },
                { data: 'reported_by', name: 'reported_by', title: 'Reported By' },
                { data: 'listing_type', name: 'listing_type', title: 'Listing Type' },
                { data: 'reason', name: 'reason', title: 'Reason' },
                { data: 'description', name: 'description', title: 'Description' },
                { data: 'created_at', name: 'created_at', title: 'Date' },
                
            ],
            drawCallback: function() {
                feather.replace();
            }
        });
    }
});
</script>
@endPushOnce
@endsection