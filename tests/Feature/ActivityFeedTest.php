<?php

namespace Tests\Feature;

use App\Task;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityFeedTest extends TestCase
{
   use RefreshDatabase;

   /** @test */ 
   public function creating_porject_records_activity(){
       $this->withoutExceptionHandling();

       $project = ProjectFactory::create();

       $this->assertCount(1 , $project->activity);

       tap($project->activity->last(), function($activity){
        $this->assertEquals('created_project', $activity->description);

        $this->assertNull($activity->changes); 
    });
   }

   /** @test */ 
   public function updating_project_records_activity(){
    $this->withoutExceptionHandling();

    $project = ProjectFactory::create();
    $original_title = $project->title;

    $project->update(['title'=>'changed']);

    $this->assertCount(2, $project->activity);

    tap($project->activity->last(), function($activity) use ($original_title){
        $this->assertEquals('updated_project', $activity->description);

        $expected = [
            'before'=>['title' => $original_title],
            'after'=> ['title' => 'changed']
        ];

        $this->assertEquals($expected , $activity->changes); 
    });

   }

   /** @test */ 
   public function creating_new_task_records_project_activity(){
    //$this->withoutExceptionHandling();
    
    $project = ProjectFactory::create();
    // $project->addTask('test task');
    $att = factory(Task::class)->raw();
    $task = $project->addTask($att);

    $this->assertCount(2, $project->activity);
    
    tap($project->activity->last(), function($activity){
        $this->assertEquals('created_task', $activity->description);
        $this->assertInstanceOf(Task::class, $activity->subject);
   });

   }


   /** @test */ 
   public function completing_task_records_project_activity(){
    $this->withoutExceptionHandling();
    
    $project = ProjectFactory::withTasks(1)->create();

    $this->actingAs($project->owner)->patch($project->tasks[0]->path(),[
        'body'=>'foobar',
        'completed'=>true
    ]);

    $this->assertCount(3, $project->activity);
    
    tap($project->activity->last(), function($activity){
        $this->assertEquals('completed_task', $activity->description);
        $this->assertInstanceOf(Task::class, $activity->subject);
    });

   }

    /** @test */ 
    public function incompleting_task_records_project_activity(){
        //$this->withoutExceptionHandling();
        
        $project = ProjectFactory::withTasks(1)->create(['complete'=>true]);
    
        // $this->actingAs($project->owner)->patch($project->tasks[0]->path(),[
        //     'body'=>'foobar',
        //     'completed'=>true
        // ]);
        $project->tasks[0]->incomplete();
    
        $this->assertCount(3, $project->activity);
        $this->assertEquals('incompleted_task', $project->activity->last()->description);
        tap($project->activity->last(), function($activity){
            $this->assertEquals('incompleted_task', $activity->description);
            $this->assertInstanceOf(Task::class, $activity->subject);
       });
    
       }

        /** @test */ 
    public function delete_task_generate_activiy(){
        //$this->withoutExceptionHandling();
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks[0]->delete();

        $this->assertCount(3, $project->activity);
    
    }
}
