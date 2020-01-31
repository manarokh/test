<?php 

namespace App;

use Illuminate\Support\Facades\Auth;

trait RecordsActivity {

    public $oldAttributes = [] ;

    public static function bootRecordsActivity(){

        foreach (self::recordableEvents() as $event){

            static::$event(function($model) use ($event){
                $model->recordActivity($model->activityDescription($event));
            });

            if($event === 'updated'){
                static::updating(function ($model){
                    $model->oldAttributes = $model->getOriginal();
                });
            }

        }
    }

    protected function activityDescription($description){
          return  "{$description}_". strtolower( class_basename($this) ); //created_task
    }

    protected static function recordableEvents(){
        if(isset(static::$recordableEvents)){
            return static::$recordableEvents;
        }

        return ['created','updated'];
    }

    public function recordActivity($description){

        $id = Auth::id();  //get the signed in user id 

        $this->activity()->create([
            //'user_id' => ($this->project ?? $this)->owner->id, // fix this error 
            'user_id' => $id ?? ($this->project ?? $this)->owner->id , // solve the error but some tests failed , fix it later 
            'description' => $description,
            'changes' => $this->activityChanges() , 
            'project_id' => basename($this) === 'Project' ? $this->id : $this->project_id,
            ]);
    }


    public function activity(){
        return $this->morphMany(Activity::class,'subject')->latest();
    }


    public function activityChanges(){

        if ($this->wasChanged()){
            return [
                'before' => array_except( array_diff( $this->oldAttributes , $this->getAttributes() ), 'updated_at' ),
                'after' =>  array_except($this->getChanges() , 'updated_at')
            ];
        }

    }

}