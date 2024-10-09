@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Discount Index')

@section('content')
<main class="p-4 md:ml-64 h-auto pt-20">
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-3xl font-bold text-gray-900">Discount</h2>
                    <a href="{{ route('discount.create') }}" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Create New Discount</a>
                </div>
                <table class="min-w-full" id="discountTable">
                    <thead>
                        <tr>
                            <th>Venue Name</th>
                            <th>Field Name</th>
                            <th>Base Price</th>
                            <th>Discount</th>
                            <th>Discounted Price</th>
                            <th>Create At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script type="text/javascript">
    $(function () {
        var table = $('#discountTable').DataTable({
            processing: true,
            serverSide: true,
            order: [[5,'desc']],
            ordering: true,
            ajax: "{{ route('discount.index') }}",
            columns: [
                {data: 'lapangan_name', name: 'lapangan_name'},
                {data: 'field_name', name: 'field_name'},
                {data: 'base_price', name: 'base_price'},
                {data: 'discount', name: 'discount'},
                {data: 'discounted_price', name: 'discounted_price'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
</script>
<!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
@endsection