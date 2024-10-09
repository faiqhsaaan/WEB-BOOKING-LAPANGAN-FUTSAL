@extends('layouts.custom')

@section('title', 'Detail Page')

@section('content')

    {{-- @if ($transactions = null)
        <div class="mt-10">
            <div class="no-file-found flex flex-col items-center justify-center py-8 px-4 text-center bg-gray-100 dark:bg-gray-800 rounded-lg shadow-md">
            <svg class="w-12 h-12 dark:text-gray-400 text-gray-700" stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 24 24" height="200px" width="200px" xmlns="http://www.w3.org/2000/svg"><g id="File_Off"><g><path d="M4,3.308a.5.5,0,0,0-.7.71l.76.76v14.67a2.5,2.5,0,0,0,2.5,2.5H17.44a2.476,2.476,0,0,0,2.28-1.51l.28.28c.45.45,1.16-.26.7-.71Zm14.92,16.33a1.492,1.492,0,0,1-1.48,1.31H6.56a1.5,1.5,0,0,1-1.5-1.5V5.778Z"></path><path d="M13.38,3.088v2.92a2.5,2.5,0,0,0,2.5,2.5h3.07l-.01,6.7a.5.5,0,0,0,1,0V8.538a2.057,2.057,0,0,0-.75-1.47c-1.3-1.26-2.59-2.53-3.89-3.8a3.924,3.924,0,0,0-1.41-1.13,6.523,6.523,0,0,0-1.71-.06H6.81a.5.5,0,0,0,0,1Zm4.83,4.42H15.88a1.5,1.5,0,0,1-1.5-1.5V3.768Z"></path></g></g></svg>
            <h3 class="text-xl font-medium mt-4 text-gray-700 dark:text-gray-200">Tidak Ada Cart</h3>
            <p class="text-gray-500 dark:text-gray-400 mt-2">
                Tambahkan Pesanan
            </p>
            <a href="{{ route('home.index') }}" class="mt-2 hover:shadow-form rounded-md bg-green-700 py-2 px-8 text-center text-base font-semibold text-white outline-none">
                Tambah      
            </a>   
            </div>
        </div>
    @else --}}
        <section class="min-h-screen">
            <div class="py-8">
                <div class="max-w-screen-xl mx-auto py-5 mt-10 px-4 sm:px-6 lg:px-8">
                    <h1 class="text-2xl font-semibold mb-4">Pesanan</h1>
                    <div class="">
                        <div class="md:max-w-7xl">
                            <div class="bg-white rounded-lg shadow-xl border p-6 mb-4 overflow-x-auto">
                                <table class="w-full min-w-max">
                                    <thead>
                                        <tr>
                                            <th class="text-left font-semibold">Customer Name</th>
                                            <th class="text-left font-semibold">Customer Phone</th>
                                            <th class="text-left font-semibold">Total Pembayaran</th>
                                            <th class="text-left font-semibold">Status</th>
                                            <th class="text-left font-semibold">Date</th>
                                            <th class="text-left font-semibold">Time</th>
                                            {{-- <th class="text-left font-semibold">Action</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="py-4">{{ $item->name }}</td>
                                                <td class="py-4">{{ $item->phone }}</td>
                                                <td class="py-4">Rp{{ $item->total_price }}</td>
                                                @if ($item->status == 'pending')
                                                    <td class="py-4">
                                                        <div class=" pr-3">
                                                            <div class="bg-orange-400 text-black p-0.5 text-center items-baseline rounded-lg">{{ $item->status }}</div>
                                                        </div>
                                                    </td>
                                                @elseif ($item->status == 'success')
                                                    <td class="py-4">
                                                        <div class=" pr-3">
                                                            <div class="bg-green-400 text-white p-0.5 text-center items-baseline rounded-lg">{{ $item->status }}</div>
                                                        </div>
                                                    </td>
                                                @endif
                                                <td class="py-4">{{ $item->date }}</td>
                                                <td class="py-4">{{ $item->time }}</td>
                                                {{-- @foreach ($item->bookingItems as $data)
                                                    <td class="py-4">{{ $data->jadwal->status }}</td>
                                                @endforeach --}}
                                                <td>
                                                    <div class="flex flex-col sm:flex-row sm:gap-2">
                                                        @if ($item->status == 'pending')
                                                            <a href="{{ $item->payment_url }}" class="hover:shadow-form rounded-md bg-green-700 py-2 px-5 text-center text-base font-semibold text-white outline-none mb-2 sm:mb-0">Bayar</a>
                                                            <form action="{{ route('delete.booking', $item->id) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="hover:shadow-form rounded-md bg-red-700 py-2 px-5 text-center text-base font-semibold text-white outline-none mb-2 sm:mb-0">Batal</button>
                                                            </form>
                                                            <a href="{{ route('transaction.detail', $item->id) }}" class="hover:shadow-form rounded-md bg-blue-700 py-2 px-5 text-center text-base font-semibold text-white outline-none mb-2 sm:mb-0">Show</a>
                                                        @elseif ($item->status == 'success')
                                                            <a href="{{ route('transaction.detail', $item->id) }}" class="hover:shadow-form rounded-md bg-blue-700 py-2 px-5 text-center text-base font-semibold text-white outline-none">Show</a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr> 
                                        @endforeach
                                        <!-- More product rows -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    {{-- @endif --}}


@endsection
