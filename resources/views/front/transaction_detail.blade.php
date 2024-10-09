@extends('layouts.custom')

@section('title', 'Detail Page')

@section('content')

    <section>
        <div class="bg-gray-100 py-8">
            

            <div class="max-w-screen-xl mx-auto py-5 mt-10">
            

            
            <div class=" md:px-6 xl:container 2xl:mx-auto">
                <div class="flex justify-start item-start space-y-2 flex-col">
                    <h1 class="text-3xl dark:text-white lg:text-4xl font-semibold leading-7 lg:leading-9 text-gray-800">Order #{{ $transaction->id }}</h1>
                    <p class="text-base dark:text-gray-300 font-medium leading-6 text-gray-600">{{ $transaction->created_at }}</p>
                    <p class="text-base dark:text-gray-300 font-medium leading-6 text-gray-600">No Invoice : {{ $transaction->short_invoice }}</p>
                </div> 
                <div class="mt-10 flex flex-col xl:flex-row jusitfy-center items-stretch w-full xl:space-x-8 space-y-4 md:space-y-6 xl:space-y-0">
                    <div class="flex flex-col justify-start items-start w-full space-y-4 md:space-y-6 xl:space-y-8">
                        @php
                        $groupedItems = $booking_items->groupBy('lapangan.id');
                        @endphp

                        <div class="flex flex-col justify-start items-start dark:bg-gray-800 bg-gray-50 px-4 py-4 md:py-6 md:p-6 xl:p-8 w-full">
    <h2 class="text-2xl md:text-3xl dark:text-white font-bold leading-6 xl:leading-5 text-gray-800">
        Detail Pesanan
    </h2>

    @foreach ($groupedItems as $lapanganId => $items)
        @php
            $lapangan = $items->first()->lapangan;
            $subtotal = $items->sum(function($item) {
                return $item->field->discounted_price ?? $item->jadwal->price;
            });
        @endphp

        <div class="mt-4 md:mt-6 flex flex-col w-full bg-white dark:bg-gray-700 rounded-lg shadow-md p-4">
            <h3 class="text-xl dark:text-white xl:text-2xl font-semibold leading-6 text-gray-800">
                {{ $lapangan->name }}
            </h3>

            <div class="overflow-x-auto mt-4">
                <table class="w-full table-auto">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-lg dark:text-white leading-none text-gray-800 bg-gray-200">Lapangan</th>
                            <th class="px-4 py-2 text-lg dark:text-white leading-none text-gray-800 bg-gray-200">Tanggal</th>
                            <th class="px-4 py-2 text-lg dark:text-white leading-none text-gray-800 bg-gray-200">Waktu</th>
                            <th class="px-4 py-2 text-lg dark:text-white leading-none text-gray-800 bg-gray-200">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td class="px-4 py-2 text-lg dark:text-white leading-none text-gray-800 border-t border-gray-200">{{ $item->field->name }}</td>
                                <td class="px-4 py-2 text-lg dark:text-white leading-none text-gray-800 border-t border-gray-200">{{ $item->jadwal->date }}</td>
                                <td class="px-4 py-2 text-lg dark:text-white leading-none text-gray-800 border-t border-gray-200">{{ $item->jadwal->start_time }} - {{ $item->jadwal->end_time }}</td>
                                <td class="px-4 py-2 text-lg dark:text-white leading-none text-gray-800 border-t border-gray-200">Rp{{ number_format($item->field->discounted_price ?? $item->jadwal->price) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-4 flex justify-between items-center w-full">
                <p class="text-base dark:text-white font-semibold leading-4 text-gray-800">
                    Subtotal untuk {{ $lapangan->name }}
                </p>

                <p class="text-base dark:text-gray-300 font-semibold leading-4 text-gray-600">
                    Rp{{ number_format($subtotal) }}
                </p>
            </div>
        </div>
    @endforeach
</div>
                        <div class="flex justify-center  md:flex-row flex-col items-stretch w-full space-y-4 md:space-y-0 md:space-x-6 xl:space-x-8">
                            <div class="flex flex-col px-4 py-6 md:p-6 xl:p-8 w-full bg-gray-50 dark:bg-gray-800 space-y-6">
                                <h3 class="text-xl dark:text-white font-semibold leading-5 text-gray-800">Summary</h3>
                                <div class="flex justify-center items-center w-full space-y-4 flex-col border-gray-200 border-b pb-4">
                                    <div class="flex justify-between w-full">
                                        <p class="text-base dark:text-white leading-4 text-gray-800">Subtotal</p>
                                        <p class="text-base dark:text-gray-300 leading-4 text-gray-600">Rp{{ number_format($transaction->total_price) }}</p>
                                    </div>
                                </div>
                                <div class="flex justify-between items-center w-full">
                                    <p class="text-base dark:text-white font-semibold leading-4 text-gray-800">Total</p>
                                    <p class="text-base dark:text-gray-300 font-semibold leading-4 text-gray-600">Rp{{ number_format($transaction->total_price) }}</p>
                                </div>
                            </div>
                            <div class="flex flex-col justify-center px-4 py-6 md:p-6 xl:p-8 w-full bg-gray-50 dark:bg-gray-800 space-y-6">
                                <h3 class="text-xl dark:text-white font-semibold leading-5 text-gray-800">Status</h3>
                                <div class="flex justify-between items-start w-full">
                                    <div class="flex justify-center items-center space-x-4">
                                        <div class="flex flex-col justify-start items-center">
                                            <p class="text-lg leading-6 dark:text-white font-semibold text-gray-800">Status Pemabayaran</p>
                                        </div>
                                    </div>
                                    @if ($transaction->status == 'pending')
                                        <div class="bg-yellow-500 px-3 py-1 rounded-lg">
                                            <p class="text-lg font-semibold leading-6 dark:text-white text-gray-800">{{ $transaction->status }}</p>
                                        </div>
                                    @elseif ($transaction->status == 'success')
                                        <div class="bg-green-500 px-3 py-1 rounded-lg">
                                            <p class="text-lg font-semibold leading-6 dark:text-white text-white">{{ $transaction->status }}</p>
                                        </div>
                                        <a href="{{ route('transaction.pdf', $transaction->id) }}" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                                            Cetak PDF
                                        </a>
                                    @endif
                                </div>
                                <div class="w-full flex justify-center items-center">
                                    @if ($transaction->status == 'pending')
                                        <a href="{{ $transaction->payment_url }}" class="text-center hover:bg-black dark:bg-white dark:text-gray-800 dark:hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 py-5 w-96 md:w-full bg-gray-800 text-base font-medium leading-4 text-white">Bayar</a>
                                    @elseif ($transaction->status == 'success')
                                        {{-- <a href="{{ route('transaction.pdf', $transaction->id) }}" target="_blank" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                            Cetak PDF
                                        </a> --}}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 w-full xl:w-96  items-center md:items-start px-4 py-6 md:p-6 xl:p-8 ">
                        <h3 class="text-xl dark:text-white font-semibold leading-5 text-gray-800">Customer</h3>
                        <div class=" items-stretch w-full">
                            <div class="flex flex-col justify-start items-start flex-shrink-0">
                                <div class="flex justify-center w-full md:justify-start items-center space-x-4 py-8 border-b border-gray-200">
                                    <div class="flex justify-start items-start flex-col space-y-2">
                                        <p class="text-base dark:text-white font-semibold leading-4 text-left text-gray-800">{{ $transaction->name }}</p>
                                        <p class="text-sm dark:text-gray-300 leading-5 text-gray-600">{{ $transaction->phone }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        


        </div>


        </div>
    </section>


@endsection