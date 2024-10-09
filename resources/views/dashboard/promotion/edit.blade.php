@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Promotion Edit')

@section('content')
<main class="p-4 md:ml-64 h-auto pt-16">
    <div class="p-12">

        <div class="mb-5">
            <h2 class="text-3xl font-bold text-gray-900">Promotion Create</h2>
        </div>

        <div class="bg-white shadow-xl mx-auto w-full max-w-[1250px] p-10 rounded-lg">
            <form action="{{ route('promotion.update', $promotion->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-5">
                    <label for="lapangan_id" class="mb-3 block text-base font-medium text-[#07074D]">Futsal</label>
                    <select name="lapangan_id" id="lapangan_id" class="form-control w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        <option value="">Select Futsal</option>
                        @foreach ($lapangans as $lapangan)
                        <option value="{{ $lapangan->id }}" {{ $promotion->lapangan->id == $promotion->id ? 'selected' : '' }} >{{ $lapangan->name }}</option>
                        @endforeach
                    </select>
                    @error('lapangan_id')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <img width="300" height="300" class="mb-1" src="{{ Storage::url($promotion->image) }}" alt="Photo">
                    <label for="image" class="mb-3 block text-base font-medium text-[#07074D]">image</label>
                    <input type="file" name="image" id="image" value="{{ $promotion->image }}" placeholder="image" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('image') }}" />
                    @error('image')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
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
