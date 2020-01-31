<?php

namespace Tests\Unit;

use App\Task;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;
   /** @test */ 
   public function it_has_path(){
       $project = factory('App\Project')->create();

       $this->assertEquals('/projects/'.$project->id , $project->path());
   }

   /** @test */ 
   public function project_can_add_task(){
        $project = factory('App\Project')->create();
        $att = factory(Task::class)->raw();
        $task = $project->addTask($att);

        $this->assertCount(1 , $project->tasks);
        $this->assertTrue($project->tasks->contains($task));
   }

   /** @test */ 
   public function project_can_invite_user(){
        $project = factory('App\Project')->create();

        $project->invite($user = factory(User::class)->create());

        $this->assertTrue( $project->members->contains($user) ); 

   }
}
