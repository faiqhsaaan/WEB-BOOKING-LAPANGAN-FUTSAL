<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Field;
use App\Models\lapangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (Gate::allows('admin')) {
            $query = Discount::with('lapangan', 'field')->orderBy('created_at', 'desc');
        } elseif (Gate::allows('staff')) {
            $query = Discount::with('lapangan', 'field')
                        ->where('user_id', auth()->user()->id)
                        ->orderBy('created_at', 'desc');
        } else {
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda tidak memiliki akses');
        }

        if ($request->ajax()) {
            return DataTables::of($query)
                ->addIndexColumn()
                ->addColumn('lapangan_name', function ($discount) {
                    return $discount->lapangan->name;
                })
                ->addColumn('field_name', function ($discount) {
                    return $discount->field->name;
                })
                ->addColumn('base_price', function ($discount) {
                    return 'Rp ' . number_format($discount->field->base_price);
                })
                ->addColumn('discounted_price', function ($discount) {
                    return 'Rp ' . number_format($discount->discounted_price);
                })
                ->addColumn('action', function ($discount) {
                    $editBtn = '<a href="' . route('discount.edit', $discount->id) . '" class="edit btn btn-primary btn-sm">Edit</a>';
                    $deleteBtn = '<form action="' . route('discount.destroy', $discount->id) . '" method="POST" style="display:inline">
                        ' . csrf_field() . '
                        ' . method_field('DELETE') . '
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure?\')">Delete</button>
                    </form>';
                    return $editBtn . ' ' . $deleteBtn;
                })
                ->addColumn('DT_RowIndex', function ($row) {
                    return '';
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('Y-m-d');
                })
                ->rawColumns(['action','created_at'])
                ->make(true);
        }

        return view('dashboard.discount.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Gate::allows('admin')){
            $lapangans = lapangan::all();
        } elseif(Gate::allows('staff')){
            $lapangans = lapangan::where('user_id', auth()->user()->id)->get();
        } else{
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        }

        return view('dashboard.discount.create', compact('lapangans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'field_id' => 'required|exists:fields,id',
            'discount' => 'required|numeric|min:0|max:100',
        ]);

        $data['user_id'] = auth()->user()->id;

        try {
            $field = Field::findOrFail($data['field_id']);
            $discountedPrice = $field->base_price * (1 - $data['discount'] / 100);
            
            Discount::create([
                'lapangan_id' => $data['lapangan_id'],
                'field_id' => $data['field_id'],
                'discount' => $data['discount'],
                'discounted_price' => $discountedPrice,
                'user_id' => $data['user_id'],
            ]);

            return redirect()->route('discount.index')->with('success', 'Data berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    // ... (keep other methods unchanged)

    public function getFields($lapanganId)
    {
        $fields = Field::where('lapangan_id', $lapanganId)->get();
        return response()->json($fields);
    }

    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        $discounts = $discount;

        if(Gate::allows('admin')){
            $lapangans = lapangan::all();
        } elseif(Gate::allows('staff')){
            $lapangans = lapangan::where('user_id', auth()->user()->id)->get();
        } else{
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        }

        $fields = Field::where('lapangan_id', $discount->lapangan_id)->get();

        return view('dashboard.discount.edit', compact('discounts', 'lapangans', 'fields'));
    }

    public function update(Request $request, string $id)
    {
        $discount = Discount::find($id);

        $data = $request->validate([
            'lapangan_id' => 'required|exists:lapangans,id',
            'field_id' => 'required|exists:fields,id',
            'discount' => 'required|numeric|min:0|max:100',
        ]);

        $data['user_id'] = auth()->user()->id;

        try {
            $field = Field::findOrFail($data['field_id']);
            $discountedPrice = $field->base_price * (1 - $data['discount'] / 100);
            
            $discount->update([
                'lapangan_id' => $data['lapangan_id'],
                'field_id' => $data['field_id'],
                'discount' => $data['discount'],
                'discounted_price' => $discountedPrice,
                'user_id' => $data['user_id'],
            ]);

            return redirect()->route('discount.index')->with('success', 'Data berhasil di Update');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $discount = Discount::find($id);
        $field = Field::find($discount->field_id);

        try {
            $discount->delete();
            $field->discounted_price = null; // Hapus harga yang telah didiskon
            $field->save();
            return redirect()->route('discount.index')->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
