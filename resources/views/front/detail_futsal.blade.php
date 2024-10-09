@extends('layouts.custom')

@section('title', 'Detail Page')

@section('content')

    <section>
      <div class="max-w-screen-xl mx-auto py-10">
        <a href="#">
          <img
            class="md:w-full md:h-[500px] md:object-cover hidden lg:block "
           
            src="{{ Storage::url($lapangans->photos) }}"
            alt="Sunset in the mountains"
          />
        </a>
      </div>
      <div class="lg:px-28 md:px-14 px-10">
        <div class="px-2">
          <h1 class="lg:text-4xl md:text-3xl text-2xl font-semibold">{{ $lapangans->name }}</h1>
          <br />
          <p class="lg:text-lg md:text-sm text-sm font-medium"><span class="text-green-900">{{ $lapangans->province->name }}</span> / <span class="text-green-900">{{ $lapangans->regencies->name }}</span></p>
        </div>
      </div>
      <div class="md:h-screen md:flex md:justify-between px-10 lg:px-16 mb-5 lg:gap-5">
        

        <section class="lg:px-5 lg:pl-14 pb-10 px-5">

          
          <h1 class="md:text-2xl text-xl font-semibold py-5">Pilih Lapangan</h1>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 lg:gap-7 gap-5">
            @foreach ($fields as $result)
                <div
                  class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
                  >
                  <a href="#">
                    <img
                      class="pb-3 rounded-t-lg lg:w-[25rem] lg:h-[12rem] md:w-[20rem] md:h-[8rem]"
                      src="{{ Storage::url($result->image) }}"
                      alt="product image"
                    />
                  </a>
                  <div class="px-5 pb-3">
                    <a href="#">
                      <h5
                        class="lg:text-xl md:text-lg font-semibold tracking-tight text-gray-900 dark:text-white"
                      >
                        {{ $result->name }}
                      </h5>
                      <h5
                        class="lg:text-sm md:text-xs mt-1 font-semibold tracking-tight text-gray-900 dark:text-white"
                      >
                        {{ $result->description }}
                      </h5>
                    </a>
                      <div class="pt-5 flex items-center justify-between">
                      <a
                        href="{{ route('jadwal.detail', ['lapangan' => $result->lapangan_id , 'field' => $result->id]) }}#jadwalDetail"
                        class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm lg:px-4 lg:py-2 md:px-3 md:py-1 py-1 px-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                        >Jadwal</a
                      >
                    </div>
                  </div>
                </div>
            @endforeach
          </div>
        </section>
        <div>
          
          <div class="w-full my-3 pr-12">
            <hr>
          </div>

            <div class="max-w-screen-sm pr-16">
              <h2 class="text-lg font-bold">Description</h2>
              <p class="lg:text-lg md:text-sm my-2">{{ $lapangans->description }}</p>
              <h2 class="text-lg mt-5 font-bold">Address</h2>
              <p class="lg:text-lg md:text-sm my-2">{{ $lapangans->location }}</p>
              <h2 class="text-lg mt-5 font-bold">Facilities</h2>
              <p class="lg:text-lg md:text-sm my-2">{{ $lapangans->facilities }}</p>
            </div>
            <div id="jadwal" class="w-full mt-3">
              <hr>
            </div>
        </div>

        {{-- <div
          class="text-gray-700 shadow-md bg-clip-border h-[250px] rounded-xl"
          >
          <div class="p-6">
            <h3 class="text-sm font-normal">Buka Jam</h3>
            <h3 class="text-xl font-bold mb-5 mt-2">06:00 - 23:00<span class=" text-sm font-normal"></span></h3>
            <h3 class="text-sm font-normal">Mulai Dari</h3>
            <h3 class="text-xl font-bold mb-5 mt-2">Rp {{ number_format($lapangans->price) }} <span class=" text-sm font-normal">Per Jam</span></h3>
            <a href="#jadwal"class="align-middle select-none font-sans font-bold text-center transition-all disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-lg py-3 px-20 rounded-lg bg-green-600 text-white shadow-md shadow-gray-900/10">
              Cek Ketersediaan
            </a>
          </div>
        </div> --}}

        

      </div>
    </section>

    {{-- <section class="px-10 pb-10 mt-10 lg:px-32 lg:pb-20">

      <h1 class="text-3xl font-semibold py-5">Pilih Lapangan</h1>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 lg:gap-7 gap-5">
        @foreach ($fields as $result)
            <div
              class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
              >
              <a href="#">
                <img
                  class="pb-5 rounded-t-lg"
                  style="width: 25rem; height: 16rem;"
                  src="{{ Storage::url($result->image) }}"
                  alt="product image"
                />
              </a>
              <div class="px-5 pb-5">
                <a href="#">
                  <h5
                    class="text-3xl font-semibold tracking-tight text-gray-900 dark:text-white"
                  >
                    {{ $result->name }}
                  </h5>
                  <h5
                    class="text-md mt-1 font-semibold tracking-tight text-gray-900 dark:text-white"
                  >
                    {{ $result->description }}
                  </h5>
                </a>
                  <div class="pt-5 flex items-center justify-between">
                  <a
                    href="{{ route('jadwal.detail', ['lapangan' => $result->lapangan_id , 'field' => $result->id]) }}#jadwalDetail"
                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                    >Jadwal</a
                  >
                </div>
              </div>
            </div>
        @endforeach
      </div>
    </section> --}}

    {{-- <section class="px-32 py-5">
        

      <div class="mb-5">
        <p class="text-2xl font-semibold">Review</p>
      </div>
        @forelse ($feedbacks as $feedback)
            
            @if ($feedback->rating >= 4)
                
                <div class="mb-5">
                    <article class="bg-gray-100 p-5 rounded-lg">
                        <div class="flex items-center mb-4">
                            <img class="w-10 h-10 me-4 rounded-full" src="{{ Storage::url($feedback->user->profile_image) }}" alt="">
                            <div class="font-medium dark:text-white">
                                <p>{{ $feedback->user->name }} <time datetime="2014-08-16 19:00" class="block text-sm text-gray-500 dark:text-gray-400"></time></p>
                            </div>
                        </div>
                        <footer class="mb-3 text-sm text-gray-500 dark:text-gray-400"><p>Reviewed {{ $feedback->date }},{{ $feedback->time }}</p></footer>
                        @if ($feedback->rating == 5)
                            
                            <div class="flex items-center mb-1 space-x-1 rtl:space-x-reverse">
                                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                </svg>
                                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                </svg>
                                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                </svg>
                                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                </svg>
                                <svg class="w-4 h-4 text-yellow-300 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                </svg>
                                <h3 class="ms-2 text-sm font-semibold text-gray-900 dark:text-white"></h3>
                            </div>
                        @elseif ($feedback->rating == 4)

                            <div class="flex items-center mb-1 space-x-1 rtl:space-x-reverse">
                                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                </svg>
                                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                </svg>
                                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                </svg>
                                <svg class="w-4 h-4 text-yellow-300" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                </svg>
                                <svg class="w-4 h-4 text-gray-300 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/>
                                </svg>
                                <h3 class="ms-2 text-sm font-semibold text-gray-900 dark:text-white"></h3>
                            </div>
                            
                        @endif
                        <p class="mb-2 text-gray-500 dark:text-gray-400">{{ $feedback->comment }}</p>
                        {{-- <aside>
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">19 people found this helpful</p>
                            <div class="flex items-center mt-3">
                                <a href="#" class="px-2 py-1.5 text-xs font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Helpful</a>
                                <a href="#" class="ps-4 text-sm font-medium text-blue-600 hover:underline dark:text-blue-500 border-gray-200 ms-4 border-s md:mb-0 dark:border-gray-600">Report abuse</a>
                            </div>
                        </aside> 
                    </article>
                </div>
            
            @elseif ($feedback->rating < 4)

            @endif

        @empty
            <p>Tidak Ada Review</p>
        @endforelse

    </section> --}}

@endsection