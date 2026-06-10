<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Apply authentication and permission middleware to the controller actions.
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:manage users')->only(['index','create','store','edit','update']);
        $this->middleware('permission:delete users')->only(['destroy']);
    }
    // Display a listing of the users in the system.
    public function index()
    {
        //
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    // Show the form for creating a new user.
    public function create()
    {
        //
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // Store a newly created user in storage.
    public function store(UserStoreRequest $request)
    {
        //
        $data = $request->validated();
        $data['password'] = Hash::make($request->password);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('user_images'), $imageName);
            $data['image'] = $imageName;
        }
        $user = User::create($data);
        $user->assignRole($request->role);
        return redirect()->route('users.index')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    // Display the details of a specific user.
    public function show(User $user)
    {
        //
        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    // Show the form for editing a specific user.
    public function edit(User $user)
    {
        //
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    // Update the details of a specific user in storage.
    public function update(UserUpdateRequest $request, User $user)
    {
        //
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
        $user->update($data);
        $user->syncRoles([$request->role]);
        return redirect()->route('users.index')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    // Remove a specific user from storage.
    public function destroy(User $user)
    {
        //
        $user->delete();
        return back()->with('success', 'User deleted successfully');
    }
}
