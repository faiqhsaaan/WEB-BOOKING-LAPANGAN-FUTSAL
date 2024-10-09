@extends('layouts.custom')

@section('title', 'Detail Page')

@section('content')

    <section class="mt-5">

        <div class="bg-gray-50 dark:bg-gray-900" id="contact">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-16 text-center">
                <h2 class="text-4xl font-bold dark:text-gray-100">{{ $contact->title }}</h2>
                <p class="pt-6 pb-6 text-base max-w-2xl text-center m-auto dark:text-gray-400">
                    {{ $contact->subtitle }}
                </p>
            </div>
            <div
                class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8 pb-16 grid md:grid-cols-2 lg:grid-cols-2 gap-y-8 md:gap-x-8 md:gap-y-8 lg:gap-x-8 lg:gap-y-16">
                <div>
                    <h2 class="text-lg font-bold dark:text-gray-100">Contact Us</h2>
                    <p class="max-w-sm mt-4 mb-4 dark:text-gray-400">{{ $contact->information }}</p>
                    <div class="flex items-center mt-2 space-x-2 text-dark-600 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75">
                            </path>
                        </svg>
                        <a href="mailto:hello@company.com">{{ $contact->email }}</a>
                    </div>
                    <div class="flex items-center mt-2 space-x-2 text-dark-600 dark:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" aria-hidden="true" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 01-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z">
                            </path>
                        </svg>
                        <a href="tel:11111111111">{{ $contact->phone }}</a>
                    </div>
                </div>
                <div>
                    @auth
                        <form action="{{ route('home_contact.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="mb-5">
                                <label for="name" >Email Address</label>
                                <input type="text" value="{{ Auth::user()->name }}" placeholder="Full Name" autocomplete="false"
                                    class="w-full px-4 py-3 border-2 placeholder:text-gray-800 dark:text-white rounded-md outline-none dark:placeholder:text-gray-200 dark:bg-gray-900 focus:ring-4 border-gray-300 focus:border-gray-600 ring-gray-100 dark:border-gray-600 dark:focus:border-white dark:ring-0"
                                    name="name">
                            </div>
                            <div class="mb-5">
                                <label for="email_address" >Email Address</label>
                                <input id="email_address" value="{{ Auth::user()->email }}" type="email" placeholder="Email Address" autocomplete="false"
                                    class="w-full px-4 py-3 border-2 placeholder:text-gray-800 dark:text-white rounded-md outline-none dark:placeholder:text-gray-200 dark:bg-gray-900   focus:ring-4  border-gray-300 focus:border-gray-600 ring-gray-100 dark:border-gray-600 dark:focus:border-white dark:ring-0"
                                    name="email">
                            </div>
                            <div class="mb-5">
                                <label for="phone">Phone</label>
                                <input id="phone" value="{{ Auth::user()->phone }}" type="number" placeholder="Tambahkan Phone" autocomplete="false"
                                    class="w-full px-4 py-3 border-2 placeholder:text-gray-800 dark:text-white rounded-md outline-none dark:placeholder:text-gray-200 dark:bg-gray-900   focus:ring-4  border-gray-300 focus:border-gray-600 ring-gray-100 dark:border-gray-600 dark:focus:border-white dark:ring-0"
                                    name="phone">
                            </div>
                            <div class="mb-5 pb-3">
                                <div class="relative mb-5">
                                    <label for="labels-range-input" >Rating</label>
                                    <input id="labels-range-input" name="rating" type="range" value="500" min="1" max="5" step="1" class="w-full h-2 bg-gray-200 rounded-lg appearance-none cursor-pointer dark:bg-gray-700">
                                    <span class="text-sm text-gray-500 dark:text-gray-400 absolute start-0 -bottom-6">1</span></span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400 absolute start-1/4 -translate-x-1/2 rtl:translate-x-1/2 -bottom-6">2</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400 absolute start-2/4 -translate-x-1/2 rtl:translate-x-1/2 -bottom-6">3</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400 absolute start-3/4 -translate-x-1/2 rtl:translate-x-1/2 -bottom-6">4</span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400 absolute end-0 -bottom-6">5</span>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="comment" >Message</label>
                                <textarea placeholder="Your Message"
                                    class="w-full px-4 py-3 border-2 placeholder:text-gray-800 dark:text-white dark:placeholder:text-gray-200 dark:bg-gray-900   rounded-md outline-none  h-36 focus:ring-4  border-gray-300 focus:border-gray-600 ring-gray-100 dark:border-gray-600 dark:focus:border-white dark:ring-0"
                                    name="comment">
                                </textarea>
                            </div>
                            <button type="submit"
                                class="w-full py-4 font-semibold text-white transition-colors bg-gray-900 rounded-md hover:bg-gray-800 focus:outline-none focus:ring-offset-2 focus:ring focus:ring-gray-200 px-7 dark:bg-white dark:text-black ">Send
                                Message
                            </button>
                        </form>
                    @endauth

                    @guest
                        <div class="shadow-xl p-5 max-w-md">
                            <p>Login Untuk Bisa Mengirimkan Feedback</p>
                        </div>
                    @endguest
                </div>
            </div>
        </div>

    </section>

@endsection