<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    public function index(){

        $projects = auth()->user()->accessibleProjects();

        return view('projects.index',compact('projects'));
    }

    public function store(){

        //validation 
        // $attributes = request()->validate([
        //     'title' => 'required',
        //     'description' => 'required',
        //     'notes' => 'min:2',
        // ]);


        // $attributes['owner_id'] = auth()->id();

        //store
        $project = auth()->user()->projects()->create($this->validateRequest());

        if(request()->has('tasks')){
            $project->addTasks(request('tasks'));
        }

        if(request()->wantsJson()){
            return ['message' => $project->path()];
        }

        //redirect 
        return redirect($project->path());
    }   

    public function show(Project $project){
        
        $this->authorize('update' , $project);
        // if( auth()->user()->isNot( $project->owner ) ){
        //     abort(403);
        // }
        $test = DB::table('tasks')->where('project_id',$project->id)->paginate(5);
        return view('projects.show',compact('project','test'));
    }

    public function create(){
        return view('projects.create');
    }

    public function update(Project $project){

        $this->authorize('update' , $project);

        // if( auth()->user()->isNot( $project->owner ) ){
        //     abort(403);
        // }

        $project->update($this->validateRequest());

        return redirect($project->path());
    }

    public function edit(Project $project){
        return view('projects.edit',compact('project'));
    }

    public function validateRequest(){
        return request()->validate([
            'title' => 'sometimes | required',
            'description' => 'sometimes | required',
            'notes' => 'nullable',
        ]);
    }

    public function destroy(Project $project){
        $this->authorize('manage' , $project);
        
        $project->delete();

        return redirect('/projects');
    }
}
