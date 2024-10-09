<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\lapangan;
use App\Models\Promotion;
use App\Traits\Fonnte;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $query = Promotion::with('lapangan');

            if (Gate::allows('staff')) {
                $query->where('user_id', Auth::user()->id);
            } elseif (!Gate::allows('admin')) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    return '<img src="' . asset('storage/' . $row->image) . '" width="100" height="100" alt="Promotion Image">';
                })
                ->addColumn('action', function($row){
                    $actionBtn = '
                        <a href="' . route('promotion.edit', $row->id) . '" class="edit btn btn-success btn-sm">Edit</a>
                        <form action="' . route('promotion.destroy', $row->id) . '" method="POST" style="display:inline">
                            '.csrf_field().'
                            '.method_field("DELETE").'
                            <button type="submit" class="delete btn btn-danger btn-sm">Delete</button>
                        </form>
                     ';
                    return $actionBtn;
                })
                ->editColumn('created_at', function ($row) {
                        return $row->created_at->format('Y-m-d');
                })
                ->rawColumns(['image', 'action', 'created_at'])
                ->make(true);
        }

        return view('dashboard.promotion.index');
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
        }else{
            abort(403, 'Anda bukan staff futsal');
        }
        return view('dashboard.promotion.create', compact('lapangans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id'
        ]);

        $data['user_id'] = Auth::user()->id;

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('assets', 'public');
            $data['image'] = $image;
        } else {
            return redirect()->back()->with('error', 'File gambar tidak ditemukan');
        }

        try {
            Promotion::create($data);
            return redirect()->route('promotion.index')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('promotion.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Promotion $promotion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {   
        if(Gate::allows('admin')){
            $promotion = Promotion::findOrFail($id);
            $lapangans = lapangan::all();
        }elseif(Gate::allows('staff')){
            $promotion = Promotion::findOrFail($id);
            $lapangans = lapangan::where('user_id', auth()->user()->id)->get();
        }else{
            abort(403, 'Anda bukan staff futsal');
        }

        return view('dashboard.promotion.edit', compact('promotion', 'lapangans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $promotion = Promotion::findOrFail($id);

        $data = $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image')->store('assets', 'public');
            $data['image'] = $image;
        } else {
            return redirect()->back()->with('error', 'File gambar tidak ditemukan');
        }

        try {
            $promotion->update($data);
            return redirect()->route('promotion.index')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->route('promotion.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $promotion = Promotion::find($id);

        try {
            $promotion->delete();
            return redirect()->route('promotion.index')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
