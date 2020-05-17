@extends('main')
@section('content')

	@if(session()->has('message'))
		<div class="alert alert-success">
			{{ session()->get('message') }}
		</div>
	@endif

    @include('elements.form_create_item')

@endsection