@extends('layouts-dashboard.custom')

@section('title', 'Dashboard user Index')

@section('content')
    <main class="p-4 md:ml-64 h-auto pt-20">
        <div class="flex flex-col">
            <div class="overflow-x-auto">
                <div class="min-w-full inline-block align-middle">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-3xl font-bold text-gray-900">User</h2>
                        <a href="{{ route('user.create') }}" class="px-4 py-2 text-white bg-green-800 rounded-lg hover:bg-green-700">Create</a>
                    </div>
                    <div class="overflow-hidden">
                        <table class="min-w-full rounded-xl" id="usersTable">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="p-3 text-left text-sm font-semibold text-gray-900">Name</th>
                                    <th class="p-3 text-left text-sm font-semibold text-gray-900">Email</th>
                                    <th class="p-3 text-left text-sm font-semibold text-gray-900">Phone</th>
                                    <th class="p-3 text-left text-sm font-semibold text-gray-900">Preferences</th>
                                    <th class="p-3 text-left text-sm font-semibold text-gray-900">Role</th>
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
    $(document).ready(function() {
        $('#usersTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('user.index') }}",
            columns: [
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'phone', name: 'phone'},
                {data: 'prefrences', name: 'prefrences'},
                {data: 'role', name: 'role'},
                {data: 'action', name: 'action', orderable: false, searchable: false}
            ]
        });
    });
</script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.js"></script>
@endsection

{{-- @section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css">
@endsection --}}