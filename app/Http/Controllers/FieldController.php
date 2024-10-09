<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Field;
use App\Models\Jadwal;
use App\Models\lapangan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Gate::any(['admin', 'staff'])) {
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        }

        $lapangans = Gate::allows('admin') ? lapangan::all() : lapangan::where('user_id', auth()->user()->id)->get();

        if ($request->ajax()) {
            // if(Gate::allows('admin')){
                $query = Field::with(['lapangan', 'discount'])->select('fields.*');
            // }
            if (Gate::allows('staff')) {
                $query->where('fields.user_id', auth() ->user()->id);
            }

            if ($request->futsal) {
                $query->where('lapangan_id', $request->futsal);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="'.Storage::url($row->image).'" width="100" height="100" alt="Photo">';
                })
                ->addColumn('discounted_price', function ($row) {
                    if ($row->discount) {
                        $discountAmount = $row->base_price * $row->discount->discount / 100;
                        return number_format($row->base_price - $discountAmount, 2);
                    }
                    return null;
                })
                ->addColumn('action', function($row){
                    $actionBtn = '
                        <a href="'.route('jadwal.index', $row->id).'" class="px-2 py-1 bg-yellow-300 text-black rounded">Jadwal</a>
                        <a href="'.route('field.edit', $row->id).'" class="px-2 py-1 bg-blue-500 text-white rounded">Edit</a>
                        <form action="'.route('field.destroy', $row->id).'" method="POST" class="inline">
                            '.csrf_field().'
                            '.method_field("DELETE").'
                            <button type="submit" class="px-2 py-1 bg-red-500 text-white rounded">Delete</button>
                        </form>
                    ';
                    return $actionBtn;
                })
                ->editColumn('created_at', function ($row) {
                        return $row->created_at->format('Y-m-d');
                })
                ->rawColumns(['image', 'action','created_at'])
                ->make(true);
        }

        return view('dashboard.field.index', compact('lapangans'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Gate::allows('admin')){
            $lapangans = lapangan::all();
        }elseif(Gate::allows('staff')){
            $lapangans = lapangan::where('user_id', auth()->user()->id)->get();
        } else{
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        }

        $durations = [
            '1' => '1 Hari',
            '7' => '1 Minggu',
            '30' => '1 Bulan',
            '90' => '3 Bulan'
        ];

        return view('dashboard.field.create', compact('lapangans', 'durations'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'lapangan_id' => 'required|exists:lapangans,id',
            'image' => 'required|image',
            'description' => 'required|string',
            'open_time' => 'required',
            'close_time' => 'required',
            'slot_duration' => 'required|in:60,120',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'base_price' => 'required|numeric',
            'price_ranges' => 'nullable|array'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('assets', 'public');
            $data['image'] = $image;
        } else {
            return redirect()->back()->with('error', 'File gambar tidak ditemukan');
        }

        $data['user_id'] = auth()->user()->id;
        
        try {
            $field = Field::create($data);

            // Filter out empty price ranges
            $validPriceRanges = array_filter($request->price_ranges ?? [], function($range) {
                return !empty($range['start_time']) && !empty($range['end_time']) && !empty($range['price']);
            });

            foreach ($validPriceRanges as $range) {
                $field->priceRanges()->create([
                    'start_time' => $range['start_time'],
                    'end_time' => $range['end_time'],
                    'price' => $range['price']
                ]);
            }

            $this->createSchedules($field, $data);
            return redirect()->route('field.index')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            Log::error('Error creating field: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function createSchedules(Field $field, array $data)
    {
        $startDate = Carbon::parse($data['start_date'])->startOfDay();
        $endDate = Carbon::parse($data['end_date'])->endOfDay();
        $slotDuration = (int)$data['slot_duration'];
        
        $startTime = Carbon::parse($data['open_time']);
        $endTime = Carbon::parse($data['close_time']);

        while ($startDate->lte($endDate)) {
            $currentTime = $startTime->copy();
            
            while ($currentTime->lt($endTime)) {
                $endSlotTime = $currentTime->copy()->addMinutes($slotDuration);
                if ($endSlotTime->gt($endTime)) {
                    $endSlotTime = $endTime->copy();
                }

                $price = $this->getPriceForTimeSlot($currentTime, $data['base_price'], $data['price_ranges']);

                try{
                    Jadwal::create([
                        'field_id' => $field->id,
                        'date' => $startDate->toDateString(),
                        'name' => 'Tersedia',
                        'user_id' => auth()->user()->id,
                        'start_time' => $currentTime->toTimeString(),
                        'end_time' => $endSlotTime->toTimeString(),
                        'status' => 'available',
                        'price' => $price,
                    ]);
                } catch (\Exception $e) {
                    Log::error('Error creating field: ' . $e->getMessage());
                    return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
                }


                $currentTime = $endSlotTime;
            }
            
            $startDate->addDay();
        }
    }

    // private function getPriceForTimeSlot($time, $basePrice, $priceRanges)
    // {
    //     foreach ($priceRanges as $range) {
    //         $start = Carbon::parse($range['start_time']);
    //         $end = Carbon::parse($range['end_time']);
    //         if ($time->between($start, $end)) {
    //             return $range['price'];
    //         }
    //     }
    //     return $basePrice;
    // }

    private function getPriceForTimeSlot($time, $basePrice, $priceRanges)
    {
        if (!is_array($priceRanges) || empty($priceRanges)) {
            return $basePrice;
        }

        foreach ($priceRanges as $range) {
            $start = Carbon::parse($range['start_time']);
            $end = Carbon::parse($range['end_time']);
            if ($time->between($start, $end)) {
                return $range['price'];
            }
        }
        return $basePrice;
    }


    public function extendSchedule(Request $request, Field $field)
    {
        $data = $request->validate([
            'extend_end_date' => 'required|date|after:' . $field->schedules()->max('date'),
        ]);

        $startDate = Carbon::parse($field->schedules()->max('date'))->addDay()->startOfDay();
        $endDate = Carbon::parse($data['extend_end_date'])->endOfDay();

        try {
            $this->createSchedulesForDateRange($field, $startDate, $endDate);
            return redirect()->back()->with('success', 'Jadwal berhasil diperpanjang.');
        } catch (\Exception $e) {
            Log::error('Error Perpanjang jadwal: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    private function createSchedulesForDateRange(Field $field, Carbon $startDate, Carbon $endDate)
    {
        $openTime = Carbon::parse($field->open_time);
        $closeTime = Carbon::parse($field->close_time);
        $slotDuration = $field->slot_duration;

        while ($startDate->lte($endDate)) {
            $currentTime = $openTime->copy();

            while ($currentTime->lt($closeTime)) {
                $endSlotTime = $currentTime->copy()->addMinutes($slotDuration);
                if ($endSlotTime->gt($closeTime)) {
                    $endSlotTime = $closeTime->copy();
                }

                $price = $this->getPriceForTimeSlot($currentTime, $field->base_price, $field->price_ranges);

                // Periksa apakah jadwal sudah ada sebelum membuat yang baru
                $existingSchedule = Jadwal::where('field_id', $field->id)
                                    ->where('date', $startDate->toDateString())
                                    ->where('start_time', $currentTime->toTimeString())
                                    ->where('end_time', $endSlotTime->toTimeString())
                                    ->first();

                if (!$existingSchedule) {
                    Jadwal::create([
                        'field_id' => $field->id,
                        'date' => $startDate->toDateString(),
                        'name' => 'Tersedia',
                        'user_id' => auth()->user()->id,
                        'start_time' => $currentTime->toTimeString(),
                        'end_time' => $endSlotTime->toTimeString(),
                        'status' => 'available',
                        'price' => $price
                    ]);
                }

                $currentTime = $endSlotTime;
            }

            $startDate->addDay();
        }
    }

    // private function getPriceForTimeSlot($time, $basePrice, $priceRanges)
    // {
    //     // Implementasi logika harga sesuai dengan kebutuhan Anda
    //     // ...
    // }

    /**
     * Display the specified resource.
     */
    public function show(Field $field)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Field $field)
    {
        $field->load(['jadwal', 'priceRanges']);
        
        if(Gate::allows('admin')){
            $lapangans = lapangan::all();
        } elseif(Gate::allows('staff')){
            $lapangans = lapangan::where('user_id', auth()->user()->id)->get();
        } else{
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        }
        
        return view('dashboard.field.edit', compact('lapangans', 'field'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $field = Field::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string',
            'lapangan_id' => 'required|exists:lapangans,id',
            'image' => 'nullable|image',
            'description' => 'nullable|string',
            // 'open_time' => 'required',
            // 'close_time' => 'required',
            // 'slot_duration' => 'required|integer',
            // 'base_price' => 'required|numeric',
            // 'price_ranges' => 'required|array',
            // 'price_ranges.*.start_time' => 'required',
            // 'price_ranges.*.end_time' => 'required',
            // 'price_ranges.*.price' => 'required|numeric',
            // 'start_date' => 'required|date',
            // 'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        DB::beginTransaction();

        try {
            // Update basic field information
            $field->fill($data);

            // Handle image update
            if ($request->hasFile('image')) {
                if ($field->image) {
                    Storage::disk('public')->delete($field->image);
                }
                $field->image = $request->file('image')->store('assets', 'public');
            }

            $field->save();

            // // Update price ranges
            // $field->priceRanges()->delete();
            // foreach ($data['price_ranges'] as $range) {
            //     $field->priceRanges()->create($range);
            // }

            // Update or create schedules
            // $this->updateOrCreateSchedules($field, $data);

            DB::commit();

            return redirect()->route('field.index')->with('success', 'Field and schedules updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating field: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating the field: ' . $e->getMessage())->withInput();
        }
    }

    // private function updateOrCreateSchedules(Field $field, array $data)
    // {
    //     $startDate = Carbon::parse($data['start_date'])->startOfDay();
    //     $endDate = Carbon::parse($data['end_date'])->endOfDay();
    //     $slotDuration = (int)$data['slot_duration'];
        
    //     $startTime = Carbon::parse($data['open_time']);
    //     $endTime = Carbon::parse($data['close_time']);

    //     // Delete existing schedules within the date range
    //     Jadwal::where('field_id', $field->id)
    //           ->whereBetween('date', [$startDate, $endDate])
    //           ->delete();

    //     while ($startDate->lte($endDate)) {
    //         $currentTime = $startTime->copy();
            
    //         while ($currentTime->lt($endTime)) {
    //             $endSlotTime = $currentTime->copy()->addMinutes($slotDuration);
    //             if ($endSlotTime->gt($endTime)) {
    //                 $endSlotTime = $endTime->copy();
    //             }

    //             $price = $this->getPriceForTimeSlot($currentTime, $data['base_price'], $data['price_ranges']);

    //             Jadwal::create([
    //                 'field_id' => $field->id,
    //                 'date' => $startDate->toDateString(),
    //                 'name' => 'Available',
    //                 'user_id' => auth()->user()->id,
    //                 'start_time' => $currentTime->toTimeString(),
    //                 'end_time' => $endSlotTime->toTimeString(),
    //                 'status' => 'available',
    //                 'price' => $price,
    //             ]);

    //             $currentTime = $endSlotTime;
    //         }
            
    //         $startDate->addDay();
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $field = Field::find($id);

        $field->delete();

        return redirect()->route('field.index')->with('success', 'Data berhasil Di hapus');
    }
}
