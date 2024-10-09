@extends('layouts-dashboard.custom')

@section('title', 'Dashboard User Create')

@section('content')
<main class="p-4 md:ml-64 h-auto pt-16">
    <div class="p-12">

        <div class="mb-5">
            <h2 class="text-3xl font-bold text-gray-900">User Create</h2>
        </div>

        <div class="bg-white shadow-xl mx-auto w-full max-w-[1250px] p-10 rounded-lg">
            <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="mb-5">
                    <label for="profile_image" class="mb-3 block text-base font-medium text-[#07074D]">Profile Image</label>
                    <input type="file" name="profile_image" id="profile_image" placeholder="Masukan profile_image" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('profile_image') }}" />
                    @error('profile_image')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="name" class="mb-3 block text-base font-medium text-[#07074D]">Name</label>
                    <input type="text" name="name" id="name" placeholder="Masukan  Username" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('name') }}" />
                    @error('name')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="email" class="mb-3 block text-base font-medium text-[#07074D]">Email</label>
                    <input type="email" name="email" id="email" placeholder="Masukan email" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('email') }}" />
                    @error('email')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="phone" class="mb-3 block text-base font-medium text-[#07074D]">Phone</label>
                    <input type="number" name="phone" id="phone" placeholder="Masukan phone" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('phone') }}" />
                    @error('phone')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="password" class="mb-3 block text-base font-medium text-[#07074D]">password</label>
                    <input type="password" name="password" id="password" placeholder="Masukan password" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('password') }}" />
                    @error('password')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="mb-5">
                    <label for="prefrences" class="mb-3 block text-base font-medium text-[#07074D]">Prefrences</label>
                    <input type="text" name="prefrences" id="prefrences" placeholder="Masukan prefrences" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('prefrences') }}" />
                    @error('prefrences')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="sosmed" class="mb-3 block text-base font-medium text-[#07074D]">Sosmed</label>
                    <input type="text" name="sosmed" id="sosmed" placeholder="Masukan Link sosmed" class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" value="{{ old('sosmed') }}" />
                    @error('sosmed')
                    <div class="text-red-500 mt-2 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="role" class="mb-3 block text-base font-medium text-[#07074D]">Futsal</label>
                    <select name="role" id="role" class="form-control w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                        <option value="user">user</option>
                        <option value="admin">Admin</option>
                        <option value="staff">Staff</option>
                    </select>
                    @error('role')
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
