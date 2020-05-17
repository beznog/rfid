@extends('main')
@section('content')

	<div class="navi-btn-container cell small-12">
	    <a href="{{ url()->previous() }}" class="button">
	      <i class="fi-arrow-left"></i>
	      Back
	    </a>
	</div>

	@if(session()->has('message'))
		<div class="alert alert-success">
			{{ session()->get('message') }}
		</div>
	@endif
	
    @include('elements.form_create_item')
@endsection