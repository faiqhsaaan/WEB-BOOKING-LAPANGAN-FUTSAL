@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Review Index')

@section('content')
    
    <main class="p-4 md:ml-64 h-auto pt-20">
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="min-w-full inline-block align-middle">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h2 class="text-3xl font-bold text-gray-900">Review</h2>
                        </div>
                    </div>
                    <div class="overflow-hidden">
                        <table class="min-w-full rounded-xl" id="reviewTable">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize rounded-t-xl">Id</th>
                                    <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize rounded-t-xl">User Name</th>
                                    <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize rounded-t-xl">User Email</th>
                                    <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize rounded-t-xl">Futsal Name</th>
                                    <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize rounded-t-xl">Rating</th>
                                    <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize rounded-t-xl">Comment</th>
                                    <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize rounded-t-xl">Date</th>
                                    <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize rounded-t-xl">Time</th>
                                    <th class="p-5 text-left text-sm leading-6 font-semibold text-gray-900 capitalize rounded-t-xl">Actions</th>
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
        $(document).ready(function() {
            $('#reviewTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('review.index') }}",
                columns: [
                    {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                    {data: 'user_name', name: 'user_name'},
                    {data: 'user_email', name: 'user_email'},
                    {data: 'futsal_name', name: 'futsal_name'},
                    {data: 'rating', name: 'rating'},
                    {data: 'comment', name: 'comment'},
                    {data: 'date', name: 'date'},
                    {data: 'time', name: 'time'},
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                ]
            });
        });

        // function toggleModal() {
        //     const modal = document.getElementById('searchModal');
        //     modal.classList.toggle('hidden');
        // }
    </script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
@endsection