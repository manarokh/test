<?php

namespace Tests\Feature;

use App\Bill;
use App\Task;
use Tests\TestCase;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ObjectTaskTest extends TestCase
{
    use RefreshDatabase, WithFaker;

   /** @test */
   public function a_task_can_have_bill()
   {
        $project = ProjectFactory::create();

       $attributes = factory(Task::class)->raw();
       $task = $project->addTask($attributes);

       $billAttributes = factory(Bill::class)->raw();
    //    $billAttributes2 = factory(Bill::class)->raw();

    //    $bills = $task->addBills([$billAttributes1,$billAttributes2]);
       $bill = $task->addBill($billAttributes);
       //dd($bill->vin);
       $this->actingAs($project->owner)->get($project->path())->assertSee($bill->vin);
   }
}
