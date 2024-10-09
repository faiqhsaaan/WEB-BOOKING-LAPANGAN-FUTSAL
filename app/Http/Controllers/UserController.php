<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(Gate::allows('admin')){
            if ($request->ajax()) {
                $query = User::query();
                return DataTables::of($query)
                    ->addColumn('action', function($user) {
                        $editBtn = '<a href="'.route('user.edit', $user->id).'" class="btn btn-sm btn-primary">Edit</a>';
                        $deleteBtn = '<form action="'.route('user.destroy', $user->id).'" method="POST" class="d-inline">
                            '.csrf_field().'
                            '.method_field('DELETE').'
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>';
                        return $editBtn . ' ' . $deleteBtn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
            }
            return view('dashboard.user.index');
        } elseif(Gate::allows('staff')){
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        } else {
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if(Gate::allows('admin')){
            return view('dashboard.user.create');
        }else{
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'nullable|string|min:4|max:20',
            'email' => 'nullable|email',
            'profile_image' => 'nullable|image',
            'phone' => 'nullable|string',
            'password' => 'nullable|string',
            'sosmed' => 'nullable|string',
            'prefrences' => 'nullable|string',
            'role' => 'nullable|string',
        ]);

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image')->store('assets', 'public');
            $data['profile_image'] = $image;
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $request->password ? Hash::make($request->password) : null,
            'sosmed' => $data['sosmed'],
            'prefrences' => $data['prefrences'],
            'role' => $data['role'],
            'profile_image' => $data['profile_image'],
        ]);

        return redirect()->route('user.index')->with('success', 'User berhasil dibuat');
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
    public function edit(string $id)
    {
        if(Gate::allows('admin')){
            $user = User::find($id);

            return view('dashboard.user.edit', compact('user'));
        }else{
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        $data = $request->validate([
            'name' => 'nullable|string|min:4|max:20',
            'email' => 'nullable|email',
            'profile_image' => 'nullable|image',
            'phone' => 'nullable|string',
            'sosmed' => 'nullable|string',
            'prefrences' => 'nullable|string',
            'role' => 'nullable|string',
        ]);

        if ($request->hasFile('profile_image')) {
            $image = $request->file('profile_image')->store('assets', 'public');
            $data['profile_image'] = $image;
        }
        // Update data user dengan data yang baru
        $user->update($data);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('user.index');
    }
}
