@extends('layouts.custom')

@section('title', 'Verify Otp ')

@section('content')
    
    {{-- <form method="POST" action="{{ route('verify.otp.submit') }}" class="bg-white shadow-md rounded px-8 py-6">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2" for="otp">OTP:</label>
            <input type="text" name="otp" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="otp" placeholder="Enter OTP" required>
            <button type="submit" class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Verifikasi OTP</button>
        </div>
    </form>

    <div class="flex items-center justify-between">
        <form method="POST" action="{{ route('resend.otp') }}">
            @csrf
            <input type="hidden" name="email" value="{{ session('email') }}">
            <button type="submit" class="inline-block align-baseline font-bold text-sm text-teal-500 hover:text-teal-800">Kirim Ulang OTP</button>
        </form>
    </div> --}}

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="my-10">
        <div class="max-w-md mx-auto border mt-20">
            
            <div class="bg-white shadow-md rounded px-8 py-6">
                <form method="POST" action="{{ route('verify.otp.submit') }}" class="">
                    @csrf
                    <div class="mb-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2" for="otp">OTP:</label>
                            <input type="text" name="otp" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="otp" placeholder="Enter OTP" required>
                        </div>
                        <button type="submit" class="bg-teal-500 hover:bg-teal-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Verifikasi OTP</button>
                    </div>
                </form>
                <form method="POST" action="{{ route('resend.otp') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ session('email') }}">
                    <button type="submit" class="inline-block align-baseline font-bold text-sm text-teal-500 hover:text-teal-800">Resend OTP</button>
                </form>
            </div>
        </div>
    </section>

@endsection