<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Ensure that only authenticated users can access the methods in this controller.
    public function __construct()
    {
        $this->middleware('auth');
    }
    // Display the profile page of the authenticated user.
    public function index()
    {
        //
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }
    // Display the profile edit page for the authenticated user.
    public function edit()
    {
        //
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    // Update the profile information of the authenticated user.
    public function update(ProfileUpdateRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();
        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];
        if ($request->hasFile('image')) {
            if ($user->image && File::exists(public_path('user_images/'.$user->image))) {
                File::delete(public_path('user_images/'.$user->image));
            }
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('user_images'), $imageName);
            $data['image'] = $imageName;
        }
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        if ($user instanceof User) {
            $user->update($data);
        }
        return redirect()->route('profile.index')->with('success', 'Profile updated successfully');
    }
}
