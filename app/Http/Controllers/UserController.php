<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
class UserController extends Controller
{
    //
    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required',
            'confirm_password' => 'required|same:new_password',
        ]);
        if ($validator->fails()) {
            return back()->withSuccess($validator->errors()->all());
        }

        $user  = User::find(Auth::user()->id);

        if(Hash::check($request->old_password, $user->password)){
            $user->password  = bcrypt($request->new_password);
            $user->save();
            return back()->withSuccess('Password changed successfully.');
        }else{
            return back()->withSuccess('Old password is Invalid.');
        }
    }
}
