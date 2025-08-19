@extends('layouts.app')

@section('content')

<!-- bread crumb start-->
<div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
    <div class="grow">
        <h5 class="text-16">Districts</h5>
    </div>
    <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
        <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  
            before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
            <a href="{{ route('dashboard') }}" class="text-slate-400 dark:text-zink-200">Dashboard</a>
        </li>
        <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  
            before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
            <span>Masters</span>
        </li>
        <li class="text-slate-700 dark:text-zink-100">Districts</li>
    </ul>
</div>
<!-- bread crumb End -->

<!--start card-->
<div class="card">
    <div class="card-body">
        <table id="districtTable" class="bordered group data-table table" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>District Name</th>
                    <th>State Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<!--end card-->

@endsection

@pushOnce('script')
<script>
$(document).ready(function () {
    var table = $('#districtTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("districts_data") }}',
            type: 'GET'
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'districts_name', name: 'districts_name' },
            { data: 'state_name', name: 'state_name' },
            {
                data: 'status',
                name: 'status',
                render: function (data) {
                    return data == 1
                        ? "<span class='px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent'><span class='size-1.5 ltr:mr-1 rtl:ml-1 rounded-full bg-green-500 inline-block'></span> Active</span>"
                        : "<span class='px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-red-100 border-transparent text-red-500 dark:bg-red-500/20 dark:border-transparent'><span class='size-1.5 ltr:mr-1 rtl:ml-1 rounded-full bg-red-500 inline-block'></span> Inactive</span>";
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
                            <a href="{{ url('admin/districts') }}/${full.id}/edit"
                            class="flex items-center justify-center transition-all duration-200 ease-linear rounded-md size-8 bg-slate-100 dark:bg-zink-600 dark:text-zink-200 text-slate-500 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-100 dark:hover:bg-custom-500/20">
                                <i data-lucide="pencil" class="size-4"></i>
                            </a>

                            <!-- Delete -->
                            ${full.deleted_at == null ? `
                            <a href="#!" data-id="${full.id}" class="btn-delete flex items-center justify-center transition-all duration-200 ease-linear rounded-md size-8 bg-slate-100 dark:bg-zink-600 dark:text-zink-200 text-slate-500 hover:text-red-500 dark:hover:text-red-500 hover:bg-red-100 dark:hover:bg-red-500/20">
                                <i data-lucide="trash-2" class="size-4"></i>
                            </a>` : ''}

                            <!-- Restore -->
                            ${full.deleted_at != null ? `
                            <a href="#!" data-id="${full.id}" class="btn-restore flex items-center justify-center transition-all duration-200 ease-linear rounded-md size-8 bg-slate-100 dark:bg-zink-600 dark:text-zink-200 text-slate-500 hover:text-green-500 dark:hover:text-green-500 hover:bg-green-100 dark:hover:bg-green-500/20">
                                <i data-lucide="rotate-ccw" class="size-4"></i>
                            </a>` : ''}
                        </div>
                    `;
                }
            }
        ],
        order: [[0, 'desc']],
        dom: '<"flex justify-between items-center mb-4"<"flex items-center gap-3"l><"flex items-center gap-3"f<"add-btn">>>rt<"flex justify-between items-center mt-4"ip>',
        initComplete: function () {
            $("div.add-btn").html(`
                <a href="{{ route('districts.create') }}" 
                   type="button" 
                   class="ml-3 text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                   <i data-lucide="plus" class="inline-block size-4"></i> 
                   <span class="align-middle">Add District</span>
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
            customClass: {
                confirmButton: 'text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20 ltr:mr-1 rtl:ml-1',
                cancelButton: 'text-white bg-red-500 border-red-500 btn hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-custom-400/20',
            },
            confirmButtonText: "Yes, delete it!",
            buttonsStyling: false,
            showCloseButton: true
        }).then(function(result) {
            if (result.value) {
                $.ajax({
                    url: '{{ route("districts.destroy", ":id") }}'.replace(':id', id),
                    method: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function() {
                        $('#districtTable').DataTable().ajax.reload();
                        Swal.fire({
                            title: 'Deleted!',
                            text: 'District deleted successfully.',
                            icon: 'success',
                            customClass: {
                                confirmButton: 'text-white btn bg-custom-500 border-custom-500',
                            },
                            buttonsStyling: false
                        });
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
            text: "Do you want to recover this district?",
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
                $.ajax({
                    url: '{{ route("districts.restore", ":id") }}'.replace(':id', id),
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function() {
                        $('#districtTable').DataTable().ajax.reload();
                        Swal.fire('Restored!', 'District has been recovered.', 'success');
                    },
                    error: function() {
                        Swal.fire('Error!', 'Something went wrong.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endPushOnce
