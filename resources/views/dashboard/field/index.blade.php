@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Field Index')

@section('content')
    <main class="p-4 md:ml-64 h-auto pt-20">
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="min-w-full inline-block align-middle">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-3xl font-bold text-gray-900">Field</h2>
                        <div class="flex justify-center items-baseline gap-3">
                            <div class="mb-4">
                                <select id="futsal_filter" class="p-2 border rounded">
                                    <option value="">All Venue</option>
                                    @foreach($lapangans as $lapangan)
                                        <option value="{{ $lapangan->id }}">{{ $lapangan->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <a href="{{ route('field.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Create</a>
                        </div>
                    </div>


                    <table id="fields-table" class="min-w-full rounded-xl">
                        <thead>
                            <tr class="bg-gray-100 whitespace-nowrap">
                                <th>Image</th>
                                <th>Venue Name</th>
                                <th>Field Name</th>
                                <th>Price</th>
                                <th>Discounted Price</th>
                                <th>Description</th>
                                <th>Create At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
        var table = $('#fields-table').DataTable({
            order: [[6,'desc']],
            ordering: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.tryout.index') }}",
                data: function (d) {
                    d.futsal = $('#futsal_filter').val();
                }
            },
            columns: [
                {data: 'image', name: 'image', orderable: false, searchable: false},
                {data: 'lapangan.name', name: 'lapangan.name'},
                {data: 'name', name: 'name'},
                {data: 'base_price', name: 'base_price'},
                {data: 'discounted_price', name: 'discounted_price'},
                {data: 'description', name: 'description'},
                {data: 'created_at', name: 'created_at'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ], // Mengurutkan berdasarkan kolom 'lapangan.name' secara default
        });

        $('#futsal_filter').change(function(){
            table.draw();
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