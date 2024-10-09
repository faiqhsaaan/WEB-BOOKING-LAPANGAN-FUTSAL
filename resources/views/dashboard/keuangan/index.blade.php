@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Jadwal Index')

@section('content')
<main class="p-4 md:ml-64 h-auto pt-20">
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="flex justify-between py-5">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Laporan Keuangan & Booking</h2>
                    </div>
                    <div>
                        <input type="date" id="date-filter" class="rounded-lg border-gray-300 mr-2">
                        <button id="reset-filter" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Reset</button>
                    </div>
                </div>
                <div class="overflow-hidden">
                    <table id="keuangan-table" class="min-w-full rounded-xl">
                        <thead>
                            <tr class="bg-gray-100">
                                <th>Id</th>
                                <th>Customer Name</th>
                                <th>Phone</th>
                                <th>Total Price</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="flex justify-between items-center p-4 bg-white shadow-lg rounded-lg mt-5">
        <p class="text-lg font-semibold text-gray-700">Total Pendapatan</p>
        <p id="total-amount" class="text-lg font-bold text-gray-900">Rp{{ number_format($initialTotal, 0, ',', '.') }}</p>
    </div>
</main>
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">

<script>
$(document).ready(function() {
    var table = $('#keuangan-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('keuangan.index') }}",
            data: function (d) {
                d.date = $('#date-filter').val();
            }
        },
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'name', name: 'name'},
            {data: 'phone', name: 'phone'},
            {data: 'total_price_formatted', name: 'total_price'},
            {data: 'date', name: 'date'},
            {data: 'time', name: 'time'},
            {data: 'status', name: 'status'},
        ],
        drawCallback: function(settings) {
            var api = this.api();
            var total = api.ajax.json().total || 0;
            $('#total-amount').text('Rp' + numberFormat(total));
        }
    });

    $('#date-filter').change(function(){
        table.draw();
    });

    $('#reset-filter').click(function(){
        $('#date-filter').val('');
        table.draw();
    });

    function numberFormat(number) {
        return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }
});
</script>
<!-- DataTables CSS -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
@endsection