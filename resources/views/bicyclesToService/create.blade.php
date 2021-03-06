@extends('layouts.app')
@include('errors._errors')
@section('content')

@auth
<div>
    Logged in user:
    {{Auth::user()->name}} <br>
    with email: {{auth()->user()->email}}

</div>
<div>
    <form action="{{ route('bicyclesToService.store') }}" method="POST" enctype="multipart/form-data">
        {{-- <form action="/bicycle" method="POST" enctype="multipart/form-data"> --}}
        @csrf
        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Your biycle name.." required>

        @error('name')
        <p class="error">{{$message}}</p>
        @enderror


        <label for="description">Description</label>
        <input type="text" id="description" name="description" placeholder="Description" required>



        <input type="checkbox" id="sellable" name="is_sellable" value="1">
        <label for="is_sellable"> For Sell</label><br>
        <input type="checkbox" id="rentable" name="is_rentable" value="1">
        <label for="is_rentable"> For Rent</label><br>
        <input type="checkbox" id="serviceable" name="is_serviceable" value="1">
        <label for="is_serviceable"> For Service</label><br><br>

        <input type="submit" value="Submit">
    </form>
</div>


<div class="input-group">
    <span class="input-group-btn">
        <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
            <i class="fa fa-picture-o"></i> Choose
        </a>
    </span>
    <input id="thumbnail" class="form-control" type="text" name="filepath">
</div>
<img id="holder" style="margin-top:15px;max-height:100px;">
</div>



<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>



@endauth


@endsection
