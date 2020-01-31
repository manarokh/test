<?php

namespace Tests\Unit;

use App\User;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
  /** @test */ 
  public function user_has_projects(){
      $user = factory('App\User')->create();

      $this->assertInstanceOf(Collection::class , $user->projects);
  }

  /** @test */ 
  public function user_has_accessible_projects(){
    $user = $this->signedIn();
    ProjectFactory::ownedBy($user)->create();

    $secondUser = factory(User::class)->create();
    $thirdUser = factory(User::class)->create();
    
    $secondproject = tap(ProjectFactory::ownedBy($secondUser)->create())->invite($thirdUser);

    $this->assertCount(1 , $user->accessibleProjects());

     $secondproject->invite($user);
     $this->assertCount(2 , $user->accessibleProjects());
  }
}
