@extends('layouts.app')

@section('content')

<!-- bread crumb start-->
<div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
    <div class="grow">
        <h5 class="text-16">Users</h5>
    </div>
    <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
        <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1 before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
            <a href="{{ route('dashboard') }}" class="text-slate-400 dark:text-zink-200">Dashboard</a>
        </li>
        <li class="text-slate-700 dark:text-zink-100">Users</li>
    </ul>
</div>
<!-- bread crumb end -->

<!-- start card -->
<div class="card">
    <div class="card-body">
        <table id="usersTable" class="bordered group data-table table w-full">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<!-- end card -->

@endsection

@pushOnce('script')
<script>
$(document).ready(function () {
   var table = $('.data-table').DataTable({
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
                    return data 
                        ? `<img src="${data}" alt="Image" class="w-12 h-12 rounded-full object-cover border" />` 
                        : '-';
                }
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function (data, type, full, meta) {
                    return `
                        <div class="flex gap-2">
                            <!-- Edit -->
                            <a href="{{ url('admin/users') }}/${full.id}/edit" 
                               class="flex items-center justify-center transition-all duration-200 ease-linear rounded-md size-8 bg-slate-100 dark:bg-zink-600 dark:text-zink-200 text-slate-500 hover:text-custom-500 hover:bg-custom-100 dark:hover:text-custom-500 dark:hover:bg-custom-500/20">
                                <i data-lucide="pencil" class="size-4"></i>
                            </a>

                            <!-- View -->
                            <a href="{{ url('admin/users') }}/${full.id}/show" 
                               class="flex items-center justify-center transition-all duration-200 ease-linear rounded-md size-8 bg-slate-100 dark:bg-zink-600 dark:text-zink-200 text-slate-500 hover:text-blue-500 hover:bg-blue-100 dark:hover:text-blue-500 dark:hover:bg-blue-500/20">
                                <i data-lucide="eye" class="size-4"></i>
                            </a>

                            ${ full.deleted_at != null 
                                ? `<button class="btn-restore flex items-center justify-center transition-all duration-200 ease-linear rounded-md size-8 bg-green-100 text-green-500 dark:bg-green-500/20 hover:bg-green-200" data-id="${full.id}">
                                     <i data-lucide="rotate-ccw" class="size-4"></i>
                                   </button>`
                                : ''
                            }

                            ${ full.deleted_at == null 
                                ? `<a href="#!" data-id="${full.id}" 
                                      class="btn-delete flex items-center justify-center transition-all duration-200 ease-linear rounded-md size-8 bg-slate-100 text-slate-500 dark:bg-zink-600 dark:text-zink-200 hover:text-red-500 hover:bg-red-100 dark:hover:text-red-500 dark:hover:bg-red-500/20">
                                      <i data-lucide="trash-2" class="size-4"></i>
                                   </a>`
                                : ''
                            }
                        </div>
                    `;
                }
            }
        ],
        order: [[0, 'desc']],
        dom: '<"flex justify-between items-center mb-4"<"flex items-center gap-3"l><"flex items-center gap-3"f<"add-btn">>>rt<"flex justify-between items-center mt-4"ip>',
        initComplete: function () {
            $("div.add-btn").html(`
                <a href="{{ route('users.create') }}" 
                   class="ml-3 text-white btn bg-custom-500 border-custom-500 hover:bg-custom-600 hover:border-custom-600 focus:ring focus:ring-custom-100 rounded-md shadow-md px-3 py-2 flex items-center gap-2">
                   <i data-lucide="plus" class="size-4"></i>
                   <span>Add User</span>
                </a>
            `);
            lucide.createIcons();
        },
        language: {
            sLengthMenu: 'Show _MENU_',
            search: 'Search',
            searchPlaceholder: 'Search...'
        },
        drawCallback: function() {
            lucide.createIcons();
        }
    });

    // Delete
    $(document).on('click', '.btn-delete', function() {
        let id = $(this).data('id');
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it!",
            customClass: {
                confirmButton: 'btn bg-red-500 text-white hover:bg-red-600',
                cancelButton: 'btn bg-slate-200 text-slate-700 hover:bg-slate-300',
            },
            buttonsStyling: false
        }).then(result => {
            if (result.value) {
                $.ajax({
                    url: '{{ route("users.destroy", ":id") }}'.replace(':id', id),
                    method: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function() {
                        table.ajax.reload();
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
        let id = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: "Do you want to restore this user?",
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, restore it!',
            customClass: {
                confirmButton: 'btn bg-green-500 text-white hover:bg-green-600',
                cancelButton: 'btn bg-slate-200 text-slate-700 hover:bg-slate-300',
            },
            buttonsStyling: false
        }).then(result => {
            if (result.value) {
                $.post('{{ route("users.restore", ":id") }}'.replace(':id', id), {
                    _token: '{{ csrf_token() }}'
                }, function() {
                    table.ajax.reload();
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
