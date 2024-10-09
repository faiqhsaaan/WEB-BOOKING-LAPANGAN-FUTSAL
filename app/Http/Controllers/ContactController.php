<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       if(Gate::allows('admin')){
            $contact = Contact::first(); // Singular karena mengambil satu data

            return view('dashboard.contact.edit', compact('contact'));
       }else{
            Auth::guard('web')->logout();
            return redirect()->route('login')->with('error', 'Anda Tidak memiliki akses');
       }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Method kosong, tidak digunakan
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Method kosong, tidak digunakan
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        // Method kosong, tidak digunakan
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contact = Contact::find($id);

        return view('dashboard.contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $contact = Contact::find($id); // Singular karena mengambil satu data

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'required|string|max:255',
            'information' => 'required|string',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $contact->update($data);

        return redirect()->back()->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        // Method kosong, tidak digunakan
    }
}
