<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $tasks = Task::all()->latest();

            if (!$tasks) {
                throw new \Exception();  
            }

            // intend to display user index page
            // return view('tasks.index', compact('tasks'));
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $task = Task::find($id);

            if (!$task) {
                throw new \Exception();  
            }

            // intend to display task show page
            // return view('tasks.show');
        } catch(\Exception $e) {
            Session::flash('error', 'Encountered error while tried to retrieve task details.');
            return redirect()->route('tasks.index');
        }
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
            $task = Task::find($id);

            if (!$task) {
                throw new \Exception();  
            }

            // intend to display task index page
            // return view('tasks.index');
        } catch(\Exception $e) {
            Session::flash('error', 'Encountered error while tried to retrieve task details.');
            return redirect()->route('tasks.index');
        }
    }
}
