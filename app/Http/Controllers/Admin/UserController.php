<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\UsersDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ImageTrait;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    use ImageTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */

    public function dataTable(Request $request, UserDataTable $dataTable)
    {
        $dataTable->applyPhoneFilter($request->input('phone'));

        return $dataTable->eloquent(User::query())->toJson();
    }

    public function applyPhoneFilter($phone)
    {
        if ($phone) {
            $this->builder()->where('phone', 'LIKE', "%$phone%");
        }
    }
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'country_code' => 'required|string|max:5', 
            'phone' => 'required|string|max:20', 
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // 'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
      
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $this->verifyAndUpload($request, 'profile_image');
            $data['profile_image'] = asset('img/users/' . $data['profile_image']);
        }
        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'country_code' => 'required|string|max:15',
            'phone' => 'required|string|max:20',
            'status' => 'required|boolean', 
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            // 'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);
        
        if ($request->hasFile('profile_image')) {
            $data['profile_image'] = $this->verifyAndUpload($request, 'profile_image', $user->profile_image);
            $data['profile_image'] = asset('img/users/' . $data['profile_image']);
        }
        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Request $request, $id)
    // {
    //     $user = User::find($id);
    
    //     $user->delete();
    
    //     return response()->json(['message' => 'User deleted successfully.'], 200);
    // }
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json(['message' => 'User deleted successfully'], 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

    public function updateStatususer($id, Request $request)
    {
        $status = $request->input('status');
    
        $user = User::find($id); 
    
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'User not found'], 404);
        }
       
        $user->status = ($status == 1) ? true : false;
        $user->save();
    
        return response()->json(['success' => true, 'message' => 'Status updated successfully']);
    }
    

    
}
