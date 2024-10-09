<!-- resources/views/dashboard/laporan/pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Futsal Data Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>Futsal Data Report for {{ $month }}/{{ $year }}</h1>
    <table>
        <thead>
            <tr>
                <th>Futsal Name</th>
                {{-- <th>Futsal Province</th> --}}
                <th>Futsal RegenCy</th>
                {{-- <th>Futsal Address</th> --}}
                <th>Futsal Facilities</th>
                <th>Futsal Price</th>
                <th>Total Fields</th>
                <th>Total Schedules</th>
                <th>Total Booked Schedules</th>
                {{-- <th>Total Bookings</th> --}}
                <th>Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transformedData as $futsal)
                <tr>
                    <td>{{ $futsal['futsal_name'] }}</td>
                    {{-- <td>{{ $futsal['futsal_province'] }}</td> --}}
                    <td>{{ $futsal['futsal_regency'] }}</td>
                    {{-- <td>{{ $futsal['futsal_alamat'] }}</td> --}}
                    <td>{{ $futsal['futsal_facilities'] }}</td>
                    <td>{{ $futsal['futsal_price'] }}</td>
                    <td>{{ $futsal['total_fields'] }}</td>
                    <td>{{ $futsal['total_schedules'] }}</td>
                    <td>{{ $futsal['total_booked_schedules'] }}</td>
                    {{-- <td>{{ $futsal['total_bookings'] }}</td> --}}
                    <td>{{ $futsal['total_revenue'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
