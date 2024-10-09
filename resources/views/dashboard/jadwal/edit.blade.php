@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Jadwal Edit')

@section('content')
<main class="p-4 md:ml-64 h-auto pt-16">
    <div class="p-12">

        <div class="mb-5">
            <h2 class="text-3xl font-bold text-gray-900">Jadwal Edit</h2>
        </div>

        <div class="bg-white shadow-xl mx-auto w-full max-w-[1250px] p-10 rounded-lg">
            <form action="{{ route('jadwal.update', $jadwals->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                {{-- <input type="hidden" name="field_id" id="field_id"> --}}
                {{-- {{ $fields->id }} --}}
                <div class="mb-5">
                    <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">name</label>
                    <input type="name" name="name" id="name" value="{{ old('name', $jadwals->name) }}" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('name')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="date" class="mb-3 block text-base font-medium text-[#07074D]">Date</label>
                    <input type="date" name="date" id="date" value="{{ old('date', $jadwals->date) }}" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('date')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="start_time" class="mb-3 block text-base font-medium text-[#07074D]">Start Time</label>
                    <input type="time" name="start_time" id="start_time" value="{{ old('start_time', $jadwals->start_time) }}" placeholder="Enter your start_time" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('start_time')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="end_time" class="mb-3 block text-base font-medium text-[#07074D]">End Time</label>
                    <input type="time" name="end_time" id="end_time" value="{{ old('end_time', $jadwals->end_time) }}" placeholder="Enter your end_time" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('end_time')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="status" class="mb-3 block text-base font-medium text-[#07074D]">Status</label>
                    <select name="status" id="status" class="form-control w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        <option value="available" {{ old('status', $jadwals->status) == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="booked" {{ old('status', $jadwals->status) == 'booked' ? 'selected' : '' }}>Booked</option>
                        <option value="maintenance" {{ old('status', $jadwals->status) == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="hover:shadow-form w-full rounded-md bg-green-700 py-3 px-8 text-center text-base font-semibold text-white outline-none">
                        Edit
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection
