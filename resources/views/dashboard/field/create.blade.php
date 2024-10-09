@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Field Create')

@section('content')
<main class="p-4 md:ml-64 h-auto pt-16">
    <div class="p-12">
        <div class="mb-5">
            <h2 class="text-3xl font-bold text-gray-900">Field Create</h2>
        </div>

        <div class="bg-white shadow-xl mx-auto w-full max-w-[1250px] p-10 rounded-lg">

            {{-- @if($errors->any())
                @foreach($errors->all() as $error)
                    <div class="py-3 w-full rounded-3xl bg-red-500 text-white">
                        {{$error}}
                    </div>
                @endforeach
            @endif --}}

            <form action="{{ route('field.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="mb-5">
                    <label for="lapangan_id" class="mb-3 block text-base font-medium text-[#07074D]">Venue</label>
                    <select name="lapangan_id" id="lapangan_id" class="form-control w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        <option value="">Select Venue</option>
                        @foreach ($lapangans as $lapangan)
                        <option value="{{ $lapangan->id }}">{{ $lapangan->name }}</option>
                        @endforeach
                    </select>
                    @error('lapangan_id')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">Field Name</label>
                    <input type="text" name="name" id="name" placeholder="Full Name" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('name') }}" />
                    @error('name')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="image" class="mb-3 block text-base font-medium text-[#07074D]">Photo</label>
                    <input type="file" name="image" id="image" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                    @error('image')
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

                <!-- New fields for scheduling -->
                <div class="mb-5">
                    <label for="open_time" class="mb-3 block text-base font-medium text-[#07074D]">Opening Time</label>
                    <input type="time" name="open_time" id="open_time" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('open_time') }}" />
                    @error('open_time')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="close_time" class="mb-3 block text-base font-medium text-[#07074D]">Closing Time</label>
                    <input type="time" name="close_time" id="close_time" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('close_time') }}" />
                    @error('close_time')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
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
                <div class="mb-5">
                    <label for="slot_duration" class="mb-3 block text-base font-medium text-[#07074D]">Slot Duration</label>
                    <select name="slot_duration" id="slot_duration" class="form-control w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        <option value="60">1 Hour</option>
                        <option value="120">2 Hours</option>
                    </select>
                    @error('slot_duration')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="base_price" class="mb-3 block text-base font-medium text-[#07074D]">Base Price</label>
                    <input type="number" name="base_price" id="base_price" placeholder="Base Price" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('base_price') }}" />
                    @error('base_price')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div id="price-ranges">
                    <div class="mb-5 price-range-item" data-optional="true">
                        <label class="mb-3 block text-base font-medium text-[#07074D]">Price Range 1 (Optional)</label>
                        <div class="flex gap-2 items-center">
                            <input type="time" name="price_ranges[0][start_time]" placeholder="Start Time" class="w-1/3 rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            <input type="time" name="price_ranges[0][end_time]" placeholder="End Time" class="w-1/3 rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                            <input type="number" name="price_ranges[0][price]" placeholder="Price" class="w-1/3 rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <button type="button" onclick="addPriceRange()" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Add Price Range</button>
                </div>

                <div>
                    <button type="submit" class="hover:shadow-form w-full rounded-md bg-green-700 py-3 px-8 text-center text-base font-semibold text-white outline-none">
                        Create Field and Schedules
                    </button>
                </div>
            </form>
        </div>
    </div>
</main>

<script>
let priceRangeCount = 1;

function addPriceRange() {
    const container = document.getElementById('price-ranges');
    const newRange = document.createElement('div');
    newRange.classList.add('mb-5', 'price-range-item');
    newRange.innerHTML = `
        <label class="mb-3 block text-base font-medium text-[#07074D]">Price Range ${priceRangeCount + 1}</label>
        <div class="flex gap-2 items-center">
            <input type="time" name="price_ranges[${priceRangeCount}][start_time]" placeholder="Start Time" class="w-1/3 rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
            <input type="time" name="price_ranges[${priceRangeCount}][end_time]" placeholder="End Time" class="w-1/3 rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
            <input type="number" name="price_ranges[${priceRangeCount}][price]" placeholder="Price" class="w-1/3 rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" required />
            <button type="button" onclick="removePriceRange(this)" class="text-red-500 hover:text-red-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    `;
    container.appendChild(newRange);
    priceRangeCount++;
}

function removePriceRange(button) {
    const priceRangeItem = button.closest('.price-range-item');
    priceRangeItem.remove();
    updatePriceRangeLabels();
}

function updatePriceRangeLabels() {
    const priceRanges = document.querySelectorAll('.price-range-item:not([data-optional])');
    priceRanges.forEach((range, index) => {
        const label = range.querySelector('label');
        label.textContent = `Price Range ${index + 2}`;
    });
    priceRangeCount = priceRanges.length + 1;
}

document.getElementById('fieldForm').addEventListener('submit', function(event) {
    const priceRanges = document.querySelectorAll('.price-range-item:not([data-optional])');
    let hasEmptyFields = false;

    priceRanges.forEach((range) => {
        const inputs = range.querySelectorAll('input');
        inputs.forEach(input => {
            if (!input.value) {
                hasEmptyFields = true;
                input.classList.add('border-red-500');
            } else {
                input.classList.remove('border-red-500');
            }
        });
    });

    if (hasEmptyFields) {
        event.preventDefault();
        alert('Please fill in all additional price range fields before submitting.');
    }
});
</script>
@endsection