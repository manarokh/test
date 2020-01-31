<?php

namespace App\Http\Controllers;

use App\User;
use App\Project;
use App\Http\Requests\ProjectInvitationsRequest;

class ProjectInvitationsController extends Controller
{
    public function store(Project $project, ProjectInvitationsRequest $request)
    {
        $user = User::whereEmail(request('email'))->first();
        $project->invite($user);
        return redirect($project->path());
    }
}
