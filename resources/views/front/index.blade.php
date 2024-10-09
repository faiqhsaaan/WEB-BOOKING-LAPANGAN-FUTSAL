@extends('layouts.custom')

@section('title', 'Home Page')

@section('content')
    
    <section class="px-3 py-5 lg:py-10">
      

        <div id="default-carousel" class="relative w-full" data-carousel="slide">
            <!-- Carousel wrapper -->
            <div class="mt-10 relative h-56 overflow-hidden rounded-lg md:h-96">
                <!-- Item 1 -->
                @foreach ($promotions as $promotion)
                  <a href="{{ route('home.detail', $promotion->lapangan->id) }}">
                    <div class="hidden duration-700 ease-in-out" data-carousel-item>
                        <img src="{{ Storage::url($promotion->image) }}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">
                    </div>
                  </a>
                @endforeach
            </div>
            {{-- <!-- Slider indicators -->
            <div class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse">
                <button type="button" class="w-3 h-3 rounded-full" aria-current="true" aria-label="Slide 1" data-carousel-slide-to="0"></button>
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 2" data-carousel-slide-to="1"></button>
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 3" data-carousel-slide-to="2"></button>
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 4" data-carousel-slide-to="3"></button>
                <button type="button" class="w-3 h-3 rounded-full" aria-current="false" aria-label="Slide 5" data-carousel-slide-to="4"></button>
            </div> --}}
            <!-- Slider controls -->
            <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
            </button>
            <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
            </button>
        </div>

    </section>

    <h1 class="pt-16 lg:text-3xl md:text-3xl text-2xl font-bold text-center">Rekomendasi Lapangan Futsal</h1>

    {{-- <!-- Modal Background -->
    <div id="searchModal" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <!-- Modal Content -->
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 mt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Search</h3>
                    <div class="mt-2">
                      <div class="mb-5">
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
                        <form method="GET" action="{{ route('home.index') }}" class="flex mb-4">
                          <select name="regencies_id" id="regencies_id" value="{{ request()->get('regencies_id') }}" class="form-control w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                              <option value="">Select City</option>
                          </select>
                          @error('regencies_id')
                          <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                          @enderror
                          </div>
                          <div class="">
                            <label
                              for="default-search"
                              class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white"
                              >Search</label
                            >
                            <input
                              type="search"
                              name="search"
                              id="default-search"
                              class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500"
                              placeholder="Search facilities ..."
                            />
                          </div>
                          <div>
                            <button
                            type="submit"
                            class="mt-4 text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-8 py-4 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                          >
                            Search
                          </button>
                          </div>
                        </form>
                      </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 z-auto px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button" onclick="toggleModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:w-auto sm:text-sm">Close</button>
            </div>
            </div>
        </div>
    </div>


    <div class="my-5 text-center">
        <!-- Button to Open Modal -->
    <button type="button" onclick="toggleModal()" class="text-white bg-blue-500 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-3">Open Search</button>

    </div> --}}

    <section class="py-10">
      <div class="lg:flex lg:justify-center grid grid-cols-1 md:px-20 px-10 gap-3">
        <div class="lg:mb-5">
          <form method="GET" action="{{ route('home.index') }}" class="flex">
            <select name="regencies_id" id="regencies_id" class="form-control w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                <option value="">Select City</option>
                @foreach ($allRegencies as $regency)
                    <option value="{{ $regency->regencies_id }}" {{ request('regencies_id') == $regency->regencies_id ? 'selected' : '' }}>
                        {{ $regency->regency_name }}
                    </option>
                @endforeach
            </select>
            @error('regencies_id')
                <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <input type="search" name="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-green-500 focus:border-green-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500" placeholder="Search facilities ..." />
          </div>
          <div>
            <button type="submit" class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-8 py-4 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">Search</button>
          </form>
        </div>
      </div>
    </section>

    <section class="px-10 pb-10 md:px-32 md:pb-20 mb-20">

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 lg:gap-10 md:gap-5 gap-5">
        @foreach ($results as $result)
            <div
              class="w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
              >
              <a href="{{ route('home.detail',$result->id) }}">
                <img
                  class="pb-5 rounded-t-lg w-full h-[16rem] "
                  src="{{ Storage::url($result->photos) }}"
                  alt="product image"
                />
              </a>
              <div class="px-5 pb-5">
                <a href="{{ route('home.detail',$result->id) }}">
                  <h5
                    class="text-2xl font-semibold tracking-tight text-gray-900 dark:text-white"
                  >
                    {{ $result->name }}
                  </h5>
                  <h5
                    class="text-sm mt-1 font-semibold tracking-tight text-gray-900 dark:text-white"
                  >
                    {{ $result->province->name }}, {{ $result->regencies->name }}
                  </h5>
                </a>
                <div class="pt-5 grid md:grid-cols-1 grid-cols-1 gap-1 items-center md:gap-2 lg:flex lg:justify-between">
                  <div>
                    
                      <span class="text-sm font-bold text-gray-900 dark:text-white"
                        ><span class="font-normal">Mulai</span> Rp<span class="text-lg font-bold">{{ number_format($result->price) }}</span><span class="font-normal"> / Jam</span></span
                      >
                  </div>
                  <a
                    href="{{ route('home.detail',$result->id) }}"
                    class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
                    >Detail</a
                  >
                </div>
              </div>
            </div>
        @endforeach
      </div>
    </section>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    {{-- <section class="pb-12 mx-auto md:pb-20 max-w-7xl">
        <div class="py-4 text-center md:py-8">
            <h4 class="text-base font-bold tracking-wide text-center uppercase text-teal-600">Reviews</h4>
            <p class="mt-2 tracking-tight text-gray-900 text:xl md:text-2xl">We have some fans.</p>
        </div>

        <div class="gap-8 space-y-8 md:columns-2 lg:columns-3">

            <div class="p-8 bg-white border border-gray-100 shadow-2xl aspect-auto rounded-3xl shadow-gray-600/10">
                <div class="flex gap-4 items-start">
                    <img class="w-12 h-12 rounded-full" src="https://randomuser.me/api/portraits/men/12.jpg" alt="user avatar" width="400" height="400" loading="lazy">
                    <div class="flex-1 flex justify-between items-start">
                        <div>
                            <h6 class="text-lg font-medium text-gray-700">Ravi Kumar</h6>
                            <p class="text-sm text-gray-500">Car Enthusiast</p>
                        </div>
                        <a href="https://twitter.com/ravikumar/status/1234567890"
                            class="text-blue-500 hover:text-blue-600 ml-4">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                <p class="mt-8">The quality of these seat covers is outstanding. They fit perfectly and add a touch of
                    luxury to
                    my car's interior. Highly recommend!</p>
            </div>

            <div class="p-8 bg-white border border-gray-100 shadow-2xl aspect-auto rounded-3xl shadow-gray-600/10">
                <div class="flex gap-4 items-start">
                    <img class="w-12 h-12 rounded-full" src="https://randomuser.me/api/portraits/women/14.jpg" alt="user avatar" width="200" height="200" loading="lazy">
                    <div class="flex-1 flex justify-between items-start">
                        <div>
                            <h6 class="text-lg font-medium text-gray-700">Anjali Sharma</h6>
                            <p class="text-sm text-gray-500">Marketing Professional</p>
                        </div>
                        <a href="https://www.instagram.com/p/1234567890" class="text-blue-500 hover:text-blue-600 ml-4">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                <p class="mt-8">I love the customizable designs! I was able to choose the perfect color to match my car's
                    interior. The material feels very durable.</p>
            </div>

            <div class="p-8 bg-white border border-gray-100 shadow-2xl aspect-auto rounded-3xl shadow-gray-600/10">
                <div class="flex gap-4 items-start">
                    <img class="w-12 h-12 rounded-full" src="https://randomuser.me/api/portraits/men/18.jpg" alt="user avatar" width="200" height="200" loading="lazy">
                    <div class="flex-1 flex justify-between items-start">
                        <div>
                            <h6 class="text-lg font-medium text-gray-700">Vijay Singh</h6>
                            <p class="text-sm text-gray-500">Software Developer</p>
                        </div>
                        <a href="https://www.facebook.com/vijaysingh/posts/1234567890"
                            class="text-blue-500 hover:text-blue-600 ml-4">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>
                </div>
                <p class="mt-8">These seat covers are a game-changer for long drives. The added padding and ergonomic design
                    make
                    a huge difference in comfort.</p>
            </div>

            <div class="p-8 bg-white border border-gray-100 shadow-2xl aspect-auto rounded-3xl shadow-gray-600/10">
                <div class="flex gap-4 items-start">
                    <img class="w-12 h-12 rounded-full" src="https://randomuser.me/api/portraits/women/2.jpg" alt="user avatar" width="200" height="200" loading="lazy">
                    <div class="flex-1 flex justify-between items-start">
                        <div>
                            <h6 class="text-lg font-medium text-gray-700">Priya Patel</h6>
                            <p class="text-sm text-gray-500">Mobile Developer</p>
                        </div>
                        <a href="https://twitter.com/priyapatel/status/1234567890"
                            class="text-blue-500 hover:text-blue-600 ml-4">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                <p class="mt-8">The installation was super easy, and the instructions were clear. My car looks and feels
                    much more
                    upscale now.</p>
            </div>

            <div class="p-8 bg-white border border-gray-100 shadow-2xl aspect-auto rounded-3xl shadow-gray-600/10">
                <div class="flex gap-4 items-start">
                    <img class="w-12 h-12 rounded-full" src="https://randomuser.me/api/portraits/men/62.jpg" alt="user avatar" width="200" height="200" loading="lazy">
                    <div class="flex-1 flex justify-between items-start">
                        <div>
                            <h6 class="text-lg font-medium text-gray-700">Arjun Mehta</h6>
                            <p class="text-sm text-gray-500">Manager</p>
                        </div>
                        <a href="https://www.instagram.com/p/1234567890" class="text-blue-500 hover:text-blue-600 ml-4">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                <p class="mt-8">Great value for money. The seat covers have a premium feel and have significantly improved
                    the
                    look of my car's interior.</p>
            </div>

            <div class="p-8 bg-white border border-gray-100 shadow-2xl aspect-auto rounded-3xl shadow-gray-600/10">
                <div class="flex gap-4 items-start">
                    <img class="w-12 h-12 rounded-full" src="https://randomuser.me/api/portraits/women/19.jpg" alt="user avatar" width="400" height="400" loading="lazy">
                    <div class="flex-1 flex justify-between items-start">
                        <div>
                            <h6 class="text-lg font-medium text-gray-700">Sneha Rao</h6>
                            <p class="text-sm text-gray-500">Product Designer</p>
                        </div>
                        <a href="https://www.facebook.com/sneharao/posts/1234567890"
                            class="text-blue-500 hover:text-blue-600 ml-4">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </div>
                </div>
                <p class="mt-8">Absolutely love these seat covers. They're stylish, comfortable, and were really easy to
                    install.
                    My car interior looks brand new!</p>
            </div>

        </div>
    </section> --}}

@endsection

@section('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="path/to/your/script.js"></script>

    <script>
      document.getElementById('regencies_id').addEventListener('change', function() {
        document.getElementById('cityForm').submit();
      });
    </script>
@endsection