<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Project;
use App\Models\Product;
use App\Models\Category;






class HomeController extends Controller
{
    function index() : View {
        $users = User::where('role', '=', 2)->where('is_otp_verify',1)->count();
        $projects=Project::where('status', 1)->count() ;
        $products=Product::where('status', 1)->count() ;
        $cats=Category::where('status', 1)->count() ;


        return view('admin.dashboard',compact('users','projects','products','cats'));
    }


    public function profilesetting(Request $request){
        $user = User::where('role', '=', 1)->get();
        // p($user);
        return view('admin.profilesetting',compact('user'));
    }

    public function profilesettingupdate(Request $request, User $user)
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
}