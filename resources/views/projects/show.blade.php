@extends('layouts.app')

@section('content')

    <header class="flex items-center mb-3 pb-4">
        <div class="flex justify-between items-end w-full">
            <p class="text-default text-sm font-normal">
                <a href="/projects" class="text-default text-sm font-normal no-underline hover:underline">My Projects</a>
                / {{ $project->title }}
            </p>

            <div class="flex items-center">
                @foreach ($project->members as $member)
                    <img 
                    src="{{gravatar_url($member->email)}}" 
                    alt="{{$member->name}}'s avatar'" 
                    class="rounded-full w-10 mr-2 shadow">
                @endforeach
                <img 
                    src="{{gravatar_url($project->owner->email)}}" 
                    alt="{{$project->owner->name}}'s avatar'" 
                    class="rounded-full w-10 mr-2 shadow">

                <a href="{{ $project->path() }}/create_task" class="button-primary ml-4"> Add Task </a>

                <a href="{{$project->path()}}/edit" 
                    class="button-primary ml-4">Edit Project</a>
            </div>
        </div>
    </header>


    <main>
        <div class="lg:flex -mx-3">
            <div class="w-3/4  px-3 mb-4">
                <div class="mb-8">
                    <h2 class="font-normal text-lg text-default mb-3" >Tasks</h2>
                    {{-- Tasks --}}

                    {{-- add new Task --}}
                    {{-- <div class="card mb-3">
                        <form action="{{ $project->path().'/tasks' }}" method="POST">
                            @csrf
                            <input type="text" name="body" class="bg-card text-default w-full" placeholder="Add New Task ">
                        </form>
                    </div> --}}

                    {{-- show tasks --}}
                    {{-- <div>
                        @foreach ($test as $item)
                            {{$item->id}}
                        @endforeach
                    </div>
                    <ul class="flex none">
                        <li class=" mr-4"><a class="page-link" href="{{$project->path()}}?page=2">2</a></li>
                        <li class=" mr-4"><a class="page-link" href="{{$project->path()}}?page=3">3</a></li>
                        <li class=" mr-4"><a class="page-link" href="{{$project->path()}}?page=4">4</a></li>
                        <li class=" mr-4"><a class="page-link" href="{{$project->path()}}?page=5">5</a></li>
                    </ul> --}}
                    @foreach ($project->tasks as $task)
                        <div class="card mb-3">
                            <form action="{{ $task->path() }}" method="post">
                                @csrf
                                @method('PATCH')

                                <shipping-bill :task="{{ $task }}" :bills="{{$task->bills}}" path="{{ $task->path() }}"></shipping-bill>
                            </form>
                        </div>
                    @endforeach
                </div>

                <div>
                    <h2 class="font-normal text-lg text-default mb-3" >General Notes</h2>
                    {{-- General Notes --}}
                    <form action="{{ $project->path() }}" method="POST">
                        @csrf
                        @method('PATCH')
                        {{-- <input type="hidden" name="title" value="{{$project->title}}">
                        <input type="hidden" name="description" value="{{$project->description}}"> --}}
                        <textarea 
                            class="card w-full" 
                            style="min-height: 175px" 
                            name="notes"
                            placeholder="Enter your Notes Here ...">{{ $project->notes }}</textarea>

                        <button type="submit" class="button-primary mt-1 float-right">Save</button>
                     </form>
                     @include('errors')
                </div>
            </div>


            <div class="w-1/3">
                @include('projects.card')
                @include('projects.activity.card')

                @can('manage',$project)
                    @include('projects.invites')
                @endcan
            </div>
        </div>
    </main>
    
@endsection