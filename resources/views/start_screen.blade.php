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

<div class="orbit" role="region" aria-label="Favorite Space Pictures" data-orbit>
  <div class="orbit-wrapper">
    <div class="orbit-controls">
      <button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>
      <button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button>
    </div>
    <ul class="orbit-container">
      
    </ul>
  </div>
</div>
@endsection