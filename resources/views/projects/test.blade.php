@extends('layouts.app')

@section('content')

    @foreach ($project->tasks as $task)

    <div class="card mb-3">
        <form action="{{ $task->path() }}" method="post">
            @csrf
            @method('PATCH')

            <shipping-bill :task="{{ $task }}" path="{{ $task->path() }}"></shipping-bill>
        </form>
    </div>

    @endforeach

@endsection