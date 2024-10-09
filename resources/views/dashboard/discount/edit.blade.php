@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Discount Edit')

@section('content')
<main class="p-4 md:ml-64 h-auto pt-16">
    <div class="p-12">
        <div class="mb-5">
            <h2 class="text-3xl font-bold text-gray-900">Discount Edit</h2>
        </div>

        <div class="bg-white shadow-xl mx-auto w-full max-w-[1250px] p-10 rounded-lg">
            <form action="{{ route('discount.update', $discounts->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-5">
                    <label for="lapangan_id" class="mb-3 block text-base font-medium text-[#07074D]">Futsal</label>
                    <select name="lapangan_id" id="lapangan_id" class="form-control w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        <option value="">Select Futsal</option>
                        @foreach ($lapangans as $lapangan)
                        <option value="{{ $lapangan->id }}" {{ $discounts->lapangan_id == $lapangan->id ? 'selected' : '' }}>{{ $lapangan->name }}</option>
                        @endforeach
                    </select>
                    @error('lapangan_id')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="field_id" class="mb-3 block text-base font-medium text-[#07074D]">Field</label>
                    <select name="field_id" id="field_id" class="form-control w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        <option value="">Select Field</option>
                        @foreach ($fields as $field)
                        <option value="{{ $field->id }}" {{ $discounts->field_id == $field->id ? 'selected' : '' }}>{{ $field->name }} - Base Price: {{ $field->base_price }}</option>
                        @endforeach
                    </select>
                    @error('field_id')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-5">
                    <label for="discount" class="mb-3 block text-base font-medium text-[#07074D]">Discount (%)</label>
                    <input type="number" name="discount" id="discount" value="{{ $discounts->discount }}" placeholder="Enter discount percentage" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" min="0" max="100" />
                    @error('discount')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                <div>
                    <button type="submit" class="hover:shadow-form w-full rounded-md bg-green-700 py-3 px-8 text-center text-base font-semibold text-white outline-none">
                        Update
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
                    }
                });
            } else {
                $('#field_id').empty();
                $('#field_id').append('<option value="">Select Field</option>');
            }
        });
    });
</script>
@endsection