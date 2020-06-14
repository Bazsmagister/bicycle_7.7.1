@extends('layouts.app')

@section('content')

<div style="padding-left: 20px">
    <p>Name :
        {{$bicycle->name}} </p>
    <p> Description :
        {{$bicycle->description}} </p>

    <p> Price :
        {{$bicycle->price}} Ft</p>

    <p> Rent Price /24h :
        {{$bicycle->rent_price}} Ft</p>

    <p> Image :
        @role('super-admin')
        {{$bicycle->image}}
        @endrole

        <img src="/storage/{{$bicycle->image}}" alt="this should be an image3" width="130" height="100">

        <img src="/storage/{{$bicycle->image}}" alt="this should be an image 0">

        {{-- <img src="{{$bicycle->image}}" alt="this should be an image1" width="100" height="100">

        <img src="images/{{$bicycle->image}}" alt="this should be an image2" width="100" height="100"> --}}




        {{-- <img src="{{asset("$bicycle->image")}}" alt="this should be an image4" width="100" height="100">

        <embed src="{{ asset("$bicycle->image")}}" alt="embed">

        <img src="{{asset("$bicycle->image")}}" alt="this should be an image5" width="100" height="100"> --}}


    </p>

    <hr>
    @auth
    @if ($bicycle->is_rentable==1)
    <form action="/rentthisbike" method="get">
        <button class='button btn-info' type="submit">Rent that bicycle</button>

    </form>
    @endif
    @endauth

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

    <hr>

    {{$bicycle}}
    <hr>

    @endhasanyrole


    <p>Test roles:</p>
    @hasanyrole('super-admin|serviceman|salesman')
    <p>has any role</p>
    @else
    <p>has not role</p>
    @endhasanyrole

</div>


@endsection
