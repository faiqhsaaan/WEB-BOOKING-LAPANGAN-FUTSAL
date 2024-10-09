<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class KeuanganController extends Controller
{
    public function index(Request $request)
    {
        if(Gate::denies('admin') && Gate::denies('staff')) {
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        }

        if ($request->ajax()) {
            $query = $this->getQuery();

            if ($request->has('date') && $request->date != '') {
                $query->whereDate('date', $request->date);
            }

            $data = $query->get();
            $total = $data->sum('total_price');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('total_price_formatted', function($row) {
                    return number_format($row->total_price, 0, ',', '.');
                })
                ->rawColumns(['total_price_formatted'])
                ->with(['total' => $total])
                ->make(true);
        }

        $initialTotal = $this->getQuery()->sum('total_price');

        return view('dashboard.keuangan.index', compact('initialTotal'));
    }

    private function getQuery()
    {
        if(Gate::allows('admin')){
            return Booking::query();
        } else {
            return Booking::where('user_id', Auth::user()->id);
        }
    }

    // Other methods remain unchanged
}