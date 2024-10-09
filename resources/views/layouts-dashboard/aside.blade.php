<aside
        class="fixed top-0 left-0 z-40 w-64 h-screen pt-14 transition-transform -translate-x-full bg-white border-r border-gray-200 md:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidenav"
        id="drawer-navigation"
      >
        <div class="overflow-y-auto py-5 px-3 h-full bg-white dark:bg-gray-800">
          <ul class="space-y-2">
            @if (Gate::allows('admin') || Gate::allows('staff'))
              <li>
                <a
                  href="{{ route('dashboard') }}"
                  class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg {{ Route::currentRouteName() === 'dashboard' ? 'bg-green-700 text-white' : '' }} dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4"  fill="#939ba9" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M160 80c0-26.5 21.5-48 48-48l32 0c26.5 0 48 21.5 48 48l0 352c0 26.5-21.5 48-48 48l-32 0c-26.5 0-48-21.5-48-48l0-352zM0 272c0-26.5 21.5-48 48-48l32 0c26.5 0 48 21.5 48 48l0 160c0 26.5-21.5 48-48 48l-32 0c-26.5 0-48-21.5-48-48L0 272zM368 96l32 0c26.5 0 48 21.5 48 48l0 288c0 26.5-21.5 48-48 48l-32 0c-26.5 0-48-21.5-48-48l0-288c0-26.5 21.5-48 48-48z"/></svg>
                  <span class="ml-3">Overview</span>
                </a>
              </li>
            @endif
            <li>
              <a
                href="{{ route('lapangan.index') }}"
                class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg {{ Route::currentRouteName() === 'lapangan.index' ? 'bg-green-700 text-white' : '' }} dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4" fill="#939ba9" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M417.3 360.1l-71.6-4.8c-5.2-.3-10.3 1.1-14.5 4.2s-7.2 7.4-8.4 12.5l-17.6 69.6C289.5 445.8 273 448 256 448s-33.5-2.2-49.2-6.4L189.2 372c-1.3-5-4.3-9.4-8.4-12.5s-9.3-4.5-14.5-4.2l-71.6 4.8c-17.6-27.2-28.5-59.2-30.4-93.6L125 228.3c4.4-2.8 7.6-7 9.2-11.9s1.4-10.2-.5-15l-26.7-66.6C128 109.2 155.3 89 186.7 76.9l55.2 46c4 3.3 9 5.1 14.1 5.1s10.2-1.8 14.1-5.1l55.2-46c31.3 12.1 58.7 32.3 79.6 57.9l-26.7 66.6c-1.9 4.8-2.1 10.1-.5 15s4.9 9.1 9.2 11.9l60.7 38.2c-1.9 34.4-12.8 66.4-30.4 93.6zM256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zm14.1-325.7c-8.4-6.1-19.8-6.1-28.2 0L194 221c-8.4 6.1-11.9 16.9-8.7 26.8l18.3 56.3c3.2 9.9 12.4 16.6 22.8 16.6l59.2 0c10.4 0 19.6-6.7 22.8-16.6l18.3-56.3c3.2-9.9-.3-20.7-8.7-26.8l-47.9-34.8z"/></svg>
                <span class="ml-3">Venue</span>
              </a>
            </li>
            <li>
              <a
                href="{{ route('field.index') }}"
                class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg {{ Route::currentRouteName() === 'field.index' ? 'bg-green-700 text-white hover:bg-gray-500 ' : '' }} dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4" fill="#939ba9" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M256 256C114.6 256 0 213 0 160s114.6-96 256-96s256 43 256 96s-114.6 96-256 96zm192.3 1.8c24.7-9.3 46.9-21 63.7-35.6L512 352c0 53-114.6 96-256 96S0 405 0 352L0 222.3c16.8 14.6 39 26.3 63.7 35.6C114.5 276.9 182.5 288 256 288s141.5-11.1 192.3-30.2z"/></svg>
                <span class="ml-3">Field</span>
              </a>
            </li>
            <li>
              <a
                href="{{ route('promotion.index') }}"
                class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg {{ Route::currentRouteName() === 'promotion.index' ? 'bg-green-700 text-white hover:bg-gray-500 ' : '' }} dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4" fill="#939ba9" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M64 256l0-96 160 0 0 96L64 256zm0 64l160 0 0 96L64 416l0-96zm224 96l0-96 160 0 0 96-160 0zM448 256l-160 0 0-96 160 0 0 96zM64 32C28.7 32 0 60.7 0 96L0 416c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-320c0-35.3-28.7-64-64-64L64 32z"/></svg>
                <span class="ml-3">Promotion</span>
              </a>
            </li>
            <li>
              <a
                href="{{ route('discount.index') }}"
                class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg {{ Route::currentRouteName() === 'discount.index' ? 'bg-green-700 text-white hover:bg-gray-500 ' : '' }} dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4" viewBox="0 0 512 512" fill="#939ba9"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M345 39.1L472.8 168.4c52.4 53 52.4 138.2 0 191.2L360.8 472.9c-9.3 9.4-24.5 9.5-33.9 .2s-9.5-24.5-.2-33.9L438.6 325.9c33.9-34.3 33.9-89.4 0-123.7L310.9 72.9c-9.3-9.4-9.2-24.6 .2-33.9s24.6-9.2 33.9 .2zM0 229.5L0 80C0 53.5 21.5 32 48 32l149.5 0c17 0 33.3 6.7 45.3 18.7l168 168c25 25 25 65.5 0 90.5L277.3 442.7c-25 25-65.5 25-90.5 0l-168-168C6.7 262.7 0 246.5 0 229.5zM144 144a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/></svg>
                <span class="ml-3">Discount</span>
              </a>
            </li>
            <li>
              <a
                href="{{ route('report') }}"
                class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg {{ Route::currentRouteName() === 'report' ? 'bg-green-700 text-white hover:bg-gray-500 ' : '' }} dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
              >
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="w-4" fill="#939ba9"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M64 32C64 14.3 49.7 0 32 0S0 14.3 0 32L0 64 0 368 0 480c0 17.7 14.3 32 32 32s32-14.3 32-32l0-128 64.3-16.1c41.1-10.3 84.6-5.5 122.5 13.4c44.2 22.1 95.5 24.8 141.7 7.4l34.7-13c12.5-4.7 20.8-16.6 20.8-30l0-247.7c0-23-24.2-38-44.8-27.7l-9.6 4.8c-46.3 23.2-100.8 23.2-147.1 0c-35.1-17.6-75.4-22-113.5-12.5L64 48l0-16z"/></svg>
                <span class="ml-3">Report Field</span>
              </a>
            </li>
            <li>
              <a
                href="{{ route('keuangan.index') }}"
                class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg {{ Route::currentRouteName() === 'keuangan.index' ? 'bg-green-700 text-white hover:bg-gray-500 ' : '' }} dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
              >
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4" fill="#939ba9" viewBox="0 0 576 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 112.5L0 422.3c0 18 10.1 35 27 41.3c87 32.5 174 10.3 261-11.9c79.8-20.3 159.6-40.7 239.3-18.9c23 6.3 48.7-9.5 48.7-33.4l0-309.9c0-18-10.1-35-27-41.3C462 15.9 375 38.1 288 60.3C208.2 80.6 128.4 100.9 48.7 79.1C25.6 72.8 0 88.6 0 112.5zM288 352c-44.2 0-80-43-80-96s35.8-96 80-96s80 43 80 96s-35.8 96-80 96zM64 352c35.3 0 64 28.7 64 64l-64 0 0-64zm64-208c0 35.3-28.7 64-64 64l0-64 64 0zM512 304l0 64-64 0c0-35.3 28.7-64 64-64zM448 96l64 0 0 64c-35.3 0-64-28.7-64-64z"/></svg>
                <span class="ml-3">Report Finnace</span>
              </a>
            </li>
            @if (Gate::allows('admin'))
              <li>
                <a
                  href="{{ route('feedback.index') }}"
                  class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg {{ Route::currentRouteName() === 'feedback.index' ? 'bg-green-700 text-white hover:bg-gray-500 ' : '' }} dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4" fill="#939ba9" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M48 64C21.5 64 0 85.5 0 112c0 15.1 7.1 29.3 19.2 38.4L236.8 313.6c11.4 8.5 27 8.5 38.4 0L492.8 150.4c12.1-9.1 19.2-23.3 19.2-38.4c0-26.5-21.5-48-48-48L48 64zM0 176L0 384c0 35.3 28.7 64 64 64l384 0c35.3 0 64-28.7 64-64l0-208L294.4 339.2c-22.8 17.1-54 17.1-76.8 0L0 176z"/></svg>
                  <span class="flex-1 ml-3 whitespace-nowrap">Feedback</span>
                </a>
              </li>
            @endif
            @if (Gate::allows('admin'))
              <li>
                <a
                  href="{{ route('review.index') }}"
                  class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg {{ Route::currentRouteName() === 'review.index' ? 'bg-green-700 text-white hover:bg-gray-500 ' : '' }} dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" class="w-4" fill="#939ba9" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M512 240c0 114.9-114.6 208-256 208c-37.1 0-72.3-6.4-104.1-17.9c-11.9 8.7-31.3 20.6-54.3 30.6C73.6 471.1 44.7 480 16 480c-6.5 0-12.3-3.9-14.8-9.9c-2.5-6-1.1-12.8 3.4-17.4c0 0 0 0 0 0s0 0 0 0s0 0 0 0c0 0 0 0 0 0l.3-.3c.3-.3 .7-.7 1.3-1.4c1.1-1.2 2.8-3.1 4.9-5.7c4.1-5 9.6-12.4 15.2-21.6c10-16.6 19.5-38.4 21.4-62.9C17.7 326.8 0 285.1 0 240C0 125.1 114.6 32 256 32s256 93.1 256 208z"/></svg>
                  <span class="flex-1 ml-3 whitespace-nowrap">Review</span>
                </a>
              </li>
            @endif
            @if (Gate::allows('admin'))
              <li>
                <a
                  href="{{ route('user.index') }}"
                  class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg {{ Route::currentRouteName() === 'user.index' ? 'bg-green-700 text-white hover:bg-gray-500 ' : '' }} dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" fill="#939ba9" class="w-4"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512l388.6 0c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304l-91.4 0z"/></svg>
                  <span class="flex-1 ml-3 whitespace-nowrap">User</span>
                </a>
              </li>
            @endif
          </ul>
          <ul
            class="pt-5 mt-5 space-y-2 border-t border-gray-200 dark:border-gray-700"
          >
          @if (Gate::allows('admin'))
            <li>
              <a
                href="{{ route('notifications.index') }}"
                class="flex items-center p-2 text-base font-medium {{ Route::currentRouteName() === 'notifications.index' ? 'bg-green-700 text-white hover:bg-gray-500 ' : '' }} text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group"
              >
               <svg xmlns="http://www.w3.org/2000/svg" fill="#939ba9" class="w-4" viewBox="0 0 448 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M224 0c-17.7 0-32 14.3-32 32l0 19.2C119 66 64 130.6 64 208l0 18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416l384 0c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8l0-18.8c0-77.4-55-142-128-156.8L256 32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3l-64 0-64 0c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z"/></svg>
                <span class="ml-3">Notification</span>
              </a>
            </li>
            <li>
            <li>
              <a
                href="{{ route('brand.index') }}"
                class="flex items-center p-2 text-base font-medium {{ Route::currentRouteName() === 'brand.index' ? 'bg-green-700 text-white hover:bg-gray-500 ' : '' }} text-gray-900 rounded-lg transition duration-75 hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group"
              >
               <svg xmlns="http://www.w3.org/2000/svg" fill="#939ba9" class="w-4" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512z"/></svg>
                <span class="ml-3">Logo</span>
              </a>
            </li>
            <li>
              <a
                href="{{ route('contact.index') }}"
                class="flex items-center p-2 text-base font-medium text-gray-900 rounded-lg transition duration-75 {{ Route::currentRouteName() === 'contact.index' ? 'bg-green-700 text-white hover:bg-gray-500 ' : '' }} hover:bg-gray-100 dark:hover:bg-gray-700 dark:text-white group"
              >
                <svg xmlns="http://www.w3.org/2000/svg" fill="#939ba9" class="w-4" viewBox="0 0 512 512"><!--!Font Awesome Free 6.6.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"/></svg>
                <span class="ml-3">Setting</span>
              </a>
            </li>
          @endif
          </ul>
        </div>
        <div
          class="hidden absolute bottom-0 left-0 justify-center p-4 space-x-4 w-full lg:flex bg-white dark:bg-gray-800 z-20"
          >
          <ul>

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
      </aside>