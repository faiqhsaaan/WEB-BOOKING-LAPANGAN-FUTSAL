<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
        <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
        <link href="/style/main.css" rel="stylesheet" />
        <link href="https://cdn.datatables.net/v/dt/dt-2.0.8/datatables.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" integrity="sha512-L0Shl7nXXzIlBSUUPpxrokqq4ojqgZFQczTYlGjzONGTDAcLremjwaWv5A+EDLnxhQzY5xUZPWLOLqYRkY0Cbw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    
        <link href='https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.css' rel='stylesheet' />
        <script src="sweetalert2/dist/sweetalert2.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.10.2/main.min.js'></script>
    <title>@yield('title')</title>
    @yield('style')
    @include('layouts.style')
    @include('layouts.script')
</head>
<body>
    @if (Route::currentRouteName() === 'verify.otp' | Route::currentRouteName() === 'register' || Route::currentRouteName() === 'login')

    @else
        @include('layouts.header')
    @endif
    <main>
        @yield('content')
    </main>
    @if ( Route::currentRouteName() === 'chart' | Route::currentRouteName() === 'verify.otp' | Route::currentRouteName() === 'register' | Route::currentRouteName() === 'login')
        
    @else
        @include('layouts.footer')
    @endif

    @yield('script')
    <!-- Floating Cart -->
    <div id="floatingCart" class="fixed bottom-4 md:right-4 bg-white rounded-lg shadow-lg hidden max-w-sm w-full">
        <div id="cartHeader" class="flex justify-between items-center p-4 border-b">
            <h3 class="font-bold text-lg">Your Bookings</h3>
            <button id="closeCart" class="text-gray-500 hover:text-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <div id="cartContent" class="p-4">
            <ul id="cartItems" class="mb-4 max-h-60 overflow-y-auto"></ul>
            <div class="flex justify-between items-center">
                <span class="text-lg">Total: <span id="cartTotal" class="font-bold">Rp 0</span></span>
                <form action="{{ route('add-to-chart') }}" method="POST" id="checkoutForm">
                    @csrf
                    <input type="hidden" name="cart_items" id="cartItemsInput">
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition duration-300">Selanjutnya</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Floating Cart Icon -->
    <div id="cartIcon" class="fixed bottom-4 right-4 bg-green-500 text-white p-3 rounded-full shadow-lg cursor-pointer hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
        <span id="cartItemCount" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center">0</span>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const floatingCart = document.getElementById('floatingCart');
        const cartIcon = document.getElementById('cartIcon');
        const closeCart = document.getElementById('closeCart');
        const cartItems = document.getElementById('cartItems');
        const cartTotal = document.getElementById('cartTotal');
        const cartItemsInput = document.getElementById('cartItemsInput');
        const cartItemCount = document.getElementById('cartItemCount');
        const checkoutForm = document.getElementById('checkoutForm');
        let cart = JSON.parse(localStorage.getItem('cart')) || [];

        function updateCart() {
            cartItems.innerHTML = '';
            let total = 0;
            cart.forEach((item, index) => {
                const li = document.createElement('li');
                li.className = 'flex justify-between items-start mb-2 pb-2 border-b';
                li.innerHTML = `
                    <div>
                        <div class="font-semibold">${item.futsal_name || 'Nama futsal tidak tersedia'}</div>
                        <div class="text-sm">${item.field_name || 'Nama lapangan tidak tersedia'}</div>
                        <div class="text-sm">${item.date || 'Tanggal tidak tersedia'}</div>
                        <div class="text-sm">${item.start_time || 'Waktu mulai tidak tersedia'} - ${item.end_time || 'Waktu selesai tidak tersedia'}</div>
                        <div class="text-sm font-semibold">Rp ${(item.price || 0).toLocaleString('id-ID')}</div>
                    </div>
                    <button class="text-red-500 hover:text-red-700 ml-2" onclick="removeItem(${index})">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                `;
                cartItems.appendChild(li);
                total += item.price || 0;
            });
            cartTotal.textContent = `Rp ${total.toLocaleString('id-ID')}`;
            cartItemsInput.value = JSON.stringify(cart);
            cartItemCount.textContent = cart.length;
            cartIcon.style.display = cart.length > 0 ? 'block' : 'none';
            localStorage.setItem('cart', JSON.stringify(cart));
        }

        function removeItem(index) {
            cart.splice(index, 1);
            updateCart();
            showNotification('Item dihapus dari keranjang');
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

        cartIcon.addEventListener('click', function() {
            floatingCart.style.display = 'block';
            cartIcon.style.display = 'none';
        });

        closeCart.addEventListener('click', function() {
            floatingCart.style.display = 'none';
            cartIcon.style.display = 'block';
        });

        checkoutForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            fetch(this.action, {
                method: 'POST',
                body: new FormData(this),
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Items successfully added to chart');
                    cart = [];
                    localStorage.removeItem('cart');
                    updateCart();
                    floatingCart.style.display = 'none';
                    cartIcon.style.display = 'none';
                    window.location.href = data.redirect;
                } else {
                    showNotification(data.message || 'Error adding items to chart');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred');
            });
        });

        updateCart();

        window.addToCart = function(item) {
            if (!item.date || !item.start_time || !item.end_time || isNaN(item.price) || !item.futsal_name || !item.field_name) {
                console.error('Invalid item data:', item);
                showNotification('Maaf, terjadi kesalahan saat menambahkan item ke keranjang. Data tidak lengkap atau tidak valid.');
                return;
            }

            const existingItem = cart.find(cartItem => 
                cartItem.jadwal_id === item.jadwal_id
            );

            if (existingItem) {
                showNotification('Slot ini sudah ada di keranjang Anda.');
                return;
            }

            cart.push(item);
            updateCart();
            showNotification('Item berhasil ditambahkan ke keranjang');
        };

        window.removeItem = removeItem;
    });
    </script>

    @yield('script')
    @if (session('success'))
        <script>
            const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
            });
            Toast.fire({
            icon: "success",
            title: "{{  session('success') }}",
            });
        </script>
    @endif


    

</body>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core/main.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid/main.js'></script>
<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction/main.js'></script>
</html>