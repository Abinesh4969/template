@extends('layouts.app')

@section('content')
<div class="content-overlay"></div>
<div class="header-navbar-shadow"></div>
<div class="content-wrapper container-xxl p-0">
    <div class="content-header row">
        <div class="content-header-left col-md-9 col-12 mb-2">
            <div class="row breadcrumbs-top">
                <div class="col-12">
                    <h2 class="content-header-title float-start mb-0">Users</h2>
                    <div class="breadcrumb-wrapper">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content-body">
        <section>
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="data-table table">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>phone</th>
                                <th>Images</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection

@pushOnce('script')
<script>
$(document).ready(function () {
    $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("users.data") }}',
        columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'phone', name: 'phone' },
            {
                data: 'image_url',
                name: 'image_url',
                render: function(data) {
                    return data ? `<img src="${data}" alt="Image" width="60" height="60" style="object-fit: cover;" />` : '-';
                }
            },
            
            {
            data: 'actions',
            name: 'actions',
            orderable: false,
            searchable: false,
            render: function (data, type, full, meta) {
                return (
                '<a href="{{ url("admin/users") }}/' + full.id + '/edit" class="btn btn-sm btn-primary">' +
                '<i data-feather="edit"></i></a> ' +'<a href="{{ url("admin/users") }}/' + full.id + '/show" class="btn btn-sm btn-info">' +
                 '<i data-feather="eye"></i></a> ' +
                   (
                    full.deleted_at != null
                        ? '<button class="btn-restore btn-sm btn btn-success" data-id="' + full.id + '" >' +
                        '<i data-feather="rotate-ccw"></i></button> '
                        : ''
                    ) +
                     (
                    full.deleted_at == null
                        ? '<a href="#" class="btn btn-sm btn-danger btn-delete" data-id="' + full.id + '">' +
                '<i data-feather="trash-2"></i></a>'
                        : ''
                    ) 
            );


            }
        }
    ],
    order: [[0, 'desc']],
    dom:
        '<"d-flex justify-content-between align-items-center header-actions mx-2 row mt-75"' +
        '<"col-sm-12 col-lg-4 d-flex justify-content-center justify-content-lg-start" l>' +
        '<"col-sm-12 col-lg-8 ps-xl-75 ps-0"<"dt-action-buttons d-flex align-items-center justify-content-center justify-content-lg-end flex-lg-nowrap flex-wrap"<"me-1"f>B>>' +
        '>t' +
        '<"d-flex justify-content-between mx-2 row mb-1"' +
        '<"col-sm-12 col-md-6"i>' +
        '<"col-sm-12 col-md-6"p>' +
        '>',
      language: {
        sLengthMenu: 'Show _MENU_',
        search: 'Search',
        searchPlaceholder: 'Search..'
      },
    buttons: [
        {
            text: 'Add New',
            className: 'add-new btn btn-primary',
            action: function (e, dt, node, config) {
               window.location.href = "{{ route('users.create') }}";
            },
            init: function (api, node, config) {
                $(node).removeClass('btn-secondary');
                $(node).css('margin-bottom', '-8px');
            }
        }
    ],
    drawCallback: function(settings) {
        feather.replace();
    }
    });

    // Delete
    $(document).on('click', '.btn-delete', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-outline-danger ms-1'
            },
            buttonsStyling: false
        }).then(result => {
            if (result.value) {
                $.ajax({
                    url: '{{ route("users.destroy", ":id") }}'.replace(':id', id),
                    method: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function() {
                        $('.data-table').DataTable().ajax.reload();
                        Swal.fire('Deleted!', 'User deleted successfully.', 'success');
                    },
                    error: function() {
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });

    // Restore
    $(document).on('click', '.btn-restore', function() {
        var id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to restore this user?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, restore it!',
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-outline-secondary ms-1'
            },
            buttonsStyling: false
        }).then(result => {
            if (result.value) {
                $.post('{{ route("users.restore", ":id") }}'.replace(':id', id), {
                    _token: '{{ csrf_token() }}'
                }, function() {
                    $('.data-table').DataTable().ajax.reload();
                    Swal.fire('Restored!', 'User has been restored.', 'success');
                }).fail(function() {
                    Swal.fire('Error!', 'Something went wrong.', 'error');
                });
            }
        });
    });
});
</script>
@endPushOnce
