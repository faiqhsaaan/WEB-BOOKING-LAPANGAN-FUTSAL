<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Detail</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { text-align: center; margin-bottom: 20px; }
        .detail { margin-bottom: 10px; }
        .item { margin-bottom: 5px; }
        .subtotal { font-weight: bold; margin-top: 10px; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f0f0f0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Transaction Detail</h1>
        <p>Order #{{ $transaction->id }}</p>
        <p>Date: {{ $transaction->created_at }}</p>
        <p>Invoice: {{ $transaction->short_invoice }}</p>
    </div>

    @foreach ($groupedItems as $lapanganId => $items)
        @php
        $lapangan = $items->first()->lapangan;
        $subtotal = $items->sum(function($item) {
            return $item->field->discounted_price ?? $item->jadwal->price;
        });
        @endphp
        <div class="detail">
            <h2>{{ $lapangan->name }}</h2>
            <table>
                <thead>
                    <tr>
                        <th>Lapangan</th>
                        <th>Tanggal</th>
                        <th>Waktu</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                        <tr>
                            <td>{{ $item->field->name }}</td>
                            <td>{{ $item->jadwal->date }}</td>
                            <td>{{ $item->jadwal->start_time }} - {{ $item->jadwal->end_time }}</td>
                            <td>Rp{{ number_format($item->field->discounted_price ?? $item->jadwal->price) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="subtotal">
                Subtotal for {{ $lapangan->name }}: Rp{{ number_format($subtotal) }}
            </div>
        </div>
    @endforeach

    <div class="total">
        <h3>Total: Rp{{ number_format($transaction->total_price) }}</h3>
    </div>
</body>
</html>