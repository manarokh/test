<?php

namespace Tests\Feature;

use App\Task;
use App\Project;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageProjectsTest extends TestCase
{
    use Withfaker , RefreshDatabase ; 

    /** @test */
    public function a_user_can_create_project(){
        //$this->withoutExceptionHandling();
        $this->signedIn();

        $this->get('/projects/create')->assertStatus(200);
        $attributes = factory(Project::class)->raw();
        
        // $response = $this->post('/projects' , $attributes);

        // $project = Project::where($attributes)->first();
        // $response->assertRedirect($project->path());

        // $this->assertDatabaseHas('projects',$attributes);

        $this->followingRedirects()->post('/projects' , $attributes)
        ->assertSee($attributes['title'])
        ->assertSee($attributes['description'])
        ->assertSee($attributes['notes']);
    }

    /** @test */ 
    public function task_can_be_included_part_of_new_project(){
        $this->signedIn();
        $attributes = factory(Project::class)->raw();
        $task1 = factory(Task::class)->create();
        $task2 = factory(Task::class)->create();

        $attributes['tasks']=[
            $task1,
        ];
        $this->post('/projects',$attributes); 
        $this->assertCount(1,Project::first()->tasks);
    }

    /** @test */
    public function a_project_requires_title(){
        $this->signedIn();
        $attributes = factory('App\Project')->raw([
            'title'=> ''
            ]);
        $this->post('/projects',$attributes)->assertSessionHasErrors('title'); 
    }

    /** @test */
    public function a_project_requires_description(){
        $this->signedIn();
        
        $attributes = factory('App\Project')->raw([
            'description'=> ''
            ]);
        $this->post('/projects',$attributes)->assertSessionHasErrors('description'); 
    }
    
    /** @test */
    public function a_user_can_view_their_project()
    {
        // $this->signedIn();
        // $this->withoutExceptionHandling();
        // $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

        $project = ProjectFactory::create();


        $this->actingAs($project->owner)->get($project->path())
            ->assertSee($project->title)
            ->assertSee($project->description);
    }

     /** @test */
     public function only_authenticated_user_can_create_project(){        
        //$this->withoutExceptionHandling();

        $attributes = factory('App\Project')->raw();
        $this->post('/projects',$attributes)->assertRedirect('login'); 
        
    }

    /** @test */
    public function guest_cannot_view_project(){        
        //$this->withoutExceptionHandling();
        $this->get('/projects')->assertRedirect('login'); 

    }

    /** @test */
    public function guest_cannot_view_single_project(){        
        //$this->withoutExceptionHandling();

        $project = factory('App\Project')->create();

        $this->get($project->path())->assertRedirect('login'); 

    }

    /** @test */ 
    public function authenticated_user_cannot_view_others_projects(){
        //$this->withoutExceptionHandling();

        $this->signedIn();
        //$project = factory('App\Project')->create();

        $project = ProjectFactory::create();


        $this->get($project->path())->assertStatus(403);

    }

    /** @test */ 
    public function unthenticated_user_cannot_update_others_projects(){
        //$this->withoutExceptionHandling();

        $this->signedIn();
        $project = factory('App\Project')->create();

        $this->patch($project->path() , [] )->assertStatus(403);

    }

    /** @test */ 
    public function project_belong_to_owner(){
        $project = factory('App\Project')->create();
        $this->assertInstanceOf('App\User' , $project->owner );
    }

    /** @test */
    public function guest_cannot_manage_project(){        
        //$this->withoutExceptionHandling();

        $project = factory('App\Project')->create();

        $this->get('/projects')->assertRedirect('login'); 
        $this->get('/projects/create')->assertRedirect('login'); 
        $this->get($project->path().'/edit')->assertRedirect('login'); 
        $this->get($project->path())->assertRedirect('login'); 
        $this->post('/projects', $project->toArray() )->assertRedirect('login'); 
    }

    
   /** @test */ 
   public function user_can_update_project(){
     $this->withoutExceptionHandling();

    // $this->signedIn();
    // $project = factory('App\Project')->create(['owner_id' => auth()->id()]);

    $project = ProjectFactory::create();

    $this->actingAs($project->owner)
            ->patch($project->path(),$attributes = [
                'title' => 'changed',
                'description'=>'changed',
                'notes' => 'changed',
                ])->assertRedirect($project->path());

    $this->get($project->path().'/edit')->assertOk();

    $this->assertDatabaseHas('projects', $attributes );
    }

    /** @test */ 
    public function user_can_update_notes(){
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
                ->patch($project->path(),$attributes = ['notes' => 'changed'])->assertRedirect($project->path());

        $this->get($project->path().'/edit')->assertOk();

        $this->assertDatabaseHas('projects', $attributes );
    }

    /** @test */ 
    public function user_can_delete_project(){
        $this->withoutExceptionHandling();
        
        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
                ->delete($project->path())->assertRedirect('/projects');

        $this->assertDatabaseMissing('projects', $project->only('id'));
    }

    /** @test */ 
    public function unauthorized_users_cannot_delete_project(){
        
        $project = ProjectFactory::create();
        $this->delete($project->path())->assertRedirect('/login');

        $user = $this->signedIn();
        $this->delete($project->path())->assertStatus(403);

        $project->invite($user);
        $this->actingAs($user)->delete($project->path())->assertStatus(403);
    }

    /** @test */ 
    public function users_can_view_projects_they_have_invited_to(){
        $project = tap(ProjectFactory::create())->invite($this->signedIn());

        $this->get('/projects')->assertSee($project->title);
    }
}
