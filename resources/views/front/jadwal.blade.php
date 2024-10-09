@extends('layouts.custom')

@section('title', 'Detail Page')

@section('content')
    <section>
        <div class="max-w-screen-xl mx-auto py-10">
            <a href="#">
                <img class="w-full h-[500px] object-cover hidden lg:block" src="{{ Storage::url($field->image) }}" alt="Lapangan image" />
            </a>
        </div>

        <div class="lg:ml-32 md:ml-12 sm:ml-6 ml-3" id="jadwalDetail">
            <h1 class="lg:text-5xl md:text-3xl text-2xl font-bold">{{ $lapangans->name }} / {{ $fields->name }}</h1>
            <br />
            <p class="lg:text-2xl md:text-xl text-lg">{{ $fields->description }}</p>
        </div>
    </section>

    <section class="py-5 px-5 md:px-12 lg:px-32 mb-48">
        <h2 class="lg:text-3xl md:text-2xl text-xl font-bold text-center mb-6">Jadwal Lapangan</h2>
        
        <div class="mb-4 flex justify-center items-center">
            <form method="GET" action="{{ route('jadwal.detail', ['lapangan' => $lapangans->id, 'field' => $field->id]) }}" class="flex items-center">
                <input type="hidden" name="week" value="{{ $currentWeek }}">
                <button type="submit" name="direction" value="prev" class="md:px-4 md:py-2 px-2 py-1  text-sm text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 mr-2" {{ $currentWeek <= 0 ? 'disabled' : '' }}>Previous Week</button>
                <span class="md:text-lg text-sm font-semibold mx-4">{{ $startDate->format('d M Y') }} - {{ $endDate->format('d M Y') }}</span>
                <button type="submit" name="direction" value="next" class="md:px-4 md:py-2 px-2 py-1 text-white bg-blue-500 rounded-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 ml-2">Next Week</button>
            </form>
        </div>

        <div class="mb-4">
            <input type="text" id="searchInput" placeholder="Cari (Hari/Tanggal/Nama)" class="w-full p-2 border rounded">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full border-collapse">
                <thead>
                    <tr>
                        <th class="border p-2">Hari / Tanggal</th>
                        @foreach ($timeSlots as $slot)
                            <th class="border p-2">
                                {{ $slot['start'] }} - {{ $slot['end'] }}
                            </th>
                        @endforeach
                    </tr>
                </thead>
                <tbody id="calendarBody">
                    @foreach ($preparedJadwals as $date => $dayJadwals)
                        <tr>
                            <td class="border p-2">
                                {{ Carbon\Carbon::parse($date)->format('l, d F Y') }}
                            </td>
                            @foreach ($timeSlots as $slot)
                                @if (isset($dayJadwals[$slot['start']]))
                                    @php
                                        $slotData = $dayJadwals[$slot['start']][0];
                                    @endphp
                                    <td class="border p-2">
                                        <div class="text-center">
                                            @if ($slotData['status'] == 'booked')
                                                <span class="bg-gray-200 text-gray-700 p-1 px-3 rounded text-md">{{ $slotData['name'] ?? 'Booked' }}</span>
                                            @elseif ($slotData['status'] == 'available')
                                                <div class="flex flex-col items-center">
                                                    <span class="text-xs mb-1">Rp {{ number_format($slotData['price'], 0, ',', '.') }}</span>
                                                    @auth
                                                        <button type="button" 
                                                                class="add-to-cart bg-green-500 text-white p-1 px-3 rounded text-md hover:bg-green-600"
                                                                data-lapangan-id="{{ $lapangans->id }}"
                                                                data-field-id="{{ $field->id }}"
                                                                data-jadwal-id="{{ $slotData['id'] }}"
                                                                data-price="{{ $slotData['price'] }}"
                                                                data-date="{{ $date }}"
                                                                data-start-time="{{ $slot['start'] }}"
                                                                data-end-time="{{ $slot['end'] }}"
                                                                data-futsal-name="{{ $lapangans->name }}"
                                                                data-field-name="{{ $fields->name }}">
                                                            Book
                                                        </button>
                                                    @else
                                                        <a href="{{ route('login') }}" class="bg-green-500 text-white p-1 rounded text-md hover:bg-green-600">Book</a>
                                                    @endauth
                                                </div>
                                            @elseif ($slotData['status'] == 'maintenance')
                                                <span class="bg-red-200 text-red-700 p-1 rounded text-xl">Maintenance</span>
                                            @endif
                                        </div>
                                    </td>
                                @else
                                    <td class="border p-2">
                                        <span class="text-gray-300">Tidak Tersedia</span>
                                    </td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    {{-- <!-- Floating Cart -->
    <div id="floatingCart" class="fixed bottom-4 right-4 bg-white p-4 rounded-lg shadow-lg hidden max-w-sm w-full">
        <h3 class="font-bold mb-2 text-lg">Your Bookings</h3>
        <ul id="cartItems" class="mb-4 max-h-60 overflow-y-auto"></ul>
        <div class="flex justify-between items-center">
            <span class="text-lg">Total: <span id="cartTotal" class="font-bold">Rp 0</span></span>
            <form action="{{ route('add-to-chart') }}" method="POST" id="checkoutForm">
                @csrf
                <input type="hidden" name="cart_items" id="cartItemsInput">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">Selanjutnya</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchInput');
            const rows = document.querySelectorAll('#calendarBody tr');
            const addToCartButtons = document.querySelectorAll('.add-to-cart');
            const floatingCart = document.getElementById('floatingCart');
            const cartItems = document.getElementById('cartItems');
            const cartTotal = document.getElementById('cartTotal');
            const cartItemsInput = document.getElementById('cartItemsInput');
            let cart = [];

            // Search functionality
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                rows.forEach(row => {
                    const text = row.textContent.toLowerCase();
                    row.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });

            // Add to cart functionality
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const item = {
                        lapangan_id: this.dataset.lapanganId,
                        field_id: this.dataset.fieldId,
                        jadwal_id: this.dataset.jadwalId,
                        price: parseInt(this.dataset.price),
                        date: this.dataset.date,
                        time: this.dataset.time
                    };
                    addToCart(item);
                });
            });

            function addToCart(item) {
                // Check if the item is already in the cart
                const existingItem = cart.find(cartItem => 
                    cartItem.jadwal_id === item.jadwal_id
                );

                if (existingItem) {
                    alert('This slot is already in your cart.');
                    return;
                }

                cart.push(item);
                updateCart();
                showNotification('Item added to cart');
            }

            function updateCart() {
                cartItems.innerHTML = '';
                let total = 0;
                cart.forEach((item, index) => {
                    const li = document.createElement('li');
                    li.className = 'flex justify-between items-center mb-2 pb-2 border-b';
                    li.innerHTML = `
                        <div>
                            <div class="font-semibold">${item.date}</div>
                            <div class="text-sm">${item.time}</div>
                            <div class="text-sm font-semibold">Rp ${item.price.toLocaleString('id-ID')}</div>
                        </div>
                        <button class="text-red-500 hover:text-red-700" onclick="removeItem(${index})">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    `;
                    cartItems.appendChild(li);
                    total += item.price;
                });
                cartTotal.textContent = `Rp ${total.toLocaleString('id-ID')}`;
                cartItemsInput.value = JSON.stringify(cart);
                floatingCart.style.display = cart.length > 0 ? 'block' : 'none';
            }

            function removeItem(index) {
                cart.splice(index, 1);
                updateCart();
                showNotification('Item removed from cart');
            }

            function showNotification(message) {
                const notification = document.createElement('div');
                notification.textContent = message;
                notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded shadow-lg transition-opacity duration-500';
                document.body.appendChild(notification);
                setTimeout(() => {
                    notification.style.opacity = '0';
                    setTimeout(() => {
                        document.body.removeChild(notification);
                    }, 500);
                }, 3000);
            }

            // Make removeItem function global so it can be called from inline onclick
            window.removeItem = removeItem;
        });
    </script> --}}
    <script>
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', function() {
                const item = {
                    lapangan_id: this.dataset.lapanganId,
                    field_id: this.dataset.fieldId,
                    jadwal_id: this.dataset.jadwalId,
                    price: parseInt(this.dataset.price),
                    date: this.dataset.date,
                    start_time: this.dataset.startTime,
                    end_time: this.dataset.endTime,
                    futsal_name: this.dataset.futsalName,
                    field_name: this.dataset.fieldName
                };
                window.addToCart(item);
            });
        });
    </script>
@endsection