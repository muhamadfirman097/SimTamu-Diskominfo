<?php

namespace App\Http\Controllers;

use App\Models\Division;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash; // <-- Add this
use Illuminate\Validation\ValidationException;

class SettingsController extends Controller
{
    // Display the main settings page
    public function index()
    {
        $divisions = Division::orderBy('name')->get();
        return view('admin.settings', compact('divisions'));
    }

    // Store a new division
    public function storeDivision(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:divisions']);
        Division::create($request->all());
        return back()->with('success', 'Division added successfully.');
    }

    // Update an existing division
    public function updateDivision(Request $request, Division $division)
    {
        $request->validate(['name' => 'required|string|max:255|unique:divisions,name,' . $division->id]);
        $division->update($request->all());
        return back()->with('success', 'Division updated successfully.');
    }

    // Delete a division
    public function destroyDivision(Request $request, Division $division)
    {
        // Validate the admin's current password
        if (!Hash::check($request->password, $request->user()->password)) {
            // Throw an exception that will be caught and displayed
            throw ValidationException::withMessages([
                'password_delete' => 'Kata sandi yang Anda masukkan salah untuk menghapus divisi.',
            ]);
        }

        $division->delete();
        return back()->with('success', 'Divisi berhasil dihapus.');
    }
}
