@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Jadwal Index')

@section('content')
<main class="p-4 md:ml-64 h-auto pt-20">
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="overflow-hidden py-5">
                    <div class="flex justify-between mb-4">
                        <h2 class="text-3xl font-bold text-gray-900">Laporan Lapangan</h2>
                        <div class="flex justify-center items-baseline gap-3">
                            <div class="mb-4 flex gap-4">
                                <select id="monthFilter" class="form-select p-2 rounded-md">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                    @endfor
                                </select>
                                <select id="yearFilter" class="form-select p-2 rounded-md">
                                    @for ($i = date('Y'); $i >= 2000; $i--)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="flex items-center gap-2">
                                <button id="exportExcel" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">Export Excel</button>
                                <button id="exportPdf" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Export PDF</button>
                            </div>
                        </div>
                    </div>
                    

                    <table id="futsalTable" class="min-w-full rounded-xl">
                        <thead class="whitespace-nowrap">
                            <tr class="bg-gray-100">
                                <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">Name Venue</th>
                                <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">Provinsi</th>
                                <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">kota</th>
                                <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">Alamat</th>
                                <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">Fasilitas</th>
                                <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">Harga</th>
                                <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">Total Lapangan</th>
                                <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">Total Jadwal</th>
                                <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">Total Jadwal Booked</th>
                                <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">Total Booking</th>
                                <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize">Pendapatan</th>
                            </tr>
                        </thead>
                        <tbody class="whitespace-nowrap">
                            <!-- Data will be populated by DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

<script>
$(document).ready(function() {
    var table = $('#futsalTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route("report") }}',
            data: function(d) {
                d.month = $('#monthFilter').val();
                d.year = $('#yearFilter').val();
            }
        },
        columns: [
            {data: 'futsal_name', name: 'futsal_name'},
            {data: 'futsal_province', name: 'futsal_province'},
            {data: 'futsal_regency', name: 'futsal_regency'},
            {data: 'futsal_alamat', name: 'futsal_alamat'},
            {data: 'futsal_facilities', name: 'futsal_facilities'},
            {data: 'futsal_price', name: 'futsal_price'},
            {data: 'total_fields', name: 'total_fields'},
            {data: 'total_schedules', name: 'total_schedules'},
            {data: 'total_booked_schedules', name: 'total_booked_schedules'},
            {data: 'total_bookings', name: 'total_bookings'},
            {data: 'total_revenue', name: 'total_revenue'},
        ]
    });

    $('#monthFilter, #yearFilter').change(function(){
        table.draw();
    });

    $('#exportExcel').click(function(){
        var month = $('#monthFilter').val();
        var year = $('#yearFilter').val();
        window.location.href = '{{ route("report") }}?export_excel=1&month=' + month + '&year=' + year;
    });

    $('#exportPdf').click(function(){
        var month = $('#monthFilter').val();
        var year = $('#yearFilter').val();
        window.location.href = '{{ route("report") }}?export_pdf=1&month=' + month + '&year=' + year;
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
