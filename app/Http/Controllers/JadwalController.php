<?php

namespace App\Http\Controllers;

use App\Models\Field;
use App\Models\Jadwal;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\DataTables;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $fieldId)
    {
        if ($request->ajax()) {
            $query = Jadwal::where('field_id', $fieldId);

            if ($request->filled('date')) {
                $query->whereDate('date', $request->date);
            }

            return DataTables::of($query)
                ->addColumn('action', function($row){
                    $actionBtn = '';
                    if ($row->status == 'available') {
                        $actionBtn .= '<button class="add-to-cart-btn px-2 py-1 bg-green-500 text-white rounded" data-jadwal-id="'.$row->id.'" data-field-id="'.$row->field_id.'" data-lapangan-id="'.$row->lapangan_id.'">Order</button>';
                    }// } elseif ($row->status == 'maintenance') {
                    //     $actionBtn .= '<button class="px-2 py-1 bg-red-500 text-white rounded delete-btn" data-jadwal-id="'.$row->id.'" data-field-id="'.$row->field_id.'">Delete</button>';
                    // }
                    return $actionBtn;
                })
                ->addColumn('checkbox', function($row){
                    if ($row->status == 'available') {
                        return '<input type="checkbox" name="jadwal_ids[]" value="'.$row->id.'" class="jadwal-checkbox" data-field-id="'.$row->field_id.'">';
                    }
                    return '';
                })
                ->addColumn('status_select', function($row){
                    if ($row->status != 'booked') {
                        $select = '<select class="status-select form-control w-full rounded-md border border-[#e0e0e0] bg-white py-2 px-4 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" data-id="'.$row->id.'">';
                        $statuses = ['available', 'maintenance'];
                        foreach ($statuses as $status) {
                            $selected = $row->status == $status ? 'selected' : '';
                            $select .= '<option value="'.$status.'" '.$selected.'>'.$status.'</option>';
                        }
                        $select .= '</select>';
                        return $select;
                    }
                    return $row->status;
                })
                ->addColumn('price_input', function($row){
                    if ($row->status == 'available') {
                        return '<input type="number" class="price-input w-full rounded-md border border-[#e0e0e0] bg-white py- px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" data-id="'.$row->id.'" value="'.$row->price.'">';
                    }
                    return $row->price;
                })
                ->rawColumns(['action', 'checkbox', 'status_select', 'price_input'])
                ->make(true);
        }

        $field = Field::findOrFail($fieldId);
        return view('dashboard.jadwal.index', compact('field'));
    }

    public function updateStatus(Request $request)
    {
        $jadwal = Jadwal::findOrFail($request->id);
        $jadwal->status = $request->status;
        $jadwal->save();

        return response()->json(['success' => true]);
    }

    public function updatePrice(Request $request)
    {
        $jadwal = Jadwal::findOrFail($request->id);
        $jadwal->price = $request->price;
        $jadwal->save();

        return response()->json(['success' => true]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Field $field)
    {
        if(Gate::allows('admin') || Gate::allows('staff')){
            $field = Field::with('priceRanges')->findOrFail($field->id);
            return view('dashboard.jadwal.create', compact('field'));
        } else {
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Field $field)
    {
        $data = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = Carbon::parse($data['start_date'])->startOfDay();
        $endDate = Carbon::parse($data['end_date'])->endOfDay();
        $openTime = Carbon::parse($field->open_time);
        $closeTime = Carbon::parse($field->close_time);
        $slotDuration = (int) $field->slot_duration; // in minutes// in minutes

        $createdCount = 0;
        $batchSize = 100;
        $schedules = [];

        while ($startDate <= $endDate) {
            $currentTime = $openTime->copy();

            while ($currentTime < $closeTime) {
                $endSlotTime = $currentTime->copy()->addMinutes($slotDuration);
                
                if ($endSlotTime > $closeTime) {
                    $endSlotTime = $closeTime->copy();
                }

                $price = $this->getPriceForTimeSlot($currentTime, $field);

                $schedules[] = [
                    'field_id' => $field->id,
                    'user_id' => Auth::id(),
                    'date' => $startDate->toDateString(),
                    'name' => 'Tersedia',
                    'start_time' => $currentTime->format('H:i:s'),
                    'end_time' => $endSlotTime->format('H:i:s'),
                    'status' => 'available',
                    'price' => $price,
                ];

                $createdCount++;

                if (count($schedules) >= $batchSize) {
                    Jadwal::insert($schedules);
                    $schedules = [];
                }

                $currentTime = $endSlotTime;
            }
            
            $startDate->addDay();
        }

        if (!empty($schedules)) {
            Jadwal::insert($schedules);
        }

        return redirect()->route('jadwal.index', $field->id)
            ->with('success', "{$createdCount} jadwal berhasil dibuat.");
    }

    private function getPriceForTimeSlot($time, $field)
    {
        if ($field->priceRanges->isNotEmpty()) {
            foreach ($field->priceRanges as $range) {
                $start = Carbon::parse($range->start_time);
                $end = Carbon::parse($range->end_time);
                if ($time->between($start, $end)) {
                    return $range->price;
                }
            }
        }
        return $field->base_price;
    }

    /**
     * Display the specified resource.
     */
    public function show(Jadwal $jadwal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Field $field, Jadwal $jadwal)
    {
        $jadwals = $jadwal;
        if(Gate::allows('admin')){
            $fields = $field::where('user_id', auth()->user()->id)->get();
        }elseif(Gate::allows('staff')){
            $fields = $field::where('user_id', auth()->user()->id)->get();
        } else{
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        }
        // dd($jadwals, $fields);
        $fields = "";
        return view('dashboard.jadwal.edit', compact('fields', 'jadwals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        $jadwals = Jadwal::findOrFail($jadwal->id);
        
        $data = $request->validate([
            'name' => 'string',
            'date' => 'string|date',
            'start_time' => 'string|date_format:H:i:s',
            'end_time' => 'string|date_format:H:i:s|after:start_time',
            'status' => 'string',
            'price' => 'string',
        ]);

        // Tambahkan field_id ke data
        $data['field_id'] = $jadwal->field->id;
        // dd($data['field_id']);

        // Update jadwal
        $jadwals->update($data);

        // Redirect ke route jadwal.index dengan parameter field_id
        return redirect()->route('jadwal.index', $data['field_id'])
                        ->with('success', 'Jadwal updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jadwal $jadwal, Field $field, $id)
    {
        $item = Jadwal::findOrFail($id);

        $item->delete();
        return redirect()->route('jadwal.index', $field->id)->with('success', 'Jadwal deleted successfully.');
    }

    public function search(Request $request,Field $field){

        $results = $field->jadwal;
        $request->validate([
            'date' => 'required|date',
        ]);

        $date = $request->input('date');
        $results = Jadwal::whereDate('date', $date)->get(); // Ganti dengan nama kolom yang sesuai

        return view('dashboard.jadwal.index', [
            'results' => $results
        ]);
    }
}
