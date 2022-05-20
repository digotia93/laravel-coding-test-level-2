<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Http\Requests\AddProjectRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $pageIndex = $request->pageIndex ?? 0;
            $pageSize = $request->pageSize ?? 3;
            $sortBy = $request->sortBy ?? 'name';
            $sortDirection = $request->sortDirection ?? 'ASC';

            $projects = Partner::filter($request->all())->take($pageSize)->paginate($pageIndex)->orderBy($sortBy, $sortDirection)->get();

            // intend to display project index page
            // return view('projects.index', compact('projects'));
        } catch(\Exception $e) {
            Session::flash('error', 'Encountered error while tried to retrieve project list.');
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
        if (Auth::user()->type != User::PRODUCT_OWNER) {
            Session::flash('error', 'Only product owner allowed to create project.');
            return redirect()->route('project.index');
        }

        // intend to display project create page
        return view('projects.create'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddProjectRequest $request)
    {
        // get input
        $input = $request->all();

        try {
            $project = new Project();
            $project->id = uniqid();
            $project->name = $input['name'];
            $project->save();

            if (!$project) {
                throw new \Exception(); 
            }

            // NOTE: Creating a project and assign 2 users to it.
            // seems no users column requested in project table, hardly could assign users to a project,
            // therefore so would be determined by tasks assign according to project

            Session::flash('success', 'Project has been created successfully.');
            return redirect()->route('projects.show', $project->id);
        } catch(\Exception $e) {
            Session::flash('error', 'Encountered error while tried to create project.');
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
            $project = Project::find($id);

            if (!$project) {
                throw new \Exception();  
            }

            // intend to display project show page
            // return view('projects.show', compact('project'));
        } catch(\Exception $e) {
            Session::flash('error', 'Encountered error while tried to retrieve project details.');
            return redirect()->route('projects.index');
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
            // get input
            $input = $request->all();
            $project = Project::find($id);

            if (!$project) {
                throw new \Exception();  
            }

            return view('projects.edit', compact('project')); 
        } catch(\Exception $e) {
            Session::flash('error', 'No project found.');
            return redirect()->route('projects.index');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EditProjectRequest $request, $id)
    {
        // get input
        $input = $request->all();

        try {
            $project = Project::find($id);

            if (!$project) {
                throw new \Exception(); 
            }

            $project->name = $input['name'];
            $project->save();

            if (!$project) {
                throw new \Exception(); 
            }

            Session::flash('success', 'Project has been updated successfully.');
            return redirect()->route('projects.show', $project->id);
        } catch(\Exception $e) {
            Session::flash('error', 'Encountered error while tried to update project.');
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
            $project = Project::find($id);

            if (!$project) {
                throw new \Exception();  
            }

            // intend to display project index page
            // return view('projects.index');
        } catch(\Exception $e) {
            Session::flash('error', 'Encountered error while tried to retrieve project details.');
            return redirect()->route('projects.index');
        }
    }
}
