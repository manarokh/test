@extends('layouts.app')

@section('content')
    @foreach ($task->bills as $bill)
        <h3>Bill {{$bill->id}}</h3>
        Vin : {{$bill->vin}} <br>
        Engine : {{$bill->engine}} <br>
        Model : {{$bill->model}} <br>
        Notes : {{$bill->notes}} <br>
        <hr>
    @endforeach
@endsection
