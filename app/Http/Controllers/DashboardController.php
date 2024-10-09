<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Comment;
use App\Models\Discount;
use App\Models\Field;
use App\Models\Jadwal;
use App\Models\Lapangan;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if(Gate::allows('admin')){
            $month = $request->input('month', 'all');
            $selectedMonth = $month == 'all' ? 'Semua Bulan' : Carbon::parse($month)->format('F Y');

            $totalFutsal = Lapangan::when($month != 'all', function($query) use ($month) {
                                    return $query->whereMonth('created_at', Carbon::parse($month)->month)
                                                ->whereYear('created_at', Carbon::parse($month)->year);
                                })
                                ->distinct('id')
                                ->count('id');
            $totalField = Field::when($month != 'all', function($query) use ($month) {
                                    return $query->whereMonth('created_at', Carbon::parse($month)->month)
                                                ->whereYear('created_at', Carbon::parse($month)->year);
                                })
                                ->distinct('id')
                                ->count('id');
            $totalUser = User::when($month != 'all', function($query) use ($month) {
                                    return $query->whereMonth('created_at', Carbon::parse($month)->month)
                                                ->whereYear('created_at', Carbon::parse($month)->year);
                                })
                                ->distinct('id')
                                ->count('id');

            // Menghitung total revenue
            if ($month == 'all') {
                $totalRevenue = [];
                for ($m = 1; $m <= 12; $m++) {
                    $revenue = Booking::whereMonth('created_at', $m)
                                        ->whereYear('created_at', Carbon::now()->year)
                                        ->sum('total_price');
                    $totalRevenue[] = $revenue;
                }
            } else {
                $totalRevenue = [Booking::whereMonth('created_at', Carbon::parse($month)->month)
                                    ->whereYear('created_at', Carbon::parse($month)->year)
                                    ->sum('total_price')];
            }

            $totalBookedSchedules = Jadwal::where('status', 'booked')
                                        ->when($month != 'all', function($query) use ($month) {
                                            return $query->whereMonth('created_at', Carbon::parse($month)->month)
                                                        ->whereYear('created_at', Carbon::parse($month)->year);
                                        })
                                        ->count();

            $totalBookedSchedulesAvailabel = Jadwal::where('status', 'available')
                                        ->when($month != 'all', function($query) use ($month) {
                                            return $query->whereMonth('created_at', Carbon::parse($month)->month)
                                                        ->whereYear('created_at', Carbon::parse($month)->year);
                                        })
                                        ->count();

            $totalUniqueBookers = Booking::when($month != 'all', function($query) use ($month) {
                                            return $query->whereMonth('created_at', Carbon::parse($month)->month)
                                                        ->whereYear('created_at', Carbon::parse($month)->year);
                                        })
                                        ->distinct('id')
                                        ->count('id');

            $months = array_merge(['all' => 'Semua Bulan'], array_reduce(range(1, 12), function($carry, $m) {
                $carry[date('Y-m', mktime(0, 0, 0, $m, 1))] = date('F Y', mktime(0, 0, 0, $m, 1));
                return $carry;
            }, []));

            $discounts = Discount::all();
            $comments = Comment::all();
        } elseif(Gate::allows('staff')){
            $month = $request->input('month', 'all');
            $selectedMonth = $month == 'all' ? 'Semua Bulan' : Carbon::parse($month)->format('F Y');

            $totalFutsal = Lapangan::where('user_id', Auth::user()->id)->when($month != 'all', function($query) use ($month) {
                                    return $query->whereMonth('created_at', Carbon::parse($month)->month)
                                                ->whereYear('created_at', Carbon::parse($month)->year);
                                })
                                ->distinct('id')
                                ->count('id');
            $totalField = Field::where('user_id', Auth::user()->id)->when($month != 'all', function($query) use ($month) {
                                    return $query->whereMonth('created_at', Carbon::parse($month)->month)
                                                ->whereYear('created_at', Carbon::parse($month)->year);
                                })
                                ->distinct('id')
                                ->count('id');
            $totalUser = User::when($month != 'all', function($query) use ($month) {
                                    return $query->whereMonth('created_at', Carbon::parse($month)->month)
                                                ->whereYear('created_at', Carbon::parse($month)->year);
                                })
                                ->distinct('id')
                                ->count('id');

            // Menghitung total revenue
            if ($month == 'all') {
                $totalRevenue = [];
                for ($m = 1; $m <= 12; $m++) {
                    $revenue = Booking::where('user_id', Auth::user()->id)->whereMonth('created_at', $m)
                                        ->whereYear('created_at', Carbon::now()->year)
                                        ->sum('total_price');
                    $totalRevenue[] = $revenue;
                }
            } else {
                $totalRevenue = [Booking::where('user_id', Auth::user()->id)->whereMonth('created_at', Carbon::parse($month)->month)
                                    ->whereYear('created_at', Carbon::parse($month)->year)
                                    ->sum('total_price')];
            }

            $totalBookedSchedules = Jadwal::where('user_id', Auth::user()->id)->where('status', 'booked')
                                        ->when($month != 'all', function($query) use ($month) {
                                            return $query->whereMonth('created_at', Carbon::parse($month)->month)
                                                        ->whereYear('created_at', Carbon::parse($month)->year);
                                        })
                                        ->count();

            $totalBookedSchedulesAvailabel = Jadwal::where('user_id', Auth::user()->id)->where('status', 'available')
                                        ->when($month != 'all', function($query) use ($month) {
                                            return $query->whereMonth('created_at', Carbon::parse($month)->month)
                                                        ->whereYear('created_at', Carbon::parse($month)->year);
                                        })
                                        ->count();

            $totalUniqueBookers = Booking::where('user_id', Auth::user()->id)->when($month != 'all', function($query) use ($month) {
                                            return $query->whereMonth('created_at', Carbon::parse($month)->month)
                                                        ->whereYear('created_at', Carbon::parse($month)->year);
                                        })
                                        ->distinct('id')
                                        ->count('id');

            $months = array_merge(['all' => 'Semua Bulan'], array_reduce(range(1, 12), function($carry, $m) {
                $carry[date('Y-m', mktime(0, 0, 0, $m, 1))] = date('F Y', mktime(0, 0, 0, $m, 1));
                return $carry;
            }, []));

            $discounts = Discount::all();
            $comments = Comment::all();
        }else{
            return redirect()->route('home.index');
        }

        return view('dashboard.index', compact('comments','discounts','totalFutsal', 'totalField', 'totalUser', 'totalRevenue', 'totalBookedSchedules', 'totalUniqueBookers', 'month','totalBookedSchedulesAvailabel', 'months', 'selectedMonth'));
    }

}