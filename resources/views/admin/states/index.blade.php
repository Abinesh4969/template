@extends('layouts.app')

@section('content')


 <!-- bread crumb start-->
<div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
    <div class="grow">
        <h5 class="text-16">State</h5>
    </div>
    <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
        <li class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
            <a href="#!" class="text-slate-400 dark:text-zink-200">State</a>
        </li>
        <li class="text-slate-700 dark:text-zink-100">
            index
        </li>
    </ul>
</div>

<!-- bread crumb End -->

<!--start card-->
    <div class="card">
        <div class="card-body">
            <h6 class="mb-4 text-15">Bordered Table</h6>
            <table id="borderedTable" class="bordered group data-table table" style="width:100%">
                <thead>
                   <tr>
                        <th>ID</th>
                        <th>State Name</th>
                        <th>Status</th>
                        <th>Deleted Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
<!--end card-->


<!--  -->



<!--  -->

@endsection

@pushOnce('script')
<script>
$(document).ready(function () {
   var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("states_data") }}',
            type: 'GET'
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'state_name', name: 'state_name' },
            {
                data: 'status',
                name: 'status',
                render: function (data, type, full, meta) {
                    return data == 1
                        ? "<span class='px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent'><span class='size-1.5 ltr:mr-1 rtl:ml-1 rounded-full bg-green-500 inline-block'></span> Active</span>"
                        : "<span class='px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-red-100 border-transparent text-red-500 dark:bg-red-500/20 dark:border-transparent'><span class='size-1.5 ltr:mr-1 rtl:ml-1 rounded-full bg-red-500 inline-block'></span> Inactive</span>";
                }
            },
            {
                data: 'status_label',
                name: 'status_label',
                render: function(data) {
                    return data === 'Deleted'
                        ? '<span class="badge bg-danger">Deleted</span>'
                        : '<span class="badge bg-success">Active</span>';
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
                    <!-- View -->
                    <a href="{{ url('admin/states') }}/${full.id}" 
                    class="flex items-center justify-center transition-all duration-200 ease-linear rounded-md size-8 bg-slate-100 dark:bg-zink-600 dark:text-zink-200 text-slate-500 hover:text-blue-500 dark:hover:text-blue-500 hover:bg-blue-100 dark:hover:bg-blue-500/20">
                        <i data-lucide="eye" class="size-4"></i>
                    </a>

                    <!-- Edit -->
                    <a href="{{ url('admin/states') }}/${full.id}/edit" 
                    class="flex items-center justify-center transition-all duration-200 ease-linear rounded-md size-8 bg-slate-100 dark:bg-zink-600 dark:text-zink-200 text-slate-500 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-100 dark:hover:bg-custom-500/20">
                        <i data-lucide="pencil" class="size-4"></i>
                    </a>

                    <!-- Delete -->
                    <a href="#!" data-id="${full.id}" data-modal-target="deleteModal"
                    class="btn-delete flex items-center justify-center transition-all duration-200 ease-linear rounded-md size-8 bg-slate-100 dark:bg-zink-600 dark:text-zink-200 text-slate-500 hover:text-red-500 dark:hover:text-red-500 hover:bg-red-100 dark:hover:bg-red-500/20">
                        <i data-lucide="trash-2" class="size-4"></i>
                    </a>
                </div>
            `;
        }
    }

        ],
        order: [[0, 'desc']],
        // Match template styling
        // dom: '<"flex justify-between items-center mb-4"lf>t<"flex justify-between items-center mt-4"ip>',
        // classes: {
        //     sWrapper: "dataTables_wrapper dt-tailwind"
        // },
        language: {
            sLengthMenu: 'Show _MENU_',
            search: 'Search',
            searchPlaceholder: 'Search...'
        },
        // buttons: [
        //     {
        //         text: 'Add New',
        //         className: 'add-new btn btn-primary',
        //         action: function () {
        //             window.location.href = "{{ route('states.create') }}";
        //         },
        //         init: function (api, node) {
        //             $(node).removeClass('btn-secondary');
        //             $(node).css('margin-bottom', '-8px');
        //         }
        //     }
        // ],
        drawCallback: function() {
            lucide.createIcons();
            //  feather.replace();
        }
    });

    // Delete
    $(document).on('click', '.btn-delete', function() {
        let id = $(this).data('id');
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
                    url: '{{ route("states.destroy", ":id") }}'.replace(':id', id),
                    method: 'DELETE',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function() {
                        $('.data-table').DataTable().ajax.reload();
                        Swal.fire('Deleted!', 'State deleted successfully.', 'success');
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
            text: "Do you want to recover this state?",
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
                    url: '{{ route("states.restore", ":id") }}'.replace(':id', id),
                    method: 'POST',
                    data: { _token: '{{ csrf_token() }}' },
                    success: function() {
                        $('.data-table').DataTable().ajax.reload();
                        Swal.fire('Restored!', 'State has been recovered.', 'success');
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
