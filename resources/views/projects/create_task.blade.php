@extends('layouts.app')

@section('content')
    <bill-info 
    path="{{$project->path()}}"
    taskpath="{{$project->path()}}/tasks"></bill-info>
@endsection