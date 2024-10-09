@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Futsal Index')

@section('content')
<main class="p-4 md:ml-64 h-auto pt-20">
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="flex flex-col md:flex-row justify-between items-center mb-4">
                    <h2 class="text-3xl font-bold text-gray-900 mb-2 md:mb-0">Venue</h2>
                    <div class="flex justify-center items-baseline gap-3">
                        <div class="flex gap-3">
                            <a href="{{ route('lapangan.create') }}" class="px-4 py-2 bg-green-800 text-white rounded-lg hover:bg-green-700">Create</a>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table id="lapanganTable" class="min-w-full rounded-xl">
                        <thead>
                            <tr class="bg-gray-100">
                                <th>Photo</th>
                                <th>Venue Name</th>
                                <th>Province</th>
                                <th>Regency</th>
                                <th>Price</th>
                                <th>Create At</th>
                                <th>Actions</th>
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
<script>
    $(document).ready(function() {
        var table = $('#lapanganTable').DataTable({
            order: [[5,'desc']],
            ordering: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('lapangan.index') }}",
                error: function (xhr, error, thrown) {
                    console.log('Ajax error:', error);
                }
            },
            columns: [
                {data: 'photo', name: 'photo'},
                {data: 'name', name: 'name'},
                {data: 'province.name', name: 'province.name'},
                {data: 'regencies.name', name: 'regencies.name'},
                {data: 'price', name: 'price'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ],
            drawCallback: function(settings) {
                console.log('DataTables has redrawn the table');
            },
            responsive: true,
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