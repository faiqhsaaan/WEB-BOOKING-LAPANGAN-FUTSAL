@extends('layouts-dashboard.custom')

@section('title', 'Dashboard Index')

@section('content')

<main class="p-4 md:ml-64 h-auto pt-20">
  <div class="flex justify-between items-center mb-5">
    <div>
        <h2 class="text-3xl font-bold text-gray-900">Dashboard</h2>
    </div>
    <div>
      <form method="GET" action="{{ route('dashboard') }}">
            <label for="month" class="mr-2">Pilih Bulan:</label>
            <select name="month" id="month" class="form-control w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-3 font-medium text-[#6B7280] focus:border-[#6A64F1] focus:shadow-md" onchange="this.form.submit()">
                @foreach($months as $key => $value)
                    <option value="{{ $key }}" {{ $key == request('month', 'all') ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </form>                
    </div>
  </div>
  
  @if (Gate::allows('admin'))
      <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
            <!-- Card for Total Orders -->
            <div class="shadow-lg rounded-md p-4 bg-white">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-pink-500">
                            <!-- SVG Icon for Total Orders -->
                        </div>
                        <p class="text-lg font-semibold text-gray-600 mt-1">Total Venue</p>
                        <p class="text-2xl font-bold">{{ number_format($totalFutsal) }}</p>
                    </div>
                    <div class="text-green-500 font-bold text-3xl"><i class="fa-solid fa-futbol"></i></div>
                </div>
            </div>

            <!-- Card for Total Sales -->
            <div class="shadow-lg rounded-md p-4 bg-white">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-yellow-500">
                            <!-- SVG Icon for Total Sales -->
                        </div>
                        <p class="text-lg font-semibold text-gray-600 mt-1">Total Lapangan</p>
                        <p class="text-2xl font-bold">{{ number_format($totalField) }}</p>
                    </div>
                    <div class="text-green-500 font-bold text-3xl"><i class="fa-solid fa-hockey-puck"></i></div>
                </div>
            </div>

            <!-- Card for New Customers -->
            <div class="shadow-lg rounded-md p-4 bg-white">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-green-500">
                            <!-- SVG Icon for New Customers -->
                        </div>
                        <p class="text-lg font-semibold text-gray-600 mt-1">Total Customers</p>
                        <p class="text-2xl font-bold">{{ $totalUniqueBookers }}</p>
                    </div>
                    <div class="text-green-500 font-bold text-3xl"><i class="fa-solid fa-users"></i></div>
                </div>
            </div>

            <!-- Card for Users Online -->
            <div class="shadow-lg rounded-md p-4 bg-white">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-purple-500">
                            <!-- SVG Icon for Users Online -->
                        </div>
                        <p class="text-lg font-semibold text-gray-600 mt-1">Users</p>
                        <p class="text-2xl font-bold">{{ $totalUser }}</p>
                    </div>
                    <div class="text-green-500 font-bold text-3xl"><i class="fa-solid fa-user"></i></div>
                </div>
            </div>
        </div>
  @elseif (Gate::allows('staff'))
      <!-- Stats Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-4">
            <!-- Card for Total Orders -->
            <div class="shadow-lg rounded-md p-4 bg-white">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-pink-500">
                            <!-- SVG Icon for Total Orders -->
                        </div>
                        <p class="text-lg font-semibold text-gray-600 mt-1">Total Venue</p>
                        <p class="text-2xl font-bold">{{ number_format($totalFutsal) }}</p>
                    </div>
                    <div class="text-green-500 font-bold text-3xl"><i class="fa-solid fa-futbol"></i></div>
                </div>
            </div>

            <!-- Card for Total Sales -->
            <div class="shadow-lg rounded-md p-4 bg-white">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-yellow-500">
                            <!-- SVG Icon for Total Sales -->
                        </div>
                        <p class="text-lg font-semibold text-gray-600 mt-1">Total Lapangan</p>
                        <p class="text-2xl font-bold">{{ number_format($totalField) }}</p>
                    </div>
                    <div class="text-green-500 font-bold text-3xl"><i class="fa-solid fa-hockey-puck"></i></div>
                </div>
            </div>

            <!-- Card for New Customers -->
            <div class="shadow-lg rounded-md p-4 bg-white">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-green-500">
                            <!-- SVG Icon for New Customers -->
                        </div>
                        <p class="text-lg font-semibold text-gray-600 mt-1">Total Customers</p>
                        <p class="text-2xl font-bold">{{ $totalUniqueBookers }}</p>
                    </div>
                    <div class="text-green-500 font-bold text-3xl"><i class="fa-solid fa-users"></i></div>
                </div>
            </div>

            {{-- <!-- Card for Users Online -->
            <div class="shadow-lg rounded-md p-4 bg-white">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="text-purple-500">
                            <!-- SVG Icon for Users Online -->
                        </div>
                        <p class="text-lg font-semibold text-gray-600 mt-1">Users</p>
                        <p class="text-2xl font-bold">{{ $totalUser }}</p>
                    </div>
                    <div class="text-green-500 font-bold text-3xl"><i class="fa-solid fa-user"></i></div>
                </div>
            </div> --}}
        </div>
  @endif

  <!-- Monthly Sales & Traffic Source Charts -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mb-4">
      <div>

            <!-- Bar Chart for Monthly Sales -->
            <div class="shadow-lg rounded-md p-4 bg-white">
                <h5 class="font-semibold text-xl mb-4">Revenue</h5>
                <canvas id="revenueChart"></canvas>
            </div>

            @if (Gate::allows('admin'))
                <!-- Table for Ads Performance -->
                <div class="shadow-lg rounded-md p-4 bg-white mb-4 mt-5">
                    <h5 class="font-semibold text-xl mb-4">Disount</h5>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Venue
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Discount
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach ($discounts as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->lapangan->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $item->discount }}%</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

      </div>

      <!-- Doughnut Chart for Traffic Source -->
      <div class="shadow-lg rounded-md p-4 bg-white">
          <h5 class="font-semibold text-xl mb-4">Schedules</h5>
          <canvas id="doughnutChart"></canvas>
      </div>
  </div>

  <!-- Table for Ads Performance -->
    {{-- @if (Gate::allows('admin'))
        <div class="shadow-lg rounded-md p-4 bg-white mb-4 mt-5">
            <h5 class="font-semibold text-xl mb-4">Feedback</h5>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Rating
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Message
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach ($comments as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($item->rating >= 4)
                                    @if ($item->rating == 5)
                                
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
                                    @elseif ($item->rating == 4)

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
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $item->comment }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif --}}
</main>

@endsection

@section('script')
  <script type="module">
      import Chart from 'chart.js/auto';
  </script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script>
        const revenueChart = document.getElementById('revenueChart');
        new Chart(revenueChart, {
            type: 'bar',
            data: {
                labels: @json($month == 'all' ? array_values(array_slice($months, 1)) : [$selectedMonth]),
                datasets: [{
                    label: 'Pendapatan',
                    data: @json($totalRevenue),
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        display: true
                    },
                    y: {
                        display: true
                    }
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Grafik Pendapatan'
                    }
                }
            }
        });


      const doughnutChart = document.getElementById('doughnutChart');
      new Chart(doughnutChart, {
          type: 'doughnut',
          data: {
              labels: ['Booked', 'Available'],
              datasets: [{
                  label: 'Jadwal',
                  data: [{{ $totalBookedSchedules }}, {{ $totalBookedSchedulesAvailabel }}],
                  backgroundColor: [
                      'rgba(255, 99, 132, 0.2)',
                      'rgba(75, 192, 192, 0.2)'
                  ],
                  borderColor: [
                      'rgba(255, 99, 132, 1)',
                      'rgba(75, 192, 192, 1)'
                  ],
                  borderWidth: 1
              }]
          },
          options: {
              responsive: true,
          }
      });
  </script>
@endsection
