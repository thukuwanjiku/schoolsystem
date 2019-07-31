<?php

namespace App\Http\Controllers\Parents;

use App\DB\Students\StudentParent;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class ParentsLoginController extends Controller
{
    public function showLogin()
    {
        /*
         * if there's a parent logged in,
         * no need to show the login page,
         * redirect to parents dashboard
         *
         * */

        if(session()->has('parent_auth')){
            return redirect()->route('parents_performance');
        }

        return view('auth.parents_login');
    }

    public function login(Request $request)
    {
        //validate login
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        //attempt to login
        return $this->attemptLogin($request);
    }

    private function attemptLogin($request)
    {
        //check if there's a parent with the email given
        if(!$parent = StudentParent::where('email', $request['email'])->first()){
            //no parent with this email, return error
            return back()->withInput()->withErrors("Wrong email or password");
        }

        //there's a parent with this email, check if password entered is correct
        if(!Hash::check($request['password'], $parent->password)){
            //passwords do not match, return error
            return back()->withInput()->withErrors("Wrong email or password");
        }

        /*
         * correct password entered,
         * save parent in session
         * redirect to parents dashboard
         *
         * */
        session()->put('parent_auth', $parent);
        return redirect()->route('parents_performance');
    }


    public function logout()
    {
        session()->invalidate();
        return redirect()->route('parents_login');
    }
}
