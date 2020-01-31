@extends('layouts.app')

@section('content')
    <header class="flex items-end mb-3 py-4">
        <h1 class="text-2xl mr-auto text-default" >KTC Archive</h1>
        <a href="/projects/create" class="button-primary" @click.prevent="$modal.show('new-project')">Create a New Project</a>
    </header>

    <main class="lg:flex flex-wrap -mx-3">
        @forelse ($projects as $project)
            <div class="lg:w-1/3 px-2 pb-6">
                @include('projects.card')
            </div>
        @empty
            <div class="font-bold ml-4">
                No Projects Yet . 
            </div>
        @endforelse
    </main>

    <new-project-modal></new-project-modal>

@endsection
