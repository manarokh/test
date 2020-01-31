@extends('layouts.app')

@section('content')
        {{$bill->vin}} <br>
        {{$bill->engine}} <br>
        {{$bill->model}} <br>
        {{$bill->notes}} <br>        
@endsection
