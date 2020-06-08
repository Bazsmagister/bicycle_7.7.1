@extends('layouts.app')

@section('content')


<div style="padding-left: 20px">
    <p>Name :
        {{$bicycle->name}} </p>
    <p> Description :
        {{$bicycle->description}} </p>

    <p> Price :
        {{$bicycle->price}} </p>

    <p> Image :
        {{$bicycle->image}} </p>
    <img src="{{$bicycle->image}}" alt="this should be an image" width="100" height="100">


    <hr>

    {{$bicycle}}
    <hr>

    <p>Test roles:</p>
    @hasanyrole('super-admin|serviceman|salesman')
    <p>has any role</p>
    @else
    <p>has not role</p>
    @endhasanyrole




    {{-- @hasanyrole('super-admin') --}}
    @hasanyrole('super-admin|serviceman|salesman')


    <div>
        <a href="{{$bicycle->id}}/edit" class="btn btn-warning">Edit</a>
    </div>

    {{-- <form action="{{$bicycle->id}}" method="post">

    {{ method_field('delete') }}
    @csrf

    <button class="btn btn-outline-danger" type="submit">Delete the bicycle</button>
    </form> --}}

    <hr>
    <form action="{{ route('bicycle.destroy', $bicycle->id) }}" method="POST">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger">Delete the bicycle</button>
    </form>

    @endhasanyrole

</div>


@endsection
