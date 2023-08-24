<?php

namespace App\Http\Controllers;
use App\Models\User;

use Illuminate\Http\Request;

class UsersController extends Controller
{   
    //function for 'users' page
    public function index()
    {
        $users = User::all();
        return view('users',compact('users'));
    }

    //Function for Update User Form
    public function updateUserForm($id) {
        $users = User::find($id);
        return view('updateuserform', compact('users'));
    }

    //Function for Updating the User Data w.r.t ID
    public function updateUser(Request $request, $id) {
            $users = User::find($id);
            $users -> name = $request->input('userName');
            $users -> email = $request->input('userEmail');
            $users -> save();
            return redirect()->route('users');
    }

    //Function for Changing User Status from Active (By Default) to Inactive
    public function changeUserStatus(Request $request) {
        $users = User::find($request->id);
        $users->status = $request->status;
        $users -> save();
    }

    //Function for Seeing Expenses
    public function newExpense() {
        return view('newexpense');
    }
}
