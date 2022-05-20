<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = User::all()->latest();

            if (!$users) {
                throw new \Exception();  
            }

            // intend to display user index page
            // return view('users.index', compact('users'));
        } catch(\Exception $e) {
            Session::flash('error', 'Encountered error while tried to retrieve user list.');
            return redirect()->route('home');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                throw new \Exception();  
            }

            // intend to display user show page
            // return view('users.show');
        } catch(\Exception $e) {
            Session::flash('error', 'Encountered error while tried to retrieve user details.');
            return redirect()->route('users.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                throw new \Exception();  
            }

            // intend to display user index page
            // return view('users.index');
        } catch(\Exception $e) {
            Session::flash('error', 'Encountered error while tried to retrieve user details.');
            return redirect()->route('users.index');
        }
    }
}