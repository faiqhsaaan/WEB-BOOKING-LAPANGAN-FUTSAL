<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\DataTables;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        if(Gate::allows('admin')){
            if ($request->ajax()) {
                $query = Feedback::with(['user', 'lapangan']);

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('user_name', function ($row) {
                        return $row->user->name;
                    })
                    ->addColumn('user_email', function ($row) {
                        return $row->user->email;
                    })
                    ->addColumn('futsal_name', function ($row) {
                        return $row->lapangan->name;
                    })
                    ->addColumn('action', function($row){
                        $actionBtn = '
                            <form action="'.route('review.destroy', $row->id).'" method="POST" class="inline-block">
                                '.csrf_field().'
                                '.method_field('DELETE').'
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                   Delete
                                </button>
                            </form>';
                        return $actionBtn;
                    })
                        ->addColumn('DT_RowIndex', function ($row) {
                        return '';
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('dashboard.review.index');
        } else {
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        }
    }


    public function destroy(string $id){
        if(Gate::allows('admin')){
            $reviews = Feedback::find($id);

            $reviews->delete();

            return redirect()->route('review.index')->with('success', 'Feedback Berhasil Dihapus');
        }else{
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        }
    }
}
