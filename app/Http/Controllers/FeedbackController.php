<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Yajra\DataTables\Facades\DataTables;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        if(Gate::allows('admin')){
            $query = Comment::query();

            if ($request->ajax()) {
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('user_name', function ($row) {
                        return $row->user->name;
                    })
                    ->addColumn('user_email', function ($row) {
                        return $row->user->email;
                    })
                    ->addColumn('action', function($row){
                        $actionBtn = '<form action="' . route('feedback.destroy', $row->id) . '" method="POST" class="d-inline">
                                        ' . csrf_field() . '
                                        ' . method_field('DELETE') . '
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                      </form>';
                        return $actionBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }

            return view('dashboard.feedback.index');
        } else {
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        }
    }

    public function destroy(string $id){
        if(Gate::allows('admin')){
            $feedbacks = Comment::find($id);

            $feedbacks->delete();

            return redirect()->route('feedback.index')->with('success', 'Feedback Berhasil Dihapus');
        }else{
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        }
    }
}