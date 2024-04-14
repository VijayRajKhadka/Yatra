<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        return view('super-admin.dashboard');
    }
    
    public function users()
{
    $usersWithRole1 = User::where('role', 1)->paginate(10);
    $usersDescending = User::whereNotNull('role')->whereNotIn('role', [1, 3])->orderBy('role', 'desc')->paginate(10);
    
    return view('super-admin.user', compact('usersWithRole1', 'usersDescending'));
}


    public function searchUsers(Request $request)
    {
        $query = $request->input('query');

        $usersWithRole1 = User::where('role', 1)->paginate(10);

        $usersDescending = User::where('name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->orWhere('contact', 'like', "%$query%")
            ->orderBy('role', 'desc')
            ->paginate(10);

        return view('super-admin.user', compact('usersWithRole1', 'usersDescending'));
    }

    public function editUser($id)
    {  
        $user = User::findOrFail($id);

        return view('super-admin.edit_user', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::find($id);
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->role = $request->input('role');
        $user->contact = $request->input('contact');
        $user->update();

        return redirect()->route('users', $id)->with('success', "User {$user->name} details updated successfully.");
    }
   

    public function deleteUser($id)
    {
        $user = User::find($id);
        $user->role = 3;
        $user->save();

        return redirect()->route('users')->with('success', "User {$user->name} is Deleted Succusfully.");
    }





}
