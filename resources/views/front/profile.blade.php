@extends('layouts.custom')

@section('title', 'Detail Page')

@section('content')

    <section class="py-10 mt-10 dark:bg-gray-900">
        <div class="lg:w-[80%] md:w-[90%] xs:w-[96%] mx-auto flex gap-4">
            <div
                class="lg:w-[88%] md:w-[80%] sm:w-[88%] xs:w-full mx-auto shadow-2xl p-4 rounded-xl h-fit self-center dark:bg-gray-800/40">
                <!--  -->
                <div class="">
                    <h1
                        class="lg:text-3xl md:text-2xl sm:text-xl xs:text-xl  font-bold mb-2 dark:text-white">
                        Profile
                    </h1>
                    <h2 class="text-grey text-sm mb-4 dark:text-gray-400">Create Profile</h2>
                    @if (session('error'))
                    <div class="bg-red-400">
                        {{ session('error') }}
                    </div>
                    @endif
                    <form action="{{ route('home.edit.profile', $user->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <!-- Cover Image -->
                        <div
                            class="w-full rounded-sm bg-cover bg-center bg-no-repeat items-center">
                            <!-- Profile Image -->
                            <div
                                class="mx-auto flex justify-center w-[141px] h-[141px] bg-blue-300/20 rounded-full bg-[url('{{ Storage::url($user->profile_image) }}')] bg-cover bg-center bg-no-repeat">

                                <div class="bg-white/90 rounded-full w-6 h-6 text-center ml-28 mt-4">

                                    <input type="file" name="profile_image" id="upload_profile" hidden>

                                    <label for="upload_profile">
                                            <svg data-slot="icon" class="w-6 h-5 text-blue-700" fill="none"
                                                stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
                                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z">
                                                </path>
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0ZM18.75 10.5h.008v.008h-.008V10.5Z">
                                                </path>
                                            </svg>
                                        </label>
                                </div>
                            </div>
                        </div>
                        <h2 class="text-center mt-1 font-semibold dark:text-gray-300">Upload Profile
                        </h2>
                        <div class="flex lg:flex-row md:flex-col sm:flex-col xs:flex-col gap-2 justify-center w-full">
                            <div class="w-full  mb-4 mt-6">
                                <label for=""  class="mb-2 dark:text-gray-300">Name</label>
                                <input type="text"
                                        value="{{ $user->name }}"
                                        name="name"
                                        class="mt-2 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                        placeholder="Name">
                            </div>
                            <div class="w-full  mb-4 lg:mt-6">
                                <label for="" class=" dark:text-gray-300">Email</label>
                                <input type="email"
                                        value="{{ $user->email }}"
                                        name="email"
                                        class="mt-2 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                        placeholder="Email">
                            </div>
                        </div>

                        <div class="flex lg:flex-row md:flex-col sm:flex-col xs:flex-col gap-2 justify-center w-full">
                            <div class="w-full mb-4 lg:mt-6">
                                <label for="" class=" dark:text-gray-300">Phone</label>
                                <input type="text"
                                        name="phone"
                                        value="{{ $user->phone }}"
                                        class="mt-2 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                        placeholder="Tambahkan Phone">
                            </div>
                            <div class="w-full  mb-4 lg:mt-6">
                                <label for="" class=" dark:text-gray-300">Sosmed</label>
                                <input type="text"
                                        name="sosmed"
                                        value="{{ $user->sosmed }}"
                                        class="mt-2 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                        placeholder="Tambahkan Sosmed">
                            </div>
                        </div>
                        <div class="w-full  mb-4 lg:mt-6">
                            <label for="" class=" dark:text-gray-300">Prefrence</label>
                            <input type="text"
                                    value="{{ $user->prefrences }}"
                                    name="prefrences"
                                    class="mt-2 w-full border-2 rounded-lg dark:text-gray-200 dark:border-gray-600 dark:bg-gray-800"
                                    placeholder="Tambahkan Prefrence">
                        </div>
                        <div class="w-full rounded-lg bg-blue-500 mt-4 text-white text-lg font-semibold">
                            <button type="submit" class="w-full p-2">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection