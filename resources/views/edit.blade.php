@extends('main')
@section('content')
    @if(count($errors))
	    <div class="form-group">
	        <div class="alert alert-danger">
	            <ul>
	                @foreach($errors->all() as $error)
	                    <li>{{$error}}</li>
	                @endforeach
	            </ul>
	        </div>
	    </div>
	@endif

    @include('elements.form_create_word')
@endsection