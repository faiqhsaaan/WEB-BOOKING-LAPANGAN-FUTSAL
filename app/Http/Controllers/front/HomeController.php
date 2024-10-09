<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use App\Models\Field;
use App\Models\Gallery;
use App\Models\Jadwal;
use App\Models\lapangan;
use App\Models\Promotion;
use App\Models\Province;
use App\Models\Regency;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Lapangan::query();

        if ($regencyId = $request->get('regencies_id')) {
            $query->where('regencies_id', $regencyId);
        }

        if ($search = $request->get('search')) {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%')
                    ->orWhere('facilities', 'like', '%' . $search . '%');
            });
        }

        $results = $query->get();
        $promotions = Promotion::all();

        // Ambil semua kota unik dari tabel lapangans
        $allRegencies = Lapangan::select('regencies_id', 'regencies.name as regency_name')
                        ->join('regencies', 'lapangans.regencies_id', '=', 'regencies.id')
                        ->distinct()
                        ->get();

        return view('front.index', compact('results', 'promotions', 'allRegencies'));
    }


    public function profile(Request $request){

        $user = Auth::user();

        return view('front.profile', compact('user'));
    }

    public function edit_profile(Request $request){
        $user = User::findOrFail(Auth::user()->id);
        
        // dd($request);
        $data = $request->validate([
            'name' => 'nullable',
            'email' => 'nullable|email',
            'phone' => 'nullable',
            'sosmed' => 'nullable',
            'profile_image' => 'nullable|image',
            'prefrences' => 'nullable',
        ]);

        
        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image')->store('assets', 'public');
            $data['profile_image'] = $image;
        } else {
            return redirect()->back()->with('error', 'File gambar tidak ditemukan');
        }
        // dd($user);

        $user->update($data);

        return redirect()->route('home.profile');
    }

    public function detail_futsal(Jadwal $jadwal ,lapangan $lapangan)
    {
        $fields = Field::with('lapangan')->where('lapangan_id', $lapangan->id)->get();
        $lapangans = Lapangan::findOrFail($lapangan->id);
        
        $feedbacks = Feedback::where('lapangan_id', $lapangan->id)->get();

        $jadwals = $jadwal;

        return view('front.detail_futsal', compact('fields', 'lapangans', 'feedbacks'));
    }



    public function jadwal_detail(Request $request, Lapangan $lapangan, Field $field)
    {
        $lapangans = Lapangan::findOrFail($lapangan->id);
        $fields = Field::findOrFail($field->id);
        
        $currentWeek = $request->input('week', 0);
        $direction = $request->input('direction', 'current');

        if ($direction === 'next') {
            $currentWeek++;
        } elseif ($direction === 'prev' && $currentWeek > 0) {
            $currentWeek--;
        }

        $today = now()->startOfDay();
        $startDate = $today->copy()->addWeeks($currentWeek)->startOfWeek();
        $endDate = $startDate->copy()->endOfWeek();

        // Ensure we're including today if it's the current week
        if ($currentWeek == 0) {
            $startDate = $today;
        }

        $jadwals = Jadwal::where('field_id', $field->id)
            ->where('date', '>=', $startDate)
            ->where('date', '<=', $endDate)
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        $slotDurationMinutes = intval($field->slot_duration); // Ensure it's an integer
        $slotDurationHours = $slotDurationMinutes / 60;

        // Calculate time slots based on open_time and close_time
        $openTime = Carbon::parse($field->open_time);
        $closeTime = Carbon::parse($field->close_time);
        $timeSlots = [];
        $currentTime = $openTime->copy();

        while ($currentTime < $closeTime) {
            $endTime = $currentTime->copy()->addMinutes($slotDurationMinutes);
            $timeSlots[] = [
                'start' => $currentTime->format('H:i'),
                'end' => $endTime->format('H:i')
            ];
            $currentTime = $endTime;
        }

        // Prepare the jadwals data based on field's slot duration and operating hours
        $preparedJadwals = $jadwals->groupBy('date')->map(function ($dayJadwals) use ($slotDurationMinutes, $openTime, $closeTime) {
            $slots = collect();
            $now = now(); // Current time

            foreach ($dayJadwals as $jadwal) {
                $startTime = Carbon::parse($jadwal->date . ' ' . $jadwal->start_time);
                $endTime = Carbon::parse($jadwal->date . ' ' . $jadwal->end_time);
                
                $currentSlotTime = max($startTime, $openTime->copy()->setDate($startTime->year, $startTime->month, $startTime->day));
                $slotEndTime = min($endTime, $closeTime->copy()->setDate($startTime->year, $startTime->month, $startTime->day));

                while ($currentSlotTime < $slotEndTime) {
                    // Only add slots that are in the future
                    if ($currentSlotTime->greaterThanOrEqualTo($now)) {
                        $slots->push([
                            'hour' => $currentSlotTime->format('H:i'),
                            'status' => $jadwal->status,
                            'name' => $jadwal->name,
                            'id' => $jadwal->id,
                            'price' => $jadwal->price, // Fetch price from jadwal
                        ]);
                    }
                    $currentSlotTime->addMinutes($slotDurationMinutes);
                }
            }
            return $slots->groupBy('hour');
        });

        return view('front.jadwal', compact('preparedJadwals', 'lapangans', 'fields', 'field', 'currentWeek', 'startDate', 'endDate', 'slotDurationMinutes', 'timeSlots'));
    }



    public function home_about($id){
        $lapangan = lapangan::findOrFail($id);

        return view('front.detail', compact('lapangan'));
    }

    public function gallery_futsal($id) {
        $lapangan = Lapangan::findOrFail($id);
        $galleries = Gallery::where('lapangan_id', $id)->get();
        
        return view('front.gallery', compact('lapangan', 'galleries'));
    }


    public function gallery_add(Request $request, $id) 
    {
        $lapangan = Lapangan::findOrFail($id);

        // dd($request);

        $data = $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'image' => 'required|image|mimes:png,jpg',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('assets', 'public');
            $data['image'] = $image;
        } else {
            return redirect()->back()->with('error', 'File gambar tidak ditemukan');
        }

        $data['user_id'] = Auth::user()->id;

        Gallery::create($data);

        return redirect()->route('gallery_futsal', $lapangan->id)->with('success', 'Gambar berhasil ditambahkan');
    }

}
