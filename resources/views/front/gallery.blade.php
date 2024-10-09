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

      <div class="lg:ml-32 md:ml-12 sm:ml-6 mb-5">
        <h1 class="text-5xl font-bold">{{ $lapangan->name }}</h1>
        <br />
        <p class="text-2xl font-medium"><span class="text-green-900">{{ $lapangan->province->name }}</span> / <span class="text-green-900">{{ $lapangan->regencies->name }}</span></p>
      </div>

      <div class="px-32 mb-5">
        <div class="w-full py-0.5 bg-green-700"></div>
        <div class="flex justify-center items-baseline gap-5 my-2">
          <a class="text-xl font-bold" href="{{ route('home.detail', $lapangan->id) }}">
            <div class="px-4 py-1 bg-green-500 rounded-lg text-white">
              Home
            </div>
          </a>
          <a class="text-xl font-bold" href="{{ route('home.about', $lapangan->id) }}">
            About
          </a>
          <a class="text-xl font-bold" href="{{ route('home.gallery', $lapangan->id) }}">
            Gallery
          </a>
        </div>
        <div class="w-full py-0.5 bg-green-700"></div>
      </div>
    </section>

    <section class="lg:py-20 lg:px-32 md:py-10 md:px-12">
       @if(session('success'))
          <div class="bg-green-500 text-center text-white p-4 rounded mb-4">
              {{ session('success') }}
          </div>
      @endif
      @error('image')
          <div class="text-red-500 text-center mt-2">{{ $message }}</div>
      @enderror
      <form class="text-center my-8" action="{{ route('home.gallery.create', $lapangan->id) }}">
        <input type="hidden" name="lapangan_id" value="{{ $lapangan->id }}" id="">
        <input type="file" class="form-control border-collapse" name="image">
        <button class="px-3 py-2 bg-green-500 rounded-lg" type="hidden">
          Tambah
        </button>
      </form>

      <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
          @foreach ($lapangan->gallery as $gallery)
            <div>
                <img class="h-auto max-w-full rounded-lg" src="{{ Storage::url($gallery->image) }}" alt="">
            </div>
          @endforeach
      </div>


    </section>

@endsection