@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Field Edit')

@section('content')
<main class="p-4 md:ml-64 h-auto pt-16">
    <div class="p-12">
        <div class="mb-5">
            <h2 class="text-3xl font-bold text-gray-900">Field Edit</h2>
        </div>

        <div class="bg-white shadow-xl mx-auto w-full max-w-[1250px] p-10 rounded-lg">
            <form action="{{ route('field.update', $field->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- Existing field details -->
                <div class="mb-5">
                    <label for="lapangan_id" class="mb-3 block text-base font-medium text-[#07074D]">Venue</label>
                    <select name="lapangan_id" id="lapangan_id" class="form-control w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        <option value="">Select Venue</option>
                        @foreach ($lapangans as $lapangan)
                        <option value="{{ $lapangan->id }}" {{ $field->lapangan->id == $lapangan->id ? 'selected' : '' }}>{{ $lapangan->name }}</option>
                        @endforeach
                    </select>
                    @error('lapangan_id')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">Field Name</label>
                    <input type="text" name="name" id="name" value="{{ $field->name }}" placeholder="Full Name" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('name')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <img width="300" height="300" class="mb-1" src="{{ Storage::url($field->image) }}" alt="Photo">
                    <label for="image" class="mb-3 block text-base font-medium text-[#07074D]">Image</label>
                    <input type="file" name="image" id="image" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('image')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="description" class="mb-3 block text-base font-medium text-[#07074D]">Description</label>
                    <textarea name="description" id="description" placeholder="Enter Description" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">{{ $field->description }}</textarea>
                    @error('description')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                {{-- <!-- Schedule editing section -->
                <div class="mb-5">
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Edit Schedules</h3>
                    
                    <div class="mb-3">
                        <label for="open_time" class="mb-2 block text-base font-medium text-[#07074D]">Opening Time</label>
                        <input type="time" name="open_time" id="open_time" value="{{ $field->open_time }}" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div>

                    <div class="mb-3">
                        <label for="close_time" class="mb-2 block text-base font-medium text-[#07074D]">Closing Time</label>
                        <input type="time" name="close_time" id="close_time" value="{{ $field->close_time }}" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div>

                    <div class="mb-3">
                        <label for="slot_duration" class="mb-2 block text-base font-medium text-[#07074D]">Slot Duration (minutes)</label>
                        <input type="number" name="slot_duration" id="slot_duration" value="{{ $field->slot_duration }}" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div>

                    <div class="mb-3">
                        <label for="base_price" class="mb-2 block text-base font-medium text-[#07074D]">Base Price</label>
                        <input type="number" name="base_price" id="base_price" value="{{ $field->base_price }}" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    </div>

                    <!-- Price Ranges -->
                    <div id="price-ranges">
                        <h4 class="text-lg font-semibold text-gray-900 mb-2">Price Ranges</h4>
                        @foreach($field->priceRanges as $index => $range)
                        <div class="mb-3 flex gap-2">
                            <input type="time" name="price_ranges[{{ $index }}][start_time]" value="{{ $range->start_time }}" class="w-1/3 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            <input type="time" name="price_ranges[{{ $index }}][end_time]" value="{{ $range->end_time }}" class="w-1/3 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            <input type="number" name="price_ranges[{{ $index }}][price]" value="{{ $range->price }}" class="w-1/3 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                        @endforeach
                    </div>

                    <button type="button" onclick="addPriceRange()" class="mb-3 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Add Price Range</button>

                    <!-- Date Range for Schedule Update -->
                    <div class="mb-3">
                        <label for="start_date" class="mb-2 block text-base font-medium text-[#07074D]">Start Date for Schedule Update</label>
                        <input type="date" name="start_date" id="start_date" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                    </div>

                    <div class="mb-3">
                        <label for="end_date" class="mb-2 block text-base font-medium text-[#07074D]">End Date for Schedule Update</label>
                        <input type="date" name="end_date" id="end_date" class="w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
                    </div>
                </div> --}}

                <div>
                    <button type="submit" class="hover:shadow-form w-full rounded-md bg-green-700 py-3 px-8 text-center text-base font-semibold text-white outline-none">
                        Update Field
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
let priceRangeCount = {{ count($field->priceRanges) }};

function addPriceRange() {
    const container = document.getElementById('price-ranges');
    const newRange = document.createElement('div');
    newRange.classList.add('mb-3', 'flex', 'gap-2');
    newRange.innerHTML = `
        <input type="time" name="price_ranges[${priceRangeCount}][start_time]" class="w-1/3 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
        <input type="time" name="price_ranges[${priceRangeCount}][end_time]" class="w-1/3 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
        <input type="number" name="price_ranges[${priceRangeCount}][price]" class="w-1/3 rounded-md border border-[#e0e0e0] bg-white py-2 px-3 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
    `;
    container.appendChild(newRange);
    priceRangeCount++;
}
</script>
@endsection