<?php

namespace App\Http\Controllers;

use App\Task;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProjectTasksController extends Controller
{
    //
    // public function store(Project $project){

    //     $this->authorize('update' ,$project);
        
    //     request()->validate(['body' => 'required']);
        
    //     $project->addTask(request('body'));

    //     return redirect($project->path());
    // }

    public function show(Project $project){
        return view('projects.create_task',compact('project'));
    }

    public function store(Project $project,Request $request)
    {
        $this->authorize('update', $project);
        $attributes = request()->validate([
            'bill_num' => 'required',
            'from' => 'required',
            'to' => 'required',
            'city' => 'required',
            'driver' => 'required',
            'date' => 'required',
            'telephone' => 'sometimes'
            ]);

        $billAttr = request()->validate([
            'vin' => 'required',
            'engine' => 'required',
            'notes' => 'required',
            'model' => 'required',
        ]);

        $results = array_map( null , $billAttr['vin'] , $billAttr['engine'] , $billAttr['model'] , $billAttr['notes'] );
        $keys = ['vin','engine','model','notes'];
        $bills = array();

        foreach ($results as $res) {
            $sample = array_combine($keys,$res);
            array_push($bills,$sample);
        }
        // $final1 = array_combine($keys,$results[0]);
        // $final2 = array_combine($keys,$results[1]);
        // $final3 = array_combine($keys,$results[2]);
        // array_push($bills,$final1);
        // array_push($bills,$final2);
        // array_push($bills,$final3);
        // dd($bills);

        $task = $project->addTask($attributes);
        $task->addBills($bills);

        return redirect($project->path());
    }

    public function update(Project $project,Task $task){

        $this->authorize('update' , $task->project);
        
        $attributes = request()->validate([
            'bill_num' => 'required | sometimes',
            'from' => 'required | sometimes',
            'to' => 'required | sometimes',
            'city' => 'required | sometimes',
            'driver' => 'required | sometimes',
            'date' => 'required | sometimes',
            'telephone'=> 'required | sometimes'
            ]);

        $billAttr = request()->validate([
            'vin' => 'required | sometimes',
            'engine' => 'required | sometimes',
            'notes' => 'required | sometimes',
            'model' => 'required | sometimes',
        ]);
        if(request()->has('vin')){
            $results = array_map( null , $billAttr['vin'] , $billAttr['engine'] , $billAttr['model'] , $billAttr['notes'] );
            $keys = ['vin','engine','model','notes'];
            $bills = array();

            foreach ($results as $res) {
                $sample = array_combine($keys,$res);
                array_push($bills,$sample);
            }

            DB::table('bills')->where('task_id',$task->id)->delete();

            $task->addBills($bills);
            // foreach ($bills as $bill) {
            //     //  dd($bill);
            //      $task->addBill($bill);
            // }
            // $attributes['telephone'] = request('telephone');
            
        }
        $task->update($attributes);

        // $method = request('completed') ? 'complete' : 'incomplete' ; 
        // $task->$method();
        request('completed') ? $task->complete() : $task->incomplete(); 
        return redirect($project->path());
    }

    public function edit(Project $project,Task $task){
        return view('projects.edit_task',[
            'project'=>$project,
            'task'=>$task
            ]);
    }

    public function test(Project $project,Task $task){
        return view('projects.test',[
            'project'=>$project,
            'task'=>$task
            ]);        
    }

    public function destroy(Project $project , Task $task){
        $this->authorize('manage' , $project);

        $task->delete();

        return redirect($project->path());
    }
}
