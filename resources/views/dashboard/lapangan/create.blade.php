@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Futsal Create')

@section('content')
<main class="p-4 md:ml-64 h-auto pt-16">
    <div class="p-12">

        <div class="mb-5">
            <h2 class="text-3xl font-bold text-gray-900">Venue Create</h2>
        </div>

        <div class="bg-white shadow-xl mx-auto w-full max-w-[1250px] p-10 rounded-lg">
            <form action="{{ route('lapangan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="mb-5">
                    <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">Venue Name</label>
                    <input type="text" name="name" id="name" placeholder="Full Name" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('name') }}" />
                    @error('name')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="photos" class="mb-3 block text-base font-medium text-[#07074D]">Photo</label>
                    <input type="file" name="photos" id="photos" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('photos')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="facilities" class="mb-3 block text-base font-medium text-[#07074D]">Facilities</label>
                    <input type="text" name="facilities" id="facilities" placeholder="Enter your facilities" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('facilities') }}" />
                    @error('facilities')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="location" class="mb-3 block text-base font-medium text-[#07074D]">Address</label>
                    <textarea name="location" id="location" placeholder="Masukan detail Alamat" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">{{ old('location') }}</textarea>
                    @error('location')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="province_id" class="mb-3 block text-base font-medium text-[#07074D]">Province</label>
                    <select name="province_id" id="province_id" class="form-control w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        <option value="">Select Province</option>
                        @foreach ($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->name }}</option>
                        @endforeach
                    </select>
                    @error('province_id')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="regencies_id" class="mb-3 block text-base font-medium text-[#07074D]">City</label>
                    <select name="regencies_id" id="regencies_id" class="form-control w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        <option value="">Select City</option>
                    </select>
                    @error('regencies_id')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="price" class="mb-3 block text-base font-medium text-[#07074D]">Price</label>
                    <input type="number" name="price" id="price" placeholder="Enter your price" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('price') }}" />
                    @error('price')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="description" class="mb-3 block text-base font-medium text-[#07074D]">Description</label>
                    <textarea name="description" id="description" placeholder="Masukan Keterangan" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">{{ old('description') }}</textarea>
                    @error('description')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="hover:shadow-form w-full rounded-md bg-green-700 py-3 px-8 text-center text-base font-semibold text-white outline-none">
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="path/to/your/script.js"></script>
<script>
    $(document).ready(function() {
        $('#province_id').on('change', function() {
            var provinceId = $(this).val();
            console.log("Selected Province ID: " + provinceId);  // Debugging
            if (provinceId) {
                $.ajax({
                    url: '{{ url("/api/regencies") }}/' + provinceId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log("Received Data: ", data);  // Debugging
                        $('#regencies_id').empty();
                        $('#regencies_id').append('<option value="">Select City</option>');
                        $.each(data, function(key, value) {
                            $('#regencies_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error("Error: " + textStatus, errorThrown);  // Debugging
                    }
                });
            } else {
                $('#regencies_id').empty();
                $('#regencies_id').append('<option value="">Select City</option>');
            }
        });
    });
</script>
@endsection
