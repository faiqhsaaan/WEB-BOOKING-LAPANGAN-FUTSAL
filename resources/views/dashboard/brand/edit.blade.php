@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Brand Edit')

@section('content')
<main class="md:ml-64 h-auto pt-20">
    <div class="p-12">
        <div class="mb-5">
            <h2 class="text-4xl font-bold text-gray-900">Logo</h2>
        </div>
        <div class="bg-white shadow-xl mx-auto w-full max-w-[1250px] p-10 rounded-lg">
            <form action="{{ route('brand.update', $brands) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <img width="300" height="300" class="mb-1" src="{{ Storage::url($brands->image) }}" alt="Photo">
                <div class="mb-5">
                    <label for="image" class="mb-3 block text-base font-medium text-[#07074D]">Logo</label>
                    <input type="file" name="image" id="image" value="{{ $brands->image }}" placeholder="Tambahkan Logo" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('image') }}" />
                    @error('image')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">Nama Logo</label>
                    <input type="text" name="name" id="name" value="{{ $brands->name }}" placeholder="masukkan name logo " class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('name') }}" />
                    @error('name')
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
