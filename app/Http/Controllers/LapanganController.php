<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\District;
use App\Models\lapangan;
use App\Models\province;
use App\Models\Regency;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class LapanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Log::info('Index method called');

        try {
            if ($request->ajax()) {
                Log::info('Ajax request received');

                $query = Lapangan::with(['province', 'regencies']);

                if (Gate::allows('admin')) {
                    Log::info('User is admin');
                } elseif (Gate::allows('staff')) {
                    Log::info('User is staff');
                    $query->where('user_id', auth()->user()->id);
                } else {
                    Log::warning('Unauthorized access attempt');
                    return response()->json(['error' => 'Unauthorized'], 403);
                }

                Log::info('Query built: ' . $query->toSql());

                return DataTables::of($query)
                    ->addColumn('action', function ($lapangan) {
                        $editBtn = '<a href="' . route('lapangan.edit', $lapangan->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                        $deleteBtn = '<form action="' . route('lapangan.destroy', $lapangan->id) . '" method="POST" style="display:inline">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form>';
                        return $editBtn . ' ' . $deleteBtn;
                    })
                    ->addColumn('photo', function ($lapangan) {
                        return '<img src="' . Storage::url($lapangan->photos) . '" width="100" height="100">';
                    })
                    ->editColumn('created_at', function ($lapangan) {
                        return $lapangan->created_at->format('Y-m-d');
                    })
                    ->rawColumns(['action', 'photo','created_at'])
                    ->make(true);
            }

            $provinces = Province::all();
            $cities = lapangan::all();

            Log::info('Returning view');
            return view('dashboard.lapangan.index', compact('provinces', 'cities'));

        } catch (\Exception $e) {
            Log::error('Error in index method: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            if ($request->ajax()) {
                return response()->json(['error' => 'An error occurred while processing your request.'], 500);
            } else {
                return back()->with('error', 'An error occurred while loading the page. Please try again.');
            }
        }
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Gate::allows('admin')){
            $provinces = Province::all();
            $regencies = Regency::all(); 
            $districts = District::all();
            $villages = Village::all();
        }elseif(Gate::allows('staff')){
            $provinces = Province::all();
            $regencies = Regency::all(); 
            $districts = District::all();
            $villages = Village::all();
        }else{
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        }
        return view('dashboard.lapangan.create', compact('provinces', 'regencies', 'districts', 'villages'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'facilities' => 'required|string',
            'location' => 'required|string',
            'province_id' => 'required|string',
            'regencies_id' => 'required|string',
            'price' => 'required|string',
            'description' => 'required|string',
            'photos' => 'required|image',
            'calender' => 'string|nullable'
        ]);

        if ($request->hasFile('photos')) {
            $image = $request->file('photos')->store('assets', 'public');
            $data['photos'] = $image;
        } else {
            return redirect()->back()->with('error', 'File gambar tidak ditemukan');
        }

        $data['user_id'] = auth()->user()->id;
        
        try {
            lapangan::create($data);
            return redirect()->route('lapangan.index')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(lapangan $lapangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(lapangan $lapangan)
    {
        if(Gate::allows('admin')){
            $provinces = Province::all();
            $regencies = Regency::all();
        }elseif(Gate::allows('staff')){
            $provinces = Province::all();
            $regencies = Regency::all();
        }else {
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        }


        // $this->authorize('edit', $lapangan);

        return view('dashboard.lapangan.edit', compact('lapangan', 'provinces','regencies'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $update = lapangan::findOrFail($id);

        $data = $request->validate([
            'name' => 'string',
            'facilities' => 'string',
            'location' => 'string',
            'province_id' => 'string',
            'regencies_id' => 'string',
            'price' => 'string',
            'description' => 'string',
            'photos' => 'image',
            'calender' => 'string|nullable'
        ]);

        if ($request->hasFile('photos')) {
            $image = $request->file('photos')->store('assets', 'public');
            $data['photos'] = $image;
        } else {
            return redirect()->back()->with('error', 'File gambar tidak ditemukan');
        }
        
        try {
            $update->update($data);
            return redirect()->route('lapangan.index')->with('success', 'Data berhasil diedit');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lapangan = lapangan::find($id);

        $lapangan->delete();

        return redirect()->route('lapangan.index');
    }
}
