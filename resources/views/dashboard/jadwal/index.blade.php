@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Jadwal Index')

@section('content')
    
<main class="p-4 md:ml-64 h-auto pt-20">
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">

                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-3xl font-bold text-gray-900">Jadwal</h2>

                    <div class="flex items-center gap-3">
                        <div class="relative">
                            <label for="date" class="sr-only">Filter by Date</label>
                            <input type="date" id="date" name="date" value="" class="block w-48 px-3 py-2 text-sm text-gray-900 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500" />
                        </div>
                        <a href="{{ route('jadwal.create', $field->id) }}" class="px-4 py-2 text-white bg-green-800 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                            Create
                        </a>
                        <button id="bulkAddToCartBtn" class="px-4 py-2 text-white bg-blue-800 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 hidden">
                            Order Selected
                        </button>
                    </div>
                </div>

                <div class="overflow-hidden">
                    <table id="jadwalTable" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    <input type="checkbox" id="selectAll">
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name / Keterangan</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Time</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Time</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

<script>
$(document).ready(function() {
    let table = $('#jadwalTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('jadwal.index', $field->id) }}",
            data: function(d) {
                d.date = $('#date').val() || null;
            }
        },
        columns: [
            {data: 'checkbox', name: 'checkbox', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'date', name: 'date'},
            {data: 'start_time', name: 'start_time'},
            {data: 'end_time', name: 'end_time'},
            {data: 'price_input', name: 'price_input', orderable: false, searchable: false},
            {data: 'status_select', name: 'status_select', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        order: [[2, 'asc']],
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries per page",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "Showing 0 to 0 of 0 entries",
            infoFiltered: "(filtered from _MAX_ total entries)",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        }
    });

    $('#date').change(function(){
        table.draw();
    });

    $('#jadwalTable').on('change', '.status-select', function() {
        let id = $(this).data('id');
        let status = $(this).val();
        $.ajax({
            url: "{{ route('jadwal.updateStatus') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                status: status
            },
            success: function(response) {
                if (response.success) {
                    table.ajax.reload();
                }
            }
        });
    });

    $('#jadwalTable').on('change', '.price-input', function() {
        let id = $(this).data('id');
        let price = $(this).val();
        $.ajax({
            url: "{{ route('jadwal.updatePrice') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                id: id,
                price: price
            },
            success: function(response) {
                if (response.success) {
                    table.ajax.reload();
                }
            }
        });
    });

    $('#selectAll').on('change', function() {
        $('.jadwal-checkbox').prop('checked', this.checked);
        updateBulkAddToCartButton();
    });

    $('#jadwalTable').on('change', '.jadwal-checkbox', function() {
        updateBulkAddToCartButton();
    });

    function updateBulkAddToCartButton() {
        if ($('.jadwal-checkbox:checked').length > 0) {
            $('#bulkAddToCartBtn').removeClass('hidden');
        } else {
            $('#bulkAddToCartBtn').addClass('hidden');
        }
    }

    $('#bulkAddToCartBtn').on('click', function() {
        let cartItems = $('.jadwal-checkbox:checked').map(function() {
            return {
                jadwal_id: this.value,
                field_id: $(this).data('field-id'),
                
            };
        }).get();

        addToCart(cartItems);
    });

    $('#jadwalTable').on('click', '.add-to-cart-btn', function() {
        let cartItems = [{
            jadwal_id: $(this).data('jadwal-id'),
            field_id: $(this).data('field-id'),
            
        }];

        addToCart(cartItems);
    });

    function addToCart(cartItems) {
        $.ajax({
            url: "{{ route('add-to-chart') }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                cart_items: JSON.stringify(cartItems)
            },
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    window.location.href = response.redirect;
                } else {
                    alert('Failed to add item(s) to cart. Please try again.');
                }
            },
            error: function(xhr) {
                alert('An error occurred. Please try again.');
                console.error(xhr.responseText);
            }
        });
    }

    $('#jadwalTable').on('click', '.delete-btn', function() {
        if (confirm('Are you sure you want to delete this schedule?')) {
            let jadwalId = $(this).data('jadwal-id');
            let fieldId = $(this).data('field-id');
            $.ajax({
                url: `/dashboard/field/${fieldId}/jadwal/${jadwalId}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        table.ajax.reload();
                    } else {
                        alert('Failed to delete schedule. Please try again.');
                    }
                },
                error: function(xhr) {
                    alert('An error occurred. Please try again.');
                    console.error(xhr.responseText);
                }
            });
        }
    });
});
</script>
@endsection