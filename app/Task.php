<?php

namespace App;

use App\Bill;
use App\Activity;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    use RecordsActivity;

    protected $guarded = []; 

    protected $touches = ['project'];

    protected $casts = [
        'completed' => 'boolean'
    ];

    protected static $recordableEvents = ['created'];

    public function path(){
        return "/projects/{$this->project->id}/tasks/$this->id";
    }

    public function project(){
        return $this->belongsTo(Project::class);
    }

    
    // protected static function boot (){
    //     parent::boot();
        
    //     static::created(function($task){
    //         $task->project->recordActivity('created_task');
            
    //         // Activity::create([
    //         //     'project_id' => $task->project->id,
    //         //     'description' => 'created_task'
    //         // ]);
    //     });

    //     static::deleted(function($task){
    //         $task->project->recordActivity('deleted_task');
    //     });


    //     // static::updated(function($task){
    //     //     if(! $task->completed) return;

    //     //     //$task->project->recordActivity('completed_task');
    //     //     // Activity::create([
    //     //     //     'project_id' => $task->project->id,
    //     //     //     'description' => 'completed_task'
    //     //     // ]);
    //     // });
    // }

    public function complete(){
        $this->update(['completed'=>true]);
        $this->recordActivity('completed_task');

    }

    public function incomplete(){
        $this->update(['completed'=>false]);
        $this->recordActivity('incompleted_task');

    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function addBill($billAttributes){
        $bill = $this->bills()->create($billAttributes);
        return $bill;
    }

    public function addBills($billsAttributes){
        return $this->bills()->createMany($billsAttributes);
    }
}
