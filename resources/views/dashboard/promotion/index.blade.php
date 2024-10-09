@extends('layouts-dashboard.custom')

@section('title', 'Dashboard promotion Index')

@section('content')
    
<main class="p-4 md:ml-64 h-auto pt-20">
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-3xl font-bold text-gray-900">Promotion</h2>
                    <a href="{{ route('promotion.create') }}" class="px-4 py-2 text-white bg-green-800 rounded-lg hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                        Create
                    </a>
                </div>
                <div class="overflow-hidden">
                    <table class="min-w-full rounded-xl" id="promotions-table">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="p-3 text-left text-sm font-semibold text-gray-900">Venue Name</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-900">Venue Id</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-900">Promotion</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-900">Create At</th>
                                <th class="p-3 text-left text-sm font-semibold text-gray-900">Actions</th>
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
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script>
$(function() {
    $('#promotions-table').DataTable({
        order: [[3,'desc']],
        ordering: true,
        processing: true,
        serverSide: true,
        ajax: "{{ route('promotion.index') }}",
        columns: [
            {data: 'lapangan.name', name: 'lapangan.name'},
            {data: 'lapangan.id', name: 'lapangan.id'},
            {data: 'image', name: 'image', orderable: false, searchable: false},
            {data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
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