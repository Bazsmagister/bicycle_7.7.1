@extends('layouts.app')
@section('content')

@auth
<div>
    {{-- Logged in user:
    {{Auth::user()->name}} <br>
    with email: {{auth()->user()->email}} --}}

</div>
<div class=container>
    <form id='form' action="/rents/{{$rent->id}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>

            <input type="number" id="user_id" name="user_id" value="{{ old('user_id', $rent->user_id) }}">
            <label for="ID">User ID</label>
        </div>

        <div>

            <input type="number" id="bicycle_id" name="bicycle_id" value="{{ old('bicycle_id', $rent->bicycle_id) }}">
            <label for="Bike ID"> Bike ID</label>
        </div>

        <div>

            <input type="date" id="rentStarted_at" name="rentStarted_at"
                value="{{ old('rentStarted_at', $rent->rentStarted_at) }}">
            <label for="rent started at">Rent started at:</label>
        </div>


        <div>
            <input type="date" name="rentEnds_at" id="rentEnds_at"
                value="{{ old('rentEnds_at', $rent->rentEnds_at) }}" />

            <label for="Rent end">Rent end:<label>
        </div>

        <div>
            <input type="date" name="bicycleReturned_at" id="bicycleReturned_at"
                value="{{ old('bicycleReturned_at', $rent->bicycleReturned_at) }}" hidden />
            <label for="Bicycle returned ">Bicycle Returned :<label>
        </div>



        {{-- <div>
            <input type="date" name="bicycleReturned_at" id="bicycleReturned_at"
                value="{{ old('bicycleReturned_at', $rent->bicycleReturned_at) }}" />
        <label for="Bicycle returned ">Bicycle Returned/<label>
</div> --}}



<input class="button btn-success" type="submit" value="Submit">

<input class="button btn-success" type="submit" value="Bicycle is returned from rent now.">
</form>
<br>
<hr>
<div>
    <form action="{{ route('rents.destroy', $rent->id) }}" method="POST">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger"
            onclick="return confirm('Do you really want to delete it?');">Delete</button>
    </form>
</div>
</div>

@endauth

@endsection
