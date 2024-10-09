@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Feedback Index')

@section('content')
    
<main class="p-4 md:ml-64 h-auto pt-20">
    <div class="flex flex-col">
        <div class="overflow-x-auto">
            <div class="min-w-full inline-block align-middle">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-3xl font-bold text-gray-900">Feedback</h2>
                </div>
                <table class="min-w-full rounded-xl" id="feedbackTable">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900">Id</th>
                            <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900">User Name</th>
                            <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900">User Email</th>
                            <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900">Rating</th>
                            <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900">Comment</th>
                            <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900">Date</th>
                            <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900">Time</th>
                            <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900">Actions</th>
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
        $('#feedbackTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('feedback.index') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'user_name', name: 'user_name'},
                {data: 'user_email', name: 'user_email'},
                {data: 'rating', name: 'rating'},
                {data: 'comment', name: 'comment'},
                {data: 'date', name: 'date'},
                {data: 'time', name: 'time'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });
    });
</script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
@endsection