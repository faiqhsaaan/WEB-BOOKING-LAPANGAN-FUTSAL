@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Setting Edit')

@section('content')
<main class="md:ml-64 h-auto pt-20">
    <div class="p-12"> 
        <div class="mb-5">
            <h2 class="text-4xl font-bold text-gray-900">Contact</h2>
        </div>
        <div class="bg-white shadow-xl mx-auto w-full max-w-[1250px] p-10 rounded-lg">
            <form action="{{ route('contact.update', $contact) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mb-5">
                    <label for="title" class="mb-3 block text-base font-medium text-[#07074D]">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $contact->title) }}" placeholder="Tambahkan" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('title')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="subtitle" class="mb-3 block text-base font-medium text-[#07074D]">Subtitle</label>
                    <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $contact->subtitle) }}" placeholder="Masukkan subtitle" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('subtitle')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="email" class="mb-3 block text-base font-medium text-[#07074D]">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $contact->email) }}" placeholder="Masukkan email" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('email')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="phone" class="mb-3 block text-base font-medium text-[#07074D]">Phone</label>
                    <input type="text" name="phone" id="phone" value="{{ old('phone', $contact->phone) }}" placeholder="Masukkan nomor telepon" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('phone')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="information" class="mb-3 block text-base font-medium text-[#07074D]">Information</label>
                    <textarea name="information" id="information" placeholder="Masukkan informasi" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">{{ old('information', $contact->information) }}</textarea>
                    @error('information')
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
