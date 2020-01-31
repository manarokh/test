<?php

namespace App;

use App\Project;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function projects(){
        //orderByDesc('updated_at')
        //orderBy('updated_at','desc')
        //oldest()
        return $this->hasMany(Project::class , 'owner_id')->latest('updated_at');
    }

    public function accessibleProjects(){
    //   $projectsCreated =  $this->projects;
    //   $ids = DB::table('project_members')->where('user_id',$this->id)->pluck('project_id');
    //   $projectsShared = Project::find($ids);
    //   return $projectsCreated->merge($projectsShared);
    return Project::where('owner_id',$this->id)
                ->orwhereHas('members',function($query){
                    $query->where('user_id',$this->id);
                })->get();
    }
}
