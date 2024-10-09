@extends('layouts.custom')

@section('title', 'Register')

@section('content')

    <!-- source:https://codepen.io/owaiswiz/pen/jOPvEPB -->
    <div class="min-h-screen bg-gray-100 text-gray-900 flex justify-center">
        <div class="max-w-screen-xl m-0 sm:m-10 bg-white shadow sm:rounded-lg flex justify-center flex-1">
            <div class="lg:w-1/2 xl:w-5/12 p-6 sm:p-12">
                <div>
                    @php
                        $brand = App\Models\Brand::first();
                    @endphp
                    <img src="{{ Storage::url($brand->image) }}"
                        class="w-[100px]" />
                </div>
                <div class="mt-12 flex flex-col items-center">
                    <div class="w-full flex-1 mt-8">
                        <div class="flex flex-col items-center">
                            <div
                                class="w-full max-w-xs font-bold py-3 text-gray-800 flex items-center justify-center">
                                <p class="text-3xl">New User</p>
                            </div>

                        </div>

                        {{-- <div class="my-12 border-b text-center">
                            <div
                                class="leading-none px-2 inline-block text-sm text-gray-600 tracking-wide font-medium bg-white transform translate-y-1/2">
                                Or sign In with Cartesian E-mail
                            </div>
                        </div> --}}

                        <div class="mx-auto max-w-xs">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf
                                <input
                                    class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                                    type="text" placeholder="Username" name="name" />
                                <input
                                    class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                                    type="email" placeholder="Email" name="email"/>
                                <input
                                    class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                                    type="number" placeholder="Phone" name="phone"/>
                                <input
                                    class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                                    type="password" placeholder="Password" name="password"/>
                                <input
                                    class="w-full px-8 py-4 rounded-lg font-medium bg-gray-100 border border-gray-200 placeholder-gray-500 text-sm focus:outline-none focus:border-gray-400 focus:bg-white mt-5"
                                    type="password" placeholder="Password Confirmation" name="password_confirmation"/>
                                <button
                                    type="submit"
                                    class="mt-5 tracking-wide font-semibold bg-green-400 text-white-500 w-full py-4 rounded-lg hover:bg-green-700 transition-all duration-300 ease-in-out flex items-center justify-center focus:shadow-outline focus:outline-none">
                                    <svg class="w-6 h-6 -ml-2" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                                        <circle cx="8.5" cy="7" r="4" />
                                        <path d="M20 8v6M23 11h-6" />
                                    </svg>
                                    <span class="ml-">
                                        Sign Up
                                    </span>
                                </button>
                            </form>
                            <p class="mt-6 text-xs text-gray-600 text-center">
                                Already have an account?
                                <a href="{{ route('login') }}" class="border-b border-gray-500 border-dotted">
                                    Log In
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-1  text-center hidden lg:flex">
                <div class="w-full bg-contain bg-center bg-no-repeat"
                    style="background-image: url('https://img.freepik.com/premium-vector/portuguese-man-is-playing-futsal_1238364-2604.jpg?w=740');">
                </div>
            </div>
        </div>
    </div>
@endsection
