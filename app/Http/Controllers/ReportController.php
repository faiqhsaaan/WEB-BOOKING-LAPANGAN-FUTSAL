<?php

namespace App\Http\Controllers;

use App\Exports\FutsalDataExport;
use Carbon\Carbon;
use App\Models\Booking;
use App\Models\Lapangan;
use App\Models\BookingItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables as DataTablesDataTables;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller   
{
    public function report(Request $request)
    {
        $month = $request->input('month', Carbon::now()->month);
        $year = $request->input('year', Carbon::now()->year);

        if (Gate::allows('admin')) {
            $futsalsQuery = Lapangan::with(['field.jadwal.bookingItem.booking' => function($query) use ($month, $year) {
                $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
            }]);
        } elseif(Gate::allows('staff')) {
            $user = auth()->user();
            $futsalsQuery = $user->lapangan()->with(['field.jadwal.bookingItem.booking' => function($query) use ($month, $year) {
                $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
            }]);
        } else {
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        }

        $transformedData = $this->transformFutsalData($futsalsQuery->get(), $month, $year);

        if ($request->ajax()) {
            return DataTablesDataTables::of($transformedData)
                ->make(true);
        }

        if ($request->has('export_excel')) {
            return Excel::download(new FutsalDataExport($transformedData), 'futsal_data.xlsx');
        }

        if ($request->has('export_pdf')) {
            $pdf = Pdf::loadView('dashboard.laporan.pdf', compact('transformedData', 'month', 'year'));
            return $pdf->download('futsal_data.pdf');
        }

        return view('dashboard.laporan.index');
    }

    private function transformFutsalData($futsals, $month, $year)
    {
        return $futsals->map(function ($futsal) use ($month, $year) {
            $totalBookings = $futsal->field->flatMap(function($field) use ($month, $year) {
                return $field->jadwal->flatMap(function($jadwal) use ($month, $year) {
                    return $jadwal->bookingItem->filter(function($bookingItem) use ($month, $year) {
                        return $bookingItem->booking &&
                            $bookingItem->booking->created_at->month == $month &&
                            $bookingItem->booking->created_at->year == $year;
                    });
                });
            })->count();

            $totalRevenue = $futsal->field->flatMap(function($field) use ($month, $year) {
                return $field->jadwal->flatMap(function($jadwal) use ($month, $year) {
                    return $jadwal->bookingItem->flatMap(function($bookingItem) use ($month, $year) {
                        if ($bookingItem->booking &&
                            $bookingItem->booking->created_at->month == $month &&
                            $bookingItem->booking->created_at->year == $year) {
                            return [$bookingItem->booking->total_price];
                        }
                        return [];
                    });
                });
            })->sum();

            return [
                'futsal_name' => $futsal->name,
                'futsal_province' => $futsal->province->name,
                'futsal_regency' => $futsal->regencies->name,
                'futsal_alamat' => $futsal->location,
                'futsal_facilities' => $futsal->facilities,
                'futsal_price' => $futsal->price,
                'total_fields' => $futsal->field->count(),
                'total_schedules' => $futsal->field->flatMap(function($field) {
                    return $field->jadwal;
                })->count(),
                'total_booked_schedules' => $futsal->field->flatMap(function($field) use ($month, $year) {
                    return $field->jadwal->where('status', 'booked')->filter(function($jadwal) use ($month, $year) {
                        return $jadwal->created_at && $jadwal->created_at->month == $month && $jadwal->created_at->year == $year;
                    });
                })->count(),
                'total_bookings' => $totalBookings,
                'total_revenue' => $totalRevenue,
            ];
        });
    }
}