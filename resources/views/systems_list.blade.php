@extends('main')
@section('content')

@if(!empty($systems))
    <ul class="accordion cell small-12" data-accordion data-allow-all-closed="true" data-multi-expand="true">
        @foreach ($systems as $system)
            <li class="accordion-item " data-accordion-item>
                <a href="#" class="accordion-title">
                    <div class="media-object cell small-12">
                        <div class="media-object-section">
                            <div class="thumbnail">
                            <img src="{{ $system->image }}">
                            </div>
                        </div>
                        <div class="media-object-section">
                            <h4>{{ $system->name }}</h4>
                            <p>{{ $system->description }}</p>
                        </div>
                    </div>
                </a>
                <div class="accordion-content" data-tab-content>
                    <div class="cell small-12">
                        @if(!empty($system->$components))
                            <ul class="accordion cell small-12" data-accordion data-allow-all-closed="true" data-multi-expand="true">
                                @foreach ($system->$components as $component)
                                    <li class="accordion-item " data-accordion-item>
                                        <a href="#" class="accordion-title">
                                            <div class="media-object cell small-12">
                                                <div class="media-object-section">
                                                    <div class="thumbnail">
                                                    <img src="{{ $component->image }}">
                                                    </div>
                                                </div>
                                                <div class="media-object-section">
                                                    <h4>{{ $component->name }}</h4>
                                                    <p>{{ $component->description }}</p>
                                                </div>
                                            </div>
                                        </a>
                                        <div class="accordion-content" data-tab-content>
                                            @if(!empty($component->$elements))
                                                @foreach ($component->$elements as $element)
                                                    <div class="media-object cell small-12">
                                                        <div class="media-object-section">
                                                            <div class="thumbnail">
                                                            <img src="{{ $element->image }}">
                                                            </div>
                                                        </div>
                                                        <div class="media-object-section">
                                                            <h4>{{ $element->name }}</h4>
                                                            <p>{{ $element->description }}</p>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="callout secondary">
                                                    <h5>This component hasn't any elements</h5>
                                                </div>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <div class="callout secondary">
                                <h5>This system hasn't any components</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>  
@else
    <div class="callout alert">
        <h5>No system found</h5>
    </div>
@endif

@endsection
