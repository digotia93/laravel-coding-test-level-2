<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\EditTaskRequest;

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
        $this->checkIsProductOwner();

        $users = User::orderBy('name', 'ASC')->get();
        $projects = Project::orderBy('name', 'ASC')->get();

        // intend to display task create page
        return view('tasks.create', compact('users', 'projects')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddTaskRequest $request)
    {
        $this->checkIsProductOwner();

        // get input
        $input = $request->all();

        try {
            $task = new Task();
            $task->id = uniqid();
            $task->title = $input['title'];
            $task->description = $input['description'];
            $task->status = Task::NOT_STARTED;
            $task->project_id = $input['project'];
            $task->user_id = $input['user'];
            $task->save();

            Session::flash('success', 'Task has been created successfully.');
            return redirect()->route('tasks.edit');
        } catch(\Exception $e) {
            Session::flash('error', 'Encountered error while tried to create task.');
            return redirect()->back()->withInput();
        }
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

            // intend to display task edit page
            // return view('tasks.edit');
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
    public function update(EditTaskRequest $request, $id)
    {
        try {
            // get input
            $input = $request->all();
            $task = Task::find($id);

            if (!$task) {
                throw new \Exception();  
            }
        } catch(\Exception $e) {
            Session::flash('error', 'No task found.');
            return redirect()->back()->withInput();
        }

        try {
            // set condition for team member who can only change the status of the task assigned to them, they can edit any other attribute in a task
            if (Auth::user()->type == User::TEAM_MEMBER) {
                if ($task->user_id != Auth::user()->id) {
                    if ($task->status != $input['status']) {
                        Session::flash('error', 'You can only update task status which assigned to yourselves.');
                        return redirect()->back()->withInput();
                    }
                }
            }

            $task->title = $input['title'];
            $task->description = $input['description'];
            $task->status = $input['status'];
            $task->project_id = $input['project'];
            $task->user_id = $input['user'];
            $task->save();

            if (!$task) {
                throw new \Exception();  
            }

            Session::flash('success', 'Task has been updated successfully.');
            return redirect()->route('tasks.show');
        } catch(\Exception $e) {
            Session::flash('error', 'Encountered error while tried to update task details.');
            return redirect()->back()->withInput();
        }
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

    public function checkIsProductOwner() {
        if (Auth::user()->type != User::PRODUCT_OWNER) {
            Session::flash('error', 'Only Product Owner is allowed to create task.');
            return redirect()->route('tasks.index');
        }
    }
}
