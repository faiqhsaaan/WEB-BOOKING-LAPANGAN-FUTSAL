@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Discount Create')

@section('content')
<main class="p-4 md:ml-64 h-auto pt-16">
    <div class="p-12">
        <div class="mb-5">
            <h2 class="text-3xl font-bold text-gray-900">Discount Create</h2>
        </div>

        <div class="bg-white shadow-xl mx-auto w-full max-w-[1250px] p-10 rounded-lg">
            <form action="{{ route('discount.store') }}" method="POST" enctype="multipart/form-data">
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
                    <label for="field_id" class="mb-3 block text-base font-medium text-[#07074D]">Field</label>
                    <select name="field_id" id="field_id" class="form-control w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" disabled>
                        <option value="">Select Field</option>
                    </select>
                    @error('field_id')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="discount" class="mb-3 block text-base font-medium text-[#07074D]">Discount (%)</label>
                    <input type="number" name="discount" id="discount" placeholder="Enter discount percentage" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('discount') }}" min="0" max="100" />
                    @error('discount')
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
<script>
    $(document).ready(function() {
        $('#lapangan_id').change(function() {
            var lapanganId = $(this).val();
            if (lapanganId) {
                $.ajax({
                    url: '/get-fields/' + lapanganId,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        $('#field_id').empty();
                        $('#field_id').append('<option value="">Select Field</option>');
                        $.each(data, function(key, value) {
                            $('#field_id').append('<option value="' + value.id + '">' + value.name + ' - Base Price: ' + value.base_price + '</option>');
                        });
                        $('#field_id').prop('disabled', false);
                    }
                });
            } else {
                $('#field_id').empty();
                $('#field_id').append('<option value="">Select Field</option>');
                $('#field_id').prop('disabled', true);
                $('#field_id').prop('disabled', true);
            }
        });
    });
</script>
@endsection