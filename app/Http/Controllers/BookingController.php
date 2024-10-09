<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingItem;
use App\Models\Chart;
use App\Models\Feedback;
use App\Models\Field;
use App\Models\Jadwal;
use App\Models\lapangan;
use App\Models\message;
use App\Traits\Fonnte;
use App\Traits\IpaymuClone;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Client\Events\RequestSending;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BookingController extends Controller
{
    use IpaymuClone;

    use Fonnte;
    
    protected $auth;

    public function __construct()
    {
        $this->auth = Auth::user();
    }

    public function add_chart(Request $request)
    {
        $cartItems = json_decode($request->input('cart_items'), true);
        
        $validator = Validator::make($cartItems, [
            '*.jadwal_id' => 'required|exists:jadwals,id',
            '*.field_id' => 'required|exists:fields,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        $user_id = Auth::user()->id;

        DB::beginTransaction();

        try {
            foreach ($cartItems as $item) {
                // Ambil lapangan_id dari tabel field
                $field = Field::findOrFail($item['field_id']);
                $lapangan_id = $field->lapangan_id;

                Chart::create([
                    'lapangan_id' => $lapangan_id,
                    'field_id' => $item['field_id'],
                    'jadwal_id' => $item['jadwal_id'],
                    'user_id' => $user_id,
                ]);
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Jadwal berhasil ditambahkan ke chart. Segera isi Form Booking',
                'redirect' => route('chart')
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Silakan coba lagi.'
            ], 500);
        }
    }

    public function chart(Jadwal $jadwal)
    {
        $chart = Chart::with('lapangan', 'field', 'jadwal', 'user')
            ->where('user_id', Auth::user()->id)
            ->get();

        $user = Auth::user()->id;

        $groupedChart = $chart->groupBy('lapangan.id');
        $lapanganTotals = [];
        $total_price = 0;

        foreach ($groupedChart as $lapanganId => $items) {
            $lapanganTotal = 0;
            foreach ($items as $item) {
                if ($item->field->discounted_price) {
                    $lapanganTotal += $item->field->discounted_price;
                } else {
                    $lapanganTotal += $item->jadwal->price;
                }
            }
            $lapanganTotals[$lapanganId] = $lapanganTotal;
            $total_price += $lapanganTotal;
        }

        return view('front.chart', compact('chart', 'total_price', 'jadwal', 'user', 'groupedChart', 'lapanganTotals'));
    }

    public function chart_destroy(string $id){
        $chart = Chart::find($id);
        
        if ($chart) {
            $chart->delete();
            return redirect()->route('chart')->with('success', 'Jadwal berhasil dihapus dari chart');
        }

        return redirect()->route('chart')->with('error', 'Jadwal tidak ditemukan');
    }


    public function payment(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,id',
            'name' => 'required|string',
            'phone' => 'required|string',
            'total_price' => 'required',
        ]);

        $user = Auth::user();

        // $jadwal = Jadwal::where('id', )
        // if (!$user->phone) {
        //     return redirect()->back()->with('message', 'No phone number found for the user');
        // }

        // dd($request);

        // $lapangan = lapangan::findOrFail($data['id']);

        if ($data) {
            // Simulasi pembuatan URL pembayaran
            $payment = json_decode(
                json_encode(
                    $this->redirect_payment(
                        $this->auth->id,
                        $request->total_price,
                        $request->name,
                        $request->phone
                    )
                ), true
            );

            // Debugging: Periksa data payment
            // dd($payment);
            // dd($payment);

            $booking = Booking::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'phone' => $data['phone'],
                'date' => Carbon::now()->toDateString(),
                'time' => Carbon::now()->toTimeString(),
                'total_price' => $data['total_price'],
                'status' => 'pending',
                'invoice' => $payment['Data']['SessionID'],
                'payment_url' => $payment['Data']['Url'] ?? null,
                'payment_method' => 'ipaymu',
            ]);

            $chart = Chart::where('user_id', $user->id)->get();

            foreach ($chart as $item) {

                $booking_item = BookingItem::create([
                    'booking_id' => $booking->id,
                    'lapangan_id' => $item->lapangan_id,
                    'field_id' => $item->field_id,
                    'jadwal_id' => $item->jadwal_id,
                    'user_id' => $user->id,
                ]);              

                $item->delete();
            }

            if ($booking) {
                return redirect($booking->payment_url)->with('success', 'Segera Selesaikan Pembayaran');
            } else {
                return redirect()->back()->with('error', 'Gagal membuat booking');
            }


        }
        
        return redirect()->route('transaction.index')->with('success', 'Data Berhasil Di Tambah');
    }

    public function delete_booking($id)
    {
        $booking = Booking::findOrFail($id);
        $booking_item = BookingItem::where('booking_id', $booking->id)->get();

        foreach ($booking_item as $item){
            $item->delete();
        }

        $booking->delete();

        return redirect()->route('transaction.index')->with('success', 'Booking berhasil dihapus');
    }

    public function return(Request $request)
    {
        // Ekstrak parameter yang diperlukan dari request
        $sid = $request->sid;
        $trx = $request->trx_id;
        $status = $request->status;
        $reference_id = $request->reference_id;

        // Cari transaksi booking berdasarkan invoice (sid)
        $transaction = Booking::where('invoice', $sid)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaksi tidak ditemukan'], 404);
        }

        // Periksa apakah transaksi sudah berhasil
        if ($transaction->status == 'success') {
            return response()->json(['message' => 'Transaksi sudah berhasil'], 200);
        } else {

            // Perbarui status berdasarkan status yang diterima
            $status = $status == 'berhasil' ? 'berhasil' : $status;
            $transaction->update([
                'status' => $status,
            ]);

            // Pengalihan ke rute yang diinginkan setelah memperbarui status
            return redirect()->route('transaction.index');
        }
    }


    public function notify(Request $request)
    {
        $sid = $request->sid;
        $status = $request->status;

        $transaction = Booking::where('invoice', $sid)->first();

        if ($transaction->status == 'success') {
            return response()->json(['message' => 'Transaksi sudah berhasil'], 200);
        } else {
            $status = $status == 'berhasil' ? 'success' : $status;
            $transaction->update([
                'status' => $status,
            ]);

            $transaction_items = BookingItem::where('booking_id', $transaction->id)->get();

            // Group booking items by lapangan (futsal venue)
            $groupedItems = $transaction_items->groupBy('lapangan.id');

            foreach ($groupedItems as $lapanganId => $items) {
                $lapangan = $items->first()->lapangan;
                
                $message = "Hi " . $transaction->name . "\n\n" .
                        "Kamu Berhasil Booking di " . $lapangan->name . "\n\n";

                foreach ($items as $item) {
                    $item->jadwal->update([
                        'status' => 'booked',
                        'name' => $transaction->name,
                    ]);

                    $message .= "Lapangan: " . $item->field->name . "\n" .
                                "Tanggal: " . $item->jadwal->date . "\n" .
                                "Jam: " . $item->jadwal->start_time . " - " . $item->jadwal->end_time . "\n\n";
                }

                // Send a single message for each futsal venue
                $this->send_message($transaction->phone, $message);
            }

            return redirect()->route('transaction.index')->with('success', 'Pembayaran Berhasil');
        }
    }


    public function transaction()
    {
        $transactions = Booking::where('user_id', $this->auth->id)->orderBy('id', 'desc')->get();

        return view('front.transaction', [
            'data' => $transactions,
        ]);
    }

    public function transaction_detail($id)
    {
        $transaction = Booking::findOrFail($id);
        $transaction->short_invoice = strtoupper(substr($transaction->invoice, 0, 8));
        $booking_items = BookingItem::where('booking_id', $transaction->id)->get();

        return view('front.transaction_detail', compact('transaction', 'booking_items'));
    }

    public function generatePDF($id)
    {
        $transaction = Booking::findOrFail($id);
        $transaction->short_invoice = strtoupper(substr($transaction->invoice, 0, 8));
        $booking_items = BookingItem::where('booking_id', $transaction->id)->get();

        $groupedItems = $booking_items->groupBy('lapangan.id');

        $pdf = Pdf::loadView('front.transaction_detail_pdf', compact('transaction', 'groupedItems'));
        
        return $pdf->download('transaction_detail_' . $transaction->short_invoice . '.pdf');
    }

    public function print(){

        return view('front.transaction_detail_pdf',compact('transaction', 'booking_items'));
    }

    public function review(Request $request){

        $data = $request->validate([
            'booking_item_id' => 'required|exists:booking_items,id',
            'lapangan_id' => 'required|exists:lapangans,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        $data['user_id'] = Auth::user()->id;

        Feedback::create([
            'booking_item_id' => $data['booking_item_id'],
            'lapangan_id' => $data['lapangan_id'],
            'user_id' => $data['user_id'],
            'date' => Carbon::now()->toDateString(),
            'time' => Carbon::now()->toTimeString(),
            'rating' => $data['rating'],
            'comment' => $data['comment'],
        ]);

        return redirect()->back()->with('success', 'Review berhasil dikirim');

    }
}
