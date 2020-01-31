<?php

namespace Tests\Feature;

use App\Task;
use App\User;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InvitationsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */ 
    public function non_owner_may_not_invite_users(){
        //$this->withoutExceptionHandling();

        $project = ProjectFactory::create();
        $user = factory(User::class)->create();

        $assertInvitationForbidden = function() use ($user,$project){
            $this->actingAs($user)
            ->post($project->path().'/invitations')
            ->assertStatus(403);
        }; 
        $assertInvitationForbidden();

        $project->invite($user);

        $assertInvitationForbidden();
    }

    /** @test */ 
    public function project_can_invite_user(){
        // $this->withoutExceptionHandling();
        $project = ProjectFactory::create();

        $userToInvite = factory(User::class)->create();
        $this->actingAs($project->owner)->post($project->path().'/invitations' , [
            'email' => $userToInvite->email
        ])->assertRedirect($project->path());
         //invite user

        $this->assertTrue($project->members->contains($userToInvite));

    }

    /** @test */ 
    public function invited_email_must_be_valid_account(){
        //$this->withoutExceptionHandling();

        $project = ProjectFactory::create();

        $this->actingAs($project->owner)
            ->post($project->path().'/invitations' , ['email' => 'notuser@example.com'])
            ->assertSessionHasErrors(['email'=> 'The user you are inviting must have an account.'] , null , 'invitations');
            // 
    }

    /** @test */ 
    public function invited_user_can_update_project_details(){
        //$this->withoutExceptionHandling();

        $project = ProjectFactory::create();

        $project->invite($newUser = factory(User::class)->create());

        $this->signedIn($newUser);
        $this->post(action('ProjectTasksController@store',$project),$task = factory(Task::class)->raw() );
        // $project->addTask('test task');

        $this->assertDatabaseHas('tasks',$task);
    
    }


    
}
