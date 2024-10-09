@extends('layouts.custom')

@section('title', 'Detail Page')

@section('content')
<section>
    <div class="py-8">
        @if ($total_price == null)
            
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
            
        @else


        <!-- component -->

        <body>
        <div class="h-screen pt-20">
            <h1 class="mb-10 text-center text-2xl font-bold">Cart Items</h1>
            <div class="mx-auto max-w-5xl justify-center px-6 md:flex md:space-x-6 xl:px-0">
                <div class="rounded-lg md:w-2/3">
                    @php
                        $groupedChart = $chart->groupBy('lapangan.id');
                    @endphp

                    @foreach ($groupedChart as $lapanganId => $items)
                        <div class="justify-between mb-6 rounded-lg bg-white p-6 shadow-md sm:flex sm:justify-start">
                            <div class="sm:ml-4 sm:flex sm:w-full sm:justify-between">
                                <div class="mt-5 sm:mt-0">
                                    <h2 class="text-2xl font-bold text-gray-900 max-sm mb-3">{{ $items->first()->lapangan->name }}</h2>
                                    @foreach ($items as $item)
                                    <hr>
                                        @if ($item->jadwal->field->discounted_price == null)
                                            <div class="flex justify-between items-center py-1">
                                                <p class="mt-1 text-xs text-gray-700">{{ $item->field->name }} - {{ \Carbon\Carbon::parse($item->jadwal->date)->format('j F Y') }} ({{ $item->jadwal->start_time }} - {{ $item->jadwal->end_time }}) : <span class="font-semibold">Rp{{ number_format($item->jadwal->price) }}</span></p>
                                                <form action="{{ route('chart.destroy', $item->id) }}" method="POST" class="pt-1 md:ml-64 ml-10 rounded-full group transition-all duration-500 flex items-center bg-red-600 hover:bg-red-700 text-white hover:text-white p-1 font-bold">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-4 w-4 cursor-pointer duration-150 hover:text-red-500">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        @else
                                            <p class="mt-1 text-xs text-gray-700">{{ $item->field->name }} - {{ \Carbon\Carbon::parse($item->jadwal->date)->format('j F Y') }} ({{ $item->jadwal->start_time }} - {{ $item->jadwal->end_time }}) : <span class="font-semibold">Rp{{ number_format($item->field->discounted_price) }}</span></p>
                                        @endif
                                        @endforeach
                                </div>
                                {{-- <div class="mt-4 flex flex-col justify-between sm:space-y-6 sm:mt-0 sm:block sm:space-x-6">
                                    @foreach ($items as $item)
                                        <div class="flex items-center justify-between space-x-4">
                                            @if ($item->jadwal->field->discounted_price == null)
                                                <p class="text-xs">Rp{{ number_format($item->jadwal->price) }}</p>
                                            @else
                                                <p class="text-xs">Rp{{ number_format($item->field->discounted_price) }}</p>
                                            @endif
                                            <form action="{{ route('chart.destroy', $item->id) }}" method="POST" class="p-2 rounded-full group transition-all duration-500 flex items-center">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 cursor-pointer duration-150 hover:text-red-500">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div> --}}
                            </div>
                        </div>
                    @endforeach
                </div>
                @if ($total_price == null)

                @else
                    <!-- Sub total -->
                    <div class="mt-6 h-full rounded-lg border bg-white p-6 shadow-md md:mt-0 md:w-1/3">
                        <form action="{{ route('payment') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-5">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" id="useCustomData" class="form-checkbox">
                                        <span class="ml-2">Gunakan data berbeda</span>
                                    </label>
                                </div>
                                <input type="hidden" name="user_id" value="{{ $user }}">
                                @error('user_id')
                                <div class="text-red-500 text-center mt-2">{{ $message }}</div>
                                @enderror

                                <input type="hidden" name="total_price" value="{{ $total_price }}">
                                @error('total_price')
                                <div class="text-red-500 text-center mt-2">{{ $message }}</div>
                                @enderror

                                <div class="mb-5">
                                    <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">
                                        Customer Name
                                    </label>
                                    <input type="text" name="name" id="name" placeholder="Full Name" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ auth()->user()->name }}" readonly />
                                    @error('name')
                                    <div class="text-red-500 text-center mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label for="phone" class="mb-3 block text-base font-medium text-[#07074D]">
                                        Phone Number
                                    </label>
                                    <input type="number" name="phone" id="phone" placeholder="Enter your phone number" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ auth()->user()->phone }}" readonly />
                                    @error('phone')
                                    <div class="text-red-500 text-center mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- <div class="mb-5">
                                    <label for="" class="mb-3 block text-base font-medium text-[#07074D]">
                                        Total
                                    </label>
                                    <div class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                                        @foreach ($chart as $item)
                                        <div class="flex justify-between">
                                            <p>{{ $item->lapangan->name }} / {{ $item->field->name }}</p>
                                            @if ($item->jadwal->field->discounted_price == null)
                                                <p>Rp{{ $item->jadwal->price }}</p>
                                            @else
                                                <p>Rp{{ $item->jadwal->field->discounted_price }}</p>
                                            @endif
                                        </div>
                                        @endforeach
                                        <div class="py-3">
                                            <div class="w-full py-0.5 rounded-xl bg-black"></div>
                                        </div>
                                        <div class="flex justify-between">
                                            <p>Total</p>
                                            <p>Rp{{ $total_price }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <button type="submit" class="hover:shadow-form w-full rounded-md bg-green-700 py-3 px-8 text-center text-base font-semibold text-white outline-none">
                                        Booking
                                    </button>
                                </div> --}}
                                <div class="mb-4">
                                    <h3 class="text-sm font-medium text-gray-700 mb-2">Ringkasan Pesanan</h3>
                                    @foreach ($groupedChart as $lapanganId => $items)
                                        <div class="mb-2">
                                            <p class="text-sm font-semibold">{{ $items->first()->lapangan->name }}</p>
                                            {{-- @foreach ($items as $item)
                                                <div class="flex justify-between text-xs text-gray-600">
                                                    <span>{{ $item->field->name }} ({{ $item->jadwal->date }})</span>
                                                    <span>
                                                        Rp{{ number_format($item->field->discounted_price ?? $item->jadwal->price) }}
                                                    </span>
                                                </div>
                                            @endforeach --}}
                                            <div class="mt-1 flex justify-between text-sm">
                                                <span>Subtotal</span>
                                                <span>Rp{{ number_format($lapanganTotals[$lapanganId]) }}</span>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <hr class="my-4" />
                                <div class="flex justify-between">
                                    <p class="text-lg font-bold">Total</p>
                                    <div class="">
                                        <p class="mb-1 text-lg font-bold">Rp{{ number_format($total_price) }}</p>
                                    </div>
                                </div>
                                <button type="submit" class="mt-6 w-full rounded-md bg-green-500 py-1.5 font-medium text-blue-50 hover:bg-blue-600">Check out</button>
                            </div>
                        </form>
                @endif
            </div>
        </div>
        
            
        @endif
        
    </div>
</section>

@endsection

@section('script')
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const useCustomDataCheckbox = document.getElementById('useCustomData');
        const nameInput = document.getElementById('name');
        const phoneInput = document.getElementById('phone');

        useCustomDataCheckbox.addEventListener('change', function() {
            if (this.checked) {
                nameInput.readOnly = false;
                phoneInput.readOnly = false;
                nameInput.value = '';
                phoneInput.value = '';
            } else {
                nameInput.readOnly = true;
                phoneInput.readOnly = true;
                nameInput.value = '{{ auth()->user()->name }}';
                phoneInput.value = '{{ auth()->user()->phone }}';
            }
        });
    });
</script>
@endsection
