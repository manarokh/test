<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
use App\User;

class Project extends Model
{

    use RecordsActivity;

    protected $guarded = [];

    protected static $recordableEvents = ['created','updated'];
    

    public function path(){
        return "/projects/{$this->id}";
    }

    public function owner(){
     return $this->belongsTo(User::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class)->latest();
    }

    public function addTask($attributes){
        $task  = $this->tasks()->create($attributes);    

        // Activity::create([
        //     'project_id' => $this->id,
        //     'description' => 'created_task'
        // ]);
        return $task;
    }

    public function addTasks($tasks){ 
        return $this->tasks()->createMany($tasks);    
    }

    public function activity(){
        return $this->hasMany(Activity::class)->latest();
    }

    public function invite(User $user){
        return $this->members()->attach($user);
    }

    public function members(){
     return $this->belongsToMany(User::class, 'project_members')->withTimestamps();
    }
}
