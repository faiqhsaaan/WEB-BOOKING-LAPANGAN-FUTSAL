@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Jadwal Create')

@section('content')
<main class="p-4 md:ml-64 h-auto pt-16">
    <div class="p-12">
        <div class="mb-5">
            <h2 class="text-3xl font-bold text-gray-900">Extend Schedules</h2>
        </div>

        <div class="bg-white shadow-xl mx-auto w-full max-w-[1250px] p-10 rounded-lg">
            <form action="{{ route('jadwal.store', $field->id) }}" method="POST">
                @csrf
                @method('POST')
                
                <div class="mb-5">
                    <label for="start_date" class="mb-3 block text-base font-medium text-[#07074D]">Start Date</label>
                    <input type="date" name="start_date" id="start_date" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('start_date') }}" />
                    @error('start_date')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-5">
                    <label for="end_date" class="mb-3 block text-base font-medium text-[#07074D]">End Date</label>
                    <input type="date" name="end_date" id="end_date" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('end_date') }}" />
                    @error('end_date')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="hover:shadow-form w-full rounded-md bg-green-700 py-3 px-8 text-center text-base font-semibold text-white outline-none">
                        Extend Schedules
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection