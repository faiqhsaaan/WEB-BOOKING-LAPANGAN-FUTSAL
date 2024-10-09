<nav
      class="bg-white dark:bg-gray-900 fixed w-full z-50 top-0 start-0 border-b border-gray-200 dark:border-gray-600"
    >
    <div
    class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto md:p-4 p-2"
    >
        @php
            $brand = App\Models\Brand::first();
        @endphp
        <a
            href="{{ route('home.index') }}"
            class="flex items-center space-x-3 rtl:space-x-reverse"
        >
            <img
            src="{{ Storage::url($brand->image) }}"
            class="h-8"
            alt="Logo"
            />
            <span
            class="self-center md:text-2xl text-lg font-semibold whitespace-nowrap dark:text-white"
            >{{ $brand->name }}</span
            >
        </a>
    <div class="flex md:order-2 space-x-1 items-center md:gap-4 gap-1 md:space-x-0 rtl:space-x-reverse">
        @auth
            <a href="{{ route('chart') }}">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>
            <div class="flex items-center md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                <button type="button" class="flex text-sm bg-gray-800 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    <span class="sr-only">Open user menu</span>
                    <img class="w-8 h-8 rounded-full" src="{{ Storage::url(auth()->user()->profile_image) }}" alt="user photo">
                </button>
            
                <div class=" z-auto hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" id="user-dropdown">
                    <div class="px-4 py-3">
                    <span class="block text-sm text-gray-900 dark:text-white">{{ Auth::user()->name }}</span>
                    <span class="block text-sm  text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->email }}</span>
                    </div>
                    <ul class="py-2" aria-labelledby="user-menu-button">
                    @if (Gate::allows('admin') || Gate::allows('staff'))
                        <li>
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Dashboard</a>
                        </li>
                    @endif

                    <li>
                        <a href="{{ route('home.profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profile</a>
                    </li>
                    <li>
                        <a href="{{ route('transaction.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Pesanan</a>
                    </li>
                    <li>
                        <a href="#" class="block px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"> 
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form></a>
                    </li>
                    </ul>
                </div>
            </div>
        @endauth

        @guest
            <a
            href="{{ route('login') }}"
            class="text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800"
            >
            Login
            </a>
        @endguest
        
        <button
        data-collapse-toggle="navbar-sticky"
        type="button"
        class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
        aria-controls="navbar-sticky"
        aria-expanded="false"
        >
        <span class="sr-only">Open main menu</span>
        <svg
            class="w-5 h-5"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 17 14"
        >
            <path
            stroke="currentColor"
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M1 1h15M1 7h15M1 13h15"
            />
        </svg>
        </button>
    </div>
    <div
        class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1"
        id="navbar-sticky"
    >
        <ul
        class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700"
        >
        <li>
            <a
            href="{{ route('home.index') }}"
            class="block py-2 px-3 {{ Route::currentRouteName() === 'home.index' ? 'text-green-700 ' : 'text-black' }} "
            aria-current="page"
            >Home</a
            >
        </li>
        <li>
            <a
            href="{{ route('home_contact.index') }}"
            class="block py-2 px-3 {{ Route::currentRouteName() === 'home_contact.index' ? 'text-green-700 ' : 'text-black' }}"
            >Contact</a
            >
        </li>
        </ul>
    </div>
    </div>
</nav>