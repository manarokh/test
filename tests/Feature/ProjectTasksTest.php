<?php

namespace Tests\Feature;

use App\Task;
use App\Project;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFActory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase,WithFaker ;

    /** @test */ 
    public function guest_cannot_add_task(){
        
        $project = factory(Project::class)->create();

        $this->post($project->path() . '/tasks')->assertRedirect('login'); 

    }

   /** @test */
   public function a_project_can_have_tasks()
   {
        //    $this->signedIn();

        //    $project = auth()->user()->projects()->create(
        //        factory(Project::class)->raw()
        //    );

        $project = ProjectFactory::create();

       //$this->post($project->path() . '/tasks', ['body' => 'test task']);
       $task = factory(Task::class)->raw();
       $project->addTask($task);
       
       $this->actingAs($project->owner)->get($project->path())->assertSee($task['from']);
   }

   /** @test */ 
   public function task_require_information(){
    //    $this->signedIn();

    //    $project = auth()->user()->projects()->create(
    //     factory(Project::class)->raw()
    //     );
        //$this->withoutExceptionHandling();

        $project = ProjectFactory::withTasks(1)->create();

        $attributes = factory('App\Task')->raw([
        'from'=> '',
        'to'=> '',
        'driver'=> '',
        'city'=> '',
        'date'=> '',
        ]);

        $this->actingAs($project->owner)
                ->post($project->path() . '/tasks',$attributes)
                ->assertSessionHasErrors('from'); 
   }

   /** @test */ 
   public function only_owner_of_project_can_add_task(){
        $this->signedIn();
        
        $project = factory(Project::class)->create();
        
        // $attributes = factory('App\Task')->raw([
        //     'body'=> 'test task'
        // ]);

        $this->post($project->path() . '/tasks',['body'=>'test task'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks',['body'=>'test task']); 
   }

   /** @test */ 
   public function task_can_be_updated(){
        $project = ProjectFactory::withTasks(1)->create();
                   // ->ownedBy($this->signedIn())
        //$this->withoutExceptionHandling();
        //$this->signedIn();
        // $project = auth()->user()->projects()->create(
        // factory(Project::class)->raw()
        // );
        // $task = $project->addTask('test task');

        $this->actingAs($project->owner)->patch($project->tasks->first()->path(),[
            'from'=>'changed',
        ]);
        $this->assertDatabaseHas('tasks',[
            'from'=>'changed',
        ]);
    }

    /** @test */ 
   public function task_can_be_completed(){
    $project = ProjectFactory::withTasks(1)->create();
 
    $this->actingAs($project->owner)->patch($project->tasks->first()->path(),[
        'completed' => true
    ]);
    $this->assertDatabaseHas('tasks',[
        'completed' => true
    ]);
    }

    /** @test */ 
   public function task_can_be_incompleted(){
    $project = ProjectFactory::withTasks(1)->create();
 
    $this->actingAs($project->owner)->patch($project->tasks->first()->path(),[
        'completed' => true
    ]);

    $this->actingAs($project->owner)->patch($project->tasks->first()->path(),[
        'completed' => false
    ]);

    $this->assertDatabaseHas('tasks',[
        'completed' => false
    ]);
    }

   /** @test */ 
   public function only_owner_of_project_can_update_task(){
     $this->signedIn();
    
    // $project = factory(Project::class)->create();

    // $task = $project->addTask('test task');

    $project = ProjectFactory::withTasks(1)->create();

    
    // $attributes = factory('App\Task')->raw([
    //     'body'=> 'test task'
    // ]);

    $this->patch($project->tasks[0]->path(), [ 'body' => 'changed' ])->assertStatus(403);

    $this->assertDatabaseMissing('tasks',['body'=>'changed']); 
}

}
