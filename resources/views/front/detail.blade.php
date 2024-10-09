@extends('layouts.custom')

@section('title', 'Detail Page')

@section('content')

    <section>
      <div class="max-w-screen-xl mx-auto py-10">
        <a href="#">
          <img
            class="w-full my-4"
            style="height: 500px;"
            src="{{ Storage::url($lapangan->photos) }}"
            alt="Sunset in the mountains"
          />
        </a>
      </div>

      <div class="lg:ml-32 md:ml-12 ml-12 mb-5">
        <h1 class="text-5xl font-bold">{{ $lapangan->name }}</h1>
        <br />
        <p class="text-2xl font-medium"><span class="text-green-900">{{ $lapangan->province->name }}</span> / <span class="text-green-900">{{ $lapangan->regencies->name }}</span></p>
      </div>

      <div class="px-10 lg:px-32 mb-5">
        <div class="w-full py-0.5 bg-green-700"></div>
        <div class="flex justify-center items-baseline gap-5 my-2">
          <a class="text-xl font-bold" href="{{ route('home.detail', $lapangan->id) }}">
            <div class="px-4 py-1 {{ request()->routeIs('home.detail') ? 'bg-green-700 text-white' : 'text-black' }} rounded-lg">
              Home
            </div>
          </a>
          <div class="px-4 py-1 {{ request()->routeIs('home.about') ? 'bg-green-700 text-white' : 'text-black' }} rounded-lg">
              About
            </div>
        </div>
        <div class="w-full py-0.5 bg-green-700"></div>
      </div>
    </section>

    <section class="lg:py-20 lg:px-32 md:py-10 md:px-12">
      <div class="grid lg:grid-cols-3 grid-cols-1 lg:gap-5 md:gap-2 gap-2">
        <div
          class="w-full sm:first:col-span-2 lg:py-14 lg:px-11 py-10 px-8 rounded-lg max-w-screen-xl bg-green-100"
        >
          <h3
            class="mb-4 text-black text-[27px] font-extrabold leading-none"
          >
            <span>Description </span>
          </h3>
          <div class="text-lg text-black leading-[1.8]">
            <p>
             {{ $lapangan->description }}
            </p>
          </div>
          
          <h3
            class="mt-10 mb-4 text-black text-[27px] font-extrabold leading-none"
          >
            <span>Facilities </span>
          </h3>
          <div class="text-lg text-black leading-[1.8]">
            <p>
              {{ $lapangan->facilities }}
            </p>
          </div>

          <h3
            class="mt-10 mb-4 text-black text-[27px] font-extrabold leading-none"
          >
            <span>Harga </span>
          </h3>
          <div class="text-lg text-black leading-[1.8]">
            <p>
             Rp{{ $lapangan->price }}/jam
            </p>
          </div>
        </div>

        <div
          class="w-full sm:first:col-span-2 lg:py-14 lg:px-11 px-10 py-10 rounded-lg max-w-screen-xl bg-green-100"
        >
          <h3
            class="mb-4 text-black text-[27px] font-extrabold leading-none"
          >
            <span>Location </span>
          </h3>
          <div class="text-lg text-black leading-[1.8]">
            <div class="flex gap-5 items-baseline">
              <i class="fa-solid fa-location-dot"></i>
              <p>
                {{ $lapangan->location }}
              </p>
            </div>
          </div>

          <h3
            class="mt-10 mb-4 text-black text-[27px] font-extrabold leading-none"
          >
            <span>Sosmed </span>
          </h3>
          <div class="text-lg text-black leading-[1.8]">
            <div class="flex gap-5 items-baseline">
              <p>
                @faiqhsaaan
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>

@endsection